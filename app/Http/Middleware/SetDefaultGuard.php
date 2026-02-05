<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetDefaultGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          // 1. Check if the session has our custom guard marker
        if ($guard = session('active_guard')) {
            auth()->shouldUse($guard);
        } 
        // 2. Fallback: If it's an admin URL but no session yet, force admin
        elseif ($request->is('admin*')) {
            auth()->shouldUse('admin');
        }
        return $next($request);
    }
}
