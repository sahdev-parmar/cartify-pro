@extends('layout.app')

@section('title', 'My Profile')
@section('styles')
    <style>
    .tab-btn {
        color: #6b7280;
        border-bottom: 2px solid transparent;
        transition: color 0.2s;
    }
    .tab-btn.active {
        color: #2563eb;
        border-bottom: 2px solid #2563eb;
    }
    </style>
@endsection
@section('content')
    <!-- Success/Error Messages -->
    <div class="fixed top-4 right-4 z-50 hidden bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 rounded-xl p-4 shadow-lg" id="successMessage">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-green-800 dark:text-green-300" id="successText"></p>
        </div>
    </div>

    <div class="fixed top-4 right-4 z-50 hidden bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-800 rounded-xl p-4 shadow-lg" id="errorMessage">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-red-800 dark:text-red-300" id="errorText"></p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="bg-gray-100 dark:bg-gray-800 py-4">
        <div class="container mx-auto px-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-700 dark:text-gray-300">My Profile</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">
            
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-user-circle mr-2"></i>My Profile
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Manage your account settings and preferences</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                
                <!-- Sidebar - Profile Summary -->
                <aside class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 text-center">
                        
                        <!-- Profile Image -->
                        <div class="mb-4">
                            @if($user->image)
                                <img src="{{ asset('storage/uploads/user/' . $user->image) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-blue-600" id="sidebarImage">
                            @else
                                <div class="w-24 h-24 rounded-full mx-auto bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-3xl border-4 border-blue-600" id="sidebarImage">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            @endif
                        </div>

                        <!-- User Info -->
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1" id="sidebarName">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $user->email }}</p>
                        
                        <!-- Address Section -->
                        <div class="mt-6 bg-gray-50 dark:bg-gray-700/40 rounded-xl p-5 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-300">
                            
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400 mr-2"></i>
                                Address Details
                            </h3>

                            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">

                                {{-- Street Address --}}
                                @if($user->address)
                                <div class="flex items-start">
                                    <i class="fas fa-home w-5 text-gray-400 mt-1"></i>
                                    <span class="ml-1">{{ $user->address }}</span>
                                </div>
                                @endif

                                {{-- City --}}
                                @if($user->city)
                                <div class="flex items-center">
                                    <i class="fas fa-city w-5 text-gray-400"></i>
                                    <span class="ml-2">{{ $user->city->name }}</span>
                                </div>
                                @endif

                                {{-- State --}}
                                @if($user->state)
                                <div class="flex items-center">
                                    <i class="fas fa-map w-5 text-gray-400"></i>
                                    <span class="ml-2">{{ $user->state->name }}</span>
                                </div>
                                @endif

                                {{-- Country --}}
                                @if($user->country)
                                <div class="flex items-center">
                                    <i class="fas fa-globe w-5 text-gray-400"></i>
                                    <span class="ml-2">{{ $user->country->name }}</span>
                                </div>
                                @endif

                            </div>
                        </div>

                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 mt-6">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Quick Links</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('orders.index') }}" class="flex items-center text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                    <i class="fas fa-shopping-bag w-5 mr-2"></i>
                                    My Orders
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}" class="flex items-center text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">
                                    <i class="fas fa-shopping-cart w-5 mr-2"></i>
                                    Continue Shopping
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-3">
                    
                    <!-- Tabs -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
                        <div class="flex border-b border-gray-200 dark:border-gray-700 overflow-x-auto">
                            <button onclick="switchTab('personal')" class="tab-btn active px-6 py-4 font-semibold text-sm whitespace-nowrap">
                                <i class="fas fa-user mr-2"></i>Personal Info
                            </button>
                            <button onclick="switchTab('address')" class="tab-btn px-6 py-4 font-semibold text-sm whitespace-nowrap">
                                <i class="fas fa-map-marker-alt mr-2"></i>Address
                            </button>
                            <button onclick="switchTab('password')" class="tab-btn px-6 py-4 font-semibold text-sm whitespace-nowrap">
                                <i class="fas fa-lock mr-2"></i>Change Password
                            </button>
                        </div>
                    </div>

                    <!-- Personal Info Tab -->
                    <div id="personalTab" class="tab-content">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Personal Information</h2>
                            
                            <form id="personalForm" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Profile Image -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Profile Image
                                    </label>
                                    <div class="flex items-center space-x-4">
                                        @if($user->image)
                                            <img src="{{ asset('storage/uploads/user/' . $user->image) }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover" id="imagePreview">
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-2xl" id="imagePreview">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <input type="file" name="image" id="imageInput" class="hidden" accept="image/*">
                                            <button type="button" onclick="document.getElementById('imageInput').click()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                                Change Photo
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="name" 
                                        value="{{ $user->name }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    >
                                    <span class="text-red-500 text-sm error" id="error_name"></span>
                                </div>

                                <!-- Email (Read-only) -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Email Address
                                    </label>
                                    <input 
                                        type="email" 
                                        value="{{ $user->email }}"
                                        disabled
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-900 text-gray-500 dark:text-gray-400 cursor-not-allowed"
                                    >
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Email cannot be changed</p>
                                </div>

                                <!-- Mobile Number -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Mobile Number
                                    </label>
                                    <input 
                                        type="text" 
                                        name="mobile_number" 
                                        value="{{ $user->mobile_number }}"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        placeholder="+91 1234567890"
                                    >
                                    <span class="text-red-500 text-sm error" id="error_mobile_number"></span>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold">
                                    <i class="fas fa-save mr-2"></i>Save Changes
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Address Tab -->
                    <div id="addressTab" class="tab-content hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Delivery Address</h2>
                            
                            <form id="addressForm">
                                @csrf
                                
                                <!-- Address -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Street Address <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        name="address" 
                                        rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        placeholder="House No., Building Name, Street Name"
                                    >{{ $user->address }}</textarea>
                                    <span class="text-red-500 text-sm error" id="error_address"></span>
                                </div>

                                <!-- Country -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Country <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        name="country_id" 
                                        id="country" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $user->country_id == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="text-red-500 text-sm error" id="error_country_id"></span>
                                </div>

                                <!-- State -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        State <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        name="state_id" 
                                        id="state" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="">Select State</option>
                                    </select>
                                    <span class="text-red-500 text-sm error" id="error_state_id"></span>
                                </div>

                                <!-- City -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        City <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        name="city_id" 
                                        id="city" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    >
                                        <option value="">Select City</option>
                                    </select>
                                    <span class="text-red-500 text-sm error" id="error_city_id"></span>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold">
                                    <i class="fas fa-save mr-2"></i>Save Address
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Tab -->
                    <div id="passwordTab" class="tab-content hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Change Password</h2>
                            
                            <form id="passwordForm">
                                @csrf
                                
                                <!-- Current Password -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Current Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            name="current_password" 
                                            id="currentPassword"
                                            class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        >
                                        <button type="button" onclick="togglePassword('currentPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <span class="text-red-500 text-sm error" id="error_current_password"></span>
                                </div>

                                <!-- New Password -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        New Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            name="new_password" 
                                            id="newPassword"
                                            class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        >
                                        <button type="button" onclick="togglePassword('newPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum 6 characters</p>
                                    <span class="text-red-500 text-sm error" id="error_new_password"></span>
                                </div>

                                <!-- Confirm New Password -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Confirm New Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            name="new_password_confirmation" 
                                            id="confirmPassword"
                                            class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                        >
                                        <button type="button" onclick="togglePassword('confirmPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold mb-4">
                                    <i class="fas fa-key mr-2"></i>Change Password
                                </button>

                                <!-- Forgot Password Link -->
                                <div class="text-center">
                                    <a href="{{ route('password.forgot') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        <i class="fas fa-question-circle mr-1"></i>Forgot your password?
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
    // Tab switching
    function switchTab(tab) {
        $('.tab-content').addClass('hidden');
        $('.tab-btn').removeClass('active');
        $('#' + tab + 'Tab').removeClass('hidden');
        event.target.classList.add('active');
    }

    // Toggle password visibility
    function togglePassword(id) {
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

    // Show success message
    function showSuccess(message) {
        $('#successText').text(message);
        $('#successMessage').removeClass('hidden');
        setTimeout(() => $('#successMessage').addClass('hidden'), 3000);
    }

    // Show error message
    function showError(message) {
        $('#errorText').text(message);
        $('#errorMessage').removeClass('hidden');
        setTimeout(() => $('#errorMessage').addClass('hidden'), 3000);
    }

    // Personal Info Form (AJAX)
    $('#personalForm').on('submit', function(e) {
        e.preventDefault();
        $('.error').text('');
        
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        $.ajax({
            url: '{{ route("profile.update.personal") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status) {
                    showSuccess(response.message);
                    
                    // Update sidebar name and image
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                    
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#error_' + key).text(value[0]);
                    });
                } else {
                    showError('An error occurred. Please try again.');
                }
            }
        });
    });

    // Address Form (AJAX)
    $('#addressForm').on('submit', function(e) {
        e.preventDefault();
        $('.error').text('');
        
        $.ajax({
            url: '{{ route("profile.update.address") }}',
            type: 'POST',
            data: $(this).serialize() + '&_method=PUT',
            success: function(response) {
                if(response.status) {
                    showSuccess(response.message);
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#error_' + key).text(value[0]);
                    });
                } else {
                    showError('An error occurred. Please try again.');
                }
            }
        });
    });

    // Password Form (AJAX)
    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();
        $('.error').text('');
        
        $.ajax({
            url: '{{ route("profile.update.password") }}',
            type: 'POST',
            data: $(this).serialize() + '&_method=PUT',
            success: function(response) {
                if(response.status) {
                    showSuccess(response.message);
                    $('#passwordForm')[0].reset();
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#error_' + key).text(value[0]);
                    });
                } else {
                    showError(xhr.responseJSON.message || 'An error occurred. Please try again.');
                }
            }
        });
    });

   // Image preview
    $("#imageInput").on('change',function(e){
        const files = e.target.files;
        for (let index = 0; index < files.length; index++) {        //files.length to count array element
            var url = URL.createObjectURL(e.target.files[index]);
            $('#imagePreview').attr('src',url);
        }
    }); 

    // Cascading dropdowns
    $(document).ready(function() {
        const selectedCountry = $('#country').val();
        const selectedState = '{{ $user->state_id }}';
        const selectedCity = '{{ $user->city_id }}';
        
        if (selectedCountry) {
            loadStates(selectedCountry, selectedState);
        }
        
        $('#country').on('change', function() {
            const countryId = $(this).val();
            $('#state').html('<option value="">Select State</option>');
            $('#city').html('<option value="">Select City</option>');
            
            if (countryId) {
                loadStates(countryId);
            }
        });
        
        $('#state').on('change', function() {
            const stateId = $(this).val();
            $('#city').html('<option value="">Select City</option>');
            
            if (stateId) {
                loadCities(stateId);
            }
        });
        
        function loadStates(countryId, selected = null) {
            $.ajax({
                url: '/api/states/' + countryId,
                type: 'GET',
                success: function(data) {
                    let options = '<option value="">Select State</option>';
                    data.forEach(state => {
                        const isSelected = selected == state.id ? 'selected' : '';
                        options += `<option value="${state.id}" ${isSelected}>${state.name}</option>`;
                    });
                    $('#state').html(options);
                    
                    if (selected && selectedCity) {
                        loadCities(selected, selectedCity);
                    }
                }
            });
        }
        
        function loadCities(stateId, selected = null) {
            $.ajax({
                url: '/api/cities/' + stateId,
                type: 'GET',
                success: function(data) {
                    let options = '<option value="">Select City</option>';
                    data.forEach(city => {
                        const isSelected = selected == city.id ? 'selected' : '';
                        options += `<option value="${city.id}" ${isSelected}>${city.name}</option>`;
                    });
                    $('#city').html(options);
                }
            });
        }
    });
    </script>
@endpush