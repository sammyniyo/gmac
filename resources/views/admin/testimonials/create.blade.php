<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Testimonial') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.testimonials.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Name</label>
                                <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name') }}" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Role</label>
                                <input type="text" name="role" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('role') }}">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Company</label>
                                <input type="text" name="company" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('company') }}">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Quote</label>
                                <textarea name="quote" rows="5" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('quote') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Rating</label>
                                <input type="number" min="1" max="5" name="rating" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('rating', 5) }}">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Display Order</label>
                                <input type="number" name="order" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('order', 0) }}">
                            </div>
                            <div class="md:col-span-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <span class="ml-2">Active</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-4 border-t">
                            <a href="{{ route('admin.testimonials.index') }}" class="text-gray-500 hover:underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Save Testimonial</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
