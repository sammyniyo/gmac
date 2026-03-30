<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gallery Items') }}
            </h2>
            <a href="{{ route('admin.gallery.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Add New Image</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="p-3 w-32">Image</th>
                                <th class="p-3">Title</th>
                                <th class="p-3">Category</th>
                                <th class="p-3">Order</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($galleryItems as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
                                        @if($item->hasMedia('gallery'))
                                            <img src="{{ $item->getFirstMediaUrl('gallery') }}" alt="{{ $item->title }}" class="w-20 h-20 object-cover rounded shadow-sm">
                                        @else
                                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                                        @endif
                                    </td>
                                    <td class="p-3 font-semibold">{{ $item->title }}</td>
                                    <td class="p-3 text-sm text-gray-600">{{ $item->category ?: 'General' }}</td>
                                    <td class="p-3 text-sm text-gray-600">{{ $item->order }}</td>
                                    <td class="p-3 text-right flex justify-end items-center space-x-3 h-full pt-8">
                                        <a href="{{ route('admin.gallery.edit', $item) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this gallery item?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline cursor-pointer">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500">No gallery items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $galleryItems->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
