<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Jobs\ProcessScheduleJob;
use Illuminate\Support\Facades\Cache;

class ProcessSchedulesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Only process schedules once per minute to avoid overload
        $cacheKey = 'schedule_processed_' . now()->format('Y-m-d-H-i');
        
        if (!Cache::has($cacheKey)) {
            // Dispatch job to process schedules
            ProcessScheduleJob::dispatch();
            
            // Cache for 1 minute to prevent duplicate processing
            Cache::put($cacheKey, true, 60);
        }

        return $next($request);
    }
}