<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Models\Setting::where('key', 'company_name')->value('value') ?? config('app.name', 'GMAC Coffee') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-stone-900 antialiased">
        @php
            $companyName = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
        @endphp

        <div class="min-h-screen grid lg:grid-cols-[1.1fr_0.9fr]">
            <div class="relative hidden lg:flex overflow-hidden bg-gradient-to-br from-emerald-950 via-slate-900 to-emerald-900">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(245,158,11,0.14),transparent_35%),radial-gradient(circle_at_bottom_right,rgba(20,83,45,0.26),transparent_32%)]"></div>
                <div class="relative z-10 flex h-full w-full flex-col justify-between p-12 text-stone-100">
                    <div></div>

                    <div class="max-w-xl">
                        <p class="mb-4 text-sm font-bold uppercase tracking-[0.35em] text-amber-200">Admin Access</p>
                        <h1 class="font-[Cormorant_Garamond] text-6xl leading-none text-stone-50">Welcome to GMAC Admin</h1>
                        <p class="mt-6 max-w-lg text-base leading-8 text-stone-300">Sign in to manage your products, stories, team details, testimonials, and the main content shown across the website.</p>
                        <p class="mt-3 max-w-lg text-sm leading-7 text-stone-400">A simple place to keep the GMAC Coffee website updated.</p>
                    </div>

                    <div class="grid max-w-xl grid-cols-3 gap-4 text-sm text-stone-300">
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-2xl font-bold text-emerald-200">01</div>
                            <div class="mt-1">Products</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-2xl font-bold text-emerald-200">02</div>
                            <div class="mt-1">Story & team</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                            <div class="text-2xl font-bold text-emerald-200">03</div>
                            <div class="mt-1">Site content</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex min-h-screen items-center justify-center bg-gradient-to-b from-stone-100 to-emerald-50 px-6 py-10">
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center lg:hidden">
                        <div class="text-xs font-bold uppercase tracking-[0.32em] text-emerald-800">{{ $companyName }}</div>
                    </div>

                    <div class="overflow-hidden rounded-[2rem] border border-stone-200 bg-white/95 p-8 shadow-[0_30px_80px_rgba(28,25,23,0.12)] backdrop-blur">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
