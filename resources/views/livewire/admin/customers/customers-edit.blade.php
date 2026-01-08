<div>
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <!-- Dark Backdrop -->
        <div class="fixed inset-0 backdrop-blur-lg bg-black/80 transition-opacity" wire:click="closeEditModal"></div>
        
        <!-- Modal Container -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">
            <!-- Modal Content -->
            <div class="relative inline-block bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-4xl">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-white">Edit User</h3>
                        </div>
                        <button wire:click="closeEditModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                    <form wire:submit.prevent="updateUser">
                        <div class="space-y-6">
                            
                            <!-- Profile Photo Upload -->
                            <div class="flex justify-center">
                                <div class="relative">
                                    @if($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover border-4 border-green-500">
                                    @elseif($Userimage)
                                        <img src="{{ asset('storage/uploads/user/' . $Userimage) }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 dark:border-gray-600">
                                    @else
                                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-green-500 to-blue-500 flex items-center justify-center border-4 border-gray-300 dark:border-gray-600">
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <label for="editImage" class="absolute bottom-0 right-0 bg-green-600 text-white p-2.5 rounded-full cursor-pointer hover:bg-green-700 shadow-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <input type="file" wire:model="image" accept="image/*" class="hidden" id="editImage">
                                    </label>
                                </div>
                            </div>
                            @error('edit_image') 
                                <p class="text-center text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror

                            <div wire:loading wire:target="edit_image" class="text-center text-sm text-blue-600 dark:text-blue-400">
                                Uploading image...
                            </div>

                            <!-- Row 1: Name and Email -->
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model="name"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_name') border-red-500 @enderror"
                                        placeholder="Enter full name"
                                    >
                                    @error('name') 
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="email" 
                                        wire:model="email"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_email') border-red-500 @enderror"
                                        placeholder="email@example.com"
                                    >
                                    @error('email') 
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 3: Gender, Mobile, User Type -->
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Gender <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        wire:model="gender"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_gender') border-red-500 @enderror"
                                    >
                                        <option value="">Select Gender</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                    </select>
                                    @error('gender') 
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Mobile Number <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model="mobile_number"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_mobile_number') border-red-500 @enderror"
                                        placeholder="+1 (555) 000-0000"
                                    >
                                    @error('mobile_number') 
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        User Type <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        wire:model="type"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_type') border-red-500 @enderror"
                                    >
                                        <option value="">Select Type</option>
                                        <option value="superadmin">Super Admin</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('type') 
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 4: Status -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Account Status <span class="text-red-500">*</span>
                                </label>
                              <div class="flex items-center space-x-3">
                                    <!-- Active -->
                                    <label class="relative cursor-pointer">
                                        <input 
                                            type="radio" 
                                            wire:model="status" 
                                            value=1
                                            class="peer sr-only"
                                        >
                                        <div class="flex items-center space-x-3 px-6 py-3 rounded-full border-2 border-gray-300 dark:border-gray-600 transition-all peer-checked:border-green-500 peer-checked:bg-green-500 peer-checked:shadow-lg peer-checked:scale-110 hover:border-green-400">
                                            <div class="w-3 h-3 rounded-full bg-gray-400 peer-checked:bg-white transition-all peer-checked:animate-pulse"></div>
                                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-white">Active</span>
                                            <svg class="w-5 h-5 text-gray-400 peer-checked:text-white opacity-0 peer-checked:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </label>
                                    <!-- Blocked -->
                                    <label class="relative cursor-pointer">
                                        <input 
                                            type="radio" 
                                            wire:model="status" 
                                            value=0
                                            class="peer sr-only"
                                        >
                                        <div class="flex items-center space-x-3 px-6 py-3 rounded-full border-2 border-gray-300 dark:border-gray-600 transition-all peer-checked:border-red-500 peer-checked:bg-red-500 peer-checked:shadow-lg peer-checked:scale-110 hover:border-red-400">
                                            <div class="w-3 h-3 rounded-full bg-gray-400 peer-checked:bg-white transition-all"></div>
                                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 peer-checked:text-white">Blocked</span>
                                            <svg class="w-5 h-5 text-gray-400 peer-checked:text-white opacity-0 peer-checked:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                    </label>
                                </div>
                                @error('status') 
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Address Section -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Location Information
                                </h4>

                               

                                <!-- Country, State, City -->
                                <div class="grid grid-cols-3 gap-6">
                                    <!-- Country -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            Country
                                        </label>
                                        <select 
                                            wire:model.live="country_id"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                        >
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- State -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            State
                                        </label>
                                        <select 
                                            wire:model.live="state_id"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                            {{ !$country_id ? 'disabled' : '' }}
                                        >
                                            <option value="">Select State</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- City -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            City
                                        </label>
                                        <select 
                                            wire:model="city_id"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                                            {{ !$state_id ? 'disabled' : '' }}
                                        >
                                            <option value="">Select City</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <!-- Address -->
                                <div class="mt-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Address
                                    </label>
                                    <textarea 
                                        wire:model="address"
                                        rows="2"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_address') border-red-500 @enderror"
                                        placeholder="Street address, apartment, suite, etc."
                                    ></textarea>
                                    @error('address') 
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <button 
                        type="button"
                        wire:click="closeEditModal"
                        class="px-6 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button"
                        wire:click="updateUser"
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-blue-600 rounded-lg hover:from-green-700 hover:to-blue-700 transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                    >
                        <svg wire:loading wire:target="updateUser" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="updateUser">Update User</span>
                        <span wire:loading wire:target="updateUser">Updating...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
