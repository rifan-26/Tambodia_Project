<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\LayoutSetting;
use App\Models\LayoutTemplate;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LayoutController extends Controller
{
    public function index()
    {
        // Get images and videos for the layout selector
        $media = Media::where('user_id', Auth::id())
            ->whereIn('type', ['Gambar', 'Video'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get current layout settings
        $layoutSetting = LayoutSetting::where('user_id', Auth::id())->first();
        $description = $layoutSetting ? $layoutSetting->description : 'Default description';

        // Check for active schedule
        $activeSchedule = $this->getActiveSchedule();
        
        if ($activeSchedule) {
            // Use scheduled media if there's an active schedule
            $layoutImages = $this->getScheduledMedia($activeSchedule);
            
            // Create position map from scheduled media
            $positionMap = [];
            foreach ($layoutImages as $media) {
                $positionMap[$media->layout_order] = $media;
            }
            
            // Fill empty positions up to 6
            for ($i = 1; $i <= 6; $i++) {
                if (!isset($positionMap[$i])) {
                    $positionMap[$i] = null;
                }
            }
        } else {
            // Use default layout media
            $layoutImages = Media::where('user_id', Auth::id())
                ->where('show_on_landing', true)
                ->orderBy('layout_order', 'asc')
                ->get();

            $allLayoutImages = Media::where('show_on_landing', true)
                ->whereNotNull('layout_order')
                ->orderBy('layout_order', 'asc')
                ->get();

            $positionMap = [];
            for ($i = 1; $i <= 6; $i++) {
                $positionMap[$i] = $allLayoutImages->where('layout_order', $i)->first();
            }
        }

        $templates = LayoutTemplate::where('user_id', Auth::id())
            ->orWhere('is_public', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('layout', compact('media', 'description', 'layoutImages', 'positionMap', 'templates', 'activeSchedule'));
    }

    public function getBackground()
    {
        try {
            $layoutSetting = LayoutSetting::where('user_id', Auth::id())->first();
            
            if ($layoutSetting && $layoutSetting->background_image_id) {
                $backgroundMedia = Media::find($layoutSetting->background_image_id);
                
                if ($backgroundMedia) {
                    return response()->json([
                        'success' => true,
                        'background' => $backgroundMedia
                    ]);
                }
            }
            
            return response()->json([
                'success' => true,
                'background' => null
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memuat background'], 500);
        }
    }

    public function updateBackground(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'background_image_id' => 'nullable|integer|exists:media,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }

            $layoutSetting = LayoutSetting::firstOrCreate(
                ['user_id' => Auth::id()],
                ['description' => 'Default description']
            );

            $layoutSetting->background_image_id = $request->background_image_id;
            $layoutSetting->save();

            $message = $request->background_image_id ? 'Background berhasil diperbarui' : 'Background berhasil dihapus';
            return response()->json(['success' => true, 'message' => 'Background updated successfully']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function updateLayout(Request $request)
    {
        try {
            $layoutData = $request->input('layout', []);
            
            // Begin database transaction
            DB::beginTransaction();
            
            // Before clearing layout, check for conflicting schedules
            $conflictingSchedules = [];
            foreach ($layoutData as $position => $mediaId) {
                if ($mediaId && is_numeric($mediaId)) {
                    // Find schedules that use this position and have different media
                    $schedules = Schedule::where('is_active', true)
                        ->whereJsonContains('layout_positions', [(int)$position])
                        ->where('media_id', '!=', $mediaId)
                        ->get();
                    
                    foreach ($schedules as $schedule) {
                        $conflictingSchedules[] = $schedule->id;
                    }
                    
                    // Also check single media schedules that conflict with this position
                    $singleMediaSchedules = Schedule::where('is_active', true)
                        ->where('media_id', '!=', $mediaId)
                        ->whereNull('layout_positions')
                        ->get();
                    
                    foreach ($singleMediaSchedules as $schedule) {
                        $conflictingSchedules[] = $schedule->id;
                    }
                }
            }
            
            // Deactivate conflicting schedules
            if (!empty($conflictingSchedules)) {
                Schedule::whereIn('id', array_unique($conflictingSchedules))
                    ->update(['is_active' => false]);
            }
            
            // Clear existing layout for this user
            Media::where('user_id', Auth::id())
                ->update(['show_on_landing' => false, 'layout_order' => null]);
            
            $updatedCount = 0;
            
            // Process each position in the layout
            foreach ($layoutData as $position => $mediaId) {
                if ($mediaId && is_numeric($mediaId)) {
                    $media = Media::where('id', $mediaId)
                        ->where('user_id', Auth::id())
                        ->first();
                    
                    if ($media) {
                        $media->update([
                            'show_on_landing' => true,
                            'layout_order' => (int)$position
                        ]);
                        $updatedCount++;
                    }
                }
            }
            
            // Commit the transaction
            DB::commit();
            
            // Log the action
            $deactivatedCount = count(array_unique($conflictingSchedules));
            $logMessage = "Updated layout with {$updatedCount} media items";
            if ($deactivatedCount > 0) {
                $logMessage .= " and deactivated {$deactivatedCount} conflicting schedules";
            }
            Log::createLog(Auth::id(), 'Update Layout', $logMessage);
            
            $responseMessage = $updatedCount > 0 
                ? "Layout berhasil disimpan dengan {$updatedCount} media!"
                : 'Layout berhasil disimpan (tanpa media)!';
            
            if ($deactivatedCount > 0) {
                $responseMessage .= " {$deactivatedCount} jadwal yang bertentangan telah dinonaktifkan.";
            }
            
            return response()->json([
                'success' => true,
                'message' => $responseMessage
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Illuminate\Support\Facades\Log::error('Error updating layout: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan layout'
            ], 500);
        }
    }

    /**
     * Get currently active schedule
     */
    private function getActiveSchedule()
    {
        $now = now();
        $currentDay = strtolower($now->format('l')); // Get day name in English
        $currentTime = $now->format('H:i:s');
        
        // Map English day names to Indonesian
        $dayMap = [
            'monday' => 'senin',
            'tuesday' => 'selasa', 
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu'
        ];
        
        $indonesianDay = $dayMap[$currentDay] ?? null;
        
        if (!$indonesianDay) {
            return null;
        }
        
        // Find all active schedules for current day and time
        $activeSchedules = Schedule::where('day_of_week', $indonesianDay)
            ->where('time', '<=', $currentTime)
            ->whereDate('start_date', '<=', $now->toDateString())
            ->where('is_active', true)
            ->get();
            
        return $activeSchedules->isNotEmpty() ? $activeSchedules : null;
    }

    /**
     * Get media for scheduled display
     */
    private function getScheduledMedia($schedules)
    {
        if (!$schedules) {
            return collect();
        }
        
        // Handle collection of schedules
        if ($schedules instanceof \Illuminate\Database\Eloquent\Collection) {
            $media = collect();
            $position = 1;
            
            foreach ($schedules as $schedule) {
                if ($schedule->media_id) {
                    $mediaItem = Media::find($schedule->media_id);
                    if ($mediaItem) {
                        $mediaItem->layout_order = $position;
                        $media->push($mediaItem);
                        $position++;
                    }
                }
            }
            
            return $media;
        }
        
        // Handle single schedule (backward compatibility)
        if ($schedules->media_id) {
            $mediaItem = Media::find($schedules->media_id);
            if ($mediaItem) {
                $mediaItem->layout_order = 1;
                return collect([$mediaItem]);
            }
        }
        
        return collect();
    }
}
