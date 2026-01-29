@extends('layout.app')

@section('title', 'Order Success')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        
        <!-- Success Message -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                <i class="fas fa-check text-green-600 dark:text-green-400 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Order Placed Successfully!</h1>
            <p class="text-gray-600 dark:text-gray-400">Thank you for your order. We'll send you a confirmation email shortly.</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 mb-6">
            
            <!-- Order Info -->
            <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Order Number</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Order Date</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Status</p>
                    <span class="inline-block px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full text-sm font-semibold">
                        {{ $order->status }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Payment Method</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ strtoupper($order->payment_method) }}</p>
                </div>
            </div>

            <!-- Delivery Address -->
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3 flex items-center">
                    <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400 mr-2"></i>
                    Delivery Address
                </h3>
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                    <p class="text-gray-900 dark:text-white font-semibold mb-1">{{ $order->user->name }}</p>
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

            <!-- Order Items -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3 flex items-center">
                    <i class="fas fa-box text-blue-600 dark:text-blue-400 mr-2"></i>
                    Order Items
                </h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex items-start space-x-3 p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <div class="w-16 h-16 flex-shrink-0">
                                @if($item->product->images)
                                    <img src="{{ asset('storage/uploads/product/' . product_images($item->product->images)[0]) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $item->product->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Quantity: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Price: ₹{{ number_format($item->price, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900 dark:text-white">₹{{ number_format($item->quantity * $item->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Total -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">Total</span>
                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">₹{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('orders.index') }}" class="block text-center py-3 px-6 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold">
                <i class="fas fa-list mr-2"></i>View All Orders
            </a>
            <a href="{{ route('home') }}" class="block text-center py-3 px-6 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-semibold">
                <i class="fas fa-home mr-2"></i>Continue Shopping
            </a>
        </div>
    </div>
</div>

@endsection