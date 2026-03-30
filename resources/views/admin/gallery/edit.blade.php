<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Gallery Image:') }} {{ $gallery->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div>
                                <div class="mb-4">
                                    <label for="title" class="block text-gray-700 font-bold mb-2">Image Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('title', $gallery->title) }}" required>
                                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                                    <select name="category" id="category" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- General --</option>
                                        <option value="Farm" {{ old('category', $gallery->category) == 'Farm' ? 'selected' : '' }}>Farm</option>
                                        <option value="Processing" {{ old('category', $gallery->category) == 'Processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="Community" {{ old('category', $gallery->category) == 'Community' ? 'selected' : '' }}>Community</option>
                                        <option value="Products" {{ old('category', $gallery->category) == 'Products' ? 'selected' : '' }}>Products</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Used for filtering on the frontend gallery page.</p>
                                    @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="order" class="block text-gray-700 font-bold mb-2">Display Order</label>
                                    <input type="number" name="order" id="order" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('order', $gallery->order) }}">
                                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first.</p>
                                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Visibility</label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
                                        <span class="ml-2 font-semibold">Active</span>
                                    </label>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-md border">
                                    <label for="image" class="block text-gray-700 font-bold mb-2 border-b pb-2">Update Image</label>
                                    
                                    @if($gallery->hasMedia('gallery'))
                                        <div class="mb-3">
                                            <img src="{{ $gallery->getFirstMediaUrl('gallery') }}" alt="{{ $gallery->title }}" class="w-full h-auto max-h-48 object-cover rounded shadow-sm border">
                                        </div>
                                    @endif

                                    <input type="file" name="image" id="image" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" accept="image/*">
                                    <p class="text-sm text-gray-500 mt-2 pt-2">Upload a new file to replace the current image. JPG, PNG, WEBP. Max size 4MB.</p>
                                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-4 border-t">
                            <a href="{{ route('admin.gallery.index') }}" class="text-gray-500 hover:underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Update Image</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
