<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post:') }} {{ $news->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Left Column: Main Content -->
                            <div class="md:col-span-2">
                                <div class="mb-4">
                                    <label for="title" class="block text-gray-700 font-bold mb-2">Post Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('title', $news->title) }}" required>
                                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="excerpt" class="block text-gray-700 font-bold mb-2">Excerpt</label>
                                    <textarea name="excerpt" id="excerpt" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Brief summary of the post..." >{{ old('excerpt', $news->excerpt) }}</textarea>
                                    @error('excerpt') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="content" class="block text-gray-700 font-bold mb-2">Full Content <span class="text-red-500">*</span></label>
                                    <textarea name="content" id="content" rows="12" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="HTML content is supported...">{{ old('content', $news->content) }}</textarea>
                                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Right Column: Settings and Image -->
                            <div>
                                <div class="bg-gray-50 p-4 rounded-md border mb-4">
                                    <h3 class="font-bold text-gray-700 mb-3 border-b pb-2">Publishing</h3>
                                    
                                    <div class="mb-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                                            <span class="ml-2 font-semibold">Published</span>
                                        </label>
                                    </div>

                                    <div class="mb-2">
                                        <label for="published_at" class="block text-gray-700 font-bold mb-2 text-sm">Publish Date</label>
                                        <input type="date" name="published_at" id="published_at" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('published_at', $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('Y-m-d') : '') }}">
                                        @error('published_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-md border">
                                    <h3 class="font-bold text-gray-700 mb-3 border-b pb-2">Cover Image</h3>
                                    
                                    @if($news->hasMedia('news'))
                                        <div class="mb-3">
                                            <img src="{{ $news->getFirstMediaUrl('news') }}" alt="{{ $news->title }}" class="w-full h-auto object-cover rounded shadow-sm border">
                                            <p class="text-xs text-gray-500 mt-1">Current Image</p>
                                        </div>
                                    @endif

                                    <div class="mb-2">
                                        <input type="file" name="image" id="image" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" accept="image/*">
                                        <p class="text-xs text-gray-500 mt-1">Upload to replace. Max 2MB.</p>
                                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-4 border-t">
                            <a href="{{ route('admin.news.index') }}" class="text-gray-500 hover:underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Update Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
