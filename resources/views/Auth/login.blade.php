<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Cartify Pro</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 antialiased">
    
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full">
            
            <!-- Dark Mode Toggle -->
            <div class="flex justify-end mb-4">
                <button 
                    onclick="toggleDarkMode()" 
                    class="p-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                    title="Toggle Dark Mode"
                >
                    <i class="fas fa-moon text-gray-600 dark:text-gray-300" id="darkModeIcon"></i>
                </button>
            </div>

            <!-- Logo Section -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2">
                    <div class="w-15 h-15 flex items-center justify-center">
                        <img src="{{asset('favicon.ico')}}" alt="icon" class="rounded-lg">
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Cartify Pro
                    </span>
                </a>
                <h2 class="mt-6 text-3xl font-bold text-gray-900 dark:text-white">Welcome Back!</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Sign in to your account to continue</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
                
                <!-- Success Message -->
                @if (session('success'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-2"></i>
                            <p class="text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 mr-2"></i>
                            <p class="text-sm text-red-800 dark:text-red-300">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                        <ul class="text-sm text-red-800 dark:text-red-300 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center space-x-2">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('post-login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-envelope text-gray-400 dark:text-gray-500 mr-2"></i>Email Address
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            autofocus 
                            autocomplete="username"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500"
                            placeholder="you@example.com"
                        >
                        @error('email')
                            <span class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-lock text-gray-400 dark:text-gray-500 mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                autocomplete="current-password"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Enter your password"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300"
                            >
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-500 dark:text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:bg-gray-700"
                            >
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        </label>

                        {{-- <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                            Forgot password?
                        </a> --}}
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transform transition-all duration-200 hover:scale-[1.02]"
                    >
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>

                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                            Sign up for free
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <div class="flex items-center justify-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                    <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dark Mode Toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            const icon = document.getElementById('darkModeIcon');
            
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                localStorage.setItem('darkMode', 'light');
            } else {
                html.classList.add('dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                localStorage.setItem('darkMode', 'dark');
            }
        }

        // Initialize dark mode from localStorage
        if (localStorage.getItem('darkMode') === 'dark' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.getElementById('darkModeIcon').classList.remove('fa-moon');
            document.getElementById('darkModeIcon').classList.add('fa-sun');
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            const successAlert = document.querySelector('.bg-green-50, .dark\\:bg-green-900\\/30');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>