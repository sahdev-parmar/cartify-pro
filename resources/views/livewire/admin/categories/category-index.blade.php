<div>

@section('title', 'Categories')

    <div class="space-y-6">
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

        {{-- page title --}}
        @section('page-title')
        <div class="py-4">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Categories</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your product categories</p>
        </div>
        @endsection

        {{-- category add button --}}
        <div class="flex justify-end">
            <button wire:click="openModal" class="flex px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Category
            </button>
        </div>

        <!-- Categories Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input 
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Search categories..." 
                                class="w-80 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <select wire:model.live="statusFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Category Name
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Products
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Created Date
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-20 h-20 rounded-lg flex items-center justify-center mr-3">
                                            <img src="{{asset('storage/uploads/category/'.$category->image)}}" alt="">
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $category['name'] }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $category['slug'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate">
                                        {{ $category['description'] }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $category['products_count'] }}</div> --}}
                                    <div class="text-xs text-gray-500 dark:text-gray-400">products</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ date('M d, Y', strtotime($category['created_at'])) }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ date('h:i A', strtotime($category['created_at'])) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button type="button"   
                                        wire:click="toggleStatus({{ $category['id'] }})"
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold transition-colors
                                            {{ $category['status'] === 1 
                                                ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-800' 
                                                : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800' 
                                            }}"
                                    >
                                        <span class="w-2 h-2 rounded-full mr-2 {{ $category['status'] === 1 ? 'bg-green-500 dark:bg-green-400' : 'bg-red-500 dark:bg-red-400' }}"></span>
                                        {{ ($category['status'] ? 'active' : 'inactive') }}
                                    </button>
                                </td>

                                {{-- edit --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button wire:click="editCategory({{ $category['id'] }})" class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>

                                        {{-- delete  --}}
                                        <button 
                                            wire:click="deleteCategory({{ $category['id'] }})"
                                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" 
                                            title="Delete"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No categories found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer / Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 " >
                {{ $categories->links() }}
            </div>
        </div>
    </div>

     <!-- Add/Edit Category Modal -->
    @if($showModal)
        @include('livewire.admin.categories.categoryModal')
    @endif
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