@extends('layout.app')

@section('title', 'Home')

@section('content')

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-800 dark:to-purple-800 py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <h1 class="text-5xl font-bold mb-6">Welcome to Cartify Pro</h1>
                    <p class="text-xl mb-8 text-gray-100">Discover amazing products at unbeatable prices. Shop now and enjoy free shipping on orders over $50!</p>
                    <div class="flex space-x-4">
                        <a href="" class="px-8 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                            View Products
                        </a>
                        <a href="" class="px-8 py-3 border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                            Contact Us
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <img src="{{ asset('shopping.png') }}" alt="Shopping" class="w-full h-80 ">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Shop by Category</h2>
                <p class="text-gray-600 dark:text-gray-400">Browse our wide selection of categories</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @forelse($categories as $category)
                    <a href="{{ route('category.show',$category->slug)}}" class="group">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 text-center hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500">
                            @if($category->image)
                                <img src="{{ asset('storage/uploads/category/' . $category->image) }}" alt="{{ $category->name }}" class="w-20 h-20 mx-auto mb-4 rounded-lg object-cover">
                            @else
                                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-th-large text-white text-3xl"></i>
                                </div>
                            @endif
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $category->products_count->count() ?? 0 }} items</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-box-open text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400">No categories available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-gray-100 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Featured Products</h2>
                    <p class="text-gray-600 dark:text-gray-400">Check out our top picks for you</p>
                </div>
                <a href="" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold flex items-center">
                    View All
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <div class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 group">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden aspect-square">
                            @if($product->images)
                                <img src="{{ asset('storage/uploads/product/' . product_images($product->images)[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                                    <i class="fas fa-box text-white text-6xl"></i>
                                </div>
                            @endif
                            
                            <!-- Quick Actions -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <div class="flex space-x-2">
                                    <a href="" class="w-10 h-10 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-2 truncate">{{ $product->name }}</h3>
                            
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

                            <!-- Add to Cart or buy Button -->
                            <div class="flex gap-6">
                                <button class="w-full py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold text-sm">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Add to Cart
                                </button>
                                <button class="w-full py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-colors font-semibold text-sm">
                                    <i class="fas fa-bolt mr-2"></i>
                                    Buy Now
                                </button>
                             </div> 
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-box-open text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400">No products available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-blue-600 dark:text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Free Shipping</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">On orders over $50</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-green-600 dark:text-green-400 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Secure Payment</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">100% secure transactions</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-undo text-purple-600 dark:text-purple-400 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Easy Returns</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">30-day return policy</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-yellow-600 dark:text-yellow-400 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">24/7 Support</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Always here to help</p>
                </div>
            </div>
        </div>
    </section>
@endsection