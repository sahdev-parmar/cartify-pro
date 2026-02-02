<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot-Password</title>
     <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-md w-full">
            
            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                
                <!-- Logo -->
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="inline-block">
                        <img src="{{asset('favicon.ico')}}" alt="Logo" class="h-16 w-16 mx-auto mb-4">
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Cartify Pro
                        </h1>
                    </a>
                </div>

                <!-- Step 1: Enter Email -->
                <div id="step1" class="step-content">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                            <i class="fas fa-lock text-blue-600 dark:text-blue-400 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Forgot Password?</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            No worries! Enter your email and we'll send you an OTP to reset your password.
                        </p>
                    </div>

                    <form id="emailForm">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Email Address
                            </label>
                            <input 
                                type="email" 
                                id="emailInput"
                                placeholder="your.email@example.com"
                                required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <div id="emailError" class="hidden text-red-500 text-sm mt-1"></div>
                        </div>

                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>Send OTP
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <a href="{{ route('login') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Login
                        </a>
                    </div>
                </div>

                <!-- Step 2: Enter OTP -->
                <div id="step2" class="step-content hidden">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                            <i class="fas fa-envelope text-green-600 dark:text-green-400 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Verify OTP</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            We've sent a 6-digit OTP to <span id="displayEmail" class="font-semibold"></span>
                        </p>
                    </div>

                    <!-- Demo OTP Display -->
                    <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900 border-2 border-yellow-200 dark:border-yellow-700 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-yellow-600 dark:text-yellow-400 mt-0.5 mr-2"></i>
                            <div>
                                <p class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Demo Version</p>
                                <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-1">
                                    Your OTP is: <span id="demoOtp" class="font-bold text-lg">------</span>
                                </p>
                                <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                                    (In production, this would be sent to your email)
                                </p>
                            </div>
                        </div>
                    </div>

                    <form id="otpForm">
                        @csrf
                        <!-- OTP Inputs -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Enter 6-Digit OTP
                            </label>
                            <div class="flex justify-between gap-2">
                                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" data-index="0">
                                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" data-index="1">
                                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" data-index="2">
                                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" data-index="3">
                                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" data-index="4">
                                <input type="text" maxlength="1" class="otp-input w-12 h-12 text-center text-xl font-bold border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" data-index="5">
                            </div>
                            <div id="otpError" class="hidden text-red-500 text-sm mt-2"></div>
                        </div>

                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold shadow-lg">
                            <i class="fas fa-check mr-2"></i>Verify OTP
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <button onclick="resendOtp()" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            <i class="fas fa-redo mr-1"></i>Resend OTP
                        </button>
                    </div>
                </div>

                <!-- Step 3: Reset Password -->
                <div id="step3" class="step-content hidden">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full mb-4">
                            <i class="fas fa-key text-purple-600 dark:text-purple-400 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Create New Password</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Your new password must be different from previously used passwords
                        </p>
                    </div>

                    <form id="resetForm" action="{{ route('password.reset.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" id="resetEmail">
                        
                        <!-- New Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                New Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="newPasswordReset"
                                    required
                                    minlength="8"
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                >
                                <button type="button" onclick="togglePasswordVisibility('newPasswordReset')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum 8 characters</p>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="confirmPasswordReset"
                                    required
                                    minlength="8"
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                >
                                <button type="button" onclick="togglePasswordVisibility('confirmPasswordReset')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-semibold shadow-lg">
                            <i class="fas fa-lock mr-2"></i>Reset Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>

    <script>
    let generatedOtp = '';
    let userEmail = '';

    // Step 1: Send OTP
    $('#emailForm').on('submit', function(e) {
        e.preventDefault();
        
        const email = $('#emailInput').val().trim();
        
        // Validate email format
        if (!isValidEmail(email)) {
            showError('#emailError', 'Please enter a valid email address');
            return;
        }
        
        // Check if user exists (AJAX)
        $.ajax({
            url: '{{ route("password.check.email") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: email
            },
            success: function(response) {
                if (response.exists) {
                    userEmail = email;
                    generateOtp();
                    showStep(2);
                } else {
                    showError('#emailError', 'No account found with this email address');
                }
            },
            error: function() {
                showError('#emailError', 'An error occurred. Please try again.');
            }
        });
    });

    // Step 2: Verify OTP
    $('#otpForm').on('submit', function(e) {
        e.preventDefault();
        
        const enteredOtp = getOtpValue();
        
        if (enteredOtp.length !== 6) {
            showError('#otpError', 'Please enter all 6 digits');
            return;
        }
        
        if (enteredOtp === generatedOtp) {
            $('#resetEmail').val(userEmail);
            showStep(3);
        } else {
            showError('#otpError', 'Invalid OTP. Please try again.');
            $('.otp-input').addClass('border-red-500');
        }
    });

    // Generate OTP (Demo)
    function generateOtp() {
        generatedOtp = Math.floor(100000 + Math.random() * 900000).toString();
        $('#demoOtp').text(generatedOtp);
        $('#displayEmail').text(userEmail);
    }

    // Resend OTP
    function resendOtp() {
        generateOtp();
        $('.otp-input').val('').first().focus();
        $('#otpError').addClass('hidden');
        
        // Show success message
        const message = $('<div class="text-green-600 dark:text-green-400 text-sm mt-2">OTP resent successfully!</div>');
        $('#otpForm').prepend(message);
        setTimeout(() => message.fadeOut(), 3000);
    }

    // OTP Input handling
    $('.otp-input').on('input', function() {
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

    // OTP backspace handling
    $('.otp-input').on('keydown', function(e) {
        if (e.key === 'Backspace' && $(this).val() === '') {
            const prevIndex = parseInt($(this).data('index')) - 1;
            if (prevIndex >= 0) {
                $(`.otp-input[data-index="${prevIndex}"]`).focus();
            }
        }
    });

    // Paste OTP
    $('.otp-input').first().on('paste', function(e) {
        e.preventDefault();
        const pasteData = e.originalEvent.clipboardData.getData('text');
        
        if (/^\d{6}$/.test(pasteData)) {
            pasteData.split('').forEach((digit, index) => {
                $(`.otp-input[data-index="${index}"]`).val(digit);
            });
            $('.otp-input').last().focus();
        }
    });

    // Helper functions
    function showStep(step) {
        $('.step-content').addClass('hidden');
        $(`#step${step}`).removeClass('hidden');
    }

    function getOtpValue() {
        let otp = '';
        $('.otp-input').each(function() {
            otp += $(this).val();
        });
        return otp;
    }

    function showError(selector, message) {
        $(selector).text(message).removeClass('hidden');
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        const icon = event.target.closest('button').querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html>