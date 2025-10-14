<?php
namespace App\Http\Controllers;
use App\Models\Schedule;
use App\Models\Media;
use App\Models\LayoutSetting;
use App\Models\ScheduleDescription;
use App\Models\ScheduledBackground;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get active schedules and media with conflict resolution
        $activeSchedules = $this->getActiveSchedule();
        $media = $this->getScheduledMedia($activeSchedules);

        // Always use scheduled media if available, otherwise fallback to default
        if ($media && $media->isNotEmpty()) {
            $layoutImages = $media;
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

        // Get layout settings (background and description)
        $layoutSettings = LayoutSetting::first();
        
        // Get active scheduled background or fallback to default
        $activeBackground = $this->getActiveScheduledBackground();
        $backgroundImage = $activeBackground ? $activeBackground->media : ($layoutSettings ? $layoutSettings->backgroundMedia : null);
        
        // Get active description from schedule descriptions or fallback to layout description
        $activeDescription = $this->getActiveScheduleDescription();
        $description = $activeDescription ? $activeDescription->description : ($layoutSettings ? $layoutSettings->description : null);

        // Set default values
        $layoutConfig = [
            'type' => 'grid',
            'duration' => 10,
            'settings' => []
        ];

        return view('landingpage', compact('media', 'backgroundImage', 'description', 'activeSchedules', 'layoutConfig'));
    }

    /**
     * Get currently active schedule
     */
    private function getActiveSchedule()
    {
        $now = now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i');
        $currentDay = strtolower($now->translatedFormat('l'));

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

        // Debug logging
        \Log::info('Schedule Debug', [
            'current_date' => $currentDate,
            'current_time' => $currentTime,
            'current_day' => $indonesianDay
        ]);

        // Get all active schedules that should be displayed (exact time match or time range)
        $activeAudioSchedules = Schedule::where('start_date', '<=', $currentDate)
            ->where(function($query) use ($currentDate) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $currentDate);
            })
            ->where(function($query) use ($indonesianDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $indonesianDay);
            })
            ->where(function($query) use ($currentTime) {
                $query->whereNull('time')
                      ->orWhere('time', '=', $currentTime)
                      ->orWhere('time', '<=', $currentTime);
            })
            ->orderBy('start_date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        // Load media relationships separately
        $activeAudioSchedules->load('media');

        // Load media relationships separately
        $activeSchedules = Schedule::where('start_date', '<=', $currentDate)
            ->where(function($query) use ($currentDate) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $currentDate);
            })
            ->where(function($query) use ($indonesianDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $indonesianDay);
            })
            ->where(function($query) use ($currentTime) {
                $query->whereNull('time')
                      ->orWhere('time', '=', $currentTime)
                      ->orWhere('time', '<=', $currentTime);
            })
            ->orderBy('start_date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        // Load media relationships separately
        $activeSchedules->load('media');

        // Debug logging - convert to array to avoid closure issues
        if ($activeSchedules->count() > 0) {
            $scheduleData = [];
            foreach ($activeSchedules as $schedule) {
                $scheduleData[] = [
                    'id' => $schedule->id,
                    'media_name' => $schedule->media ? $schedule->media->name : 'No Media',
                    'layout_positions' => $schedule->layout_positions,
                    'time' => $schedule->time,
                    'date' => $schedule->start_date
                ];
            }
            \Log::info('Found Active Schedules', [
                'count' => $activeSchedules->count(),
                'schedules' => $scheduleData
            ]);
        } else {
            \Log::info('No active schedules found');
        }

        return $activeSchedules;
    }

    /**
     * Get active schedule description
     */
    private function getActiveScheduleDescription()
    {
        $now = now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i');
        $currentDay = strtolower($now->translatedFormat('l'));

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

        return ScheduleDescription::where('is_active', true)
            ->where('start_date', '<=', $currentDate)
            ->where(function($query) use ($currentDate) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $currentDate);
            })
            ->where(function($query) use ($indonesianDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $indonesianDay);
            })
            ->where(function($query) use ($currentTime) {
                $query->whereNull('time')
                      ->orWhere('time', '=', $currentTime);
            })
            ->orderBy('start_date', 'desc')
            ->orderBy('time', 'desc')
            ->first();
    }

    /**
     * Get media for scheduled display with layout position conflict resolution
     */
    private function getScheduledMedia($activeSchedules)
    {
        if (!$activeSchedules || $activeSchedules->isEmpty()) {
            return collect();
        }
        
        $mediaCollection = collect();
        $positionMap = []; // Track which position has which schedule
        
        // Process all active schedules and resolve position conflicts
        foreach ($activeSchedules as $schedule) {
            if ($schedule->media_id && $schedule->layout_position) {
                $mediaItem = Media::find($schedule->media_id);
                if ($mediaItem) {
                    $position = $schedule->layout_position;
                    
                    // Check if this position is already occupied
                    if (!isset($positionMap[$position])) {
                        // Position is free, assign it
                        $positionMap[$position] = $schedule;
                    } else {
                        // Position conflict - compare schedules to determine which should take precedence
                        $existingSchedule = $positionMap[$position];
                        
                        // Newer schedule (by date/time) takes precedence
                        $currentDateTime = $schedule->start_date . ' ' . ($schedule->time ?? '00:00');
                        $existingDateTime = $existingSchedule->start_date . ' ' . ($existingSchedule->time ?? '00:00');
                        
                        if ($currentDateTime >= $existingDateTime) {
                            $positionMap[$position] = $schedule;
                        }
                    }
                }
            }
        }
        
        // Convert position map to media collection
        foreach ($positionMap as $position => $schedule) {
            $mediaItem = Media::find($schedule->media_id);
            if ($mediaItem) {
                $mediaItem->layout_order = $position;
                $mediaCollection->push($mediaItem);
            }
        }
        
        return $mediaCollection;
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
     * Get active scheduled background
     */
    private function getActiveScheduledBackground()
    {
        $now = now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i');
        $currentDay = strtolower($now->translatedFormat('l'));

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

        $scheduledBackground = ScheduledBackground::where('start_date', '<=', $currentDate)
            ->where(function($query) use ($indonesianDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $indonesianDay);
            })
            ->where(function($query) use ($currentTime) {
                $query->whereNull('time')
                      ->orWhere('time', '<=', $currentTime);
            })
            ->orderBy('start_date', 'desc')
            ->orderByRaw("CASE WHEN day_of_week IS NULL THEN 1 ELSE 0 END")
            ->orderBy('day_of_week')
            ->orderBy('time', 'desc')
            ->first();

        if ($scheduledBackground) {
            $scheduledBackground->load('media');
        }

        return $scheduledBackground;
    }

    /**
     * API endpoint to get current schedule info
     */
    public function getCurrentSchedule()
    {
        $activeSchedules = $this->getActiveSchedule();
        
        // Convert collection to array to avoid closure issues
        $scheduleData = null;
        if ($activeSchedules && $activeSchedules->count() > 0) {
            $firstSchedule = $activeSchedules->first();
            $scheduleData = [
                'id' => $firstSchedule->id,
                'media_id' => $firstSchedule->media_id,
                'day_of_week' => $firstSchedule->day_of_week,
                'time' => $firstSchedule->time,
                'start_date' => $firstSchedule->start_date
            ];
        }
        
        return response()->json([
            'has_active_schedule' => $scheduleData !== null,
            'schedule' => $scheduleData
        ]);
    }

    /**
     * API endpoint to get active visual schedules
     */
    public function getActiveVisualSchedules()
    {
        $activeSchedule = $this->getActiveSchedule();
        $activeBackground = $this->getActiveScheduledBackground();
        $activeDescription = $this->getActiveScheduleDescription();
        $activeAudio = $this->getActiveAudioSchedules();
        
        $scheduledMedia = [];
        if ($activeSchedule) {
            $mediaCollection = $this->getScheduledMedia($activeSchedule);
            foreach ($mediaCollection as $media) {
                $scheduledMedia[] = [
                    'id' => $media->id,
                    'name' => $media->name,
                    'type' => $media->type,
                    'file_path' => $media->file_path,
                    'layout_order' => $media->layout_order ?? null
                ];
            }
        }
        
        // Convert audio schedules to array to avoid closure issues
        $audioData = [];
        if ($activeAudio && $activeAudio->count() > 0) {
            foreach ($activeAudio as $schedule) {
                $audioData[] = [
                    'id' => $schedule->id,
                    'media_id' => $schedule->media_id,
                    'media_name' => $schedule->media ? $schedule->media->name : 'Unknown',
                    'media_path' => $schedule->media ? $schedule->media->file_path : '',
                    'time' => $schedule->time,
                    'start_date' => $schedule->start_date,
                    'end_date' => $schedule->end_date
                ];
            }
        }

        // Convert all objects to arrays to prevent closure issues
        $mediaScheduleData = null;
        if ($activeSchedule && $activeSchedule->count() > 0) {
            $mediaScheduleData = [];
            foreach ($activeSchedule as $schedule) {
                $mediaScheduleData[] = [
                    'id' => $schedule->id,
                    'media_id' => $schedule->media_id,
                    'layout_position' => $schedule->layout_position,
                    'time' => $schedule->time,
                    'start_date' => $schedule->start_date,
                    'end_date' => $schedule->end_date
                ];
            }
        }

        $backgroundData = null;
        if ($activeBackground) {
            $backgroundData = [
                'id' => $activeBackground->id,
                'media_id' => $activeBackground->media_id,
                'time' => $activeBackground->time,
                'start_date' => $activeBackground->start_date
            ];
        }

        $descriptionData = null;
        if ($activeDescription) {
            $descriptionData = [
                'id' => $activeDescription->id,
                'description' => $activeDescription->description,
                'time' => $activeDescription->time,
                'start_date' => $activeDescription->start_date
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'media_schedule' => $mediaScheduleData,
                'scheduled_media' => $scheduledMedia,
                'background_schedule' => $backgroundData,
                'description_schedule' => $descriptionData,
                'audio_schedule' => $audioData,
                'has_active_media' => $mediaScheduleData !== null,
                'has_active_background' => $backgroundData !== null,
                'has_active_description' => $descriptionData !== null,
                'has_active_audio' => count($audioData) > 0
            ]
        ]);
    }

    /**
     * Get active audio schedules - DISABLED for landing page
     * Audio should only play in dashboard admin panel
     */
    private function getActiveAudioSchedules()
    {
        // Return empty collection - no audio on landing page
        return collect([]);
    }

    /**
     * API endpoint specifically for audio schedules - DISABLED for landing page
     * Audio should only play in dashboard admin panel
     */
    public function getActiveAudioSchedule()
    {
        return response()->json([
            'success' => true,
            'has_active_audio' => false,
            'audio_schedules' => []
        ]);
    }
}