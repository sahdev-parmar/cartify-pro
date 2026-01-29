@extends('layout.app')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-100 dark:bg-gray-800 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <a href="{{ route('orders.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">My Orders</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-700 dark:text-gray-300">{{ $order->order_number }}</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Order Details
                </h1>
                <p class="text-gray-600 dark:text-gray-400">Order #{{ $order->order_number }}</p>
            </div>
            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>

        <!-- Order Status Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Order Number</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Order Date</p>
                    <p class="text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Status</p>
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
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Payment Method</p>
                    <p class="text-gray-900  px-3 py-1 inline-block dark:text-white rounded-full bg-gray-200 dark:bg-gray-600 font-semibold">{{ strtoupper($order->payment_method) }}</p>
                </div>
            </div>

            @if($order->status === 'pending')
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button 
                        onclick="cancelOrder({{ $order->id }})" 
                        class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold"
                    >
                        <i class="fas fa-times mr-2"></i>Cancel This Order
                    </button>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Side - Order Items & Address -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Order Items -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-box text-blue-600 dark:text-blue-400 mr-2"></i>
                        Order Items
                    </h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-start space-x-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
                                <div class="w-24 h-24 flex-shrink-0">
                                    @if($item->product && $item->product->images && count(product_images($item->product->images)) > 0)
                                        <img src="{{ asset('storage/uploads/product/' . product_images($item->product->images)[0]) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-box text-white text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ $item->product ? $item->product->name : 'Product Unavailable' }}
                                    </h3>
                                    @if($item->product && $item->product->category)
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Category: {{ $item->product->category->name }}
                                        </p>
                                    @endif
                                    <div class="flex items-center space-x-4 mt-2">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Price: ₹{{ number_format($item->price, 2) }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Quantity: {{ $item->quantity }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                        ₹{{ number_format($item->price * $item->quantity, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400 mr-2"></i>
                        Delivery Address
                    </h2>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                        <p class="text-gray-900 dark:text-white font-semibold mb-2">{{ $order->user->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">{{ $order->address }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">
                            {{ $order->city->name ?? '' }}, {{ $order->state->name ?? '' }} - {{ $order->country->name ?? '' }}
                        </p>
                        @if($order->user->mobile_number)
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                                <i class="fas fa-phone mr-2"></i>{{ $order->user->mobile_number }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Side - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-receipt text-blue-600 dark:text-blue-400 mr-2"></i>
                        Order Summary
                    </h2>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Subtotal ({{ $order->items->count() }} items)</span>
                            <span class="font-semibold">₹{{ number_format($order->total)}}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Shipping</span>
                            <span class="font-semibold text-green-600 dark:text-green-400">FREE</span>
                        </div>
                    </div>

                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">₹{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="space-y-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Payment Method</span>
                            <span class="text-gray-900 dark:text-white font-semibold">{{ $order->payment_method_label }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Order Date</span>
                            <span class="text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Need Help -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Need help with your order?</p>
                        <a href="{{route('contact-us')}}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-semibold">
                            <i class="fas fa-headset mr-1"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
</script>
@endpush