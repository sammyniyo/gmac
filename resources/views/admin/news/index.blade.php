<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('News & Events') }}
            </h2>
            <a href="{{ route('admin.news.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Add New Post</a>
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
                                <th class="p-3">Cover</th>
                                <th class="p-3">Title</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Published At</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
                                        @if($post->hasMedia('news'))
                                            <img src="{{ $post->getFirstMediaUrl('cover') }}" alt="{{ $post->title }}" class="w-16 h-12 object-cover rounded">
                                        @else
                                            <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <div class="font-semibold">{{ $post->title }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($post->excerpt, 50) }}</div>
                                    </td>
                                    <td class="p-3">
                                        @if($post->is_published)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Published</span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Draft</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-sm text-gray-600">
                                        {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="p-3 text-right flex justify-end items-center space-x-3 h-full pt-6">
                                        <a href="{{ route('admin.news.edit', $post) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('admin.news.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline cursor-pointer">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500">No news posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
