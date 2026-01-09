<div>
    <!-- View Admin Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <!-- Dark Backdrop -->
        <div class="fixed inset-0 backdrop-blur-lg bg-black/80 transition-opacity" wire:click="closeViewModal"></div>
        
        <!-- Modal Container -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">
            <!-- Modal Content -->
            <div class="relative inline-block bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-4xl">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-white">Admin Details</h3>
                        </div>
                        <button wire:click="closeViewModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                    <div class="space-y-6">
                        <!-- Profile Section -->
                        <div class="flex items-start space-x-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                            <!-- Profile Image -->
                            <div class="flex-shrink-0">
                                @if($selectedAdmin->image)
                                    <img 
                                        src="{{ asset('storage/uploads/user/' . $selectedAdmin->image) }}" 
                                        alt="{{ $selectedAdmin->name }}"
                                        class="w-32 h-32 rounded-2xl object-cover border-4 border-blue-500 shadow-lg"
                                    >
                                @else
                                    <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center border-4 border-blue-500 shadow-lg">
                                        <span class="text-4xl font-bold text-white">{{ substr($selectedAdmin->name, 0, 2) }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Basic Info -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $selectedAdmin->name }}</h2>
                                    
                                    <!-- Status Badge -->
                                    @if($selectedAdmin->status == 1)
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300">
                                            Blocked
                                        </span>
                                    @endif
                                </div>

                                <!-- Email -->
                                <div class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 mb-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm">{{ $selectedAdmin->email }}</span>
                                    @if($selectedAdmin->email_verified_at)
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Type and Gender Badges -->
                                <div class="flex items-center space-x-2">
                                    @if($selectedAdmin->type == 'superadmin')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                            </svg>
                                            Super Admin
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-300">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            Admin
                                        </span>
                                    @endif

                                    @if($selectedAdmin->gender == 1)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-300">
                                            Female
                                        </span>
                                    @elseif($selectedAdmin->gender == 0)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                            Male
                                        </span>
                                    @endif

                                    <!-- Session Status -->
                                    @if($selectedAdmin->has_active_session)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                                            <span class="w-2 h-2 bg-green-500 rounded-full inline-block mr-1 animate-pulse"></span>
                                            Online
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                            Offline
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Information Grid -->
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Contact Information -->
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        Contact Information
                                    </h4>
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 space-y-3">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Email</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedAdmin->email }}</p>
                                        </div>
                                        @if($selectedAdmin->mobile_number)
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Mobile</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedAdmin->mobile_number }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Location Information -->
                                @if($selectedAdmin->address || $selectedAdmin->city || $selectedAdmin->state || $selectedAdmin->country)
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Location
                                        </h4>
                                        <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 space-y-3">
                                            @if($selectedAdmin->address)
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Address</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedAdmin->address }}</p>
                                                </div>
                                            @endif
                                            @if($selectedAdmin->city)
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">City</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedAdmin->city->name }}</p>
                                                </div>
                                            @endif
                                            @if($selectedAdmin->state)
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">State</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedAdmin->state->name }}</p>
                                                </div>
                                            @endif
                                            @if($selectedAdmin->country)
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Country</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $selectedAdmin->country->name }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Account Status -->
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Account Status
                                    </h4>
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 space-y-3">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Status</p>
                                            @if($selectedAdmin->status == 1)
                                                <span class="text-sm font-semibold text-green-600 dark:text-green-400">Active</span>
                                            @else
                                                <span class="text-sm font-semibold text-red-600 dark:text-red-400">Blocked</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Type</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white capitalize">{{ $selectedAdmin->type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Session</p>
                                            @if($selectedAdmin->has_active_session)
                                                <span class="text-sm font-semibold text-green-600 dark:text-green-400">Online</span>
                                            @else
                                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Offline</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Details -->
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Account Details
                                    </h4>
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-4 space-y-3">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">User ID</p>
                                            <p class="text-sm font-mono font-medium text-gray-900 dark:text-white">#{{ str_pad($selectedAdmin->id, 6, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Member Since</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $selectedAdmin->created_at->format('F d, Y') }}
                                                <span class="text-xs text-gray-500">({{ $selectedAdmin->created_at->diffForHumans() }})</span>
                                            </p>
                                        </div>
                                        @if($selectedAdmin->last_login)
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Last Login</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $selectedAdmin->last_login->format('M d, Y H:i') }}
                                                    <span class="text-xs text-gray-500">({{ $selectedAdmin->last_login->diffForHumans() }})</span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <button 
                        wire:click="closeViewModal"
                        class="px-6 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors"
                    >
                        Close
                    </button>
                    <button 
                        wire:click="editAdmin({{ $selectedAdmin->id }})"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors shadow-lg"
                    >
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Admin
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
