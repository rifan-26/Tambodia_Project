<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Models\Schedule;

Route::get('/debug/schedule', function () {
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

    // Get all schedules for debugging
    $allSchedules = Schedule::with('media')->get();
    
    // Get active schedules based on current logic
    $activeSchedules = Schedule::where('start_date', '<=', $currentDate)
        ->where('is_active', true)
        ->where(function($query) use ($indonesianDay) {
            $query->whereNull('day_of_week')
                  ->orWhere('day_of_week', $indonesianDay);
        })
        ->where(function($query) use ($currentTime) {
            $query->whereNull('time')
                  ->orWhere('time', '<=', $currentTime);
        })
        ->with('media')
        ->orderBy('start_date', 'desc')
        ->orderBy('time', 'desc')
        ->get();

    return response()->json([
        'current_info' => [
            'date' => $currentDate,
            'time' => $currentTime,
            'day' => $indonesianDay,
            'timestamp' => $now->toDateTimeString()
        ],
        'all_schedules' => $allSchedules->map(function($schedule) {
            return [
                'id' => $schedule->id,
                'media_id' => $schedule->media_id,
                'media_name' => $schedule->media ? $schedule->media->name : 'No Media',
                'start_date' => $schedule->start_date,
                'day_of_week' => $schedule->day_of_week,
                'time' => $schedule->time,
                'is_active' => $schedule->is_active,
                'layout_positions' => $schedule->layout_positions
            ];
        }),
        'active_schedules' => $activeSchedules->map(function($schedule) {
            return [
                'id' => $schedule->id,
                'media_name' => $schedule->media ? $schedule->media->name : 'No Media',
                'start_date' => $schedule->start_date,
                'day_of_week' => $schedule->day_of_week,
                'time' => $schedule->time,
                'layout_positions' => $schedule->layout_positions
            ];
        }),
        'schedule_count' => [
            'total' => $allSchedules->count(),
            'active' => $activeSchedules->count()
        ]
    ]);
});
