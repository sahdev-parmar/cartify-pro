<div>
    @section('title','product')
    <div class="space-y-6">
        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
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
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Products</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your product inventory</p>
            </div>
        @endsection

        <div class="flex items-center justify-between">
            
            {{-- reser filter --}}
            <button wire:click="resetFilters" class="flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                Reset Filters
            </button>

            <a href="{{ route('admin.product.add') }}" class="flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Product
            </a>
        </div>

        <!-- Filters Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="grid grid-cols-4 gap-4">
                <!-- Search -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                    <div class="relative">
                        <input 
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by name, SKU..." 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                    <select wire:model.live="categoryFilter" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Stock Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Stock Status</label>
                    <select wire:model.live="stockFilter" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Stock</option>
                        <option value=1>In Stock</option>
                        <option value=0>Out of Stock</option>
                    </select>
                </div>
            </div>

            
        </div>

        <!-- Products Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left  font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-4 text-left  font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left  font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left  font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-right font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- Product with Image -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img 
                                            src="{{ asset('storage/uploads/product/' . product_images($product->images)[0]) }}" {{--helper function--}} 
                                            alt="{{ $product->name }}"
                                            class="w-12 h-12 rounded-lg object-cover border border-gray-200 dark:border-gray-700"
                                        >
                                        <div class="max-w-xs">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $product->name }}</p>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $product->slug }}</div>
                                        </div>
                                    </div>
                                    <p class="mt-1 inline-flex items-center gap-1 text-xs font-medium
                                            text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full
                                            dark:text-blue-400 dark:bg-blue-900/30">
                                        {{ count(product_images($product->images)) }}
                                        <span>Images</span>
                                    </p>
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->category)
                                        <span class="px-2 py-1 text-sm font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                            {{ $product->category->name }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">No category</span>
                                    @endif
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">₹{{ number_format($product->price, 2) }}</span>
                                    </div>
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @if($product->stock_status === 1)
                                            <span class="text-sm text-white font-semibold text-center rounded-full bg-green-600">In Stock</span>
                                        @else
                                            <span class="text-sm text-white font-semibold text-center rounded-full bg-red-600">Out of Stock</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-2">

                                        {{-- view --}}
                                        <button wire:click="viewProduct({{ $product->id }})" class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="View">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>

                                        {{-- edit --}}
                                        <button wire:click="editProduct({{ $product->id }})" class="p-2 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>

                                        {{-- delete --}}
                                        <button 
                                            wire:click="deleteProduct({{ $product->id }})"
                                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" 
                                            title="Delete"
                                        >
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">No products found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $products->links() }}
            </div>
        </div>

        <!-- View Product Modal -->
        @if($showViewModal && $selectedProduct)
            @include('livewire.admin.product.product-view')
        @endif

        @if($showEditModal)
            <livewire:Admin.Product.ProductEdit>
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