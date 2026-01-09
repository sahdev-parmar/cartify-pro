<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->boolean('remember'))) 
            {

                $request->session()->regenerate();

                // type check AFTER login
                if (! in_array(auth()->user()->type, ['admin', 'superadmin'])) {
                    Auth::logout();

                    return back()->withErrors([
                        'invalid' => 'Email or password is incorrect',
                    ]);
                }

                // type check status login
                if (auth()->user()->status == 0 ) {
                    Auth::logout();

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

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login');
    }
}
