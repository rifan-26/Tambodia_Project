<?php
namespace App\Http\Controllers;
use App\Models\Media;
use App\Models\Schedule;
use App\Models\LayoutSetting;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Check for active schedule first
        $activeSchedule = $this->getActiveSchedule();
        
        if ($activeSchedule) {
            // Use scheduled media if there's an active schedule
            $layoutImages = $this->getScheduledMedia($activeSchedule);
        } else {
            // Use default layout media
            $layoutImages = Media::where('show_on_landing', true)
                ->whereIn('type', ['Gambar', 'Video'])
                ->whereNotNull('layout_order')
                ->orderBy('layout_order', 'asc')
                ->get();
        }

        // Get all media for backward compatibility
        $media = $layoutImages;

        // Get layout description and background from settings
        $layoutSetting = LayoutSetting::first();
        $description = $layoutSetting && $layoutSetting->description ? 
            $layoutSetting->description : 
            'Kami adalah lembaga resmi pemerintah yang bertugas menyelenggarakan kegiatan statistik di wilayah Sumatera Utara. BPS hadir untuk memberikan data akurat, terpercaya, dan terkini.';
        
        // Get background image
        $backgroundImage = null;
        if ($layoutSetting && $layoutSetting->background_image_id) {
            $backgroundImage = Media::find($layoutSetting->background_image_id);
        }

        // Set default values
        $layoutConfig = [
            'type' => 'grid',
            'duration' => 10,
            'auto_rotate' => true,
            'settings' => []
        ];

        return view('landingpage', compact('media', 'layoutImages', 'description', 'backgroundImage', 'layoutConfig', 'activeSchedule'));
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

    /**
     * Convert day number to Indonesian day name
     */
    private function getDayOfWeekInIndonesian($dayNumber)
    {
        $days = [
            0 => 'minggu',
            1 => 'senin', 
            2 => 'selasa',
            3 => 'rabu',
            4 => 'kamis',
            5 => 'jumat',
            6 => 'sabtu'
        ];

        return $days[$dayNumber] ?? null;
    }

    /**
     * API endpoint to get current schedule info
     */
    public function getCurrentSchedule()
    {
        $activeSchedule = $this->getActiveSchedule();
        
        return response()->json([
            'has_active_schedule' => $activeSchedule !== null,
            'schedule' => $activeSchedule ? [
                'count' => $activeSchedule instanceof \Illuminate\Database\Eloquent\Collection ? $activeSchedule->count() : 1,
                'schedules' => $activeSchedule instanceof \Illuminate\Database\Eloquent\Collection ? 
                    $activeSchedule->map(function($schedule) {
                        return [
                            'id' => $schedule->id,
                            'media_id' => $schedule->media_id,
                            'day_of_week' => $schedule->day_of_week,
                            'time' => $schedule->time,
                            'start_date' => $schedule->start_date
                        ];
                    }) : [
                        [
                            'id' => $activeSchedule->id,
                            'media_id' => $activeSchedule->media_id,
                            'day_of_week' => $activeSchedule->day_of_week,
                            'time' => $activeSchedule->time,
                            'start_date' => $activeSchedule->start_date
                        ]
                    ]
            ] : null
        ]);
    }
}