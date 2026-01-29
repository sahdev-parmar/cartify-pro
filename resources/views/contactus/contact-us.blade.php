@extends('layout.app')

@section('title', 'Contact Us')

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
            <span class="text-gray-700 dark:text-gray-300">Contact Us</span>
        </nav>
    </div>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            <i class="fas fa-envelope mr-3"></i>Get in Touch
        </h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto">
            Have questions? We'd love to hear from you. Send us a message on mail and we'll respond as soon as possible.
        </p>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        
        <!-- Contact Info Cards -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 text-center hover:shadow-lg transition-shadow">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Visit Us</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Floor -10994, Challenger Deep<br>
                Mariana Trench, Pacific Ocean<br>
                Nearest Landmark: Pressure 1000+ atm
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 text-center hover:shadow-lg transition-shadow">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                <i class="fas fa-phone text-green-600 dark:text-green-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Call Us</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                <a href="tel:+1234567890" class="hover:text-blue-600 dark:hover:text-blue-400">
                    +999999999
                </a>
            </p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Mon-Fri: 9AM - 12PM
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700 text-center hover:shadow-lg transition-shadow">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full mb-4">
                <i class="fas fa-envelope text-purple-600 dark:text-purple-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Email Us</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                <a href="mailto:support@example.com" class="hover:text-blue-600 dark:hover:text-blue-400">
                    support@donaldduck.com
                </a>
            </p>
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                <a href="mailto:info@example.com" class="hover:text-blue-600 dark:hover:text-blue-400">
                    info@donaldduck.com
                </a>
            </p>
        </div>
    </div>

    <div >
        
        <!-- Map & Business Hours -->
        <div class="space-y-6">
            
            <!-- Map -->
            <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-bold text-gray-900 dark:text-white">
                        <i class="fas fa-map-marked-alt mr-2 text-blue-600 dark:text-blue-400"></i>
                        Our Location
                    </h3>
                </div>
                   <div class="rounded-xl overflow-hidden border border-gray-300 dark:border-gray-700 shadow-md">
                    <iframe
                        width="100%"
                        height="100%"
                        class="min-h-[400px]"
                        loading="lazy"
                        allowfullscreen
                        src="https://maps.google.com/maps?q=11.35,142.20&z=6&t=k&output=embed">
                    </iframe>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Business Hours -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-clock mr-2 text-blue-600 dark:text-blue-400"></i>
                        Business Hours
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">Monday - Friday</span>
                            <span class="text-gray-600 dark:text-gray-400">9:00 AM - 12:00 PM</span>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">Saturday</span>
                            <span class="text-gray-600 dark:text-gray-400">10:00 AM - 10:15 AM</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">Sunday</span>
                            <span class="text-red-600 dark:text-red-400 font-semibold">Closed</span>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-share-alt mr-2 text-blue-600 dark:text-blue-400"></i>
                        Follow Us
                    </h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f text-blue-600 dark:text-blue-400"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center hover:bg-blue-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-blue-600 dark:text-blue-400"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center hover:bg-pink-600 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-pink-600 dark:text-pink-400"></i>
                        </a>
                        <a href="#" class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center hover:bg-blue-700 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in text-blue-600 dark:text-blue-400"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="bg-gray-50 dark:bg-gray-900 py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-8">
            <i class="fas fa-question-circle mr-2"></i>
            Frequently Asked Questions
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-shipping-fast text-blue-600 dark:text-blue-400 mr-2"></i>
                    What is your shipping policy?
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    We offer free shipping on all orders. Delivery usually takes 3-5 business days.
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-undo text-blue-600 dark:text-blue-400 mr-2"></i>
                    What is your return policy?
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    We accept returns within 30 days of purchase. Items must be unused and in original packaging. After is your money is gone.
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-credit-card text-blue-600 dark:text-blue-400 mr-2"></i>
                    What payment methods do you accept?
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    We accept Cash on Delivery, UPI, and Bank Transfer payments.
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-headset text-blue-600 dark:text-blue-400 mr-2"></i>
                    How can I track my order?
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    You can view all your orders in the "My Orders" section after logging in.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection


