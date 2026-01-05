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
                        <div class="grid grid-cols-3 gap-2">
                            @foreach( product_images($selectedProduct->images) as $image)  {{--helper funtion--}}
                                <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700 border-2 border-transparent hover:border-blue-500 cursor-pointer">
                                    <img src="{{ asset('storage/uploads/product/' . $image) }}" alt="Product image" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right Column - Details -->
                    <div class="space-y-4">
                        <!-- Name & SKU -->
                        <div>
                            <h2 class="text-2xl font-semibold  text-gray-900 dark:text-white">{{ $selectedProduct->name }}</h2>
                             <div class="max-w-xs">
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $selectedProduct->slug }}</div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center space-x-3">
                            
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($selectedProduct->price, 2)}}</span>
                        </div>

                        <!-- Stock & Status -->
                        <div class="grid grid-cols-2 gap-4 py-4 border-y border-gray-200 dark:border-gray-700">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Stock</p>
                                @if($selectedProduct->stock_status === 1)
                                    <p class="text-2xl text-green-600 dark:text-green-400">In stock</p>
                                @else 
                                    <p class=" text-2xl text-red-600 dark:text-red-400" >Out of stock</p> 
                                @endif
                            </div>
                        </div>

                        <!-- Category -->
                        @if($selectedProduct->category)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Category</p>
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                    {{ $selectedProduct->category->name }}
                                </span>
                            </div>
                        @endif

                        <!-- Description -->
                        
                        @if($selectedProduct->description)
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase mb-1">Description</p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $selectedProduct->description}}</p>
                            </div>
                        @endif

                    
                        <!-- Views & Sales -->
                        <div class="flex items-center space-x-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span class="text-xl text-gray-600 dark:text-gray-400">{{ $selectedProduct->sales_count }} sales</span>
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
                    wire:click="editProduct({{ $selectedProduct->id }})"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                >
                    Edit Product
                </button>
            </div>
        </div>
    </div>
</div>