<div>
   <!-- Edit Product Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <!-- Dark Backdrop -->
        <div class="fixed inset-0 backdrop-blur-lg bg-black/80 transition-opacity" wire:click="closeEditModal"></div>
        
        <!-- Modal Container -->
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">
            <!-- Modal Content -->
            <div class="relative inline-block bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-4xl">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-blue-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Edit Product</h3>
                        <button wire:click="closeEditModal" class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                    <form wire:submit.prevent="updateProduct" enctype="multipart/form-data">
                        <div class="space-y-6">
                            <!-- Row 1: Category and Name -->
                            <div class="grid grid-cols-8 gap-6">
                                <!-- Category -->
                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        wire:model="category_id"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_category_id') border-red-500 @enderror"
                                    >
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>


                                <!-- Product Name -->
                                <div class="col-span-3">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Product Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model.live="name"
                                        placeholder="Enter product name"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_name') border-red-500 @enderror"
                                    >
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="col-span-3"> 
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Slug <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model="slug"
                                        placeholder="product-slug"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_slug') border-red-500 @enderror"
                                    >
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Auto-generated from product name</p>
                                    @error('slug')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                             <!-- Row 2: Pricing -->
                            <div class="grid grid-cols-3 gap-6">
                             
                                <!-- Price -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Regular Price <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3.5 text-gray-500 dark:text-gray-400">$</span>
                                        <input 
                                            type="number" 
                                            step="0.01"
                                            wire:model="price"
                                            placeholder="0.00"
                                            class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_price') border-red-500 @enderror"
                                        >
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                     <!-- Stock Status -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Stock Status <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        wire:model="stock_status"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_stock_status') border-red-500 @enderror"
                                    >
                                        <option>---Select stock status---</option>
                                        <option value=1>In Stock</option>
                                        <option value=0>Out of Stock</option>
                                    </select>
                                    @error('stock_status')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
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
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 @error('edit_sales_count') border-red-500 @enderror"
                                    >
                                    @error('sales_count')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            <!-- Images Section -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Product Images</label>
                                
                                <!-- Existing Images -->
                                @if(!empty($images) || !empty($previwImages))
                                    <div class="mb-4">
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">Current Images</p>
                                        <div class="grid grid-cols-6 gap-3">
                                            @foreach($images as $index => $image)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/uploads/product/' . $image) }}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-700">

                                                    {{-- remove images --}}
                                                    <button 
                                                        type="button"
                                                        wire:click="removeImage({{ $index }})"
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white p-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-lg"
                                                    >
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>

                                                    {{-- Make Primary Button --}}
                                                    @if($index !== $primaryImageIndex)
                                                        <button
                                                            type="button"
                                                            wire:click="makePrimary({{ $index }})"
                                                            class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium opacity-0 group-hover:opacity-100 transition-opacity shadow-lg hover:bg-blue-600"
                                                        >
                                                            Primary
                                                        </button>
                                                    @endif
                                                    @if($index === $primaryImageIndex && !$previwPrimarychange)
                                                        <span class="absolute bottom-1 left-1 bg-blue-600 text-white text-xs px-2 py-0.5 rounded">Primary</span>
                                                    @endif
                                                </div>
                                            @endforeach

                                            {{-- previwimage --}}
                                            @foreach($previwImages as $index => $image)
                                                <div class="relative group">
                                                    <img src="{{ $image->temporaryUrl() }}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-700">
                                                    <button 
                                                        type="button"
                                                        wire:click="removePreviewImage({{ $index }})"
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white p-1.5 rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-lg"
                                                    >
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                    @if($index !== $primaryPreviewIndex)
                                                        <button
                                                            type="button"
                                                            wire:click="makePreviewPrimary({{ $index }})"
                                                            class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-2 py-1 rounded text-xs font-medium opacity-0 group-hover:opacity-100 transition-opacity shadow-lg hover:bg-blue-600"
                                                        >
                                                            Primary
                                                        </button>
                                                    @endif
                                                    @if($previwPrimarychange && $index === $primaryPreviewIndex)
                                                        <span class="absolute bottom-1 left-1 bg-blue-600 text-white text-xs px-2 py-0.5 rounded">Primary</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Upload New Images -->
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:border-green-500 transition-colors">
                                    <input 
                                        type="file" 
                                        wire:model.live="previwImages"
                                        multiple
                                        accept="image/*"
                                        class="hidden"
                                        id="editImageUpload"
                                    >
                                    <label for="editImageUpload" class="cursor-pointer">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="text-green-600 dark:text-green-400 font-semibold">Click to upload</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF</p>
                                    </label>
                                </div>

                                @error('images.*')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                           
                            <!-- Row 3: Stock -->
                            <div>
                                {{-- Description --}}
                                <div>
                                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        id="description"
                                        wire:model="description"
                                        rows="4"
                                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                        placeholder="Enter product description"
                                    ></textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                    <button 
                        type="button"
                        wire:click="closeEditModal"
                        class="px-6 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button"
                        wire:click="updateProduct"
                        wire:loading.attr="disabled"
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-blue-600 rounded-lg hover:from-green-700 hover:to-blue-700 transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center"
                    >
                        <svg wire:loading wire:target="updateProduct" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="updateProduct">Update Product</span>
                        <span wire:loading wire:target="updateProduct">Updating...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
