<div>
    <a href="javascript:void(0)" id="openCartBtn" class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
        <i class="fas fa-shopping-cart text-gray-600 dark:text-gray-300 text-xl"></i>
        <span id="cartCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
            {{ auth()->check() ? auth()->user()->cart()->count() : 0 }}
        </span>
    </a>

    <!-- Sidebar Overlay -->
    <div id="cartOverlay" class="fixed inset-0  z-40 hidden transition-opacity duration-300"></div>

    <!-- Sidebar Panel -->
    <div id="cartSidebar" class="fixed right-0 top-0 h-full w-full md:w-96 bg-white dark:bg-gray-800 shadow-2xl z-50 transform translate-x-full transition-transform duration-300 flex flex-col">
        
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-shopping-cart mr-2"></i>Shopping Cart
            </h2>
            <button id="closeCartBtn" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <i class="fas fa-times text-gray-600 dark:text-gray-300 text-xl"></i>
            </button>
        </div>

        <!-- Cart Items Container -->
        <div id="cartItemsContainer" class="flex-1 overflow-y-auto p-4">
            <!-- Loading State -->
            <div id="loadingCart" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <p class="mt-4 text-gray-600 dark:text-gray-400">Loading cart...</p>
            </div>
        </div>

        <!-- Footer -->
        <div id="cartFooter" class="hidden border-t border-gray-200 dark:border-gray-700 p-4 space-y-4 bg-white dark:bg-gray-800">
            <!-- Total -->
            <div class="flex items-center justify-between">
                <span class="text-lg font-bold text-gray-900 dark:text-white">Total:</span>
                <span id="cartTotal" class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                    ₹0.00
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2">
                <a href="{{ route('checkout.index') }}" class="block w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-bold">
                    <i class="fas fa-credit-card mr-2"></i>Proceed to Checkout
                </a>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="message-box" class="bg-green-100  border-green-400 hidden  fixed right-[10px] top-[10px] w-100 dark:bg-green-900 border border-green-200 dark:border-green-800 rounded-xl p-4" style="z-index: 999">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-green-800 dark:text-green-300" id="message"></p>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    
    // Open cart sidebar
    $('#openCartBtn').on('click', function(e) {
        e.preventDefault();
        openCart();
    });

    // Close cart sidebar
    $('#closeCartBtn, #cartOverlay').on('click', function() {
        closeCart();
    });

    // Close on escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCart();
        }
    });

    // Open cart function
    function openCart() {
        $('#cartOverlay').removeClass('hidden');
        $('#cartSidebar').removeClass('translate-x-full');
        $('body').addClass('overflow-hidden');
        loadCartItems();
    }

    // Close cart function
    function closeCart() {
        $('#cartOverlay').addClass('hidden');
        $('#cartSidebar').addClass('translate-x-full');
        $('body').removeClass('overflow-hidden');
    }

    // Load cart items
    function loadCartItems() {
        $('#loadingCart').show();
        $('#cartItemsContainer').children().not('#loadingCart').remove();
        
        $.ajax({
            url: '{{ route("cart.items") }}',
            type: 'GET',
            success: function(response) {
                $('#loadingCart').hide();
                
                if (response.items && response.items.length > 0) {
                    renderCartItems(response.items, response.total);
                    $('#cartFooter').removeClass('hidden');
                } else {
                    renderEmptyCart();
                    $('#cartFooter').addClass('hidden');
                }
            },
            error: function(xhr) {
                $('#loadingCart').hide();
                if (xhr.status === 401) {
                    renderLoginPrompt();
                } else {
                    renderEmptyCart();
                }
                $('#cartFooter').addClass('hidden');
            }
        });
    }

    // Render cart items
    function renderCartItems(items, total) {
        let html = '<div class="space-y-4">';
        
        items.forEach(function(item) {
            let imageUrl = '';
            if (item.product.images && item.product.images.length > 0) {
                let images = item.product.images.split(',');
                imageUrl = '{{ asset("storage/uploads/product") }}/' + images[0];
            }
            
            html += `
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-3 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start space-x-3">
                        <!-- Product Image -->
                        <div class="w-20 h-20 flex-shrink-0">
                            ${imageUrl ? 
                                `<img src="${imageUrl}" alt="${escapeHtml(item.product.name)}" class="w-full h-full object-cover rounded-lg">` :
                                `<div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box text-white text-2xl"></i>
                                </div>`
                            }
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                ${escapeHtml(item.product.name)}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                ${parseFloat(item.product.price).toLocaleString('en-IN', {
                                style: 'currency',
                                currency: 'INR'
                            })}
                            </p>

                            <!-- Quantity Controls -->
                            <div class="flex items-center space-x-2 mt-2">
                                <button 
                                    onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})" 
                                    class="w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors ${item.quantity <= 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                                    ${item.quantity <= 1 ? 'disabled' : ''}
                                >
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="text-xl font-semibold text-gray-900 dark:text-white w-8 text-center">
                                    ${item.quantity}
                                </span>
                                <button 
                                    onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})" 
                                    class="w-6 h-6 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors"
                                >
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remove Button -->
                        <button 
                            onclick="removeCartItem(${item.id})" 
                            class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                        >
                            <i class="fas fa-trash text-lg"></i>
                        </button>
                    </div>

                    <!-- Subtotal -->
                    <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                ${parseFloat(item.quantity * item.product.price).toLocaleString('en-IN', {
                                    style: 'currency',
                                    currency: 'INR'
                                })}
                            </span>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        $('#cartItemsContainer').append(html);
        $('#cartTotal').text(parseFloat(total).toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR'
        }));
    }

    // Render empty cart
    function renderEmptyCart() {
        let html = `
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-gray-300 dark:text-gray-600 text-6xl mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400 text-lg font-semibold mb-2">Your cart is empty</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">Add some products to get started!</p>
                <a href="{{ route('products.index') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold">
                    Browse Products
                </a>
            </div>
        `;
        $('#cartItemsContainer').append(html);
    }

    // Render login prompt
    function renderLoginPrompt() {
        let html = `
            <div class="text-center py-12">
                <i class="fas fa-user-lock text-gray-300 dark:text-gray-600 text-6xl mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400 text-lg font-semibold mb-2">Please login to view cart</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">You need to be logged in to add items to cart</p>
                <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold">
                    Login Now
                </a>
            </div>
        `;
        $('#cartItemsContainer').append(html);
    }

    // Update cart quantity (global function)
    window.updateCartQuantity = function(cartId, quantity) {
        if (quantity < 1) return;
        
        showLoading();
        
        $.ajax({
            url: '{{ route("cart.update") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId,
                quantity: quantity
            },
            success: function(response) {
                loadCartItems();
                updateCartCount(response.cart_count);
                showToast('Cart updated successfully', 'success');
            },
            error: function(xhr) {
                hideLoading();
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                } else {
                    showToast('Error updating cart', 'error');
                }
            }
        });
    };

    // Remove cart item (global function)
    window.removeCartItem = function(cartId) {
        
        showLoading();
        
        $.ajax({
            url: '{{ route("cart.remove") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_id: cartId
            },
            success: function(response) {
                loadCartItems();
                updateCartCount(response.cart_count);
                showToast('Item removed from cart', 'success');
            },
            error: function(xhr) {
                hideLoading();
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                } else {
                    showToast('Error removing item', 'error');
                }
            }
        });
    };

    // Update cart count in header
    function updateCartCount(count) {
        $('#cartCount').text(count);
    }

    // Show loading overlay
    function showLoading() {
        const overlay = `
            <div id="cartLoadingOverlay" class="absolute inset-0 bg-white dark:bg-gray-800 bg-opacity-75 flex items-center justify-center z-10">
                <div class="text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Updating...</p>
                </div>
            </div>
        `;
        $('#cartItemsContainer').css('position', 'relative').append(overlay);
    }

    // Hide loading overlay
    function hideLoading() {
        $('#cartLoadingOverlay').remove();
    }

    // Show toast notification
    function showToast(message, type = 'success') {
        $('#message').empty();
        $('#message-box').fadeIn();
        $('#message').text(message);

        setTimeout(function(){
            $('#message-box').fadeOut();
        },2000)
    }

    // HTML escape function
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Make updateCartCount global for use in add to cart
    window.refreshCartCount = function() {
        $.ajax({
            url: '{{ route("cart.count") }}',
            type: 'GET',
            success: function(response) {
                updateCartCount(response.cart_count);
            }
        });
    };

    setInterval(refreshCartCount, 2000);
});
</script>
@endpush
