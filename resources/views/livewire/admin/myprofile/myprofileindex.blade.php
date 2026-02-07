<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    
        {{-- page title --}}
        @section('page-title')
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">My Profile</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage Profile Setting</p>
        </div>
        @endsection

    <!-- Sidebar - Profile Summary -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 text-center">
            
            <!-- Profile Image -->
            <div class="mb-4">
                @if($image)
                    <img src="{{ asset('storage/uploads/user/' . $image) }}" alt="{{ $name }}" class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-blue-600">
                @else
                    <div class="w-24 h-24 rounded-full mx-auto bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-3xl border-4 border-blue-600">
                        {{ substr($name, 0, 2) }}
                    </div>
                @endif
            </div>

            <!-- User Info -->
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $email }}</p>
            
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

            <!-- Role Badge -->
            <div class="inline-flex items-center mt-4 px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-semibold">
                <i class="fas fa-shield-alt mr-2"></i>{{ strtoupper($user->type)}}
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:col-span-3">
        
        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="bg-green-50 absolute right-[10px] top-[10px] w-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4" wire:poll.2s>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-green-800 dark:text-green-300">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        <!-- Tabs -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
            <div class="flex border-b border-gray-200 dark:border-gray-700 overflow-x-auto">
                <button 
                    wire:click="switchTab('personal')" 
                    class="px-6 py-4 font-semibold text-sm whitespace-nowrap transition-colors {{ $activeTab === 'personal' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    <i class="fas fa-user mr-2"></i>Personal Info
                </button>
                <button 
                    wire:click="switchTab('address')" 
                    class="px-6 py-4 font-semibold text-sm whitespace-nowrap transition-colors {{ $activeTab === 'address' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    <i class="fas fa-map-marker-alt mr-2"></i>Address
                </button>
                <button 
                    wire:click="switchTab('password')" 
                    class="px-6 py-4 font-semibold text-sm whitespace-nowrap transition-colors {{ $activeTab === 'password' ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}"
                >
                    <i class="fas fa-lock mr-2"></i>Change Password
                </button>
            </div>
        </div>

        <!-- Personal Info Tab -->
        @if($activeTab === 'personal')
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Personal Information</h2>
            
            <form wire:submit.prevent="updatePersonalInfo">
                
                <!-- Profile Image -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Profile Image
                    </label>
                    <div class="flex items-center space-x-4">
                        @if($newImage)
                            <img src="{{ $newImage->temporaryUrl() }}" alt="Preview" class="w-20 h-20 rounded-full object-cover">
                        @elseif($image)
                            <img src="{{ asset('storage/uploads/user/' . $image) }}" alt="{{ $name }}" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-2xl">
                                {{ substr($name, 0, 2) }}
                            </div>
                        @endif
                        <div>
                            <input type="file" wire:model="newImage" id="imageInput" class="hidden" accept="image/*">
                            <button type="button" onclick="document.getElementById('imageInput').click()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                Change Photo
                            </button>
                            @if($newImage)
                                <button type="button" wire:click="$set('newImage', null)" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm">
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </div>
                    @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="newImage" class="text-sm text-blue-600 dark:text-blue-400 mt-1">Uploading...</div>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        wire:model.defer="name"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                    >
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email (Read-only) -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        value="{{ $email }}"
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
                        wire:model.defer="mobile_number"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        placeholder="+91 1234567890"
                    >
                    @error('mobile_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="updatePersonalInfo">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </span>
                    <span wire:loading wire:target="updatePersonalInfo">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
                    </span>
                </button>
            </form>
        </div>
        @endif

        <!-- Address Tab -->
        @if($activeTab === 'address')
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Address Information</h2>
            
            <form wire:submit.prevent="updateAddress">
                
                <!-- Address -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Street Address <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        wire:model.defer="address"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        placeholder="House No., Building Name, Street Name"
                    ></textarea>
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Country -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Country <span class="text-red-500">*</span>
                    </label>
                    <select 
                        wire:model.live="country_id"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- State -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        State <span class="text-red-500">*</span>
                    </label>
                    <select 
                        wire:model.live="state_id"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        {{ !$country_id ? 'disabled' : '' }}
                    >
                        <option value="">Select State</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                    @error('state_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- City -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        City <span class="text-red-500">*</span>
                    </label>
                    <select 
                        wire:model.live="city_id"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        {{ !$state_id ? 'disabled' : '' }}
                    >
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="updateAddress">
                        <i class="fas fa-save mr-2"></i>Save Address
                    </span>
                    <span wire:loading wire:target="updateAddress">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Saving...
                    </span>
                </button>
            </form>
        </div>
        @endif

        <!-- Change Password Tab -->
        @if($activeTab === 'password')
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Change Password</h2>
            
            <form wire:submit.prevent="updatePassword">
                
                <!-- Current Password -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="current_password"
                            wire:model.defer="current_password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('current_password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                        >
                            <i class="fas fa-eye" id="current_password_icon"></i>
                        </button>
                    </div>
                    @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <div class="mt-2">
                        <a href="{{route('admin.forgot-password')}}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            <i class="fas fa-question-circle mr-1"></i>Forgot Password?
                        </a>
                    </div>
                </div>

                <!-- New Password -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="new_password"
                            wire:model.defer="new_password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('new_password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                        >
                            <i class="fas fa-eye" id="new_password_icon"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum 6 characters</p>
                    @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="new_password_confirmation"
                            wire:model.defer="new_password_confirmation"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('new_password_confirmation')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
                        >
                            <i class="fas fa-eye" id="new_password_confirmation_icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="updatePassword">
                        <i class="fas fa-key mr-2"></i>Change Password
                    </span>
                    <span wire:loading wire:target="updatePassword">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Changing...
                    </span>
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
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
</script>