<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminLoginRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$type): Response
    {
        if($type == 'login'){
            if($request->is('admin/login') && auth()->check() && auth()->user()->type != 'user' ){
                return redirect()->route('admin.dashboard');
            }
        }
        if($type == 'dashboard'){

            if (!auth()->check() || auth()->user()->type == 'user') {
                return redirect()->route('admin.login');
            }
        }
        return $next($request);
    }
}
