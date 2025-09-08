<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Schedule;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ProcessScheduleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $timeout = 30;

    public function handle(): void
    {
        // Prevent duplicate processing within the same minute
        $cacheKey = 'schedule_processing_' . now()->format('Y-m-d_H:i');
        if (Cache::has($cacheKey)) {
            return;
        }
        Cache::put($cacheKey, true, 60);

        $now = Carbon::now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i');
        $currentDay = $this->getDayOfWeekInIndonesian($now->dayOfWeek);

        try {
            $this->processActiveSchedules($now, $currentDate, $currentTime, $currentDay);
            // Removed automatic expiration since end_date is removed
        } catch (\Exception $e) {
            $this->logError($e->getMessage(), $now);
            throw $e;
        }
    }

    private function processActiveSchedules($now, $currentDate, $currentTime, $currentDay)
    {
        $activeSchedules = Schedule::with('media')
            ->where('is_active', true)
            ->where('start_date', '<=', $currentDate)
            ->where(function($query) use ($currentDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $currentDay);
            })
            ->get();

        foreach ($activeSchedules as $schedule) {
            if ($this->shouldActivateSchedule($schedule, $currentTime)) {
                $this->activateSchedule($schedule, $now);
            }
        }
    }

    private function shouldActivateSchedule($schedule, $currentTime)
    {
        if (!$schedule->time) return true;
        
        $scheduleTime = Carbon::parse($schedule->time)->format('H:i');
        return $scheduleTime === $currentTime;
    }

    private function activateSchedule($schedule, $now)
    {
        if (in_array($schedule->media->type, ['Gambar', 'Video'])) {
            $schedule->media->update(['show_on_landing' => true]);
        }

        Log::create([
            'user_id' => $schedule->media->user_id,
            'action' => 'Schedule Activated',
            'description' => "Media '{$schedule->media->name}' activated at {$now->format('H:i')}",
            'created_at' => $now,
        ]);
    }

    private function deactivateExpiredSchedules($now, $currentDate)
    {
        // Since we removed end_date, schedules don't automatically expire
        // They remain active until manually deactivated
        // This method is kept for future use if needed
    }

    private function logError($message, $now)
    {
        Log::create([
            'user_id' => null,
            'action' => 'Schedule Error',
            'description' => "Schedule processing error: $message",
            'created_at' => $now,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::create([
            'user_id' => null,
            'action' => 'Schedule Job Failed',
            'description' => "Schedule job failed: " . $exception->getMessage(),
            'created_at' => now(),
        ]);
    }

    private function getDayOfWeekInIndonesian($dayNumber)
    {
        return [
            0 => 'minggu', 1 => 'senin', 2 => 'selasa', 3 => 'rabu',
            4 => 'kamis', 5 => 'jumat', 6 => 'sabtu'
        ][$dayNumber] ?? null;
    }
}