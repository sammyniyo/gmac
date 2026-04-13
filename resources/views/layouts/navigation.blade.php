@php
    $companyName = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
    $isAdmin = auth()->user()->is_admin;
    $dashUrl = $isAdmin ? route('admin.dashboard') : route('dashboard');
@endphp

<nav x-data="{ open: false }" class="admin-shell-header">
    <div class="admin-sidebar__mobilebar lg:hidden">
        <div class="admin-sidebar__mobilebar-inner">
            <a href="{{ $dashUrl }}" class="flex min-w-0 items-center gap-3">
                <div class="admin-brand-badge admin-brand-badge--host">GM</div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-900">{{ $companyName }}</p>
                    <p class="truncate text-xs text-slate-500">Admin</p>
                </div>
            </a>
            <button type="button" @click="open = ! open" class="admin-icon-btn" aria-label="Toggle menu">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Single full sidebar (desktop) — all sections + search + account --}}
    <div class="admin-nav-cluster hidden lg:flex">
        <aside class="admin-sidenav admin-sidenav--single" aria-label="Admin menu">
            <div class="admin-sidenav__head">
                <a href="{{ $dashUrl }}" class="admin-sidenav__brand">
                    <span class="admin-brand-badge admin-brand-badge--host admin-brand-badge--rail">G</span>
                    <span class="admin-sidenav__brand-text">
                        <span class="admin-sidenav__site-label">Admin</span>
                        <span class="admin-sidenav__site-name">{{ $companyName }}</span>
                    </span>
                </a>
            </div>

            <div class="admin-sidenav__search-block">
                <label class="admin-sr-only" for="admin-search-sidebar">Search admin menu</label>
                <div class="admin-sidenav__search">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input type="search" id="admin-search-sidebar" class="admin-sidenav__search-input" placeholder="Filter menu…" autocomplete="off" data-admin-menu-filter>
                    <span class="admin-sidenav__search-kbd" aria-hidden="true"><kbd>⌘</kbd><kbd>K</kbd></span>
                </div>
            </div>

            <div class="admin-sidenav__scroll" id="admin-sidenav-scroll">
                @if(!$isAdmin)
                    <div class="admin-sidenav__group" data-nav-group>
                        <p class="admin-sidenav__group-label">Account</p>
                        <div class="admin-sidenav__group-body">
                            <a href="{{ $dashUrl }}" class="admin-sidenav__link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}" data-nav-item>
                                <span class="admin-sidenav__dot" aria-hidden="true"></span>
                                Dashboard
                            </a>
                        </div>
                    </div>
                @else
                    <div class="admin-sidenav__group" data-nav-group>
                        <p class="admin-sidenav__group-label">Overview</p>
                        <div class="admin-sidenav__group-body">
                            <a href="{{ route('admin.dashboard') }}" class="admin-sidenav__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" data-nav-item>
                                <span class="admin-sidenav__dot" aria-hidden="true"></span>
                                Dashboard
                            </a>
                        </div>
                    </div>

                    <div class="admin-sidenav__group" data-nav-group>
                        <p class="admin-sidenav__group-label">Website</p>
                        <div class="admin-sidenav__group-body">
                            <a href="{{ route('admin.hero-slides.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.hero-slides.*') ? 'is-active' : '' }}" data-nav-item>Hero slides</a>
                            <a href="{{ route('admin.news.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.news.*') ? 'is-active' : '' }}" data-nav-item>News</a>
                            <a href="{{ route('admin.gallery.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.gallery.*') ? 'is-active' : '' }}" data-nav-item>Gallery</a>
                            <a href="{{ route('admin.team-members.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.team-members.*') ? 'is-active' : '' }}" data-nav-item>Team</a>
                            <a href="{{ route('admin.testimonials.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.testimonials.*') ? 'is-active' : '' }}" data-nav-item>Testimonials</a>
                            <a href="{{ route('admin.washing-stations.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.washing-stations.*') ? 'is-active' : '' }}" data-nav-item>Washing stations</a>
                        </div>
                    </div>

                    <div class="admin-sidenav__group" data-nav-group>
                        <p class="admin-sidenav__group-label">Inbox</p>
                        <div class="admin-sidenav__group-body">
                            <a href="{{ route('admin.contacts.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.contacts.*') ? 'is-active' : '' }}" data-nav-item>Messages</a>
                            <a href="{{ route('admin.feedbacks.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.feedbacks.*') ? 'is-active' : '' }}" data-nav-item>Ratings & feedback</a>
                            <a href="{{ route('admin.subscribers.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.subscribers.*') ? 'is-active' : '' }}" data-nav-item>Newsletter</a>
                        </div>
                    </div>

                    <div class="admin-sidenav__group" data-nav-group>
                        <p class="admin-sidenav__group-label">Shop</p>
                        <div class="admin-sidenav__group-body">
                            <a href="{{ route('admin.products.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}" data-nav-item>Products</a>
                            <a href="{{ route('admin.orders.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}" data-nav-item>Orders</a>
                            <a href="{{ route('admin.product-categories.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.product-categories.*') ? 'is-active' : '' }}" data-nav-item>Categories</a>
                        </div>
                    </div>

                    <div class="admin-sidenav__group" data-nav-group>
                        <p class="admin-sidenav__group-label">System</p>
                        <div class="admin-sidenav__group-body">
                            <a href="{{ route('admin.settings.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.settings.*') ? 'is-active' : '' }}" data-nav-item>Site settings</a>
                            <a href="{{ route('admin.users.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}" data-nav-item>Users</a>
                            <a href="{{ route('admin.statistics.index') }}" class="admin-sidenav__link {{ request()->routeIs('admin.statistics.*') ? 'is-active' : '' }}" data-nav-item>Homepage stats</a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="admin-sidenav__footer">
                <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" class="admin-sidenav__footer-link">
                    <svg class="admin-sidenav__footer-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    View live site
                </a>
                <a href="{{ route('profile.edit') }}" class="admin-sidenav__footer-link {{ request()->routeIs('profile.edit') ? 'is-active' : '' }}">
                    <svg class="admin-sidenav__footer-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="admin-sidenav__footer-form">
                    @csrf
                    <button type="submit" class="admin-sidenav__footer-btn">
                        <svg class="admin-sidenav__footer-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M18 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                        Log out
                    </button>
                </form>
                <p class="admin-sidenav__footer-user">{{ Auth::user()->email }}</p>
            </div>
        </aside>
    </div>

    {{-- Mobile drawer --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm" @click="open = false" aria-hidden="true"></div>
        <div class="fixed inset-y-0 left-0 z-50 flex w-[min(100vw-2rem,300px)] flex-col border-r border-slate-200 bg-white shadow-2xl">
            <div class="flex items-center justify-between gap-3 border-b border-slate-200 px-4 py-4">
                <div class="flex min-w-0 items-center gap-3">
                    <div class="admin-brand-badge admin-brand-badge--host">GM</div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $companyName }}</p>
                        <p class="truncate text-xs text-slate-500">Menu</p>
                    </div>
                </div>
                <button type="button" @click="open = false" class="admin-icon-btn" aria-label="Close menu">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="border-b border-slate-200 px-4 py-3">
                <label class="admin-sr-only" for="admin-search-mobile">Filter menu</label>
                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                    <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="search" id="admin-search-mobile" class="min-w-0 flex-1 border-0 bg-transparent text-sm outline-none" placeholder="Filter…" autocomplete="off" data-admin-menu-filter-mobile>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto bg-slate-100 px-3 py-4" id="admin-mobile-nav-scroll">
                <div class="mobile-nav-groups">
                    <div class="admin-mobile-nav-section" data-mnav-group>
                        <p class="admin-mobile-nav-section__label">{{ $isAdmin ? 'Overview' : 'Account' }}</p>
                        <div class="admin-mobile-nav-section__links">
                            <x-responsive-nav-link :href="$dashUrl" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')" data-mnav-item>
                                Dashboard
                            </x-responsive-nav-link>
                        </div>
                    </div>
                    @if($isAdmin)
                        <div class="admin-mobile-nav-section" data-mnav-group>
                            <p class="admin-mobile-nav-section__label">Website</p>
                            <div class="admin-mobile-nav-section__links">
                                <x-responsive-nav-link :href="route('admin.hero-slides.index')" :active="request()->routeIs('admin.hero-slides.*')" data-mnav-item>Hero slides</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.news.index')" :active="request()->routeIs('admin.news.*')" data-mnav-item>News</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.gallery.index')" :active="request()->routeIs('admin.gallery.*')" data-mnav-item>Gallery</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.team-members.index')" :active="request()->routeIs('admin.team-members.*')" data-mnav-item>Team</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.testimonials.index')" :active="request()->routeIs('admin.testimonials.*')" data-mnav-item>Testimonials</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.washing-stations.index')" :active="request()->routeIs('admin.washing-stations.*')" data-mnav-item>Washing stations</x-responsive-nav-link>
                            </div>
                        </div>
                        <div class="admin-mobile-nav-section" data-mnav-group>
                            <p class="admin-mobile-nav-section__label">Inbox</p>
                            <div class="admin-mobile-nav-section__links">
                                <x-responsive-nav-link :href="route('admin.contacts.index')" :active="request()->routeIs('admin.contacts.*')" data-mnav-item>Messages</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.feedbacks.index')" :active="request()->routeIs('admin.feedbacks.*')" data-mnav-item>Ratings & feedback</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.subscribers.index')" :active="request()->routeIs('admin.subscribers.*')" data-mnav-item>Newsletter</x-responsive-nav-link>
                            </div>
                        </div>
                        <div class="admin-mobile-nav-section" data-mnav-group>
                            <p class="admin-mobile-nav-section__label">Shop</p>
                            <div class="admin-mobile-nav-section__links">
                                <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" data-mnav-item>Products</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" data-mnav-item>Orders</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.product-categories.index')" :active="request()->routeIs('admin.product-categories.*')" data-mnav-item>Categories</x-responsive-nav-link>
                            </div>
                        </div>
                        <div class="admin-mobile-nav-section" data-mnav-group>
                            <p class="admin-mobile-nav-section__label">System</p>
                            <div class="admin-mobile-nav-section__links">
                                <x-responsive-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')" data-mnav-item>Site settings</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" data-mnav-item>Users</x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('admin.statistics.index')" :active="request()->routeIs('admin.statistics.*')" data-mnav-item>Homepage stats</x-responsive-nav-link>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="border-t border-slate-200 p-4 space-y-2">
                <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    View live site
                </a>
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-slate-600 hover:bg-slate-50">Log out</button>
                </form>
            </div>
        </div>
    </div>
</nav>

@push('scripts')
<script>
(function () {
    function filterDesktopSidebar() {
        var input = document.getElementById('admin-search-sidebar');
        var scroll = document.getElementById('admin-sidenav-scroll');
        if (!input || !scroll) return;
        input.addEventListener('input', function () {
            var q = (input.value || '').toLowerCase().trim();
            scroll.querySelectorAll('[data-nav-group]').forEach(function (group) {
                var links = group.querySelectorAll('a.admin-sidenav__link');
                var any = false;
                links.forEach(function (a) {
                    var show = !q || (a.textContent || '').toLowerCase().indexOf(q) !== -1;
                    a.style.display = show ? '' : 'none';
                    if (show) any = true;
                });
                group.style.display = !q || any ? '' : 'none';
            });
            if (!q) {
                scroll.querySelectorAll('a.admin-sidenav__link').forEach(function (a) { a.style.display = ''; });
                scroll.querySelectorAll('[data-nav-group]').forEach(function (g) { g.style.display = ''; });
            }
        });
    }

    function filterMobileDrawer() {
        var input = document.getElementById('admin-search-mobile');
        var scroll = document.getElementById('admin-mobile-nav-scroll');
        if (!input || !scroll) return;
        input.addEventListener('input', function () {
            var q = (input.value || '').toLowerCase().trim();
            scroll.querySelectorAll('[data-mnav-group]').forEach(function (section) {
                var links = section.querySelectorAll('a');
                var vis = 0;
                links.forEach(function (a) {
                    var show = !q || (a.textContent || '').toLowerCase().indexOf(q) !== -1;
                    a.style.display = show ? '' : 'none';
                    if (show) vis++;
                });
                section.style.display = !q || vis ? '' : 'none';
            });
            if (!q) {
                scroll.querySelectorAll('a').forEach(function (a) { a.style.display = ''; });
                scroll.querySelectorAll('[data-mnav-group]').forEach(function (s) { s.style.display = ''; });
            }
        });
    }

    document.addEventListener('keydown', function (e) {
        if ((e.metaKey || e.ctrlKey) && (e.key === 'k' || e.key === 'K')) {
            e.preventDefault();
            var desktop = document.getElementById('admin-search-sidebar');
            var mobile = document.getElementById('admin-search-mobile');
            var wide = window.matchMedia('(min-width: 1024px)').matches;
            var el = wide ? desktop : mobile;
            if (el) {
                el.focus();
                el.select();
            }
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            filterDesktopSidebar();
            filterMobileDrawer();
        });
    } else {
        filterDesktopSidebar();
        filterMobileDrawer();
    }
})();
</script>
@endpush
