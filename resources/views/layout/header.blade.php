 <!-- Header -->
<header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-50">

    <!-- Main Header -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{asset('favicon.ico')}}" alt="Cartify Pro" class="h-10 w-13 rounded-lg">
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Cartify Pro
                    </span>
                </a>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <form class="w-full" action="" method="GET">
                        <div class="relative">
                            <input 
                                type="text" 
                                name="q"
                                placeholder="Search for products..." 
                                class="w-full px-4 py-3 pr-12 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4">
                    
                    <!-- Dark Mode Toggle -->
                    <button 
                        onclick="toggleDarkMode()" 
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        title="Toggle Dark Mode"
                    >
                        <i class="fas fa-moon text-gray-600 dark:text-gray-300" id="darkModeIcon"></i>
                    </button>

                    <!-- Cart -->
                    @include('cart.cart-slide')
                    @guest
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors font-semibold">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @else
                        <!-- User Menu Dropdown -->
                        <div class="relative dropdown">
                            <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                @if(auth()->user()->image)
                                    <img src="{{ asset('storage/uploads/user/' . auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full object-cover">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </div>
                                @endif
                                <span class="hidden md:block text-gray-700 dark:text-gray-300 font-medium">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-gray-500 dark:text-gray-400 text-sm"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700">
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="py-2">
                                    <a href="" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-user-circle w-5 mr-3"></i>
                                        My Profile
                                    </a>
                                    <a href="{{route('orders.index')}}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-shopping-bag w-5 mr-3"></i>
                                        My Orders
                                    </a>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 ">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                <ul class="flex items-center space-x-1">
                    <li>
                        <a href="{{ route('home') }}" class="px-4 py-3 transition-colors flex items-center font-medium
                        {{ request()->routeIs('home')
                        ? ' dark:bg-gray-800 text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-800'
                        : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-gray-800' }}">

                            <i class="fas fa-home mr-2"></i>
                            Home
                        </a>
                    </li>
                    <li class="relative dropdown">
                        <button class="px-4 py-3 transition-colors flex items-center font-medium
                        {{ request()->routeIs('category.*')
                        ? ' dark:bg-gray-800 text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-800'
                        : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-gray-800' }}">
                            <i class="fas fa-th-large mr-2"></i>
                            Categories
                            <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </button>
                        <!-- Categories Dropdown -->
                        <div class="dropdown-menu absolute left-0 mt-0 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 " style="z-index: 1000;">
                            @foreach($menucategories ?? [] as $category)
                                <a href="{{ route('category.show',$category->slug)}}" class="flex items-center justify-between px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <span>{{ $category->name }}</span>
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </a>
                            @endforeach
                        </div>
                    </li>
                    <li>
                        <a href="" class="px-4 py-3  transition-colors flex items-center font-medium
                        {{ request()->routeIs('product.*')
                        ? ' dark:bg-gray-800 text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-800'
                        : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-gray-800' }}">
                            <i class="fas fa-box-open mr-2"></i>
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="{{route('contact-us')}}" class="px-4 py-3 transition-colors flex items-center font-medium
                        {{ request()->routeIs('contact-us')
                        ? ' dark:bg-gray-800 text-blue-600 dark:text-blue-400 bg-white dark:bg-gray-800'
                        : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-gray-800' }}">
                            <i class="fas fa-envelope mr-2"></i>
                            Contact Us
                        </a>
                    </li>
                </ul>
                
                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <i class="fas fa-bars text-gray-700 dark:text-gray-300"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="container mx-auto px-4 py-2">
            <!-- Mobile Search -->
            <form class="mb-4" action="" method="GET">
                <input 
                    type="text" 
                    name="q"
                    placeholder="Search products..." 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </form>
            
            <!-- Mobile Navigation Links -->
            <ul class="space-y-1">
                <li>
                    <a href="" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                        <i class="fas fa-home mr-2"></i>Home
                    </a>
                </li>
                @auth
                    <li>
                        <a href="" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <i class="fas fa-user mr-2"></i>My Profile
                        </a>
                    </li>
                    <li>
                        <a href="" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                            <i class="fas fa-shopping-bag mr-2"></i>My Orders
                        </a>
                    </li>
                @endauth
                <li>
                    <a href="" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                        <i class="fas fa-box-open mr-2"></i>Products
                    </a>
                </li>
                <li>
                    <a href="" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                        <i class="fas fa-envelope mr-2"></i>Contact Us
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>