<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            if($request->is('admin/login') && Auth::guard('admin')->check() && Auth::guard('admin')->user()->type != 'user' ){
                return redirect()->route('admin.dashboard');
            }
        }
        if($type == 'dashboard'){

            if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->type == 'user') {
                return redirect()->route('admin.login');
            }
        }
        return $next($request);
    }
}
