@php
    $member = $member ?? null;
    $photo = $member?->portraitUrl();
    $initials = $member ? $member->avatarInitials() : 'GM';
@endphp

@if($errors->any())
    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <p class="font-medium">Please fix the highlighted fields.</p>
        <ul class="mt-1 list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div class="md:col-span-2">
        <div class="flex items-center gap-4 rounded-xl border border-border bg-muted/40 p-4">
            <div class="relative">
                <img id="team-photo-preview" src="{{ $photo }}" alt="" class="h-20 w-20 rounded-full object-cover object-top ring-1 ring-black/5 {{ $photo ? '' : 'hidden' }}">
                <div id="team-photo-initials" class="flex h-20 w-20 items-center justify-center rounded-full text-xl font-medium text-white {{ $photo ? 'hidden' : '' }}" style="background: linear-gradient(160deg, #8d7560, #3d2e24); font-family: Georgia, serif;">
                    {{ $initials }}
                </div>
            </div>
            <div class="min-w-0 flex-1">
                <label class="mb-1.5 block text-sm font-medium text-foreground">Photo</label>
                <input id="team-photo-input" type="file" name="photo" accept="image/*" class="block w-full text-sm text-muted-foreground file:mr-3 file:rounded-md file:border-0 file:bg-white file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-foreground file:ring-1 file:ring-border">
                <p class="mt-1.5 text-xs text-muted-foreground">Optional. Square headshots work best. People without a photo show initials on the public page.</p>
            </div>
        </div>
        @error('photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-foreground">Name</label>
        <input type="text" name="name" value="{{ old('name', $member->name ?? '') }}" required class="shadcn-select w-full">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-1.5 block text-sm font-medium text-foreground">Role</label>
        <input type="text" name="role" value="{{ old('role', $member->role ?? '') }}" required placeholder="Managing Director" class="shadcn-select w-full">
        @error('role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-1.5 block text-sm font-medium text-foreground">Email</label>
        <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}" class="shadcn-select w-full">
        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-1.5 block text-sm font-medium text-foreground">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $member->phone ?? '') }}" class="shadcn-select w-full">
        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-foreground">Bio</label>
        <textarea name="bio" rows="4" class="shadcn-select w-full">{{ old('bio', $member->bio ?? '') }}</textarea>
        @error('bio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-1.5 block text-sm font-medium text-foreground">Display order</label>
        <input type="number" name="order" min="0" value="{{ old('order', $member->order ?? $nextOrder ?? 0) }}" class="shadcn-select w-full">
        <p class="mt-1 text-xs text-muted-foreground">Lower numbers appear first. Managing Director should be 1.</p>
    </div>
    <div class="flex items-center pt-7">
        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" {{ old('is_active', $member->is_active ?? true) ? 'checked' : '' }}>
            <span>Show on the public team page</span>
        </label>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var input = document.getElementById('team-photo-input');
    var preview = document.getElementById('team-photo-preview');
    var initials = document.getElementById('team-photo-initials');
    if (!input || !preview) return;
    input.addEventListener('change', function () {
        var file = input.files && input.files[0];
        if (!file) return;
        var url = URL.createObjectURL(file);
        preview.src = url;
        preview.classList.remove('hidden');
        if (initials) initials.classList.add('hidden');
    });
})();
</script>
@endpush
