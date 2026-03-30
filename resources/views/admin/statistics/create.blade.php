<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Statistic Counter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.statistics.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 font-bold mb-2">Title / Label *</label>
                            <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title') }}" required placeholder="e.g. Hectares of Coffee">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="number" class="block text-gray-700 font-bold mb-2">Number / Value *</label>
                            <input type="text" name="number" id="number" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('number') }}" required placeholder="e.g. 1500+">
                            <p class="text-sm text-gray-500 mt-1">Include symbols like + or % if needed.</p>
                            @error('number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="icon" class="block text-gray-700 font-bold mb-2">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" id="icon" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('icon') }}" placeholder="e.g. fas fa-tree">
                            <p class="text-sm text-gray-500 mt-1">Optional. Example: <code>fa-solid fa-users</code>.</p>
                            @error('icon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="order" class="block text-gray-700 font-bold mb-2">Display Order</label>
                            <input type="number" name="order" id="order" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('order', 0) }}">
                            <p class="text-sm text-gray-500 mt-1">Lower numbers appear first.</p>
                            @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('admin.statistics.index') }}" class="text-gray-600 hover:underline">Cancel</a>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 font-bold transition">Create Counter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
