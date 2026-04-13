<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-medium text-zinc-500">Admin / Dashboard</p>
                <h2 class="mt-0.5 text-xl font-semibold tracking-tight text-zinc-900">Dashboard</h2>
                <p class="mt-1 max-w-xl text-sm text-zinc-500">Traffic, shop activity, and shortcuts to what you edit most often.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/') }}" target="_blank" rel="noopener noreferrer" class="shadcn-btn-secondary !text-sm">View live site</a>
                <a href="{{ route('admin.products.create') }}" class="shadcn-btn !text-sm">New product</a>
            </div>
        </div>
    </x-slot>

    @php
        $chartWidth = 760;
        $chartHeight = 240;
        $chartPaddingX = 28;
        $chartPaddingTop = 20;
        $chartPaddingBottom = 32;
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

    <div class="space-y-8">
        {{-- KPI row — aligned with sidebar areas --}}
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-500">Today</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums text-zinc-900">{{ $visitorStats['today_unique'] }}</p>
                <p class="text-xs text-zinc-500">Unique visitors</p>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-500">7 days</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums text-zinc-900">{{ $visitorStats['week_visits'] }}</p>
                <p class="text-xs text-zinc-500">Page views</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm transition hover:border-violet-300 hover:shadow-md">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-500">Orders</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums text-zinc-900">{{ $stats['orders_pending'] }}</p>
                <p class="text-xs text-violet-600">Pending · {{ $stats['orders_open'] }} open total</p>
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm transition hover:border-violet-300 hover:shadow-md">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-500">Inbox</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums text-zinc-900">{{ $stats['messages'] }}</p>
                <p class="text-xs text-violet-600">Contact messages</p>
                @if(($stats['feedbacks_pending'] ?? 0) > 0)
                    <p class="mt-2 text-xs font-medium text-amber-800">{{ $stats['feedbacks_pending'] }} review(s) awaiting approval (Ratings & feedback)</p>
                @endif
            </a>
            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-500">Catalog</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums text-zinc-900">{{ $stats['products'] }}</p>
                <p class="text-xs text-zinc-500">Products</p>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-zinc-500">Team</p>
                <p class="mt-1 text-2xl font-semibold tabular-nums text-zinc-900">{{ $stats['admins'] }}</p>
                <p class="text-xs text-zinc-500">Admins · {{ $stats['users'] }} users</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-5">
            <div class="xl:col-span-3 rounded-xl border border-zinc-200 bg-white shadow-sm">
                <div class="border-b border-zinc-200 px-5 py-4">
                    <h3 class="text-base font-semibold text-zinc-900">Traffic</h3>
                    <p class="mt-0.5 text-sm text-zinc-500">Last 7 days · page views</p>
                </div>
                <div class="p-5">
                    @if($visitorTrend->isNotEmpty())
                        <div class="overflow-x-auto rounded-lg border border-zinc-100 bg-zinc-50/80 p-4">
                            <svg viewBox="0 0 {{ $chartWidth }} {{ $chartHeight }}" class="h-[220px] w-full min-w-[560px]">
                                <defs>
                                    <linearGradient id="dashArea" x1="0" x2="0" y1="0" y2="1">
                                        <stop offset="0%" stop-color="#7c3aed" stop-opacity="0.2" />
                                        <stop offset="100%" stop-color="#7c3aed" stop-opacity="0.02" />
                                    </linearGradient>
                                    <linearGradient id="dashLine" x1="0" y1="0" x2="1" y2="0">
                                        <stop offset="0%" stop-color="#673de6" />
                                        <stop offset="100%" stop-color="#a78bfa" />
                                    </linearGradient>
                                </defs>
                                <line x1="{{ $chartPaddingX }}" y1="{{ $chartHeight - $chartPaddingBottom }}" x2="{{ $chartWidth - $chartPaddingX }}" y2="{{ $chartHeight - $chartPaddingBottom }}" stroke="#e4e4e7" stroke-width="1" />
                                @for($i = 0; $i < 4; $i++)
                                    @php
                                        $gridValue = round(($maxVisitorVisits / 3) * $i);
                                        $gridY = $chartPaddingTop + $plotHeight - (($gridValue / $maxVisitorVisits) * $plotHeight);
                                    @endphp
                                    <line x1="{{ $chartPaddingX }}" y1="{{ $gridY }}" x2="{{ $chartWidth - $chartPaddingX }}" y2="{{ $gridY }}" stroke="#f4f4f5" stroke-width="1" stroke-dasharray="4 6" />
                                    <text x="6" y="{{ $gridY + 4 }}" fill="#a1a1aa" font-size="10">{{ (int) $gridValue }}</text>
                                @endfor
                                @if($areaPath !== '')
                                    <path d="{{ $areaPath }}" fill="url(#dashArea)" />
                                    <path d="{{ $linePath }}" fill="none" stroke="url(#dashLine)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                @endif
                                @foreach($linePoints as $point)
                                    <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="4" fill="#fff" stroke="#673de6" stroke-width="2" />
                                    <text x="{{ $point['x'] }}" y="{{ $point['y'] - 12 }}" text-anchor="middle" fill="#18181b" font-size="11" font-weight="600">{{ $point['visits'] }}</text>
                                    <text x="{{ $point['x'] }}" y="{{ $chartHeight - 8 }}" text-anchor="middle" fill="#71717a" font-size="11">{{ $point['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-2 sm:grid-cols-4 lg:grid-cols-7">
                            @foreach($visitorTrend as $point)
                                <div class="rounded-lg border border-zinc-100 bg-zinc-50 px-2 py-2 text-center">
                                    <div class="text-[11px] font-medium text-zinc-600">{{ $point['label'] }}</div>
                                    <div class="text-sm font-semibold text-zinc-900">{{ $point['unique_visitors'] }}</div>
                                    <div class="text-[10px] text-zinc-500">unique</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="rounded-lg border border-dashed border-zinc-200 bg-zinc-50 px-4 py-8 text-center text-sm text-zinc-500">No visitor data yet. Browse the public site and numbers will appear here.</p>
                    @endif
                </div>
            </div>

            <div class="xl:col-span-2 space-y-6">
                <div class="rounded-xl border border-zinc-200 bg-white shadow-sm">
                    <div class="border-b border-zinc-200 px-5 py-4">
                        <h3 class="text-base font-semibold text-zinc-900">Shortcuts</h3>
                        <p class="mt-0.5 text-sm text-zinc-500">Matches your sidebar</p>
                    </div>
                    <ul class="divide-y divide-zinc-100 p-2">
                        @foreach($quickLinks as $link)
                            <li>
                                <a href="{{ $link['route'] }}" class="flex items-center justify-between gap-3 rounded-lg px-3 py-3 text-left transition hover:bg-zinc-50">
                                    <span>
                                        <span class="block text-sm font-medium text-zinc-900">{{ $link['label'] }}</span>
                                        <span class="block text-xs text-zinc-500">{{ $link['description'] }}</span>
                                    </span>
                                    <svg class="h-4 w-4 shrink-0 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white shadow-sm">
                    <div class="border-b border-zinc-200 px-5 py-4">
                        <h3 class="text-base font-semibold text-zinc-900">Top pages</h3>
                        <p class="mt-0.5 text-sm text-zinc-500">This week</p>
                    </div>
                    <ul class="max-h-64 divide-y divide-zinc-100 overflow-y-auto p-2">
                        @forelse($topPages as $page)
                            <li class="px-3 py-2.5">
                                <p class="truncate text-sm font-medium text-zinc-900">{{ $page->path }}</p>
                                <p class="text-xs text-zinc-500">{{ $page->unique_visitors }} unique · {{ $page->visits }} views</p>
                            </li>
                        @empty
                            <li class="px-3 py-6 text-center text-sm text-zinc-500">No page data yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
