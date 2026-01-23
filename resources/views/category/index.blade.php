@extends('layout.app')

@section('title', $category->name)

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-100 dark:bg-gray-800 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
        </nav>
    </div>
</div>
<!-- Category Header -->
<div class="bg-white dark:bg-gray-800 py-5 border-b border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 grid grid-cols-3 items-center">

        <!-- Left: Category Info -->
        <div class="flex items-center space-x-4 justify-start">
            @if($category->image)
                <img 
                    src="{{ asset('storage/uploads/category/' . $category->image) }}" 
                    alt="{{ $category->name }}" 
                    class="w-16 h-16 rounded-lg object-cover"
                >
            @else
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-th-large text-white text-2xl"></i>
                </div>
            @endif

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $category->name }}
            </h1>
        </div>

        <!-- Center: Search -->
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-center">
                    <i class="fas fa-search mr-2"></i>Search
                </label>

                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Search products..."
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg 
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-white 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center"
                >
            </div>
        </div>

        <!-- Right: Empty spacer -->
        <div></div>

    </div>
</div>



<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <aside class="lg:w-64 flex-shrink-0">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 sticky top-24">
                
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center justify-between">
                    <span><i class="fas fa-filter mr-2"></i>Filters</span>
                    <button onclick="resetFilters()" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Reset
                    </button>
                </h2>

               
                <hr class="border-gray-200 dark:border-gray-700 mb-6">

                <!-- Price Range Filter -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        ₹ Price Range
                    </label>
                    
                    <div class="space-y-4">
                        <!-- Min Price -->
                        <div>
                            <label class="text-xs text-gray-600 dark:text-gray-400">Min Price: ₹<span id="minPriceValue">0</span></label>
                            <input 
                                type="range" 
                                id="minPrice" 
                                min="0" 
                                max="10000" 
                                value="0" 
                                class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer"
                            >
                        </div>
                        
                        <!-- Max Price -->
                        <div>
                            <label class="text-xs text-gray-600 dark:text-gray-400">Max Price: ₹<span id="maxPriceValue">1000000</span></label>
                            <input 
                                type="range" 
                                id="maxPrice" 
                                min="0" 
                                max="1000000" 
                                value="1000000" 
                                class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer"
                            >
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 mb-6">

                <!-- Stock Filter -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        <i class="fas fa-box mr-2"></i>Availability
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="inStock" value="1" class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">In Stock Only</span>
                        </label>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 mb-6">

                <!-- Sort Filter -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        <i class="fas fa-sort mr-2"></i>Sort By
                    </label>
                    <select 
                        id="sortBy" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="latest">Latest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="name">Name: A to Z</option>
                    </select>
                </div>
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="hidden text-center py-20">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 dark:border-blue-400"></div>
                <p class="mt-4 text-gray-600 dark:text-gray-400">Loading products...</p>
            </div>
                <div id="productsContainer">
                        @include('category.product-grid', ['products' => $products])
                </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Update price range display
    $('#minPrice').on('input', function() {
        $('#minPriceValue').text($(this).val());
    });

    $('#maxPrice').on('input', function() {
        $('#maxPriceValue').text($(this).val());
    });

    // Price range filter with delay
    $('#minPrice, #maxPrice').on('change', function() {
        filterProducts();
    });

    // Search input with debounce
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            filterProducts();
        }, 500);
    });

    // Stock filter
    $('#inStock').on('change', function() {
        filterProducts();
    });

    // Sort filter
    $('#sortBy').on('change', function() {
        filterProducts();
    });

    // Filter products function
    function filterProducts(page = 1) {
        const categorySlug = '{{ $category->slug }}';
        const search = $('#searchInput').val();
        const minPrice = $('#minPrice').val();
        const maxPrice = $('#maxPrice').val();
        const inStock = $('#inStock').is(':checked') ? 1 : 0;
        const sort = $('#sortBy').val();

        // Show loading
        $('#loadingSpinner').removeClass('hidden');
        $('#productsContainer').addClass('opacity-50');

        $.ajax({
            url: '{{ route("category.filter") }}',
            type: 'GET',
            data: {
                category: categorySlug,
                search: search,
                min_price: minPrice,
                max_price: maxPrice,
                in_stock: inStock,
                sort: sort,
                page: page
            },
            success: function(response) {
                $('#productsContainer').html(response.html);
                
                // Hide loading
                $('#loadingSpinner').addClass('hidden');
                $('#productsContainer').removeClass('opacity-50');

                
            },
            error: function(xhr) {
                console.error('Error filtering products:', xhr);
                $('#loadingSpinner').addClass('hidden');
                $('#productsContainer').removeClass('opacity-50');
            }
        });
    }

    // Reset filters
    window.resetFilters = function() {
        $('#searchInput').val('');
        $('#minPrice').val(0);
        $('#maxPrice').val(1000000);
        $('#minPriceValue').text(0);
        $('#maxPriceValue').text(1000000);
        $('#inStock').prop('checked', false);
        $('#sortBy').val('latest');
        filterProducts();
    }

    // Pagination click handler
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const page = new URL(url).searchParams.get('page');
        filterProducts(page);
    });
});
</script>
@endpush
