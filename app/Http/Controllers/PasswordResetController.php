<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('Auth.forgot-password');
    }

    public function checkEmail(Request $request)
    {
         $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate 6-digit OTP
            $otp = rand(100000, 999999);
            
            // Store OTP in session (demo version)
            Session::put('reset_otp', $otp);
            Session::put('reset_email', $request->email);
            Session::put('otp_generated_at', now());
            
            // In production, send OTP to email
            // Mail::to($request->email)->send(new OtpMail($otp));
            
            return response()->json([
                'exists' => true,
                'message' => 'OTP sent to your email',
                'otp' => $otp // Only for demo - remove in production
            ]);
        }

        return response()->json([
            'exists' => false,
            'message' => 'Email not found'
        ], 404);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ]);

        $storedOtp = Session::get('reset_otp');
        $generatedAt = Session::get('otp_generated_at');
        
        // Check if OTP exists
        if (!$storedOtp) {
            return response()->json([
                'valid' => false,
                'message' => 'OTP expired. Please request a new one.'
            ], 422);
        }
        
        // Check if OTP is expired (10 minutes)
        if (now()->diffInMinutes($generatedAt) > 10) {
            Session::forget(['reset_otp', 'reset_email', 'otp_generated_at']);
            return response()->json([
                'valid' => false,
                'message' => 'OTP expired. Please request a new one.'
            ], 422);
        }
        
        // Verify OTP
        if ($request->otp == $storedOtp) {
            // Mark OTP as verified
            Session::put('otp_verified', true);
            
            return response()->json([
                'valid' => true,
                'message' => 'OTP verified successfully'
            ]);
        }
        
        return response()->json([
            'valid' => false,
            'message' => 'Invalid OTP. Please try again.'
        ], 422);
    }

    public function resendOtp()
    {
        $email = Session::get('reset_email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please start again.'
            ], 422);
        }
        
        // Generate new OTP
        $otp = rand(100000, 999999);
        
        // Update session
        Session::put('reset_otp', $otp);
        Session::put('otp_generated_at', now());
        
        // In production, send OTP to email
        // Mail::to($email)->send(new OtpMail($otp));
        
        return response()->json([
            'success' => true,
            'message' => 'OTP resent successfully',
            'otp' => $otp // Only for demo - remove in production
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // Check if OTP was verified
        if (!Session::get('otp_verified')) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify OTP first'
            ], 422);
        }
        
        // Check if email matches
        if ($request->email !== Session::get('reset_email')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Clear session
        Session::forget(['reset_otp', 'reset_email', 'otp_generated_at', 'otp_verified']);

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully! Please login with your new password.'
        ]);
    }
}
