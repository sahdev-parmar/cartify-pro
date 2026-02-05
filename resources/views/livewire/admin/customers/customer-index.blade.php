<div>
    <div class="space-y-6">
        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="bg-green-50 absolute right-[10px] top-[10px] w-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 z-100" wire:poll.3s>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-green-800 dark:text-green-300">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        {{-- page title --}}
        @section('page-title')
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Users</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your customers</p>
        </div>
        @endsection

        <!-- Filters Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="grid grid-cols-3 gap-4">
                <!-- Search -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Search by name, email, phone..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select wire:model.live="statusFilter"
                        class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Status</option>
                        <option value=1>Active</option>
                        <option value=0>Blocked</option>
                    </select>
                </div>
            </div>

            {{-- reset filter --}}
            <div class="flex items-center justify-end mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button wire:click="resetFilters"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Reset Filters
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                User</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Contact</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Location</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <!-- User -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('storage/uploads/user/' . $user->image) }}" alt="{{ $user->name }}"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <span
                                                class="capitalize {{ $user->gender ? 'text-pink-500' : 'text-blue-500' }}">{{
                                                $user->gender ? 'female' : 'male' }}</span> •
                                            Joined {{ $user->created_at->format('M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact -->
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="text-gray-900 dark:text-white">{{ $user->email }}</p>
                                    @if($user->mobile_number)
                                    <p class="text-gray-500 dark:text-gray-400">{{ $user->mobile_number }}</p>
                                    @endif
                                </div>
                            </td>

                            <!-- Location -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    @if($user->city || $user->state || $user->country)
                                    <p>{{ $user->city?->name }}{{ $user->city && $user->state ? ', ' : '' }}{{ $user->state?->name }}
                                    </p>
                                    <p>{{ $user->country->name }}</p>
                                    @else
                                    <span class="text-gray-400">No location</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button type="button" wire:click="toggleStatus({{ $user->id }})" class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold transition-colors
                                            {{ $user->status === 1 
                                                ? 'bg-green-200 dark:bg-green-900 text-green-800 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800' 
                                                : 'bg-red-200 dark:bg-red-900 text-red-800 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800' 
                                            }}">
                                    <span
                                        class="w-2 h-2 rounded-full mr-2 {{ $user->status === 1 ? 'bg-red-100 dark:bg-red-200' : 'bg-green-100 dark:bg-green-200' }}"></span>
                                    {{ ($user->status ? 'active' : 'blocked') }}
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="viewUser({{ $user->id }})"
                                        class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                        title="View">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="editUser({{ $user->id }})"
                                        class="p-2 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 rounded-lg transition-colors"
                                        title="Edit">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="deleteUser({{ $user->id }})"
                                        class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                        title="Delete">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No users found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        </div>
        
        @if($showViewModal)
            @include('livewire.admin.customers.customers-view')
        @endif

        @if($showEditModal)
            <livewire:Admin.Customers.CustomersEdit :editUserId="$editUserId"> {{-- pass parameter one to child component  --}}
        @endif

    </div>
</div>
@script
<script>
    window.addEventListener('confirmMessage', event => { 
        Swal.fire({
        title: "Are you sure?",
        text: event.detail.text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            $wire.$call('Confirmdelete') // call function
        }
        });
    });

    window.addEventListener('doneMessage', event => {

        const isDark = $('html').hasClass('dark');
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: "success",
            background: isDark ? '#0f172a' : '#ffffff',
            color:       isDark ? '#22c55e' : '#0f172a',
            iconColor:   isDark ? '#22c55e' : '#16a34a',
            confirmButtonText: 'OK',
            confirmButtonColor: isDark ? '#2563eb' : '#3b82f6',
            customClass: {
                popup: 'rounded-xl',
                title: isDark ? 'text-green-400' : 'text-green-700',
                confirmButton: 'text-white font-semibold'
            }
        });
    }); 
</script>
@endscript