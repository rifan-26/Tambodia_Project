<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        
        array_walk_recursive($input, function(&$value) {
            if (is_string($value)) {
                // Remove HTML and PHP tags
                $value = strip_tags($value);
                
                // Convert special characters to HTML entities
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
            }
        });
        
        $request->merge($input);
        
        return $next($request);
    }
}