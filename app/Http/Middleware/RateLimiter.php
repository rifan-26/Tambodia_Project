<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter as FacadesRateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RateLimiter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $limiterName
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $limiterName = 'api')
    {
        $key = $limiterName . ':' . ($request->user() ? $request->user()->id : $request->ip());
        
        $executed = FacadesRateLimiter::attempt(
            $key,
            $perMinute = 60,
            function() use ($request, $next) {
                return $next($request);
            }
        );
        
        if (!$executed) {
            return response()->json([
                'message' => 'Too many requests. Please try again later.'
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }
        
        $response = $next($request);
        
        return $response;
    }
}