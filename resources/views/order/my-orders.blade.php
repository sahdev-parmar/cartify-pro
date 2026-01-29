@extends('layout.app')

@section('title', 'My Orders')

@section('content')

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 rounded-xl p-4 shadow-lg" id="successMessage">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
        </div>
    </div>
@endif


<!-- Breadcrumb -->
<div class="bg-gray-100 dark:bg-gray-800 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-700 dark:text-gray-300">My Orders</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            <i class="fas fa-shopping-bag mr-2"></i>My Orders
        </h1>
        <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
            <i class="fas fa-home mr-2"></i>Continue Shopping
        </a>
    </div>

    @if($orders->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full mb-6">
                <i class="fas fa-shopping-bag text-gray-400 dark:text-gray-600 text-5xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Orders Yet</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">You haven't placed any orders yet.</p>
            <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold">
                <i class="fas fa-shopping-cart mr-2"></i>Start Shopping
            </a>
        </div>
    @else
        <!-- Orders List -->
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
                    
                    <!-- Order Header -->
                    <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Order Number</p>
                                <p class="font-bold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Date</p>
                                <p class="text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total</p>
                                <p class="text-lg font-bold text-blue-600 dark:text-blue-400">₹{{ number_format($order->total, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Status</p>
                                @if($order->status === 'pending')
                                    <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full text-sm font-semibold">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @elseif($order->status === 'confirmed')
                                    <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Confirmed
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full text-sm font-semibold">
                                        <i class="fas fa-times-circle mr-1"></i>Cancelled
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                  <!-- Order Items -->
                    <div class="p-6">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-box mr-2"></i>Order Items ({{ $order->items->count() }})
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($order->items as $item)
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-3 border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-16 h-16 flex-shrink-0">
                                            @if($item->product && $item->product->images && count(product_images($item->product->images)) > 0)
                                                <img src="{{ asset('storage/uploads/product/' . product_images($item->product->images)[0]) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-box text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm truncate mb-1">
                                                {{ $item->product ? $item->product->name : 'Product Unavailable' }}
                                            </h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                ₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}
                                            </p>
                                            <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                                ₹{{ number_format($item->price * $item->quantity, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <!-- Order Footer -->
                    <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Payment Method -->
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-wallet text-gray-500 dark:text-gray-400"></i>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ strtoupper($order->payment_method) }}
                                    </span>
                                </div>
                                
                                <!-- Delivery Address -->
                                <button 
                                    onclick="toggleAddress('address-{{ $order->id }}')" 
                                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                                >
                                    <i class="fas fa-map-marker-alt mr-1"></i>View Address
                                </button>
                            </div>

                            <div class="flex items-center space-x-3">
                                <!-- View Details -->
                                <a href="{{ route('order.details', $order->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </a>

                                <!-- Cancel Order (Only if pending) -->
                                @if($order->status === 'pending')
                                    <button 
                                        onclick="cancelOrder({{ $order->id }})" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-semibold"
                                    >
                                        <i class="fas fa-times mr-1"></i>Cancel Order
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Address (Hidden by default) -->
                        <div id="address-{{ $order->id }}" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>Delivery Address
                            </h4>
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                                <p class="text-gray-900 dark:text-white font-semibold">{{ $order->user->name }}</p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $order->address }}</p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                    {{ $order->city->name ?? '' }}, {{ $order->state->name ?? '' }} - {{ $order->country->name ?? '' }}
                                </p>
                                @if($order->user->mobile_number)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                                        <i class="fas fa-phone mr-1"></i>{{ $order->user->mobile_number }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
</div>

<!-- Cancel Order Confirmation Modal -->
<div id="cancelModal" class="hidden fixed inset-0 backdrop-blur-lg bg-black/80 transition-opacity z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full p-6 shadow-2xl">
        <div class="flex items-center justify-center w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full mx-auto mb-4">
            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white text-center mb-2">Cancel Order?</h3>
        <p class="text-gray-600 dark:text-gray-400 text-center mb-6">
            Are you sure you want to cancel this order? This action cannot be undone.
        </p>
        <div class="grid grid-cols-2 gap-3">
            <button 
                onclick="closeModal()" 
                class="px-4 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-semibold"
            >
                No, Keep It
            </button>
            <form id="cancelForm" method="POST" action="">
                @csrf
                @method('PUT')
                <button 
                    type="submit"
                    class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold"
                >
                    Yes, Cancel
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Toggle address visibility
function toggleAddress(id) {
    const element = document.getElementById(id);
    element.classList.toggle('hidden');
}

// Cancel order
function cancelOrder(orderId) {
    const modal = document.getElementById('cancelModal');
    const form = document.getElementById('cancelForm');
    form.action = `/order/${orderId}/cancel`;
    modal.classList.remove('hidden');
}

// Close modal
function closeModal() {
    const modal = document.getElementById('cancelModal');
    modal.classList.add('hidden');
}

// Auto-hide success/error messages
setTimeout(function() {
    const successMsg = document.getElementById('successMessage');
    const errorMsg = document.getElementById('errorMessage');
    if(successMsg) successMsg.style.display = 'none';
    if(errorMsg) errorMsg.style.display = 'none';
}, 5000);
</script>
@endpush