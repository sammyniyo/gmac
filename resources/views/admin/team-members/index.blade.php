<x-app-layout>
    <x-slot name="header">
        <div class="shadcn-page-head">
            <div>
                <p class="shadcn-kicker">GMAC Admin</p>
                <h2 class="shadcn-title">Team</h2>
                <p class="shadcn-desc">People shown on the public team page. Members without a photo display initials until you upload one.</p>
            </div>
            <a href="{{ route('admin.team-members.create') }}" class="shadcn-btn">Add member</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse($members as $member)
                    @php
                        $photo = $member->portraitUrl();
                    @endphp
                    <article class="shadcn-card overflow-hidden">
                        <div class="flex items-start gap-4 p-5">
                            @if($photo)
                                <img src="{{ $photo }}" alt="{{ $member->name }}" class="h-16 w-16 shrink-0 rounded-full object-cover object-top ring-1 ring-black/5">
                            @else
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full text-lg font-medium text-white" style="background: linear-gradient(160deg, #8d7560, #3d2e24); font-family: Georgia, serif;">
                                    {{ $member->avatarInitials() }}
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="truncate text-base font-semibold text-foreground">{{ $member->name }}</h3>
                                        <p class="mt-0.5 text-sm text-muted-foreground">{{ $member->role }}</p>
                                    </div>
                                    @if($member->is_active)
                                        <span class="shadcn-badge shadcn-badge--completed">Active</span>
                                    @else
                                        <span class="shadcn-badge shadcn-badge--cancelled">Hidden</span>
                                    @endif
                                </div>

                                <p class="mt-2 text-xs text-muted-foreground">
                                    Order {{ $member->order }}
                                    @if($member->email) · {{ $member->email }} @endif
                                </p>
                                @unless($photo)
                                    <p class="mt-1 text-xs text-amber-800">Initials avatar — add a photo later</p>
                                @endunless
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 border-t border-border px-5 py-3">
                            <a href="{{ route('admin.team-members.edit', $member) }}" class="shadcn-link">Edit</a>
                            <form action="{{ route('admin.team-members.destroy', $member) }}" method="POST" onsubmit="return confirm('Delete {{ $member->name }} from the team?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="shadcn-card col-span-full px-6 py-12 text-center text-muted-foreground">
                        No team members yet.
                        <a href="{{ route('admin.team-members.create') }}" class="shadcn-link ml-1">Add the first person</a>
                    </div>
                @endforelse
            </div>

            @if($members->hasPages())
                <div class="mt-6">{{ $members->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
