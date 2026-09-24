<x-app-layout>
    <x-slot name="header">
        <div class="shadcn-page-head">
            <div>
                <p class="shadcn-kicker">Team</p>
                <h2 class="shadcn-title">Add member</h2>
                <p class="shadcn-desc">Photo is optional. Initials will show on the site until you add one.</p>
            </div>
            <a href="{{ route('admin.team-members.index') }}" class="shadcn-btn-secondary">Back to list</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="shadcn-card p-6">
                <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.team-members._form', ['nextOrder' => $nextOrder ?? 1])
                    <div class="mt-6 flex items-center justify-end gap-3 border-t border-border pt-5">
                        <a href="{{ route('admin.team-members.index') }}" class="shadcn-btn-secondary">Cancel</a>
                        <button type="submit" class="shadcn-btn">Save member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
