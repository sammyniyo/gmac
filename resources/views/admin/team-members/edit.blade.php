<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Team Member') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.team-members.update', $member) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Name</label>
                                <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('name', $member->name) }}" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Role</label>
                                <input type="text" name="role" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('role', $member->role) }}" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Email</label>
                                <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('email', $member->email) }}">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Phone</label>
                                <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('phone', $member->phone) }}">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-bold mb-2">Bio</label>
                                <textarea name="bio" rows="5" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('bio', $member->bio) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Display Order</label>
                                <input type="number" name="order" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('order', $member->order) }}">
                            </div>
                            <div class="flex items-center pt-8">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                                    <span class="ml-2">Active</span>
                                </label>
                            </div>
                            <div class="md:col-span-2">
                                @if($member->getFirstMediaUrl('photos'))
                                    <img src="{{ $member->getFirstMediaUrl('photos') }}" alt="{{ $member->name }}" class="w-24 h-24 object-cover rounded-full mb-3">
                                @endif
                                <label class="block text-gray-700 font-bold mb-2">Photo</label>
                                <input type="file" name="photo" class="w-full border-gray-300 rounded-md shadow-sm" accept="image/*">
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-4 border-t">
                            <a href="{{ route('admin.team-members.index') }}" class="text-gray-500 hover:underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">Update Team Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
