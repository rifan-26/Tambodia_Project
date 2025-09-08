<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Log;
use App\Jobs\ProcessScheduleJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Process schedules every minute for 100% reliability
        $schedule->command('schedules:process')
                 ->everyMinute()
                 ->withoutOverlapping()
                 ->runInBackground();

        // Also dispatch queue job as backup every minute
        $schedule->job(new ProcessScheduleJob)
                 ->everyMinute()
                 ->withoutOverlapping();

        // Delete logs older than 24 hours
        $schedule->call(function () {
            Log::where('created_at', '<', now()->subHours(24))->delete();
        })->hourly();

        // Clean up failed jobs older than 7 days
        $schedule->call(function () {
            \DB::table('failed_jobs')
                ->where('failed_at', '<', now()->subDays(7))
                ->delete();
        })->daily();

        // Ensure queue workers are running (restart if needed)
        $schedule->command('queue:restart')
                 ->hourly()
                 ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}