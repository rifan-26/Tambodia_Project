<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Media;
use App\Models\Schedule;
use App\Models\LayoutSetting;
use App\Models\ScheduledBackground;

/**
 * LayoutController - Mengelola layout 
 * 
 * Controller ini bertanggung jawab untuk:
 * • Mengelola layout default media
 * • Menangani jadwal aktif media  
 * • Menyediakan data untuk landing page
 * • Mengatur pengaturan layout
 * 
 * @package App\Http\Controllers
 * @author  Laravel Admin System
 * @version 1.0
 */
class LayoutController_clean extends Controller
{
    // ═══════════════════════════════════════════════════════════════════════
    // CONSTANTS & CONFIGURATION
    // ═══════════════════════════════════════════════════════════════════════
    
    /**
     * Mapping hari dari bahasa Inggris ke Indonesia
     * 
     * @var array<string, string>
     */
    private const DAY_MAP = [
        'monday'    => 'senin',
        'tuesday'   => 'selasa', 
        'wednesday' => 'rabu',
        'thursday'  => 'kamis',
        'friday'    => 'jumat',
        'saturday'  => 'sabtu',
        'sunday'    => 'minggu'
    ];

    // ═══════════════════════════════════════════════════════════════════════
    // PUBLIC API METHODS
    // ═══════════════════════════════════════════════════════════════════════
    
    /**
     * Mendapatkan status layout saat ini termasuk media default
     * 
     * @return JsonResponse
     */
    public function getCurrentLayoutStatus(): JsonResponse
    {
        try {
            $defaultMedia         = $this->getDefaultLayoutMedia();
            $scheduledBackgrounds = $this->getScheduledBackgrounds();

            return response()->json([
                'success'             => true,
                'defaultMedia'         => $defaultMedia,
                'scheduledBackgrounds' => $scheduledBackgrounds
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to load layout status: ' . $e->getMessage());
            
            return response()->json([
                'success'             => false, 
                'message'             => 'Gagal memuat status layout',
                'defaultMedia'         => [],
                'scheduledBackgrounds' => []
            ], 500);
        }
    }

    /**
     * Mendapatkan data layout untuk landing page
     * Memprioritaskan media terjadwal daripada layout default
     * 
     * @return JsonResponse
     */
    public function getLayoutData(): JsonResponse
    {
        try {
            $activeSchedules = $this->getActiveSchedule();
            
            if ($activeSchedules) {
                $scheduledMedia = $this->getScheduledMedia($activeSchedules);
                
                if ($scheduledMedia->isNotEmpty()) {
                    return response()->json([
                        'success'       => true,
                        'media'         => $scheduledMedia,
                        'source'        => 'scheduled',
                        'schedule_count' => $activeSchedules->count()
                    ]);
                }
            }
            
            // Fallback ke media layout default
            $defaultMedia = $this->getDefaultLayoutMedia();
            
            return response()->json([
                'success'       => true,
                'media'         => $defaultMedia,
                'source'        => 'default',
                'schedule_count' => 0
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to get layout data: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data layout',
                'media'   => [],
                'source'  => 'error'
            ], 500);
        }
    }

    /**
     * Memperbarui pengaturan layout
     * 
     * @param  Request $request
     * @return JsonResponse
     */
    public function updateLayoutSettings(Request $request): JsonResponse
    {
        try {
            // Validate - allow missing field or empty array for clearing layout
            $validated = $request->validate([
                'media_ids'   => 'sometimes|array',  // 'sometimes' = optional field
                'media_ids.*' => 'nullable|exists:media,id'
            ]);

            // Get media_ids from validated data, default to empty array if not present
            $mediaIds = isset($validated['media_ids']) ? array_filter($validated['media_ids']) : [];
            
            Log::info('Updating layout settings', [
                'media_ids' => $mediaIds,
                'count' => count($mediaIds),
                'user_id' => Auth::id()
            ]);

            // Cek apakah ada jadwal yang sedang aktif
            if ($this->hasActiveSchedules()) {
                Log::warning('Cannot update layout: Active schedules exist');
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mengubah layout saat jadwal sedang aktif'
                ], 422);
            }

            DB::beginTransaction();

            // Reset semua status show_on_landing media
            Media::query()->update([
                'show_on_landing' => false, 
                'layout_order'    => null
            ]);
            Log::info('Reset all media show_on_landing status');

            // Set media terpilih untuk ditampilkan di landing page (jika ada)
            if (count($mediaIds) > 0) {
                foreach ($mediaIds as $index => $mediaId) {
                    Media::where('id', $mediaId)->update([
                        'show_on_landing' => true,
                        'layout_order'    => $index + 1
                    ]);
                    Log::info("Set media {$mediaId} to position " . ($index + 1));
                }
            } else {
                Log::info('No media selected - all media cleared from landing page');
            }

            DB::commit();

            Log::info('Layout settings updated successfully', [
                'media_count' => count($mediaIds)
            ]);
            
            return response()->json([
                'success' => true,
                'message' => count($mediaIds) > 0 
                    ? 'Layout berhasil diperbarui' 
                    : 'Layout berhasil dikosongkan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update layout settings: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui layout: ' . $e->getMessage()
            ], 500);
        }
    }

    // ═══════════════════════════════════════════════════════════════════════
    // SCHEDULE MANAGEMENT METHODS
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Mendapatkan jadwal yang sedang aktif berdasarkan tanggal dan waktu saat ini
     * 
     * @return Collection|null
     */
    public function getActiveSchedule(): ?Collection
    {
        $now         = Carbon::now();
        $currentDay  = strtolower($now->format('l'));
        $currentTime = $now->format('H:i:s');
        $currentDate = $now->toDateString();
        
        $indonesianDay = self::DAY_MAP[$currentDay] ?? null;
        
        if (!$indonesianDay) {
            Log::warning("Invalid day mapping for: {$currentDay}");
            return null;
        }
        
        // Cari jadwal aktif untuk hari dan waktu saat ini
        $activeSchedules = Schedule::where('day_of_week', $indonesianDay)
            ->where('time', '<=', $currentTime)
            ->whereDate('start_date', '<=', $currentDate)
            ->orderBy('time', 'desc')
            ->get();
            
        return $activeSchedules->isNotEmpty() ? $activeSchedules : null;
    }

    /**
     * Mendapatkan media untuk tampilan terjadwal dengan urutan layout yang tepat
     * 
     * @param  Collection|null $schedules
     * @return Collection
     */
    public function getScheduledMedia(?Collection $schedules): Collection
    {
        if (!$schedules || $schedules->isEmpty()) {
            return collect();
        }
        
        $media    = collect();
        $position = 1;
        
        foreach ($schedules as $schedule) {
            if (!$schedule->media_id) {
                continue;
            }
            
            $mediaItem = Media::find($schedule->media_id);
            if (!$mediaItem) {
                Log::warning("Media not found for schedule ID: {$schedule->id}, media_id: {$schedule->media_id}");
                continue;
            }
            
            // Set urutan layout untuk positioning yang tepat
            $mediaItem->layout_order = $position;
            $media->push($mediaItem);
            $position++;
        }
        
        return $media;
    }

    /**
     * Mengecek apakah ada jadwal yang sedang berjalan
     * 
     * @return bool
     */
    public function hasActiveSchedules(): bool
    {
        $activeSchedules = $this->getActiveSchedule();
        return $activeSchedules !== null && $activeSchedules->isNotEmpty();
    }

    /**
     * Memperbarui background layout (atau menghapusnya jika media_id null)
     * 
     * @param  Request $request
     * @return JsonResponse
     */
    public function updateBackground(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'media_id' => 'nullable|exists:media,id'
            ]);

            $mediaId = $request->input('media_id');
            
            Log::info('Updating background', [
                'media_id' => $mediaId,
                'action' => $mediaId ? 'set' : 'clear',
                'user_id' => Auth::id()
            ]);

            DB::beginTransaction();

            // Get or create layout settings for current user
            $layoutSettings = LayoutSetting::firstOrCreate(
                ['user_id' => Auth::id()],
                ['user_id' => Auth::id()]
            );
            
            // Update background media (null to clear)
            $layoutSettings->update([
                'background_image_id' => $mediaId
            ]);

            DB::commit();

            $message = $mediaId 
                ? 'Background berhasil diperbarui' 
                : 'Background berhasil dihapus';
                
            Log::info('Background updated successfully', ['media_id' => $mediaId]);

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update background: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui background'
            ], 500);
        }
    }

    /**
     * Memperbarui deskripsi layout
     * 
     * @param  Request $request
     * @return JsonResponse
     */
    public function updateDescription(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'description' => 'required|string|max:1000'
            ]);

            DB::beginTransaction();

            // Get or create layout settings for current user
            $layoutSettings = LayoutSetting::firstOrCreate(
                ['user_id' => Auth::id()],
                ['user_id' => Auth::id()]
            );
            
            // Update description
            $layoutSettings->update([
                'description' => $request->description
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Deskripsi berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update description: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui deskripsi'
            ], 500);
        }
    }

    /**
     * Mendapatkan pengaturan layout lengkap (media, background, deskripsi)
     * 
     * @return JsonResponse
     */
    public function getLayoutSettings(): JsonResponse
    {
        try {
            $layoutSettings = LayoutSetting::with('backgroundMedia')
                ->where('user_id', Auth::id())
                ->first();
            $defaultMedia = $this->getDefaultLayoutMedia();

            // Add file_path to defaultMedia for easier access
            $defaultMediaWithPaths = $defaultMedia->map(function($media) {
                return [
                    'id' => $media->id,
                    'name' => $media->name,
                    'type' => $media->type,
                    'layout_order' => $media->layout_order,
                    'file_path' => $media->file_path
                ];
            });

            return response()->json([
                'success'           => true,
                'layout_settings'   => $layoutSettings,
                'default_media'     => $defaultMediaWithPaths,
                'background_media'  => $layoutSettings?->backgroundMedia,
                'description'       => $layoutSettings?->description
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get layout settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat pengaturan layout'
            ], 500);
        }
    }

    // ═══════════════════════════════════════════════════════════════════════
    // PRIVATE HELPER METHODS
    // ═══════════════════════════════════════════════════════════════════════

    /**
     * Mendapatkan media layout default untuk landing page
     * 
     * @return Collection
     */
    private function getDefaultLayoutMedia(): Collection
    {
        return Media::where('show_on_landing', true)
            ->whereIn('type', ['Gambar', 'Video'])
            ->whereNotNull('layout_order')
            ->orderBy('layout_order', 'asc')
            ->get(['id', 'name', 'type', 'layout_order', 'file_path']);
    }

    /**
     * Mendapatkan background terjadwal (tanpa filter user_id untuk cross-admin access)
     * 
     * @return Collection
     */
    private function getScheduledBackgrounds(): Collection
    {
        return ScheduledBackground::with('media')
            ->orderBy('start_date', 'desc')
            ->orderBy('day_of_week')
            ->orderBy('time')
            ->get();
    }

    /**
     * Menampilkan halaman layout manager
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('layout-manager');
    }
}