<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\Media;
use App\Models\Log;
use Carbon\Carbon;

class ProcessSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedules:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process and activate schedules based on current date and time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $currentDate = $now->toDateString();
        $currentTime = $now->format('H:i');
        $currentDay = $this->getDayOfWeekInIndonesian($now->dayOfWeek);

        $this->info("Processing schedules at {$now->format('Y-m-d H:i:s')}");

        // Get all schedules that should be active now
        $activeSchedules = Schedule::with('media')
            ->where('is_active', true)
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->where(function($query) use ($currentDay) {
                $query->whereNull('day_of_week')
                      ->orWhere('day_of_week', $currentDay);
            })
            ->get();

        $processedCount = 0;
        $activatedCount = 0;

        foreach ($activeSchedules as $schedule) {
            $processedCount++;
            
            // Check if time matches (if time is specified)
            $timeMatches = true;
            if ($schedule->time) {
                $scheduleTime = Carbon::parse($schedule->time)->format('H:i');
                $timeMatches = ($scheduleTime === $currentTime);
            }

            if ($timeMatches) {
                $activatedCount++;
                
                // Update media to show on landing page if it's visual media
                if (in_array($schedule->media->type, ['Gambar', 'Video'])) {
                    $schedule->media->update(['show_on_landing' => true]);
                }

                // Log the activation
                Log::create([
                    'user_id' => $schedule->media->user_id,
                    'action' => 'Schedule Activated',
                    'description' => "Schedule activated for media: {$schedule->media->name} at {$now->format('H:i')}",
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                $this->info("Activated schedule for media: {$schedule->media->name}");
            }
        }

        // Deactivate expired schedules
        $expiredSchedules = Schedule::with('media')
            ->where('is_active', true)
            ->where(function($query) use ($currentDate) {
                $query->where('end_date', '<', $currentDate);
            })
            ->get();

        $deactivatedCount = 0;
        foreach ($expiredSchedules as $schedule) {
            $schedule->update(['is_active' => false]);
            
            // Remove from landing page if it's visual media
            if (in_array($schedule->media->type, ['Gambar', 'Video'])) {
                $schedule->media->update(['show_on_landing' => false]);
            }

            $deactivatedCount++;
            
            Log::create([
                'user_id' => $schedule->media->user_id,
                'action' => 'Schedule Expired',
                'description' => "Schedule expired for media: {$schedule->media->name}",
                'created_at' => $now,
                'updated_at' => $now
            ]);

            $this->info("Deactivated expired schedule for media: {$schedule->media->name}");
        }

        $this->info("Schedule processing completed:");
        $this->info("- Processed: {$processedCount} schedules");
        $this->info("- Activated: {$activatedCount} schedules");
        $this->info("- Deactivated: {$deactivatedCount} expired schedules");

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