<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register User</title>
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
<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 antialiased">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-5xl w-full">
            
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
                <h2 class="mt-6 text-3xl font-bold text-gray-900">Create Account</h2>
                <p class="mt-2 text-sm text-gray-600">Join us today and start shopping!</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                

                <form method="POST" action="{{ route('post-register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                            Personal Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    id="name" 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    autofocus
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="John Doe"
                                >
                                @error('name')
                                    <span class="text-red-500 text-sm ">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Gender <span class="text-red-500">*</span>
                                </label>
                                <div class="flex space-x-4 pt-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="0" {{ old('gender') == '0' ? 'checked' : '' }}  class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">
                                            <i class="fas fa-mars text-blue-600 mr-1"></i>Male
                                        </span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }}  class="w-5 h-5 text-pink-600 border-gray-300 focus:ring-pink-500">
                                        <span class="ml-2 text-sm text-gray-700">
                                            <i class="fas fa-venus text-pink-600 mr-1"></i>Female
                                        </span>
                                    </label>
                                </div>
                                 @error('gender')
                                    <span class="text-red-500 text-sm ">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Profile Image Upload -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-camera text-gray-400 mr-2"></i>Profile Picture <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden" id="imagePreview">
                                        <i class="fas fa-user text-gray-400 text-2xl"></i>
                                    </div>
                                    <label class="cursor-pointer">
                                        <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 inline-flex items-center">
                                            <i class="fas fa-upload mr-2"></i>Choose Image
                                        </span>
                                        <input type="file" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                                    </label>
                                </div>
                                 @error('image')
                                    <span class="text-red-500 text-sm ">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                      
                    </div>

                    <hr class="border-gray-200">

                    <!-- Contact & Address Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-address-card text-blue-600 mr-2"></i>
                            Contact & Address
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="you@example.com"
                                >
                                 @error('email')
                                    <span class="text-red-500 text-sm ">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Mobile Number -->
                            <div class="md:col-span-2">
                                <label for="mobile_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    Mobile Number
                                </label>
                                <input 
                                    id="mobile_number" 
                                    type="tel" 
                                    name="mobile_number" 
                                    value="{{ old('mobile_number') }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="+1 234 567 8900"
                                >
                                @error('mobile_number')
                                    <span class="text-red-500 text-sm ">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-4">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Street Address
                                </label>
                                <textarea 
                                    id="address" 
                                    name="address" 
                                    rows="2"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="123 Main Street, Apartment 4B"
                                >{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="text-red-500 text-sm ">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div>
                                <label for="country_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Country
                                </label>
                                <select 
                                    id="country_id" 
                                    name="country_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <span class="text-red-500 text-sm ">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- State -->
                            <div>
                                <label for="state_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    State/Province
                                </label>
                                <select 
                                    id="state_id" 
                                    name="state_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    disabled
                                >
                                    <option value="">Select State</option>
                                </select>
                            </div>

                            <!-- City -->
                            <div class="md:col-span-2">
                                <label for="city_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    City
                                </label>
                                <select 
                                    id="city_id" 
                                    name="city_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    disabled
                                >
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-200">

                    <!-- Security -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-lock text-blue-600 mr-2"></i>
                            Security
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        name="password" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Minimum 8 characters"
                                    >
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password', 'toggleIcon1')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    >
                                        <i class="fas fa-eye" id="toggleIcon1"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">At least 6 characters</p>
                                @error('password')
                                    <span class="text-red-500 text-sm ">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        id="password_confirmation" 
                                        type="password" 
                                        name="password_confirmation" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Re-enter password"
                                    >
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password_confirmation', 'toggleIcon2')" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    >
                                        <i class="fas fa-eye" id="toggleIcon2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- remember me -->
                    <div class="flex items-start">
                        <input 
                            type="checkbox" 
                            name="remember_me" 
                            id="remember_me"
                            class="w-4 h-4 mt-1 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <label class="ml-3 text-sm text-gray-600" for="remember_me">
                            Remeber me
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-[1.02]"
                    >
                        <i class="fas fa-user-plus mr-2"></i>Create Account
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="" class="font-semibold text-blue-600 hover:text-blue-700">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center">
                <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-gray-700">Contact Us</a>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Toggle password visibility
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
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

    // Preview uploaded image
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Cascading dropdowns (Country -> State -> City)
    $(document).ready(function() {
        $('#country_id').on('change', function() {
            var countryId = $(this).val();
            if(countryId) {
                $.ajax({
                    url: '/api/states/' + countryId, //make  api in laravel
                    type: 'GET',
                    success: function(data) {
                        $('#state_id').prop('disabled', false).html('<option value="">Select State</option>');
                        $('#city_id').prop('disabled', true).html('<option value="">Select City</option>');
                        
                        $.each(data, function(key, state) {
                            $('#state_id').append('<option value="' + state.id + '">' + state.name + '</option>');
                        });
                    }
                });
            } else {
                $('#state_id').prop('disabled', true).html('<option value="">Select State</option>');
                $('#city_id').prop('disabled', true).html('<option value="">Select City</option>');
            }
        });

        $('#state_id').on('change', function() {
            var stateId = $(this).val();
            if(stateId) {
                $.ajax({
                    url: '/api/cities/' + stateId, //make  api in laravel
                    type: 'GET',
                    success: function(data) {
                        $('#city_id').prop('disabled', false).html('<option value="">Select City</option>');
                        
                        $.each(data, function(key, city) {
                            $('#city_id').append('<option value="' + city.id + '">' + city.name + '</option>');
                        });
                    }
                });
            } else {
                $('#city_id').prop('disabled', true).html('<option value="">Select City</option>');
            }
        });
    });
</script>
</body>
</html>