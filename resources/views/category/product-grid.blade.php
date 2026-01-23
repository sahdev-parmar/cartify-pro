

    <!-- Products Container -->
    <div id="productsContainer">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 group">
                <!-- Product Image -->
                <div class="relative overflow-hidden aspect-square">
                    <a href="{{ route('product.show', $product->slug) }}">
                        @if($product->images)
                            <img src="{{ asset('storage/uploads/product/' .  product_images($product->images)[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                                <i class="fas fa-box text-white text-6xl"></i>
                            </div>
                        @endif
                    </a>
                    <!-- Quick Actions -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="flex space-x-2">
                            <a href="{{ route('product.show', $product->slug) }}" class="w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    <a href="">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 truncate hover:text-blue-600 dark:hover:text-blue-400">{{ $product->name }}</h3>
                    </a>
                    
                    <!-- Price -->
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <p class="text-lg font-bold text-blue-600 dark:text-blue-400">₹{{ number_format($product->price, 2) }}</p>
                        </div>
                        @if($product->stock_status)
                            <span class="text-xs text-green-600 dark:text-green-400 font-semibold">In Stock</span>
                        @else
                            <span class="text-xs text-red-600 dark:text-red-400 font-semibold">Out of Stock</span>
                        @endif
                    </div>

                    <!-- view Button -->
                    <div class="flex gap-4">
                        <a href="{{ route('product.show', $product->slug) }}"
                        class="w-full inline-flex items-center justify-center py-2.5 
                                bg-gradient-to-r from-blue-600 to-purple-600 text-white 
                                rounded-xl font-semibold text-sm
                                hover:from-blue-700 hover:to-purple-700 
                                transition-all duration-300 hover:scale-[1.02] shadow-md">
                            <i class="fas fa-eye mr-2"></i>
                            View Product
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400 text-lg font-semibold mb-2">No products found</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm">Try adjusting your filters or search terms</p>
            </div>
        @endforelse
    </div>
        <!-- Pagination -->
        @if($products->hasPages())
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-400 dark:text-gray-500 rounded-lg cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="pagination px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition-colors border border-gray-300 dark:border-gray-600">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="pagination px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition-colors border border-gray-300 dark:border-gray-600">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="pagination px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-blue-600 hover:text-white transition-colors border border-gray-300 dark:border-gray-600">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-400 dark:text-gray-500 rounded-lg cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </nav>
            </div>
        @endif

