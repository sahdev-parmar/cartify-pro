<div class="space-y-6">
       <!-- Success Message -->
        @if (session()->has('message'))
            <div class="bg-green-50 absolute right-[10px] top-[10px] w-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 z-100" wire:poll.3s>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-green-800 dark:text-green-300">{{ session('message') }}</p>
                </div>
            </div>
        @endif

    <!-- Header -->
    @section('page-title')
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Orders Management</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage customer orders</p>
        </div>
    @endsection
        
    <div class="flex items-center">
        <button wire:click="resetFilters" class="flex items-center px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
            Reset Filters
        </button>
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
                        placeholder="customer name, email..." 
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order Status</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

          
            <!-- Date Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date</label>
                <select wire:model.live="dateFilter" class="w-full px-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Payment_method</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <!-- Order Info -->
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $order->created_at->format('h:i A') }}</p>
                                </div>
                            </td>

                            <!-- Customer -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    @if($order->user?->image)
                                        <img src="{{ asset('storage/uploads/user/' . $order->user->image) }}" 
                                             class="w-10 h-10 rounded-full object-cover"
                                             alt="{{ $order->user->name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                                            <span class="text-sm font-bold text-white">
                                                {{ $order->user ? substr($order->user->name, 0, 2) : substr($order->shipping_name, 0, 2) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ $order->user?->name ?? "-" }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $order->user?->email ?? "-" }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Products (Order Items) -->
                            <td class="px-6 py-4">
                                @if($order->items && $order->items->count() > 0)
                                    <div class="space-y-2">
                                        <!-- First Product -->
                                        @php $firstItem = $order->items->first(); @endphp
                                        <div class="flex items-center space-x-2">
                                            @if($firstItem->product?->images)
                                                <img src="{{ asset('storage/uploads/product/' . product_images($firstItem->product->images)[0]) }}" 
                                                     class="w-8 h-8 rounded object-cover border border-gray-200 dark:border-gray-600"
                                                     alt="{{ $firstItem->product->name }}">
                                            @else
                                                <div class="w-8 h-8 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ Str::limit($firstItem->product?->name ?? 'Deleted Product', 25) }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Qty: {{ $firstItem->quantity }} × ₹{{ number_format($firstItem->price, 2) }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- More Products Indicator -->
                                        @if($order->items->count() > 1)
                                            <div class="flex items-center space-x-2 pl-10">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300">
                                                    +{{ $order->items->count() - 1 }} more item{{ $order->items->count() > 2 ? 's' : '' }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    ({{ $order->items->count() }} total)
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <span class="text-sm text-gray-400 dark:text-gray-500">No items</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Total -->
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">₹{{ number_format($order->total, 2) }}</p>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 ">
                                <div class="relative">
                                    <button 
                                        wire:click="toggleDropdown({{ $order->id }})"
                                        class="flex items-center space-x-2 px-3 py-1.5 text-xs font-semibold rounded-lg border-2 transition-all
                                            @if($order->status === 'pending') 
                                                bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800 text-yellow-800 dark:text-yellow-300 hover:bg-yellow-100 dark:hover:bg-yellow-900/30
                                            @elseif($order->status === 'confirmed') 
                                                bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900/30
                                            @elseif($order->status === 'cancelled') 
                                                bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900/30
                                            @endif"
                                    >
                                        <span>{{ ucfirst($order->status) }}</span>
                                        <svg class="w-3 h-3 transition-transform {{ $openDropdown === $order->id ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <!-- Dropdown -->
                                    @if($openDropdown === $order->id)
                                        <div class="absolute z-10 mt-2 w-48 rounded-xl bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 py-2">
                                            <button wire:click="updateStatus({{ $order->id }}, 'pending')" 
                                                    class="w-full px-4 py-2 text-left text-sm hover:bg-yellow-50 dark:hover:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300 transition-colors flex items-center space-x-2">
                                                <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                                <span>Pending</span>
                                            </button>
                                            <button wire:click="updateStatus({{ $order->id }}, 'confirmed')" 
                                                    class="w-full px-4 py-2 text-left text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-blue-800 dark:text-blue-300 transition-colors flex items-center space-x-2">
                                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                                <span>Confirmed</span>
                                            </button>
                                            <hr class="my-2 border-gray-200 dark:border-gray-700">
                                            <button wire:click="updateStatus({{ $order->id }}, 'cancelled')" 
                                                    class="w-full px-4 py-2 text-left text-sm hover:bg-red-50 dark:hover:bg-red-900/20 text-red-800 dark:text-red-300 transition-colors flex items-center space-x-2">
                                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                                <span>Cancelled</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </td>


                            <!-- Payment Method -->
                            <td class="px-6 py-4">
                                @php
                                    $paymentMethods = [
                                        'cod' => ['name' => 'Cash on Delivery', 'color' => 'blue'],
                                        'upi' => ['name' => 'UPI', 'color' => 'orange'],
                                        'bank_transfer' => ['name' => 'Bank Transfer', 'color' => 'green'],
                                    ];
                                    $method = $paymentMethods[$order->payment_method] ?? ['name' => 'COD', 'color' => 'blue'];
                                @endphp
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $method['name'] }}
                                    </p>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <!-- View -->
                                        <button wire:click="viewShowOrder({{ $order->id }})" 
                                        class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" 
                                        title="View Details">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>

                                    <!-- Delete -->
                                    <button 
                                        wire:click="deleteOrder({{ $order->id }})"
                                        class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" 
                                        title="Delete Order">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white mb-1">No orders found</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Try adjusting your filters to see more results</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $orders->links() }}
        </div>
    </div>

    @if($showViewModal)
        @include('livewire.admin.orders.orderView')
    @endif

</div>
@script
<script>
    window.addEventListener('confirmMessage', event => { 
        Swal.fire({
        title: "Are you sure?",
        text: event.detail.text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            $wire.$call('Confirmdelete') // call function
        }
        });
    });

    window.addEventListener('doneMessage', event => {

        const isDark = $('html').hasClass('dark');
        Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: "success",
            background: isDark ? '#0f172a' : '#ffffff',
            color:       isDark ? '#22c55e' : '#0f172a',
            iconColor:   isDark ? '#22c55e' : '#16a34a',
            confirmButtonText: 'OK',
            confirmButtonColor: isDark ? '#2563eb' : '#3b82f6',
            customClass: {
                popup: 'rounded-xl',
                title: isDark ? 'text-green-400' : 'text-green-700',
                confirmButton: 'text-white font-semibold'
            }
        });
    }); 
</script>
@endscript