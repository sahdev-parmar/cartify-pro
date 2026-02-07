<?php

namespace App\Livewire\Admin\ForgotPassword;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $step = 1;
    public $email = '';
    public $otp = ['', '', '', '', '', ''];
    public $generatedOtp = '';
    public $newPassword = '';
    public $confirmPassword = '';

    public function sendOtp()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
        ],[
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.exists' => 'No admin account found with this email address',
        ]);

        // Check if user is admin
        $user = User::where('email', $this->email)->first();
        
        if (!$user || $user->type !== 'admin') {
            $this->addError('email', 'This email is not associated with an admin account');
            return;
        }

        // Generate 6-digit OTP
        $this->generatedOtp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in session with timestamp
        Session::put('admin_otp', [
            'otp' => $this->generatedOtp,
            'email' => $this->email,
            'created_at' => now()
        ]);

        // TODO: Send OTP via email
        // Mail::to($this->email)->send(new AdminOtpMail($this->generatedOtp));

        // Move to step 2
        $this->step = 2;
        
        session()->flash('message', 'OTP sent successfully to your email');
        
        // Focus first OTP input
        $this->dispatch('focus-first-otp');
    }

    public function verifyOtp()
    {
        $enteredOtp = implode('', $this->otp);
        
        if (strlen($enteredOtp) !== 6) {
            $this->addError('otp', 'Please enter all 6 digits');
            return;
        }

        $sessionOtp = Session::get('admin_otp');
        
        if (!$sessionOtp) {
            $this->addError('otp', 'OTP expired. Please request a new one');
            return;
        }

        // Check if OTP is expired (10 minutes)
        if (now()->diffInMinutes($sessionOtp['created_at']) > 10) {
            Session::forget('admin_otp');
            $this->addError('otp', 'OTP expired. Please request a new one');
            return;
        }

        if ($enteredOtp !== $sessionOtp['otp']) {
            $this->addError('otp', 'Invalid OTP. Please try again');
            $this->clearOtpInputs();
            $this->dispatch('focus-first-otp');
            return;
        }

        // OTP verified, move to step 3
        $this->step = 3;
        session()->flash('message', 'OTP verified successfully');
    }

    public function resendOtp()
    {
        $sessionOtp = Session::get('admin_otp');
        
        if (!$sessionOtp) {
            return redirect()->route('admin.forgot-password');
        }

        // Generate new OTP
        $this->generatedOtp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        Session::put('admin_otp', [
            'otp' => $this->generatedOtp,
            'email' => $sessionOtp['email'],
            'created_at' => now()
        ]);

        // TODO: Send OTP via email
        // Mail::to($sessionOtp['email'])->send(new AdminOtpMail($this->generatedOtp));

        $this->clearOtpInputs();
        session()->flash('message', 'New OTP sent successfully');
        
        // Focus first OTP input
        $this->dispatch('focus-first-otp');
    }

    public function resetPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword'
        ], [
            'newPassword.required' => 'New password is required',
            'newPassword.min' => 'Password must be at least 6 characters',
            'confirmPassword.required' => 'Please confirm your password',
            'confirmPassword.same' => 'Passwords do not match'
        ]);

        $sessionOtp = Session::get('admin_otp');
        
        if (!$sessionOtp) {
            session()->flash('error', 'Session expired. Please try again');
            return redirect()->route('admin.forgot-password');
        }

        // Update password
        $user = User::where('email', $this->email)->first();
        $user->password = Hash::make($this->newPassword);
        $user->save();

        // Clear session
        Session::forget('admin_otp');

        session()->flash('success', 'Password reset successfully!');
        return redirect()->route('admin.login');
    }

    public function backToStep1()
    {
        $this->reset(['step', 'email', 'otp', 'generatedOtp', 'newPassword', 'confirmPassword']);
        Session::forget('admin_otp');
    }

    private function clearOtpInputs()
    {
        $this->otp = ['', '', '', '', '', ''];
        $this->dispatch('focusOtpInput', index: 0);
    }

    public function render()
    {
        return view('livewire.admin.forgot-password.forgot-password');
    }
}
