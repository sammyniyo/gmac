@php
    $companyName = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
@endphp

<nav x-data="{ open: false }" class="admin-shell-header">
    <div class="admin-sidebar__mobilebar lg:hidden">
        <div class="admin-sidebar__mobilebar-inner">
            <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-sm font-semibold text-white shadow-sm">
                    GM
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-950">{{ $companyName }}</p>
                    <p class="truncate text-xs text-slate-500">Admin workspace</p>
                </div>
            </a>

            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 p-2 text-slate-600 transition hover:bg-white focus:outline-none">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <aside class="admin-sidebar">
        <div class="admin-sidebar__panel">
            <div class="border-b border-slate-200 px-5 py-5">
                <a href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-950 text-sm font-semibold text-white shadow-sm">
                        GM
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-950">{{ $companyName }}</p>
                        <p class="truncate text-xs text-slate-500">Admin control center</p>
                    </div>
                </a>
                <div class="mt-4 inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-500">
                    {{ auth()->user()->is_admin ? 'Administrator' : 'User' }}
                </div>
            </div>

            <div class="flex-1 space-y-6 overflow-y-auto px-4 py-5">
                <div>
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-400">Workspace</p>
                    <div class="mt-3 space-y-1.5">
                        <x-nav-link :href="auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                            {{ auth()->user()->is_admin ? 'Dashboard Overview' : 'Dashboard' }}
                        </x-nav-link>
                    </div>
                </div>

                @if(auth()->user()->is_admin)
                    <div>
                        <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-400">Content</p>
                        <div class="mt-3 space-y-1.5">
                            <x-nav-link :href="route('admin.hero-slides.index')" :active="request()->routeIs('admin.hero-slides.*')">
                                Hero Slides
                            </x-nav-link>
                            <x-nav-link :href="route('admin.team-members.index')" :active="request()->routeIs('admin.team-members.*')">
                                Team
                            </x-nav-link>
                            <x-nav-link :href="route('admin.testimonials.index')" :active="request()->routeIs('admin.testimonials.*')">
                                Testimonials
                            </x-nav-link>
                            <x-nav-link :href="route('admin.product-categories.index')" :active="request()->routeIs('admin.product-categories.*')">
                                Categories
                            </x-nav-link>
                            <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                                Products
                            </x-nav-link>
                            <x-nav-link :href="route('admin.news.index')" :active="request()->routeIs('admin.news.*')">
                                News
                            </x-nav-link>
                            <x-nav-link :href="route('admin.gallery.index')" :active="request()->routeIs('admin.gallery.*')">
                                Gallery
                            </x-nav-link>
                            <x-nav-link :href="route('admin.washing-stations.index')" :active="request()->routeIs('admin.washing-stations.*')">
                                Stations
                            </x-nav-link>
                        </div>
                    </div>

                    <div>
                        <p class="px-3 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-400">Inbox & Settings</p>
                        <div class="mt-3 space-y-1.5">
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                Users
                            </x-nav-link>
                            <x-nav-link :href="route('admin.contacts.index')" :active="request()->routeIs('admin.contacts.*')">
                                Messages
                            </x-nav-link>
                            <x-nav-link :href="route('admin.subscribers.index')" :active="request()->routeIs('admin.subscribers.*')">
                                Subscribers
                            </x-nav-link>
                            <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                                Settings
                            </x-nav-link>
                            <x-nav-link :href="route('admin.statistics.index')" :active="request()->routeIs('admin.statistics.*')">
                                Statistics
                            </x-nav-link>
                        </div>
                    </div>
                @endif
            </div>

            <div class="border-t border-slate-200 p-4">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-xs font-semibold text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="truncate text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                            <div class="truncate text-xs text-slate-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1.5">
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            Profile
                        </x-nav-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full rounded-xl border border-transparent px-3 py-2 text-left text-sm font-medium text-slate-600 transition duration-150 ease-in-out hover:border-slate-200 hover:bg-white hover:text-slate-900">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="fixed inset-0 z-40 bg-slate-950/30" @click="open = false"></div>
        <div class="fixed inset-y-0 left-0 z-50 w-[88vw] max-w-[320px] overflow-y-auto border-r border-slate-200 bg-white p-4 shadow-2xl">
            <div class="flex items-center justify-between gap-3 border-b border-slate-200 pb-4">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-sm font-semibold text-white shadow-sm">
                        GM
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-950">{{ $companyName }}</p>
                        <p class="truncate text-xs text-slate-500">Admin menu</p>
                    </div>
                </div>
                <button @click="open = false" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 p-2 text-slate-600 transition hover:bg-white focus:outline-none">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-5 space-y-5">
                <div>
                    <p class="px-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-400">Workspace</p>
                    <div class="mt-2 space-y-2">
                        <x-responsive-nav-link :href="auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                            {{ auth()->user()->is_admin ? 'Dashboard Overview' : 'Dashboard' }}
                        </x-responsive-nav-link>
                    </div>
                </div>

                @if(auth()->user()->is_admin)
                    <div>
                        <p class="px-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-400">Content</p>
                        <div class="mt-2 space-y-2">
                            <x-responsive-nav-link :href="route('admin.hero-slides.index')" :active="request()->routeIs('admin.hero-slides.*')">
                                Hero Slides
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.team-members.index')" :active="request()->routeIs('admin.team-members.*')">
                                Team
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.testimonials.index')" :active="request()->routeIs('admin.testimonials.*')">
                                Testimonials
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.product-categories.index')" :active="request()->routeIs('admin.product-categories.*')">
                                Categories
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                                Products
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.news.index')" :active="request()->routeIs('admin.news.*')">
                                News
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.gallery.index')" :active="request()->routeIs('admin.gallery.*')">
                                Gallery
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.washing-stations.index')" :active="request()->routeIs('admin.washing-stations.*')">
                                Stations
                            </x-responsive-nav-link>
                        </div>
                    </div>

                    <div>
                        <p class="px-1 text-[11px] font-semibold uppercase tracking-[0.24em] text-slate-400">Inbox & Settings</p>
                        <div class="mt-2 space-y-2">
                            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                Users
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.contacts.index')" :active="request()->routeIs('admin.contacts.*')">
                                Messages
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.subscribers.index')" :active="request()->routeIs('admin.subscribers.*')">
                                Subscribers
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                                Settings
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('admin.statistics.index')" :active="request()->routeIs('admin.statistics.*')">
                                Statistics
                            </x-responsive-nav-link>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                <div class="mt-3 space-y-2">
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        Profile
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full rounded-xl border border-transparent px-4 py-3 text-left text-base font-medium text-slate-600 transition duration-150 ease-in-out hover:border-slate-200 hover:bg-white hover:text-slate-900">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
