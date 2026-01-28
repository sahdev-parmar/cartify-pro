@extends('layout.app')

@section('title', 'Checkout')

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-100 dark:bg-gray-800 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-700 dark:text-gray-300">Checkout</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
        <i class="fas fa-credit-card mr-2"></i>Checkout
    </h1>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf
        <input type="hidden" name="checkout_type" value="{{ $checkoutType }}">
        @if($checkoutType === 'buynow')
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="{{ $quantity }}">
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side - Delivery & Payment -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Delivery Address Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400 mr-2"></i>
                        Delivery Address
                    </h2>

                    <!-- Current User Address (Pre-filled) -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">
                                    <i class="fas fa-user mr-2"></i>{{ auth()->user()->name }}
                                </h3>
                                
                                @if(auth()->user()->address)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">
                                        <i class="fas fa-home mr-2"></i>{{ auth()->user()->address }}
                                    </p>
                                @endif

                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-1">
                                    <i class="fas fa-city mr-2"></i>
                                    @if(auth()->user()->city)
                                        {{ auth()->user()->city->name }},
                                    @endif
                                    @if(auth()->user()->state)
                                        {{ auth()->user()->state->name }}
                                    @endif
                                    @if(auth()->user()->country)
                                        - {{ auth()->user()->country->name }}
                                    @endif
                                </p>

                                @if(auth()->user()->mobile_number)
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                        <i class="fas fa-phone mr-2"></i>{{ auth()->user()->mobile_number }}
                                    </p>
                                @endif
                            </div>
                            <button type="button" onclick="toggleAddressForm()" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 text-sm font-semibold">
                                <i class="fas fa-edit mr-1"></i>Change
                            </button>
                        </div>
                    </div>

                    <!-- Edit Address Form (Hidden by default) -->
                    <div id="addressForm" class=" {{ $errors->any() ? '' : 'hidden' }} space-y-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Update Delivery Address</h3>
                        
                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Street Address <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="address" 
                                rows="2"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter your street address">{{ old('address', auth()->user()->address) }}</textarea>
                            @error('address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Country -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Country <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="country_id" 
                                    id="country_id"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id', auth()->user()->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- State -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    State <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="state_id" 
                                    id="state_id"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">Select State</option>
                                </select>
                                @error('state_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    City <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="city_id" 
                                    id="city_id"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">Select City</option>
                                </select>
                                @error('city_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="button" onclick="toggleAddressForm()" class="text-gray-600 dark:text-gray-400 hover:text-gray-500 text-sm">
                            <i class="fas fa-times mr-1"></i>Cancel
                        </button>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-wallet text-blue-600 dark:text-blue-400 mr-2"></i>
                        Payment Method
                    </h2>

                    <div class="space-y-3">
                        <!-- Cash on Delivery -->
                        <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-gray-900 dark:text-white">Cash on Delivery</span>
                                    <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pay when you receive your order</p>
                            </div>
                        </label>

                        <!-- UPI -->
                        <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="payment_method" value="upi" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-gray-900 dark:text-white">UPI Payment</span>
                                    <i class="fas fa-mobile-alt text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pay using UPI apps (PhonePe, Google Pay, etc.)</p>
                            </div>
                        </label>

                        <!-- Bank Transfer -->
                        <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 transition-colors has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 dark:has-[:checked]:bg-blue-900/20">
                            <input type="radio" name="payment_method" value="bank_transfer" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-gray-900 dark:text-white">Bank Transfer</span>
                                    <i class="fas fa-university text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Direct bank account transfer</p>
                            </div>
                        </label>
                    </div>

                    @error('payment_method')
                        <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Right Side - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-receipt text-blue-600 dark:text-blue-400 mr-2"></i>
                        Order Summary
                    </h2>

                    <!-- Order Items -->
                    <div class="space-y-4 mb-4 max-h-96 overflow-y-auto">
                        @if($checkoutType === 'cart')
                            @foreach($cartItems as $item)
                                <div class="flex items-start space-x-3 pb-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="w-16 h-16 flex-shrink-0">
                                        @if($item->product->images)
                                            <img src="{{ asset('storage/uploads/product/' . product_images($item->product->images)[0]) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-box text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $item->product->name }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Qty: {{ $item->quantity }}</p>
                                        <p class="text-sm font-bold text-blue-600 dark:text-blue-400 mt-1">
                                            ₹{{ number_format($item->product->price * $item->quantity, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-start space-x-3 pb-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="w-16 h-16 flex-shrink-0">
                                    @if($product->images)
                                        <img src="{{ asset('storage/uploads/product/' . product_images($product->images)[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-box text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $product->name }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Qty: {{ $quantity }}</p>
                                    <p class="text-sm font-bold text-blue-600 dark:text-blue-400 mt-1">
                                        ₹{{ number_format($product->price * $quantity, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 py-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span class="font-semibold">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Shipping</span>
                            <span class="font-semibold text-green-600 dark:text-green-400">FREE</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between items-center py-4 border-t-2 border-gray-300 dark:border-gray-600">
                        <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">₹{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <!-- Place Order Button -->
                    <button 
                        type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <i class="fas fa-check-circle mr-2"></i>
                        Place Order
                    </button>

                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center mt-3">
                        <i class="fas fa-lock mr-1"></i>
                        Secure checkout - Your information is safe
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// Toggle address form
function toggleAddressForm() {
    $('#addressForm').toggleClass('hidden');
}

// Cascading dropdowns
$(document).ready(function() {
    // Load states if country is pre-selected
    const selectedCountry = $('#country_id').val();
    if (selectedCountry) {
        loadStates(selectedCountry, '{{ old("state_id", auth()->user()->state_id) }}');
    }

    $('#country_id').on('change', function() {
        const countryId = $(this).val();
        if(countryId) {
            loadStates(countryId);
        } else {
            $('#state_id').html('<option value="">Select State</option>').prop('disabled', true);
            $('#city_id').html('<option value="">Select City</option>').prop('disabled', true);
        }
    });

    $('#state_id').on('change', function() {
        const stateId = $(this).val();
        if(stateId) {
            loadCities(stateId);
        } else {
            $('#city_id').html('<option value="">Select City</option>').prop('disabled', true);
        }
    });

    function loadStates(countryId, selectedState = null) {
        $.ajax({
            url: '/api/states/' + countryId,
            type: 'GET',
            success: function(data) {
                $('#state_id').html('<option value="">Select State</option>').prop('disabled', false);
                $('#city_id').html('<option value="">Select City</option>').prop('disabled', true);
                
                $.each(data, function(key, state) {
                    const selected = selectedState == state.id ? 'selected' : '';
                    $('#state_id').append(`<option value="${state.id}" ${selected}>${state.name}</option>`);
                });

                // Load cities if state is pre-selected
                if (selectedState) {
                    loadCities(selectedState, '{{ old("city_id", auth()->user()->city_id) }}');
                }
            }
        });
    }

    function loadCities(stateId, selectedCity = null) {
        $.ajax({
            url: '/api/cities/' + stateId,
            type: 'GET',
            success: function(data) {
                $('#city_id').html('<option value="">Select City</option>').prop('disabled', false);
                
                $.each(data, function(key, city) {
                    const selected = selectedCity == city.id ? 'selected' : '';
                    $('#city_id').append(`<option value="${city.id}" ${selected}>${city.name}</option>`);
                });
            }
        });
    }
});
</script>
@endpush