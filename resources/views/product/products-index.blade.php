@extends('layout.app')

@section('title', 'All Products')

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-100 dark:bg-gray-800 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
            <span class="text-gray-700 dark:text-gray-300">Products</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Sidebar - Filters -->
        <aside class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 sticky top-24">
                
                <!-- Filter Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        <i class="fas fa-filter mr-2"></i>Filters
                    </h2>
                    <button onclick="clearFilters()" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Clear All
                    </button>
                </div>

                <!-- Search Filter (Mobile Only) -->
                <div class="mb-6 lg:hidden">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-search mr-2"></i>Search
                    </label>
                    <input 
                        type="text" 
                        id="mobileSearch"
                        placeholder="Search products..." 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Categories Filter -->
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">
                        <i class="fas fa-th-large mr-2"></i>Categories
                    </h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($categories as $category)
                            <label class="flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded">
                                <input 
                                    type="checkbox" 
                                    class="category-filter w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                    value="{{ $category->id }}"
                                >
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">
                        <i class="fas fa-dollar-sign mr-2"></i>Price Range
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Min Price</label>
                            <input 
                                type="number" 
                                id="minPrice" 
                                placeholder="0" 
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                            >
                        </div>
                        <div>
                            <label class="block text-xs text-gray-600 dark:text-gray-400 mb-1">Max Price</label>
                            <input 
                                type="number" 
                                id="maxPrice" 
                                placeholder="100000" 
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm"
                            >
                        </div>
                        <button 
                            onclick="applyFilters()" 
                            class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold"
                        >
                            Apply Price
                        </button>
                    </div>
                </div>

                <!-- Stock Status Filter -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">
                        <i class="fas fa-box mr-2"></i>Availability
                    </h3>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded">
                            <input 
                                type="radio" 
                                name="stock" 
                                class="stock-filter w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                value="all"
                                checked
                            >
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">All Products</span>
                        </label>
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded">
                            <input 
                                type="radio" 
                                name="stock" 
                                class="stock-filter w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                value="1"
                            >
                            <span class="ml-2 text-sm text-green-600 dark:text-green-400">In Stock Only</span>
                        </label>
                        <label class="flex items-center cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 p-2 rounded">
                            <input 
                                type="radio" 
                                name="stock" 
                                class="stock-filter w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                value="0"
                            >
                            <span class="ml-2 text-sm text-red-600 dark:text-red-400">Out of Stock</span>
                        </label>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="lg:col-span-3">
            
            <!-- Header & Sorting -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                        All Products
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400" id="productCount">
                        Showing <span id="countText">0</span> products
                    </p>
                </div>
                
                <!-- Sort By -->
                <div class="flex items-center space-x-2 mt-4 sm:mt-0">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Sort By:</label>
                    <select 
                        id="sortBy" 
                        class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="latest">Latest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                        <option value="name_asc">Name: A to Z</option>
                        <option value="name_desc">Name: Z to A</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>

            <!-- Active Filters Display -->
            <div id="activeFilters" class="mb-4 flex flex-wrap gap-2"></div>

            <!-- Loading State -->
            <div id="loadingSpinner" class="hidden text-center py-12">
                <i class="fas fa-spinner fa-spin text-4xl text-blue-600 dark:text-blue-400"></i>
                <p class="text-gray-600 dark:text-gray-400 mt-4">Loading products...</p>
            </div>

            <!-- Products Grid -->
            <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Products will be loaded here via AJAX -->
            </div>

            <!-- No Results -->
            <div id="noResults" class="hidden text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Products Found</h3>
                <p class="text-gray-600 dark:text-gray-400">Try adjusting your filters or search terms</p>
            </div>

            <!-- Pagination -->
            <div id="pagination" class="mt-8"></div>
        </main>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentPage = 1;
let searchQuery = '';

// Get URL parameters on page load
$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    searchQuery = urlParams.get('q') || '';
    
    if (searchQuery) {  
        $('#mobileSearch').val(searchQuery);
    }
    
    loadProducts();
    
    // Category filter change
    $('.category-filter').on('change', function() {
        currentPage = 1;
        loadProducts();
    });
    
    // Stock filter change
    $('.stock-filter').on('change', function() {
        currentPage = 1;
        loadProducts();
    });
    
    // Sort change
    $('#sortBy').on('change', function() {
        currentPage = 1;
        loadProducts();
    });
    
    // Mobile search
    $('#mobileSearch').on('keyup', function(e) {
        if (e.key === 'Enter') {
            searchQuery = $(this).val();
            currentPage = 1;
            loadProducts();
        }
    });
});

// Load products with AJAX
function loadProducts() {
    const categories = $('.category-filter:checked').map(function() {
        return $(this).val();
    }).get();
    
    const stockStatus = $('.stock-filter:checked').val();
    const sortBy = $('#sortBy').val();
    const minPrice = $('#minPrice').val();
    const maxPrice = $('#maxPrice').val();
    
    // Show loading
    $('#loadingSpinner').removeClass('hidden');
    $('#productsGrid').addClass('opacity-50');
    $('#noResults').addClass('hidden');
    
    $.ajax({
        url: '{{ route("products.filter") }}',
        type: 'GET',
        data: {
            categories: categories,
            stock: stockStatus,
            sort: sortBy,
            min_price: minPrice,
            max_price: maxPrice,
            search: searchQuery,
            page: currentPage
        },
        success: function(response) {
            // Hide loading
            $('#loadingSpinner').addClass('hidden');
            $('#productsGrid').removeClass('opacity-50');
            
            // Update product count
            $('#countText').text(response.total);
            
            if (response.products.length === 0) {
                $('#productsGrid').html('');
                $('#noResults').removeClass('hidden');
                $('#pagination').html('');
            } else {
                $('#noResults').addClass('hidden');
                renderProducts(response.products);
                renderPagination(response.pagination);
            }
            
            // Update active filters
            updateActiveFilters();
        },
        error: function() {
            $('#loadingSpinner').addClass('hidden');
            $('#productsGrid').removeClass('opacity-50');
            alert('Error loading products');
        }
    });
}

// Render products
function renderProducts(products) {
    let html = '';
    
    products.data.forEach(product => {
        const images = product.images ? product.images.split(',') : [];
        
        const firstImage = images.length > 0 ? images[0] : null;
        
        html += `
            <div class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 dark:border-gray-700 group">
                <div class="relative overflow-hidden aspect-square">
                    <a href="/product/${product.slug}">
                        ${firstImage ? 
                            `<img src="/storage/uploads/product/${firstImage}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">` :
                            `<div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                                <i class="fas fa-box text-white text-6xl"></i>
                            </div>`
                        }
                    </a>
                    ${product.stock_status == 0 ? 
                        `<div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <span class="bg-red-600 text-white px-4 py-2 rounded-full font-bold text-sm">Out of Stock</span>
                        </div>` : 
                        `<div class="absolute top-3 right-3 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-bold">In Stock</div>`
                    }
                    ${product.category ? 
                        `<div class="absolute top-3 left-3">
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">${product.category.name}</span>
                        </div>` : ''
                    }
                </div>
                <div class="p-4">
                    <a href="/product/${product.slug}">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 truncate hover:text-blue-600 dark:hover:text-blue-400">
                            ${product.name}
                        </h3>
                    </a>
                    <div class="grid gap-2">
                        <p class="text-xl font-bold text-blue-600 dark:text-blue-400">
                            ₹${parseFloat(product.price).toFixed(2)}
                        </p>
                        ${product.stock_status == 1 ? 
                            `<a href="/product/${product.slug}"
                        class="w-full inline-flex items-center justify-center py-2.5 
                                bg-gradient-to-r from-blue-600 to-purple-600 text-white 
                                rounded-xl font-semibold text-sm
                                hover:from-blue-700 hover:to-purple-700 
                                transition-all duration-300 hover:scale-[1.02] shadow-md">
                            <i class="fas fa-eye mr-2"></i>
                            View Product
                        </a>` : ''
                        }
                    </div>
                    ${product.sales_count > 0 ? 
                        `<p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                            <i class="fas fa-shopping-bag mr-1"></i>${product.sales_count} sold
                        </p>` : ''
                    }
                </div>
            </div>
        `;
    });
    
    $('#productsGrid').html(html);
}

// Render pagination
function renderPagination(pagination) {
    if (pagination.last_page <= 1) {
        $('#pagination').html('');
        return;
    }
    
    let html = '<div class="flex justify-center space-x-2">';
    
    // Previous
    if (pagination.current_page > 1) {
        html += `<button onclick="changePage(${pagination.current_page - 1})" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
            <i class="fas fa-chevron-left"></i>
        </button>`;
    }
    
    // Pages
    for (let i = 1; i <= pagination.last_page; i++) {
        if (i === pagination.current_page) {
            html += `<button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold">${i}</button>`;
        } else if (i === 1 || i === pagination.last_page || (i >= pagination.current_page - 2 && i <= pagination.current_page + 2)) {
            html += `<button onclick="changePage(${i})" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">${i}</button>`;
        } else if (i === pagination.current_page - 3 || i === pagination.current_page + 3) {
            html += `<span class="px-2 py-2 text-gray-500 dark:text-gray-400">...</span>`;
        }
    }
    
    // Next
    if (pagination.current_page < pagination.last_page) {
        html += `<button onclick="changePage(${pagination.current_page + 1})" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
            <i class="fas fa-chevron-right"></i>
        </button>`;
    }
    
    html += '</div>';
    $('#pagination').html(html);
}

// Change page
function changePage(page) {
    currentPage = page;
    loadProducts();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Apply filters
function applyFilters() {
    currentPage = 1;
    loadProducts();
}

// Clear filters
function clearFilters() {
    $('.category-filter').prop('checked', false);
    $('input[name="stock"][value="all"]').prop('checked', true);
    $('#minPrice').val('');
    $('#maxPrice').val('');
    $('#sortBy').val('latest');
    $('#mobileSearch').val('');
    searchQuery = '';
    currentPage = 1;
    loadProducts();
}

// Update active filters display
function updateActiveFilters() {
    let html = '';
    
    // Search filter
    if (searchQuery) {
        html += `<span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm">
            Search: "${searchQuery}"
            <button onclick="removeSearchFilter()" class="ml-2 hover:text-blue-600">
                <i class="fas fa-times"></i>
            </button>
        </span>`;
    }
    
    // Category filters
    $('.category-filter:checked').each(function() {
        const categoryName = $(this).next('span').text();
        const checkbox = $(this);
        html += `<span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm">
            ${categoryName}
            <button onclick="removeCategory(${$(this).val()})" class="ml-2 hover:text-blue-600">
                <i class="fas fa-times"></i>
            </button>
        </span>`;
    });
    
    // Price filter
    const minPrice = $('#minPrice').val();
    const maxPrice = $('#maxPrice').val();
    if (minPrice || maxPrice) {
        html += `<span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm">
            Price: ₹${minPrice || '0'} - ₹${maxPrice || '∞'}
            <button onclick="$('#minPrice, #maxPrice').val(''); applyFilters();" class="ml-2 hover:text-blue-600">
                <i class="fas fa-times"></i>
            </button>
        </span>`;
    }
    
    // Stock filter
    const stock = $('.stock-filter:checked').val();
    if (stock !== 'all') {
        const stockText = stock == '1' ? 'In Stock' : 'Out of Stock';
        html += `<span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm">
            ${stockText}
            <button onclick="$('input[name=stock][value=all]').prop('checked', true); applyFilters();" class="ml-2 hover:text-blue-600">
                <i class="fas fa-times"></i>
            </button>
        </span>`;
    }
    
    $('#activeFilters').html(html);
}

// Remove search filter
function removeSearchFilter() {
    searchQuery = '';
    $('#mobileSearch').val('');
    currentPage = 1;
    loadProducts();
}

// Remove category filter
function removeCategory(categoryId) {
    $(`.category-filter[value="${categoryId}"]`).prop('checked', false);
    currentPage = 1;
    loadProducts();
}


// Show notification
function showNotification(message, type) {
    const bgColor = type === 'success' ? 'bg-green-100 dark:bg-green-900 border-green-200 dark:border-green-800' : 'bg-red-100 dark:bg-red-900 border-red-200 dark:border-red-800';
    const textColor = type === 'success' ? 'text-green-800 dark:text-green-300' : 'text-red-800 dark:text-red-300';
    
    const notification = $(`
        <div class="fixed top-4 right-4 z-50 ${bgColor} border rounded-xl p-4 shadow-lg animate-fade-in" id="quickNotification">
            <div class="flex items-center">
                <i class="fas fa-check-circle ${textColor} mr-3"></i>
                <p class="text-sm ${textColor}">${message}</p>
            </div>
        </div>
    `);
    
    $('body').append(notification);
    
    setTimeout(function() {
        notification.fadeOut(function() {
            $(this).remove();
        });
    }, 3000);
}
</script>
@endpush