<?php

namespace App\Http\Controllers;

use App\Models\ScheduledBackground;
use App\Models\Media;
use App\Models\LayoutSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ScheduledBackgroundController extends Controller
{
    public function index()
    {
        $scheduledBackgrounds = ScheduledBackground::where('user_id', Auth::id())
            ->with('media')
            ->orderBy('start_date', 'desc')
            ->orderByRaw("CASE 
                WHEN day_of_week = 'senin' THEN 1 
                WHEN day_of_week = 'selasa' THEN 2
                WHEN day_of_week = 'rabu' THEN 3
                WHEN day_of_week = 'kamis' THEN 4
                WHEN day_of_week = 'jumat' THEN 5
                WHEN day_of_week = 'sabtu' THEN 6
                WHEN day_of_week = 'minggu' THEN 7
                ELSE 8
            END")
            ->orderBy('time')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $scheduledBackgrounds
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'media_id' => 'required|exists:media,id',
            'start_date' => 'required|date|after_or_equal:today',
            'day_of_week' => 'nullable|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
            'time' => 'nullable|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Verify media belongs to user and is an image or video
            $media = Media::where('id', $request->media_id)
                ->where('user_id', Auth::id())
                ->whereIn('type', ['Gambar', 'Video'])
                ->firstOrFail();

            $scheduledBackground = ScheduledBackground::create([
                'user_id' => Auth::id(),
                'media_id' => $media->id,
                'start_date' => $request->start_date,
                'day_of_week' => $request->day_of_week,
                'time' => $request->time,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Background berhasil dijadwalkan',
                'data' => $scheduledBackground->load('media')
            ]);

        } catch (\Exception $e) {
            \Log::error('Error scheduling background: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan jadwal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $scheduledBackground = ScheduledBackground::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $scheduledBackground->delete();

            return response()->json([
                'success' => true,
                'message' => 'Jadwal background berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error deleting scheduled background: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus jadwal background',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get the currently active background based on schedule
     */
    public function getActiveBackground()
    {
        try {
            $now = now();
            $dayOfWeek = strtolower($now->isoFormat('dddd'));
            $time = $now->format('H:i');
            
            // Check for scheduled background that matches current time
            $scheduledBackground = ScheduledBackground::with('media')
                ->where('user_id', Auth::id())
                ->where('start_date', '<=', $now->toDateString())
                ->where(function($query) use ($dayOfWeek) {
                    $query->whereNull('day_of_week')
                          ->orWhere('day_of_week', $dayOfWeek);
                })
                ->where(function($query) use ($time) {
                    $query->whereNull('time')
                          ->orWhere('time', '<=', $time);
                })
                ->orderBy('start_date', 'desc')
                ->orderByRaw("CASE WHEN day_of_week IS NULL THEN 1 ELSE 0 END")
                ->orderBy('day_of_week')
                ->orderBy('time', 'desc')
                ->first();

            if ($scheduledBackground && $scheduledBackground->media) {
                return response()->json([
                    'success' => true,
                    'type' => 'scheduled',
                    'background' => [
                        'id' => $scheduledBackground->media->id,
                        'url' => $scheduledBackground->media->getUrl(),
                        'media_type' => $scheduledBackground->media->type,
                        'scheduled_start' => $scheduledBackground->start_date,
                        'scheduled_day' => $scheduledBackground->day_of_week,
                        'scheduled_time' => $scheduledBackground->time,
                    ]
                ]);
            }

            // Fallback to default background
            $layoutSettings = LayoutSetting::where('user_id', Auth::id())->first();
            
            if ($layoutSettings && $layoutSettings->backgroundMedia) {
                return response()->json([
                    'success' => true,
                    'type' => 'default',
                    'background' => [
                        'id' => $layoutSettings->backgroundMedia->id,
                        'url' => $layoutSettings->backgroundMedia->getUrl(),
                        'media_type' => $layoutSettings->backgroundMedia->type,
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Tidak ada background yang tersedia'
            ], 404);

        } catch (\Exception $e) {
            \Log::error('Error getting active background: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil background',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
