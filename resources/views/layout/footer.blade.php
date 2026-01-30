 <!-- Footer -->
<footer class="bg-gray-900 dark:bg-black text-gray-300 pt-12 pb-6 mt-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- About -->
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Cartify Pro</h3>
                <p class="text-sm text-gray-400 mb-4">Your one-stop shop for all your needs. Quality products at the best prices.</p>
                <div class="flex space-x-3">
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white text-lg font-bold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    <li><a href="{{route('products.index')}}" class="hover:text-white">Products</a></li>
                    <li><a href="{{route('contact-us')}}" class="hover:text-white">Contact Us</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white text-lg font-bold mb-4">Contact Us</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3"></i>
                        <span>
                            Floor -10994, Challenger Deep<br>
                            Mariana Trench, Pacific Ocean<br>
                            Nearest Landmark: Pressure 1000+ atm
                        </span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-3"></i>
                        <span>9999999999</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3"></i>
                        <span>info@donaldduck.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-800 pt-6">
            <div class="flex flex-col md:flex-row justify-center items-center text-sm">
                <p>&copy; {{ date('Y') }} Cartify Pro. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>