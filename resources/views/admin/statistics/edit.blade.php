<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
            {{ __('Edit Statistic Counter:') }} <span class="ml-2 text-indigo-600">{{ $statistic->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <form action="{{ route('admin.statistics.update', $statistic) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 font-bold mb-2">Title / Label *</label>
                            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title', $statistic->title) }}" required>
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="number" class="block text-gray-700 font-bold mb-2">Number / Value *</label>
                            <input type="text" name="number" id="number" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('number', $statistic->number) }}" required>
                            <p class="text-sm text-gray-500 mt-1">Include symbols like + or % if needed.</p>
                            @error('number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="block text-gray-700 font-bold mb-2">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" id="icon" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('icon', $statistic->icon) }}">
                            <p class="text-sm text-gray-500 mt-1">Optional. Example: <code>fa-solid fa-users</code>.</p>
                            @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="order" class="block text-gray-700 font-bold mb-2">Display Order</label>
                            <input type="number" name="order" id="order" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('order', $statistic->order) }}">
                            <p class="text-sm text-gray-500 mt-1">Lower numbers appear first.</p>
                            @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-between mt-8 pt-4 border-t">
                            <a href="{{ route('admin.statistics.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700 font-bold transition">Update Counter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
