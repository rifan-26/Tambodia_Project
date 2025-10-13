<?php

use Illuminate\Support\Facades\Route;
use App\Models\Schedule;
use App\Models\Media;

Route::get('/test/create-schedule', function () {
    // Get first available media
    $media = Media::first();
    
    if (!$media) {
        return response()->json(['error' => 'No media found. Please upload media first.']);
    }
    
    // Create a test schedule for current time + 1 minute
    $now = now();
    $scheduleTime = $now->addMinute()->format('H:i');
    
    $schedule = Schedule::create([
        'media_id' => $media->id,
        'start_date' => $now->toDateString(),
        'day_of_week' => null, // Any day
        'time' => $scheduleTime,
        'layout_positions' => [2], // Portrait position
        'is_active' => true
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Test schedule created',
        'schedule' => [
            'id' => $schedule->id,
            'media_name' => $media->name,
            'scheduled_time' => $scheduleTime,
            'current_time' => now()->format('H:i'),
            'date' => $schedule->start_date,
            'position' => $schedule->layout_positions[0]
        ]
    ]);
});

Route::get('/test/check-schedule-now', function () {
    $now = now();
    $currentTime = $now->format('H:i');
    
    // Create a schedule for RIGHT NOW
    $media = Media::first();
    
    if (!$media) {
        return response()->json(['error' => 'No media found']);
    }
    
    // Delete any existing schedules first
    Schedule::truncate();
    
    $schedule = Schedule::create([
        'media_id' => $media->id,
        'start_date' => $now->toDateString(),
        'day_of_week' => null,
        'time' => $currentTime,
        'layout_positions' => [2],
        'is_active' => true
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Schedule created for current time',
        'schedule' => $schedule,
        'current_time' => $currentTime,
        'check_landing_page' => url('/')
    ]);
});
