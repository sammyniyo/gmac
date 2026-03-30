<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Messages') }}
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
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="p-3">Status</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                                <th class="p-3">Subject</th>
                                <th class="p-3">Received At</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $msg)
                                <tr class="border-b hover:bg-gray-50 {{ !$msg->is_read ? 'bg-indigo-50/30' : '' }}">
                                    <td class="p-3">
                                        @if(!$msg->is_read)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                New
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Read
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3 font-semibold {{ !$msg->is_read ? 'text-gray-900' : 'text-gray-600' }}">{{ $msg->name }}</td>
                                    <td class="p-3 text-sm text-gray-600">
                                        <a href="mailto:{{ $msg->email }}" class="hover:underline">{{ $msg->email }}</a>
                                    </td>
                                    <td class="p-3 text-sm text-gray-800">{{ Str::limit($msg->subject ?: 'No Subject', 40) }}</td>
                                    <td class="p-3 text-sm text-gray-500">{{ $msg->created_at->format('M d, Y h:i A') }}</td>
                                    <td class="p-3 text-right">
                                        <a href="{{ route('admin.contacts.show', $msg) }}" class="text-blue-600 hover:text-blue-900 font-medium mr-3">View</a>
                                        <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium cursor-pointer">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-500 py-10">
                                        No messages found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
