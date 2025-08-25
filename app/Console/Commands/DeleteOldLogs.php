<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Log;

class DeleteOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:delete-old';

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
        $count = Log::where('created_at', '<', now()->subHours(24))->delete();
        $this->info("Deleted {$count} old log entries.");
        return Command::SUCCESS;
    }
}