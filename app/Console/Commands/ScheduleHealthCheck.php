<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\Log;
use Carbon\Carbon;

class ScheduleHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedules:health-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the health of the scheduling system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Schedule System Health Check ===');
        
        $now = Carbon::now();
        $this->info("Current time: {$now->format('Y-m-d H:i:s')}");
        
        // Check total schedules
        $totalSchedules = Schedule::count();
        $this->info("Total schedules: {$totalSchedules}");
        
        // Check active schedules
        $activeSchedules = Schedule::where('is_active', true)->count();
        $this->info("Active schedules: {$activeSchedules}");
        
        // Check currently running schedules
        $currentDate = $now->toDateString();
        $currentDay = $this->getDayOfWeekInIndonesian($now->dayOfWeek);
        
        $currentlyRunning = Schedule::with('media')
            ->where('is_active', true)
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->where(function($query) use ($currentDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $currentDay);
            })
            ->get();
            
        $this->info("Currently eligible schedules: {$currentlyRunning->count()}");
        
        if ($currentlyRunning->count() > 0) {
            $this->info("\nCurrently eligible schedules:");
            foreach ($currentlyRunning as $schedule) {
                $timeInfo = $schedule->time ? "at {$schedule->time}" : "all day";
                $dayInfo = $schedule->day_of_week ? "on {$schedule->day_of_week}" : "daily";
                $this->info("- {$schedule->media->name} ({$schedule->media->type}) {$timeInfo} {$dayInfo}");
            }
        }
        
        // Check recent logs
        $recentLogs = Log::where('action', 'like', '%Schedule%')
                         ->where('created_at', '>=', $now->subHours(1))
                         ->count();
        $this->info("\nRecent schedule logs (last hour): {$recentLogs}");
        
        // Check queue status
        $pendingJobs = \DB::table('jobs')->count();
        $failedJobs = \DB::table('failed_jobs')->count();
        $this->info("Pending queue jobs: {$pendingJobs}");
        $this->info("Failed queue jobs: {$failedJobs}");
        
        // Check for potential issues
        $this->info("\n=== Potential Issues ===");
        
        $expiredSchedules = Schedule::where('is_active', true)
                                   ->where('end_date', '<', $currentDate)
                                   ->count();
        if ($expiredSchedules > 0) {
            $this->warn("⚠️  {$expiredSchedules} schedules are expired but still active");
        }
        
        if ($failedJobs > 0) {
            $this->warn("⚠️  {$failedJobs} failed jobs in queue");
        }
        
        // Recommendations
        $this->info("\n=== Recommendations ===");
        $this->info("✓ Run 'php artisan schedule:run' every minute via cron");
        $this->info("✓ Run 'php artisan queue:work' to process queue jobs");
        $this->info("✓ Monitor logs for schedule activation/deactivation");
        
        $this->info("\n=== Health Check Complete ===");
        
        return Command::SUCCESS;
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
}