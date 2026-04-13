<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">GMAC Admin</p>
                <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-950">
                    Operate the site from one clean dashboard
                </h2>
                <p class="mt-2 max-w-2xl text-sm text-slate-500">
                    Manage hero content, products, team members, testimonials, and incoming messages with a calmer, modern workspace.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md transition">New product</a>
                <a href="{{ route('admin.hero-slides.create') }}" class="rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Add slide</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $chartWidth = 760;
                $chartHeight = 260;
                $chartPaddingX = 28;
                $chartPaddingTop = 22;
                $chartPaddingBottom = 34;
                $plotWidth = max(1, $chartWidth - ($chartPaddingX * 2));
                $plotHeight = max(1, $chartHeight - $chartPaddingTop - $chartPaddingBottom);
                $chartCount = max(1, $visitorTrend->count());
                $maxVisitorVisits = max(1, (int) $visitorTrend->max('visits'));
                $linePoints = $visitorTrend->values()->map(function ($point, $index) use ($chartCount, $plotWidth, $chartPaddingX, $chartPaddingTop, $plotHeight, $maxVisitorVisits) {
                    $x = $chartCount === 1
                        ? $chartPaddingX + ($plotWidth / 2)
                        : $chartPaddingX + (($plotWidth / ($chartCount - 1)) * $index);
                    $y = $chartPaddingTop + $plotHeight - (($point['visits'] / $maxVisitorVisits) * $plotHeight);

                    return [
                        'label' => $point['label'],
                        'visits' => $point['visits'],
                        'unique_visitors' => $point['unique_visitors'],
                        'x' => round($x, 2),
                        'y' => round($y, 2),
                    ];
                });
                $linePath = $linePoints->map(fn ($point, $index) => ($index === 0 ? 'M' : 'L').$point['x'].' '.$point['y'])->implode(' ');
                $areaPath = $linePoints->isNotEmpty()
                    ? $linePath.' L '.$linePoints->last()['x'].' '.($chartPaddingTop + $plotHeight).' L '.$linePoints->first()['x'].' '.($chartPaddingTop + $plotHeight).' Z'
                    : '';
            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="max-w-xl">
                            <div class="inline-flex items-center rounded-full border border-teal-200 bg-teal-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-teal-700">
                                Dashboard overview
                            </div>
                            <h3 class="mt-4 text-xl font-semibold tracking-tight text-slate-950">A calmer view of traffic and core actions</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Keep the dashboard focused on visitors, quick actions, and account access instead of repeated admin details.
                            </p>
                        </div>
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">Today</div>
                                <div class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">{{ $visitorStats['today_unique'] }}</div>
                                <div class="mt-1 text-xs text-slate-500">unique visitors</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">7 Days</div>
                                <div class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">{{ $visitorStats['week_visits'] }}</div>
                                <div class="mt-1 text-xs text-slate-500">total page views</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">Accounts</div>
                                <div class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">{{ $stats['users'] }}</div>
                                <div class="mt-1 text-xs text-slate-500">{{ $stats['admins'] }} admins</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.35fr_0.65fr]">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                        <div class="border-b border-slate-200 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Visitor Analytics</p>
                            <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Traffic trend</h3>
                            <p class="mt-2 text-sm text-slate-500">
                                A cleaner seven-day graph of public website traffic.
                            </p>
                        </div>

                        <div class="p-6">
                            @if($visitorTrend->isNotEmpty())
                                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                    <div class="flex flex-wrap items-center justify-between gap-4">
                                        <div class="flex items-center gap-3">
                                            <span class="h-3 w-3 rounded-full bg-teal-500"></span>
                                            <span class="text-sm font-semibold text-slate-900">Page views</span>
                                        </div>
                                        <div class="text-xs text-slate-500">Daily unique visitors are shown below each point.</div>
                                    </div>

                                    <div class="mt-6 overflow-x-auto">
                                        <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" class="h-[300px] w-full min-w-[680px]">
                                            <defs>
                                                <linearGradient id="visitorAreaGradient" x1="0" x2="0" y1="0" y2="1">
                                                    <stop offset="0%" stop-color="#14b8a6" stop-opacity="0.28" />
                                                    <stop offset="100%" stop-color="#14b8a6" stop-opacity="0.03" />
                                                </linearGradient>
                                            </defs>

                                            <line x1="{{ $chartPaddingX }}" y1="{{ $chartHeight - $chartPaddingBottom }}" x2="{{ $chartWidth - $chartPaddingX }}" y2="{{ $chartHeight - $chartPaddingBottom }}" stroke="#cbd5e1" stroke-width="1" />

                                            @for($i = 0; $i < 4; $i++)
                                                @php
                                                    $gridValue = round(($maxVisitorVisits / 3) * $i);
                                                    $gridY = $chartPaddingTop + $plotHeight - (($gridValue / $maxVisitorVisits) * $plotHeight);
                                                @endphp
                                                <line x1="{{ $chartPaddingX }}" y1="{{ $gridY }}" x2="{{ $chartWidth - $chartPaddingX }}" y2="{{ $gridY }}" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="4 6" />
                                                <text x="6" y="{{ $gridY + 4 }}" fill="#94a3b8" font-size="11">{{ (int) $gridValue }}</text>
                                            @endfor

                                            @if($areaPath !== '')
                                                <path d="{{ $areaPath }}" fill="url(#visitorAreaGradient)" />
                                                <path d="{{ $linePath }}" fill="none" stroke="#14b8a6" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                            @endif

                                            @foreach($linePoints as $point)
                                                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="5" fill="#ffffff" stroke="#14b8a6" stroke-width="3" />
                                                <text x="{{ $point['x'] }}" y="{{ $point['y'] - 14 }}" text-anchor="middle" fill="#0f172a" font-size="12" font-weight="600">{{ $point['visits'] }}</text>
                                                <text x="{{ $point['x'] }}" y="{{ $chartHeight - 10 }}" text-anchor="middle" fill="#475569" font-size="12" font-weight="600">{{ $point['label'] }}</text>
                                            @endforeach
                                        </svg>
                                    </div>

                                    <div class="mt-4 grid grid-cols-2 gap-3 md:grid-cols-4 xl:grid-cols-7">
                                        @foreach($visitorTrend as $point)
                                            <div class="rounded-2xl bg-white px-3 py-3 text-center">
                                                <div class="text-xs font-semibold text-slate-700">{{ $point['label'] }}</div>
                                                <div class="mt-1 text-sm font-semibold text-slate-950">{{ $point['unique_visitors'] }}</div>
                                                <div class="text-[11px] text-slate-500">unique</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-500">
                                    No visitor data yet. Start browsing the public site and the graph will fill in automatically.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                            <div class="border-b border-slate-200 px-6 py-5">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Quick Links</p>
                                <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Common actions</h3>
                            </div>
                            <div class="grid gap-4 p-6">
                                @foreach(collect($quickLinks)->take(4) as $link)
                                    <a href="{{ $link['route'] }}" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 transition hover:bg-white">
                                        <div class="text-sm font-semibold text-slate-900">{{ $link['label'] }}</div>
                                        <div class="mt-1 text-sm text-slate-500">{{ $link['description'] }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                            <div class="border-b border-slate-200 px-6 py-5">
                                <h3 class="text-xl font-semibold tracking-tight text-slate-950">Top pages this week</h3>
                                <p class="mt-2 text-sm text-slate-500">Most visited public pages over the last seven days.</p>
                            </div>
                            <div class="space-y-3 p-6">
                                @forelse($topPages as $page)
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                        <div class="text-sm font-semibold text-slate-900">{{ $page->path }}</div>
                                        <div class="mt-1 text-sm text-slate-500">{{ $page->unique_visitors }} unique visitors · {{ $page->visits }} views</div>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-500">
                                        No tracked page data yet.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 xl:grid-cols-[0.72fr_1.28fr]">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                        <div class="border-b border-slate-200 px-6 py-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">User Management</p>
                            <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Access overview</h3>
                        </div>
                        <div class="space-y-4 p-6">
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">Accounts</div>
                                <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">{{ $stats['users'] }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">Admins</div>
                                <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">{{ $stats['admins'] }}</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-slate-400">Verified</div>
                                <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">{{ $stats['verified_users'] }}</div>
                            </div>
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                Open users
                            </a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                        <div class="border-b border-slate-200 px-6 py-5">
                            <h3 class="text-xl font-semibold tracking-tight text-slate-950">Recent users</h3>
                        </div>
                        <div class="grid gap-4 p-6 md:grid-cols-2 xl:grid-cols-3">
                            @forelse($recentUsers as $user)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
                                    <div class="text-sm font-semibold text-slate-900">{{ $user->name }}</div>
                                    <div class="mt-1 truncate text-sm text-slate-500">{{ $user->email }}</div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $user->is_admin ? 'border-teal-200 bg-teal-50 text-teal-700' : 'border-slate-200 bg-white text-slate-600' }}">
                                            {{ $user->is_admin ? 'Admin' : 'User' }}
                                        </span>
                                        <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $user->email_verified_at ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-amber-200 bg-amber-50 text-amber-700' }}">
                                            {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-500 md:col-span-2 xl:col-span-3">
                                    No users found yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
