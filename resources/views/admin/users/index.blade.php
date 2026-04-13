<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">User Management</p>
                <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-950">Manage admin and staff accounts</h2>
            </div>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md transition">Add User</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if($errors->has('delete'))
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">{{ $errors->first('delete') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="p-3">User</th>
                                <th class="p-3">Role</th>
                                <th class="p-3">Verification</th>
                                <th class="p-3">Created</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">
                                        <div class="font-semibold">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="p-3">
                                        @if($user->is_admin)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Admin</span>
                                        @else
                                            <span class="px-2 py-1 bg-slate-100 text-slate-700 text-xs rounded-full">User</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        @if($user->email_verified_at)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Verified</span>
                                        @else
                                            <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full">Pending</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-sm text-gray-500">{{ $user->created_at?->format('M d, Y') }}</td>
                                    <td class="p-3 text-right">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500 hover:underline mr-3">Edit</a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
