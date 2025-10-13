<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\LayoutSetting;
use App\Models\LayoutTemplate;
use App\Models\Schedule;
use App\Models\ScheduledBackground;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LayoutController extends Controller
{
    /**
     * Get current layout status including default layout media
     */
    public function getCurrentLayoutStatus()
    {
        try {
            // Get default layout media (show_on_landing = true with layout_order)
            $defaultMedia = Media::where('show_on_landing', true)
                ->whereIn('type', ['Gambar', 'Video'])
                ->whereNotNull('layout_order')
                ->orderBy('layout_order', 'asc')
                ->get(['id', 'name', 'type', 'layout_order']);

            // Get scheduled backgrounds
            $scheduledBackgrounds = ScheduledBackground::where('user_id', Auth::id())
                ->with('media')
                ->orderBy('start_date', 'desc')
                ->orderBy('day_of_week')
                ->orderBy('time')
                ->get();

            return response()->json([
                'success' => true,
                'defaultMedia' => $defaultMedia,
                'scheduledBackgrounds' => $scheduledBackgrounds
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal memuat status layout',
                'defaultMedia' => [],
                'scheduledBackgrounds' => []
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
