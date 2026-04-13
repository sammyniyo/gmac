<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ratings & feedback') }}
        </h2>
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
                    <p class="text-sm text-gray-600 mb-4">Approve submissions to show them on the public <strong>Reviews</strong> page.</p>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3">Status</th>
                                <th class="p-3">Rating</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Comment</th>
                                <th class="p-3">Date</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feedbacks as $fb)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
                                        @if($fb->is_approved)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                                        @endif
                                    </td>
                                    <td class="p-3 font-semibold">{{ $fb->rating }}/5</td>
                                    <td class="p-3 font-medium">{{ $fb->name }}</td>
                                    <td class="p-3 text-sm text-gray-600">
                                        @if($fb->email)
                                            <a href="mailto:{{ $fb->email }}" class="hover:underline">{{ $fb->email }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="p-3 text-sm text-gray-800 max-w-md">{{ Str::limit($fb->body, 120) }}</td>
                                    <td class="p-3 text-sm text-gray-500 whitespace-nowrap">{{ $fb->created_at->format('M d, Y H:i') }}</td>
                                    <td class="p-3 text-right whitespace-nowrap">
                                        @if($fb->is_approved)
                                            <form action="{{ route('admin.feedbacks.unapprove', $fb) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-amber-600 hover:text-amber-900 font-medium mr-2 cursor-pointer">Hide</button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.feedbacks.approve', $fb) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 font-medium mr-2 cursor-pointer">Approve</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.feedbacks.destroy', $fb) }}" method="POST" class="inline" onsubmit="return confirm('Delete this feedback?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium cursor-pointer">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-gray-500 py-10">No feedback yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
