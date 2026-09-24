<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ \App\Models\Setting::where('key', 'company_name')->value('value') ?? config('app.name', 'GMAC Coffee') }}</title>
    @include('partials.favicon')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html { background: #f7f2ea; }
        body { font-family: Poppins, ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#f7f2ea] text-[#2a1c14] antialiased">
@php
    $companyName = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
    $logo = \App\Models\Setting::where('key', 'site_logo')->value('value');
    $panelImage = \App\Models\Setting::where('key', 'home_about_image')->value('value');
    $phone = \App\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+250 783 053 415';
    $email = \App\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@gmac.coffee';
    $about = \App\Models\Setting::where('key', 'about_short_text')->value('value')
        ?: 'GMAC Coffee sources, processes, and exports specialty Rwandan coffee with full traceability from washing station to cup.';
@endphp

<header class="sticky top-0 z-30 border-b border-[#e8ddd0] bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-[62px] w-11/12 max-w-[1320px] items-center justify-between">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 text-[#2a1c14] no-underline">
            @if($logo)
                <img src="{{ $logo }}" alt="{{ $companyName }}" class="h-9 w-auto object-contain">
            @else
                <img src="{{ asset('images/gmac-logo.png') }}" alt="{{ $companyName }}" class="h-9 w-auto object-contain">
            @endif
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ url('/') }}" class="inline-flex h-[34px] w-[34px] items-center justify-center rounded-[11px] border border-[#e8ddd0] bg-white text-[#6b5344] transition hover:border-[#c4a15a] hover:text-[#3d2918]" aria-label="Back to website">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-8 9 8M5 10v10h14V10"/></svg>
            </a>
        </div>
    </div>
</header>

<main class="mx-auto grid w-11/12 max-w-[1320px] grid-cols-1 items-stretch gap-8 py-8 lg:grid-cols-12 lg:gap-10 lg:py-10">
    <aside class="relative hidden overflow-hidden rounded-2xl border border-[#e8ddd0] lg:col-span-7 lg:block xl:col-span-7">
        @if($panelImage)
            <img src="{{ $panelImage }}" alt="" class="absolute inset-0 h-full w-full object-cover">
        @else
            <div class="absolute inset-0 bg-[#3d2918]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(196,161,90,0.28),transparent_42%),radial-gradient(circle_at_80%_80%,rgba(61,41,24,0.5),transparent_50%)]"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-br from-[#2a1c14]/85 via-[#3d2918]/55 to-[#5a3d28]/35"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#2a1c14]/90 via-transparent to-transparent"></div>

        <div class="relative flex min-h-[40rem] flex-col justify-between p-9 text-white xl:p-12">
            <div>
                <p class="text-sm font-medium text-white/70">{{ $companyName }}</p>
                <h2 class="mt-4 max-w-xl text-[1.75rem] font-semibold leading-tight xl:text-[2rem]">Premium Rwandan coffee, from station to export.</h2>
                <p class="mt-4 max-w-xl text-sm leading-7 text-white/80">{{ $about }}</p>
            </div>

            <div>
                <ul class="space-y-2 text-sm text-white/80">
                    <li>Phone: {{ $phone }}</li>
                    <li>{{ $email }}</li>
                    <li>KK 372 St, Kigali, Kicukiro, Rwanda</li>
                </ul>
                <p class="mt-8 text-sm font-medium text-white/70">{{ $companyName }}</p>
            </div>
        </div>
    </aside>

    <section class="flex min-w-0 flex-col justify-center lg:col-span-5">
        <div class="mx-auto w-full max-w-xl">
            {{ $slot }}
        </div>
    </section>
</main>
</body>
</html>
