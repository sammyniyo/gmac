<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Testimonials') }}</h2>
            <a href="{{ route('admin.testimonials.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Add Testimonial</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="p-3">Name</th>
                                <th class="p-3">Company</th>
                                <th class="p-3">Rating</th>
                                <th class="p-3">Order</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
                                        <div class="font-semibold">{{ $testimonial->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $testimonial->role }}</div>
                                    </td>
                                    <td class="p-3">{{ $testimonial->company }}</td>
                                    <td class="p-3">{{ $testimonial->rating }}/5</td>
                                    <td class="p-3">{{ $testimonial->order }}</td>
                                    <td class="p-3">
                                        @if($testimonial->is_active)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Active</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Hidden</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-500 hover:underline mr-3">Edit</a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline" onsubmit="return confirm('Delete this testimonial?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">No testimonials found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $testimonials->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
