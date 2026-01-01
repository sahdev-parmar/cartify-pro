<div class="fixed inset-0 z-50 overflow-y-auto">
    <!-- Dark Backdrop Overlay -->
    <div class="fixed inset-0  backdrop-blur-xs  transition-opacity" wire:click="closeModal"></div>
    
    <!-- Modal Container -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
        <!-- Modal Content -->
        <div class="relative inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-2xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">
                        {{ $categoryId ? 'Edit Category' : 'Add New Category' }}
                    </h3>
                    <button wire:click="closeModal" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6">
                <form wire:submit.prevent="save" class="space-y-6" enctype="multipart/form-data">
                    <!-- Category Name -->
                    <div class="grid grid-cols-2 gap-4">                            
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name"
                                wire:model.live="name"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                                placeholder="Enter category name"
                            >
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="slug"
                                wire:model.live="slug"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('slug') border-red-500 @enderror"
                                placeholder="category-slug"
                            >
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea 
                            id="description"
                            wire:model="description"
                            rows="4"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                            placeholder="Enter category description"
                        ></textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- image -->
                    <div class="grid grid-cols-3 gap-6">
                        <!-- image-->
                        <div>
                            <label for="image" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Image 
                            </label>
                             <input 
                                type="file" 
                                id="image"
                                wire:model.live="image"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror"
                                >
                        @error('image')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        </div>

                        {{-- image preview --}}
                        <div class="w-48 h-32 border-2 border-dashed border-gray-300
                                    flex items-center justify-center rounded-md bg-gray-50">

                            @if ($image)
                                <img src=" 
                                {{-- exception handling --}}
                            <?php try{ ?> 
                            {{ $image ? $image->temporaryurl()  : asset('storage/uploads/'.$categoryimage) }}
                            <?php }catch(\Exception $e){ ?>
                                {{ '' }}
                            <?php } ?>"
                                    class="w-full h-full object-cover rounded-md">
                            @else
                                <span class="text-gray-400 text-sm">
                                    No image selected
                                </span>
                            @endif
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Status
                            </label>
                            <select 
                                id="status"
                                wire:model="status"
                                class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                <option selected>---Select status---</option>
                                <option value=1>Active</option>
                                <option value=0>Inactive</option>
                            </select>
                            @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button 
                            type="button"
                            wire:click="closeModal"
                            class="px-6 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-colors shadow-lg"
                        >
                            {{ $categoryId ? 'Update Category' : 'Create Category' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>