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

        <div class="flex items-center justify-end">
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
                        <option value="in_stock">In Stock</option>
                        <option value="low_stock">Low Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button wire:click="resetFilters" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Reset Filters
                </button>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- Product with Image -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <img 
                                            src="{{ $product->image }}" 
                                            alt="{{ $product->name }}"
                                            class="w-16 h-16 rounded-lg object-cover border border-gray-200 dark:border-gray-700"
                                        >
                                        <div class="max-w-xs">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $product->name }}</p>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $product->slug }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->category)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                            {{ $product->category->name }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400">No category</span>
                                    @endif
                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $product->stock_quantity }}</span>
                                        @if($product->stock_status === 'in_stock')
                                            <span class="text-xs text-green-600 dark:text-green-400">In Stock</span>
                                        @elseif($product->stock_status === 'low_stock')
                                            <span class="text-xs text-yellow-600 dark:text-yellow-400">Low Stock</span>
                                        @else
                                            <span class="text-xs text-red-600 dark:text-red-400">Out of Stock</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button wire:click="viewProduct({{ $product->id }})" class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                        <button wire:click="editProduct({{ $product->id }})" class="p-2 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/30 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            wire:click="deleteProduct({{ $product->id }})"
                                            wire:confirm="Are you sure you want to delete this product?"
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
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <!-- Dark Backdrop -->
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closeViewModal"></div>
                
                <!-- Modal Container -->
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">
                    <!-- Modal Content -->
                    <div class="relative inline-block bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-4xl">
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold text-white">Product Details</h3>
                                <button wire:click="closeViewModal" class="text-white hover:text-gray-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Body -->
                        <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Left Column - Images -->
                                <div class="space-y-4">
                                    <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        <img 
                                            src="" 
                                            {{-- alt="{{ $selectedProduct->name }}" --}}
                                            class="w-full h-full object-cover"
                                        >
                                    </div>
                                    
                                    {{-- @if($selectedProduct->images->count() > 1)
                                        <div class="grid grid-cols-4 gap-2">
                                            @foreach($selectedProduct->images as $image)
                                                <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 border-2 border-transparent hover:border-blue-500 cursor-pointer">
                                                    <img src="{{ $image->thumbnail_url }}" alt="Product image" class="w-full h-full object-cover">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif --}}
                                </div>

                                <!-- Right Column - Details -->
                                <div class="space-y-4">
                                    <!-- Name & SKU -->
                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $selectedProduct->name ?? 'afsd' }}</h2>
                                    </div>

                                    <!-- Price -->
                                    <div class="flex items-center space-x-3">
                                      
                                        {{-- <span class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($selectedProduct->price, 2) ?? 'afsd'  }}</span> --}}
                                    </div>

                                    <!-- Stock & Status -->
                                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-gray-200 dark:border-gray-700">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Stock</p>
                                            {{-- <p class="text-xs 
                                                @if($selectedProduct->stock_status === 'in_stock') text-green-600 dark:text-green-400
                                                @elseif($selectedProduct->stock_status === 'low_stock') text-yellow-600 dark:text-yellow-400
                                                @else text-red-600 dark:text-red-400 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $selectedProduct->stock_status)) ?? 'afsd' }}
                                            </p> --}}
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    @if($selectedProduct->category ?? 'afsd' )
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Category</p>
                                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                                {{ $selectedProduct->category->name ?? 'afsd' }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Description -->
                                  
                                    @if($selectedProduct->description ?? 'afsd' )
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Description</p>
                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $selectedProduct->description ?? 'afsd' }}</p>
                                        </div>
                                    @endif

                                
                                    <!-- Views & Sales -->
                                    <div class="flex items-center space-x-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $selectedProduct->sales_count ?? 'afsd' }} sales</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                            <button 
                                wire:click="closeViewModal"
                                class="px-6 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600"
                            >
                                Close
                            </button>
                            <button 
                                wire:click="editProduct({{ $selectedProduct->id ?? 'afsd' }})"
                                class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                            >
                                Edit Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
