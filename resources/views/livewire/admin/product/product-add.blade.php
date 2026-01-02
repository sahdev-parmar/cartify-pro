<div>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <a href="/admin/products" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Add New Product</h1>
            </div>
            <p class="text-gray-600 dark:text-gray-400">Fill in the details to add a new product to your inventory</p>
        </div>

        <!-- Wizard Progress -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <!-- Step 1 -->
                <div class="flex items-center flex-1">
                    <button 
                        wire:click="goToStep(1)"
                        class="flex items-center justify-center w-12 h-12 rounded-full transition-all {{ $currentStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400' }}"
                    >
                        @if($currentStep > 1)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <span class="text-lg font-bold">1</span>
                        @endif
                    </button>
                    <div class="flex-1 ml-4">
                        <p class="text-sm font-semibold {{ $currentStep >= 1 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400' }}">Step 1</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Basic Info</p>
                    </div>
                </div>

                <!-- Connector -->
                <div class="flex-1 h-1 mx-4 {{ $currentStep > 1 ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700' }}"></div>

                <!-- Step 2 -->
                <div class="flex items-center flex-1">
                    <button 
                        wire:click="goToStep(2)"
                        class="flex items-center justify-center w-12 h-12 rounded-full transition-all {{ $currentStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400' }}"
                    >
                        @if($currentStep > 2)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <span class="text-lg font-bold">2</span>
                        @endif
                    </button>
                    <div class="flex-1 ml-4">
                        <p class="text-sm font-semibold {{ $currentStep >= 2 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400' }}">Step 2</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Images & Price</p>
                    </div>
                </div>

                <!-- Connector -->
                <div class="flex-1 h-1 mx-4 {{ $currentStep > 2 ? 'bg-blue-600' : 'bg-gray-200 dark:bg-gray-700' }}"></div>

                <!-- Step 3 -->
                <div class="flex items-center flex-1">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full transition-all {{ $currentStep >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-400' }}">
                        <span class="text-lg font-bold">3</span>
                    </div>
                    <div class="flex-1 ml-4">
                        <p class="text-sm font-semibold {{ $currentStep >= 3 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400' }}">Step 3</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Stock & Finish</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wizard Content -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form wire:submit.prevent="save">
                <!-- Step 1: Basic Information -->
                @if($currentStep === 1)
                    <div class="p-8 space-y-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Basic Information</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Let's start with the basic details of your product</p>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select 
                                wire:model="category_id"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror"
                            >
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model.live="name"
                                placeholder="Enter product name"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model="slug"
                                placeholder="product-slug"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('slug') border-red-500 @enderror"
                            >
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Auto-generated from product name</p>
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 2: Images & Pricing -->
                @if($currentStep === 2)
                    <div class="p-8 space-y-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Images & Pricing</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Upload product images and set pricing</p>
                        </div>

                        <!-- Product Images -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Product Images <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-blue-500 transition-colors">
                                <input 
                                    type="file" 
                                    wire:model="images"
                                    multiple
                                    accept="image/*"
                                    class="hidden"
                                    id="imageUpload"
                                >
                                <label for="imageUpload" class="cursor-pointer">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="text-blue-600 dark:text-blue-400 font-semibold">Click to uploads</span> or drag and drop
                                    </p>
                                </label>
                            </div>
                            @error('images')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror

                            <!-- Image Preview -->
                            @if(!empty($images))
                                <div class="grid grid-cols-4 gap-4 mt-4">
                                    @foreach($images as $index => $image)
                                        <div class="relative group">
                                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-700">
                                            <button 
                                                type="button"
                                                wire:click="removeImage({{ $index }})"
                                                class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            @if($index === 0)
                                                <span class="absolute bottom-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-full">Primary</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div wire:loading wire:target="images" class="mt-4">
                                <div class="flex items-center justify-center space-x-2 text-blue-600 dark:text-blue-400">
                                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm">Uploading images...</span>
                                </div>
                            </div>
                        </div>

                      

                            <!-- Sale Price -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Sale Price (Optional)
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3.5 text-gray-500 dark:text-gray-400">$</span>
                                    <input 
                                        type="number" 
                                        step="0.01"
                                        wire:model="sale_price"
                                        placeholder="0.00"
                                        class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sale_price') border-red-500 @enderror"
                                    >
                                </div>
                                @error('sale_price')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                    </div>
                @endif

                <!-- Step 3: Stock & Final -->
                @if($currentStep === 3)
                    <div class="p-8 space-y-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Stock & Final Details</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Set inventory and finalize your product</p>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <!-- Stock Status -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Stock Status <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    wire:model="stock_status"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stock_status') border-red-500 @enderror"
                                >
                                    <option value="in_stock">In Stock</option>
                                    <option value="low_stock">Low Stock</option>
                                    <option value="out_of_stock">Out of Stock</option>
                                </select>
                                @error('stock_status')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sales Count -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Sales Count <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    wire:model="sales_count"
                                    placeholder="0"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sales_count') border-red-500 @enderror"
                                >
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Number of times this product has been sold</p>
                                @error('sales_count')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
                            <h4 class="text-sm font-bold text-blue-900 dark:text-blue-300 mb-4">Product Summary</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Category:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        {{ $categories->firstWhere('id', $category_id)?->name ?? 'Not selected' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Product Name:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $name ?: 'Not entered' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Images:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ count($images) }} uploaded</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Price:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">
                                        ${{ $price ?: '0.00' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                    <button 
                        type="button"
                        wire:click="previousStep"
                        class="px-6 py-3 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors {{ $currentStep === 1 ? 'invisible' : '' }}"
                    >
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span>Previous</span>
                        </div>
                    </button>

                    @if($currentStep < $totalSteps)
                        <button 
                            type="button"
                            wire:click="nextStep"
                            class="px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-lg"
                        >
                            <div class="flex items-center space-x-2">
                                <span>Next Step</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </button>
                    @else
                        <button 
                            type="submit"
                            class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-blue-600 rounded-lg hover:from-green-700 hover:to-blue-700 transition-colors shadow-lg"
                        >
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Create Product</span>
                            </div>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
