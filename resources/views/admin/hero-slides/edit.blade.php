<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Hero Slide') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.hero-slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Title</label>
                                <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title', $slide->title) }}" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Subtitle</label>
                                <input type="text" name="subtitle" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('subtitle', $slide->subtitle) }}">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Button Text</label>
                                <input type="text" name="button_text" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('button_text', $slide->button_text) }}">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Button Link</label>
                                <input type="text" name="button_link" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('button_link', $slide->button_link) }}">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Display Order</label>
                                <input type="number" name="order" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('order', $slide->order) }}">
                            </div>

                            <div class="flex items-center pt-8">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" {{ old('is_active', $slide->is_active) ? 'checked' : '' }}>
                                    <span class="ml-2">Active</span>
                                </label>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Current Image</label>
                                @if($slide->getFirstMediaUrl('slides'))
                                    <img src="{{ $slide->getFirstMediaUrl('slides') }}" alt="{{ $slide->title }}" class="w-56 h-32 object-cover rounded mb-3">
                                @endif
                                <input type="file" name="image" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-4 border-t">
                            <a href="{{ route('admin.hero-slides.index') }}" class="text-gray-500 hover:underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Update Slide</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
