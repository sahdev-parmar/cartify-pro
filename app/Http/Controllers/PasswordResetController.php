<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('Auth.forgot-password');
    }
}
