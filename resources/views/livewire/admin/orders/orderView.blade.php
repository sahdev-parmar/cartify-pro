<div>
<!-- View Order Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Dark Backdrop with Blur -->
        <div class="fixed inset-0 backdrop-blur-lg bg-black/80 transition-opacity" 
             wire:click="closeViewModal"></div>

        <!-- Modal Container -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">
            <!-- Modal panel -->
            <div class="relative inline-block bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-5xl">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Order Details</h3>
                                <p class="text-sm text-blue-100">{{ $viewOrder->order_number ?? '-' }}</p>
                            </div>
                        </div>
                        <button wire:click="closeViewModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                    <div class="grid grid-cols-3 gap-6">
                        
                        <!-- Left Column - Customer & Address -->
                        <div class="space-y-6">
                            <!-- Customer Info Card -->
                            <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-700 rounded-xl p-6 border border-blue-100 dark:border-gray-600">
                                <div class="flex items-center space-x-2 mb-4">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <h4 class="font-bold text-gray-900 dark:text-white">Customer</h4>
                                </div>
                                
                                <!-- Avatar -->
                                <div class="flex items-center space-x-3 mb-4">
                                    @if($viewOrder->user?->image)
                                        <img src="{{ asset('storage/uploads/user/' . $viewOrder->user->image) }}" 
                                             class="w-16 h-16 rounded-full object-cover border-4 border-white dark:border-gray-600"
                                             alt="{{ $viewOrder->user->name }}">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center border-4 border-white dark:border-gray-600">
                                            <span class="text-xl font-bold text-white">
                                                {{ $viewOrder->user ? substr($viewOrder->user->name, 0, 2) : substr($viewOrder->shipping_name, 0, 2) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $viewOrder->user?->name ?? $viewOrder->shipping_name }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $viewOrder->user?->email ?? $viewOrder->shipping_email }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-2 text-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $viewOrder->user?->name }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2 text-sm">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $viewOrder->user?->mobile_number }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address Card -->
                            <div class="bg-gradient-to-br from-green-50 to-teal-50 dark:from-gray-700 dark:to-gray-700 rounded-xl p-6 border border-green-100 dark:border-gray-600">
                                <div class="flex items-center space-x-2 mb-4">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <h4 class="font-bold text-gray-900 dark:text-white">Shipping Address</h4>
                                </div>
                                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                    <p class="font-medium">{{ $viewOrder->shipping_name }}</p>
                                    <p>{{ $viewOrder->address }}</p>
                                    <p>{{ $viewOrder->City?->name }}, {{ $viewOrder->State?->name }}</p>
                                    <p>{{ $viewOrder->Country?->name }} </p>
                                </div>
                            </div>

                            <!-- Order Info Card -->
                            <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-gray-700 dark:to-gray-700 rounded-xl p-6 border border-purple-100 dark:border-gray-600">
                                <div class="flex items-center space-x-2 mb-4">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h4 class="font-bold text-gray-900 dark:text-white">Order Info</h4>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Order Date</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewOrder->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Payment Method</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $viewOrder->payment_method) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Status</span>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @if($viewOrder->status === 'confirmed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300
                                            @elseif($viewOrder->status === 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300
                                            @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 @endif">
                                            {{ ucfirst($viewOrder->status) }}
                                        </span>
                                    </div>
                                    @if($viewOrder->transaction_id)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">Transaction ID</span>
                                            <span class="text-xs font-mono text-gray-900 dark:text-white">{{ $viewOrder->transaction_id }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Products & Summary -->
                        <div class="col-span-2 space-y-6">
                            
                            <!-- Products Card -->
                            <div class="bg-white dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600">
                                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <h4 class="font-bold text-gray-900 dark:text-white">Products</h4>
                                        </div>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                            {{ $viewOrder->items->count() }} item(s)
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6 space-y-4">
                                    @foreach($viewOrder->items as $item)
                                        <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                            <!-- Product Image -->
                                            @if($item->product?->images)
                                                <img src="{{ asset('storage/uploads/product/' . product_images($item->product->images)[0]) }}" 
                                                     class="w-10 h-10 rounded-lg object-cover border-2 border-white dark:border-gray-700 shadow-sm"
                                                     alt="{{ $item->product->name }}">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center border-2 border-white dark:border-gray-700">
                                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                            @endif

                                            <!-- Product Details -->
                                            <div class="flex-1">
                                                <h5 class="font-semibold text-gray-900 dark:text-white mb-1">
                                                    {{ $item->product?->name ?? 'Product Deleted' }}
                                                </h5>
                                                <div class="flex items-center space-x-4 text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">
                                                        Qty: <span class="font-semibold text-gray-900 dark:text-white">{{ $item->quantity }}</span>
                                                    </span>
                                                    <span class="text-gray-600 dark:text-gray-400">
                                                        Price: <span class="font-semibold text-gray-900 dark:text-white">₹{{ number_format($item->price, 2) }}</span>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Subtotal -->
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Subtotal</p>
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                                    ₹{{ number_format($item->price * $item->quantity, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Order Summary Card -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 p-6">
                                <h4 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Order Summary</span>
                                </h4>
                                
                                <div class="space-y-3">
                                    
                                    <div class="pt-3 border-t-2 border-gray-300 dark:border-gray-600">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">₹{{ number_format($viewOrder->total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($viewOrder->status === 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300
                            @elseif($viewOrder->status === 'confirmed') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300
                            @elseif($viewOrder->status === 'delivered') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300
                            @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 @endif">
                            {{ ucfirst($viewOrder->status) }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button wire:click="closeViewModal" 
                                class="px-6 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>