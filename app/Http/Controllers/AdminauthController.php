<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminauthController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'email' => "required",
            'password' => 'required'
        ],
        [
            'email.required' => 'Enter Email Address',
            'password.required' => 'Enter Password',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$request->boolean('remember'))) 
            {

                $request->session()->regenerate();


                // type check AFTER login
                if (! in_array(Auth::guard('admin')->user()->type, ['admin', 'superadmin'])) {
                    Auth::guard('admin')->logout();

                    return back()->withErrors([
                        'invalid' => 'Email or password is incorrect',
                    ]);
                }

                // type check status login
                if (Auth::guard('admin')->user()->status == 0 ) {
                    Auth::guard('admin')->logout();

                    return back()->withErrors([
                        'invalid' => 'Your Account is Block Please Contact our admins',
                    ]);
                }

                
                return redirect()->route('admin.dashboard');

            }

        return back()->withErrors([
            'invalid' => 'Email or password is incorrect',
        ]);

        
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
