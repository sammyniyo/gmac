<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Name</label>
                                <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Email</label>
                                <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">New Password</label>
                                <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm">
                                <p class="mt-1 text-sm text-gray-500">Leave blank to keep the current password.</p>
                                @error('password') <div class="mt-1 text-sm text-red-500">{{ $message }}</div> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="flex items-center pt-8">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_admin" value="1" class="rounded border-gray-300" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                                    <span class="ml-2">Grant admin access</span>
                                </label>
                            </div>
                            <div class="flex items-center pt-8">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="email_verified" value="1" class="rounded border-gray-300" {{ old('email_verified', (bool) $user->email_verified_at) ? 'checked' : '' }}>
                                    <span class="ml-2">Email verified</span>
                                </label>
                            </div>
                        </div>

                        @error('is_admin') <div class="mt-4 text-sm text-red-500">{{ $message }}</div> @enderror

                        <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                            Created {{ $user->created_at?->format('M d, Y') }}.
                            @if($user->email_verified_at)
                                Verified {{ $user->email_verified_at->format('M d, Y') }}.
                            @else
                                Email is not verified yet.
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-4 border-t">
                            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
