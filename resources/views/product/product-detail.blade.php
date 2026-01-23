@extends('layout.app')

@section('title', $product->name)

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-100 dark:bg-gray-800 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            @if($product->category)
                <a href="{{ route('category.show', $product->category->slug) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ $product->category->name }}
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>  
            @endif
            <span class="text-gray-700 dark:text-gray-300">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Left Side - Image Gallery -->
        <div>
            <!-- Main Image -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-200 dark:border-gray-700 mb-4">
                <div class="aspect-square overflow-hidden rounded-lg" id="mainImageContainer">
                    @if($product->images)
                        <img src="{{ asset('storage/uploads/product/' . product_images($product->images)[0]) }}" alt="{{ $product->name }}" id="mainImage" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-box text-white text-9xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Thumbnail Gallery -->
            @if( product_images($product->images) && count(product_images($product->images)) > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach( product_images($product->images) as $index => $image)
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-2 border-2 cursor-pointer hover:border-blue-600 dark:hover:border-blue-400 transition-colors {{ $index === 0 ? 'border-blue-600 dark:border-blue-400' : 'border-gray-200 dark:border-gray-700' }}" 
                             onclick="changeImage('{{ asset('storage/uploads/product/' . $image) }}', this)">
                            <img src="{{ asset('storage/uploads/product/' . $image) }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover rounded">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Side - Product Info -->
        <div>
            <!-- Category Badge -->
            @if($product->category)
                <a href="{{ route('category.show', $product->category->slug) }}" class="inline-block mb-3">
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full text-sm font-semibold hover:bg-blue-200 dark:hover:bg-blue-800">
                        {{ $product->category->name }}
                    </span>
                </a>
            @endif

            <!-- Product Name -->
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $product->name }}</h1>
            
            <!-- Rating & Reviews -->
            <div class="flex items-center mb-6">
                <div class="flex text-yellow-400 text-lg mr-2">
                    @for($i = 1; $i <= rand(1, 5); $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
                <span class="text-gray-600 dark:text-gray-400">({{ rand(50, 500) }} reviews)</span>
                <span class="mx-3 text-gray-400">|</span>
                <span class="text-gray-600 dark:text-gray-400">
                    <i class="fas fa-shopping-bag mr-1"></i>
                    {{ $product->sales_count ?? 0 }} sold
                </span>
            </div>

            <!-- Price -->
            <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-baseline space-x-3">
                    <span class="text-5xl font-bold text-blue-600 dark:text-blue-400">
                        ₹{{ number_format($product->price, 2) }}
                    </span>
                </div>
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Availability:</span>
                    @if($product->stock_status == 1)
                        <span class="flex items-center text-green-600 dark:text-green-400 font-semibold">
                            <i class="fas fa-check-circle mr-2"></i>
                            In Stock
                        </span>
                    @else
                        <span class="flex items-center text-red-600 dark:text-red-400 font-semibold">
                            <i class="fas fa-times-circle mr-2"></i>
                            Out of Stock
                        </span>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                    <i class="fas fa-info-circle mr-2"></i>Description
                </h3>
                <div class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    {{ $product->description ?? 'No description available for this product.' }}
                </div>
            </div>

            <!-- Quantity Selector (Only if in stock) -->
            @if($product->stock_status == 1)
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                        <i class="fas fa-shopping-basket mr-2"></i>Quantity
                    </label>
                    <div class="flex items-center space-x-4">
                        <button onclick="decreaseQty()" class="w-12 h-12 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex items-center justify-center font-bold text-xl">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input 
                            type="number" 
                            id="quantity" 
                            value="1" 
                            min="1" 
                            max="100" 
                            class="w-24 text-center text-xl font-bold py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                        >
                        <button onclick="increaseQty()" class="w-12 h-12 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex items-center justify-center font-bold text-xl">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Add to Cart Button -->
                    <button 
                        onclick="addToCart()" 
                        id="addToCartBtn"
                        class="py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Add to Cart
                    </button>

                    <!-- Buy Now Button -->
                    <button 
                        onclick="buyNow()" 
                        class="py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <i class="fas fa-bolt mr-2"></i>
                        Buy Now
                    </button>
                </div>
            @else
                <!-- Out of Stock Notice -->
                <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-lg p-6 mb-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
                        <h3 class="text-lg font-bold text-red-900 dark:text-red-300">Currently Out of Stock</h3>
                    </div>
                    <p class="text-red-700 dark:text-red-400 mb-4">
                        This product is currently unavailable. Please check back later or contact us for more information.
                    </p>
                </div>
            @endif

            <!-- Product Info Box -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 space-y-3 mt-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Product Information</h3>
                <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">SKU:</span>
                    <span class="text-gray-900 dark:text-white font-semibold">{{ $product->slug }}</span>
                </div>
                <div class="flex items-center justify-between py-2  dark:border-gray-700">
                    <span class="text-gray-600 dark:text-gray-400">Category:</span>
                    @if($product->category)
                        <a href="{{ route('category.show', $product->category->slug) }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                            {{ $product->category->name }}
                        </a>
                    @else
                        <span class="text-gray-500 dark:text-gray-400">N/A</span>
                    @endif
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-shipping-fast text-blue-600 dark:text-blue-400 text-2xl mb-2"></i>
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Free Shipping</p>
                </div>
                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-undo text-green-600 dark:text-green-400 text-2xl mb-2"></i>
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Easy Returns</p>
                </div>
                <div class="text-center p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-shield-alt text-purple-600 dark:text-purple-400 text-2xl mb-2"></i>
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-semibold">Secure Payment</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts && $relatedProducts->count() > 0)
        <div class="mt-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-th-large mr-2"></i>Related Products
                </h2>
                @if($product->category)
                    <a href="{{ route('category.show', $product->category->slug) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                @endif
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 group">
                        <div class="relative overflow-hidden aspect-square">
                            <a href="{{ route('product.show', $related->slug) }}">
                                @if( product_images($related->images) && count(product_images($related->images)) > 0)
                                    <img src="{{ asset('storage/uploads/product/' . product_images($related->images)[0]) }}" alt="{{ product_images($related->images)[0] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                                        <i class="fas fa-box text-white text-6xl"></i>
                                    </div>
                                @endif
                            </a>
                            @if($related->stock_status == 0)
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <span class="bg-red-600 text-white px-4 py-2 rounded-full font-bold">Out of Stock</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <a href="{{ route('product.show', $related->slug) }}">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2 truncate hover:text-blue-600 dark:hover:text-blue-400">
                                    {{ $related->name }}
                                </h3>
                            </a>
                            <p class="text-xl font-bold text-blue-600 dark:text-blue-400">
                                ₹{{ number_format($related->price, 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
// Change main image when clicking thumbnail
function changeImage(imageSrc, element) {
    document.getElementById('mainImage').src = imageSrc;
    
    // Remove active class from all thumbnails
    document.querySelectorAll('#mainImageContainer').parentElement.nextElementSibling.querySelectorAll('div').forEach(function(div) {
        div.classList.remove('border-blue-600', 'dark:border-blue-400');
        div.classList.add('border-gray-200', 'dark:border-gray-700');
    });
    
    // Add active class to clicked thumbnail
    element.classList.remove('border-gray-200', 'dark:border-gray-700');
    element.classList.add('border-blue-600', 'dark:border-blue-400');
}

// Quantity controls
function increaseQty() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value);
    const max = parseInt(input.max);
    if (current < max) {
        input.value = current + 1;
    }
}

function decreaseQty() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
    }
}

// Add to Cart
function addToCart() {
    const quantity = document.getElementById('quantity').value;
    const productId = {{ $product->id }};
    const button = document.getElementById('addToCartBtn');
    const originalText = button.innerHTML;

    // Disable button and show loading
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';

    $.ajax({
        url: '{{ route("cart.add") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            product_id: productId,
            quantity: quantity
        },
        success: function(response) {
            // Update cart count in header
            if (response.cart_count) {
                $('.cart-count').text(response.cart_count);
            }
            
            // Show success state
            button.innerHTML = '<i class="fas fa-check mr-2"></i>Added to Cart!';
            button.classList.remove('from-blue-600', 'to-purple-600');
            button.classList.add('bg-green-600');
            
            // Reset button after 2 seconds
            setTimeout(function() {
                button.disabled = false;
                button.innerHTML = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('from-blue-600', 'to-purple-600');
            }, 2000);
            
            // Show success message (optional)
            showNotification('Product added to cart successfully!', 'success');
        },
        error: function(xhr) {
            // Enable button
            button.disabled = false;
            button.innerHTML = originalText;
            
            if (xhr.status === 401) {
                // Redirect to login
                window.location.href = '{{ route("login") }}';
            } else {
                showNotification('Error adding product to cart. Please try again.', 'error');
            }
        }
    });
}

// Buy Now (Add to cart and redirect to checkout)
function buyNow() {
    const quantity = document.getElementById('quantity').value;
    const productId = {{ $product->id }};

}

// Show notification
function showNotification(message, type) {
    // You can use a toast library or create a custom notification
    alert(message);
}
</script>
@endpush