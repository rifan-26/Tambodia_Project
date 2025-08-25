<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Log;
use Carbon\Carbon;

class DeleteOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete logs older than 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deleted = Log::where('created_at', '<', Carbon::now()->subHours(24))->delete();
        
        $this->info("Deleted {$deleted} old log entries.");
        
        return Command::SUCCESS;
    }
}
