<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-md w-full">
        
        <!-- Dark Mode Toggle Button -->
        <div class="flex justify-end mb-4">
            <button id="themeToggle" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-800 rounded-lg transition-colors">
                <svg id="sunIcon" class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <svg id="moonIcon" class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('message'))
            <div class="bg-green-50 absolute right-[10px] top-[50px] w-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4" wire:poll.2s>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-green-800 dark:text-green-300">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('favicon.ico') }}" alt="Logo" class="h-16 w-20 mx-auto mb-4 rounded-lg">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    Admin Panel
                </h1>
            </a>
        </div>
        <!-- Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
            

            <!-- Step 1: Enter Email -->
            @if($step === 1)
            <div>
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                        <i class="fas fa-lock text-blue-600 dark:text-blue-400 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Forgot Password?</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        No worries! Enter your admin email and we'll send you an OTP to reset your password.
                    </p>
                </div>

                <form wire:submit.prevent="sendOtp">
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Admin Email Address
                        </label>
                        <input 
                            type="email" 
                            wire:model.defer="email"
                            placeholder="admin@example.com"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        @error('email') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold shadow-lg"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="sendOtp">
                            <i class="fas fa-paper-plane mr-2"></i>Send OTP
                        </span>
                        <span wire:loading wire:target="sendOtp">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Sending...
                        </span>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    @guest('admin')
                        <a href="{{ route('admin.login') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Admin Login
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Dashboard
                        </a>
                    @endguest
                </div>
            </div>
            @endif

            <!-- Step 2: Enter OTP -->
            @if($step === 2)
            <div>
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                        <i class="fas fa-envelope text-green-600 dark:text-green-400 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Verify OTP</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        We've sent a 6-digit OTP to <span class="font-semibold">{{ $email }}</span>
                    </p>
                </div>

                <!-- Demo OTP Display (Remove in production) -->
                <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900 border-2 border-yellow-200 dark:border-yellow-700 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-yellow-600 dark:text-yellow-400 mt-0.5 mr-2"></i>
                        <div>
                            <p class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Demo Version</p>
                            <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-1">
                                Your OTP is: <span class="font-bold text-lg">{{ $generatedOtp }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="verifyOtp">
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            Enter 6-Digit OTP
                        </label>
                        <div class="flex justify-between gap-2" id="otpInputsContainer">
                            @for($i = 0; $i < 6; $i++)
                                <input 
                                    type="text" 
                                    maxlength="1" 
                                    wire:model.live="otp.{{ $i }}"
                                    wire:key="otp-{{ $i }}"
                                    id="otp-{{ $i }}"
                                    data-index="{{ $i }}"
                                    class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                >
                            @endfor
                        </div>
                        @error('otp') 
                            <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold shadow-lg"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="verifyOtp">
                            <i class="fas fa-check mr-2"></i>Verify OTP
                        </span>
                        <span wire:loading wire:target="verifyOtp">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Verifying...
                        </span>
                    </button>
                </form>

                <div class="mt-6 text-center space-y-2">
                    <button 
                        wire:click="resendOtp" 
                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="resendOtp">
                            <i class="fas fa-redo mr-1"></i>Resend OTP
                        </span>
                        <span wire:loading wire:target="resendOtp">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Resending...
                        </span>
                    </button>
                    <br>
                    <button 
                        wire:click="backToStep1" 
                        class="text-sm text-gray-600 dark:text-gray-400 hover:underline"
                    >
                        <i class="fas fa-arrow-left mr-1"></i>Change Email
                    </button>
                </div>
            </div>
            @endif

            <!-- Step 3: Reset Password -->
            @if($step === 3)
            <div>
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full mb-4">
                        <i class="fas fa-key text-purple-600 dark:text-purple-400 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Create New Password</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Your new password must be different from previously used passwords
                    </p>
                </div>

                <form wire:submit.prevent="resetPassword">
                    <!-- New Password -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                wire:model.defer="newPassword"
                                id="newPassword"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('newPassword')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                            >
                                <i class="fas fa-eye" id="newPassword-icon"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum 6 characters</p>
                        @error('newPassword') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                wire:model.defer="confirmPassword"
                                id="confirmPassword"
                                class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                            >
                            <button 
                                type="button" 
                                onclick="togglePasswordVisibility('confirmPassword')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                            >
                                <i class="fas fa-eye" id="confirmPassword-icon"></i>
                            </button>
                        </div>
                        @error('confirmPassword') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold shadow-lg"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="resetPassword">
                            <i class="fas fa-lock mr-2"></i>Reset Password
                        </span>
                        <span wire:loading wire:target="resetPassword">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Resetting...
                        </span>
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            @guest('admin')
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Remember your password? 
                    <a href="{{ route('admin.login') }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Login</a>
                </p>
            @endguest
        </div>
    </div>
</div>

<script>
// ============================================
// DARK MODE TOGGLE (Keep as is)
// ============================================
const themeToggle = document.getElementById('themeToggle');
const html = document.documentElement;

// Check for saved theme preference or default to light mode
const currentTheme = localStorage.getItem('theme') || 'light';
if (currentTheme === 'dark') {
    html.classList.add('dark');
}

themeToggle?.addEventListener('click', () => {
    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
});

// ============================================
// PASSWORD VISIBILITY TOGGLE (Keep as is)
// ============================================
function togglePasswordVisibility(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// ============================================
// FOCUS FIRST INPUT
// ============================================
document.addEventListener('livewire:init', () => {
    Livewire.on('focus-first-otp', () => {
        setTimeout(() => {
            document.getElementById('otp-0')?.focus();
        }, 100);
    });
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@script  {{-- this tag is very important to run jquery or js in livewire --}}
<script>
// OTP Input handling
$(document).on('input','.otp-input', function() {
    const value = $(this).val();
    
    // Only allow numbers
    if (!/^\d*$/.test(value)) {
        $(this).val('');
        return;
    }
    
    $('.otp-input').removeClass('border-red-500');
    $('#otpError').addClass('hidden');
    
    // Move to next input
    if (value.length === 1) {
        const nextIndex = parseInt($(this).data('index')) + 1;
        if (nextIndex < 6) {
            $(`.otp-input[data-index="${nextIndex}"]`).focus();
        }
    }
});

$(document).on('keydown', '.otp-input', function(e) {
    if (e.key === 'Backspace' && $(this).val() === '') {
        const prevIndex = parseInt($(this).data('index')) - 1;
        if (prevIndex >= 0) {
            $(`.otp-input[data-index="${prevIndex}"]`).focus();
        }
    }
});
</script>
@endscript