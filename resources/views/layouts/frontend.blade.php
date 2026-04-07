<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee')</title>
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::where('key', 'site_description')->value('value') ?? 'Premium Rwandan Coffee')">

    <!-- Google Fonts – loaded once here for the whole site -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])

    <!-- Layout styles (navbar + footer) -->
    <style>
    /* ─── Site-wide tokens ────────────────────────────────────────── */
    :root {
        --l-forest:    #1a0e08;
        --l-forest-dk: #0d0907;
        --l-ink:       #1a0e08;
        --l-parchment: #f6f0e6;
        --l-cream:     #fdfaf5;
        --l-gold:      var(--clr-gold, #c9963f);
        --l-gold-dk:   #8a6420;
        --l-gold-lt:   #e8c97a;
        --l-display:   'Cormorant Garamond', Georgia, serif;
        --l-body:      'DM Sans', sans-serif;
        --l-ease:      cubic-bezier(0.16, 1, 0.3, 1);
        --l-nav-h:     60px;
        --l-top-h:     36px;
    }
    [data-theme="dark"] {
        --l-parchment: #1a0e08;
        --l-cream:     #0d0907;
        --l-ink:       #f6f0e6;
    }

    *, *::before, *::after { box-sizing: border-box; }

    body {
        margin: 0;
        font-family: var(--l-body);
        background: var(--l-cream, var(--clr-bg));
        color: var(--l-ink, var(--clr-text));
        -webkit-font-smoothing: antialiased;
    }

    .container { max-width: 1280px; margin: 0 auto; padding: 0 40px; }
    @media (max-width: 768px) { .container { padding: 0 20px; } }

    /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
       NAVBAR
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
    .navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: var(--l-body);
    }

    /* ── Top info bar ── */
    .navbar__top {
        background: var(--l-forest);
        border-bottom: 1px solid rgba(192,139,48,0.18);
        height: var(--l-top-h);
        overflow: hidden;
        transition: height 0.3s var(--l-ease), opacity 0.3s;
    }
    .navbar.is-scrolled .navbar__top { height: 0; opacity: 0; }

    .navbar__top-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: var(--l-top-h);
    }
    .navbar__top-left,
    .navbar__top-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .navbar__top-pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 0.68rem;
        font-weight: 400;
        letter-spacing: 0.06em;
        color: rgba(246,240,230,0.62);
        text-decoration: none;
        transition: color 0.2s;
    }
    .navbar__top-pill:hover { color: var(--l-gold-lt); }
    .navbar__top-pill i { font-size: 0.6rem; color: var(--l-gold); }
    .navbar__top-pill--hide-sm { }

    .navbar__top-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        color: rgba(246,240,230,0.45);
        font-size: 0.72rem;
        text-decoration: none;
        transition: color 0.2s;
    }
    .navbar__top-icon:hover { color: var(--l-gold-lt); }

    /* Lang + theme tools in top bar */
    .navbar__top-tools {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .navbar__top-lang-btn,
    .navbar__top-theme-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        background: transparent;
        border: 1px solid rgba(192,139,48,0.22);
        color: rgba(246,240,230,0.58);
        font-family: var(--l-body);
        font-size: 0.65rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
    }
    .navbar__top-lang-btn:hover,
    .navbar__top-theme-btn:hover { border-color: var(--l-gold); color: var(--l-gold-lt); }

    /* Lang dropdown */
    .navbar__lang-wrap { position: relative; }
    .navbar__lang-drop {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        background: var(--l-forest-dk);
        border: 1px solid rgba(192,139,48,0.2);
        min-width: 120px;
        z-index: 200;
    }
    .navbar__lang-wrap:hover .navbar__lang-drop,
    .navbar__lang-wrap.is-open .navbar__lang-drop { display: block; }
    .navbar__lang-item {
        display: block;
        padding: 8px 14px;
        font-size: 0.72rem;
        font-weight: 400;
        letter-spacing: 0.08em;
        color: rgba(246,240,230,0.65);
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }
    .navbar__lang-item:hover { background: rgba(192,139,48,0.12); color: var(--l-gold-lt); }
    .navbar__lang-item.is-active { color: var(--l-gold); }

    /* ── Main nav bar ── */
    .navbar__bar {
        background: var(--l-cream);
        border-bottom: 1px solid rgba(192,139,48,0.12);
        height: var(--l-nav-h);
        transition: background 0.3s, box-shadow 0.3s;
    }
    [data-theme="dark"] .navbar__bar { background: #0f0a05; }
    .navbar.is-scrolled .navbar__bar {
        box-shadow: 0 4px 32px rgba(26,16,8,0.1);
    }

    .navbar__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: var(--l-nav-h);
        gap: 24px;
    }

    /* Logo */
    .navbar__brand { display: flex; align-items: center; flex-shrink: 0; }
    .navbar__logo { height: 40px; width: auto; object-fit: contain; display: block; }

    /* Links */
    .navbar__links {
        display: flex;
        align-items: center;
        gap: 0;
        list-style: none;
        margin: 0;
        padding: 0;
        height: 100%;
    }
    .navbar__links li { height: 100%; display: flex; align-items: center; }
    .navbar__link {
        display: flex;
        align-items: center;
        height: 100%;
        padding: 0 14px;
        font-family: var(--l-body);
        font-size: 0.72rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(26,16,8,0.6);
        text-decoration: none;
        position: relative;
        transition: color 0.2s;
        white-space: nowrap;
    }
    [data-theme="dark"] .navbar__link { color: rgba(246,240,230,0.55); }
    .navbar__link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 14px;
        right: 14px;
        height: 2px;
        background: var(--l-gold);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.25s var(--l-ease);
    }
    .navbar__link:hover { color: var(--l-ink); }
    [data-theme="dark"] .navbar__link:hover { color: var(--l-parchment); }
    .navbar__link:hover::after,
    .navbar__link.is-active::after { transform: scaleX(1); }
    .navbar__link.is-active { color: var(--l-ink); font-weight: 500; }
    [data-theme="dark"] .navbar__link.is-active { color: var(--l-parchment); }

    /* CTA buttons in nav */
    .navbar__tools {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .navbar__cta {
        display: inline-flex;
        align-items: center;
        padding: 9px 18px;
        font-family: var(--l-body);
        font-size: 0.68rem;
        font-weight: 500;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        text-decoration: none;
        background: var(--l-gold);
        color: var(--l-ink);
        border: none;
        transition: background 0.2s, transform 0.2s var(--l-ease);
        white-space: nowrap;
    }
    .navbar__cta:hover { background: var(--l-gold-lt); transform: translateY(-1px); }
    .navbar__cta--secondary {
        background: transparent;
        color: rgba(26,16,8,0.65);
        border: 1px solid rgba(26,16,8,0.15);
    }
    [data-theme="dark"] .navbar__cta--secondary {
        color: rgba(246,240,230,0.6);
        border-color: rgba(246,240,230,0.15);
    }
    .navbar__cta--secondary:hover {
        background: rgba(192,139,48,0.08);
        color: var(--l-gold-dk);
        border-color: var(--l-gold);
        transform: translateY(-1px);
    }

    /* ── Mobile burger ── */
    .navbar__burger {
        display: none;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
        width: 36px;
        height: 36px;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 4px;
        flex-shrink: 0;
    }
    .navbar__burger-line {
        display: block;
        width: 100%;
        height: 1.5px;
        background: var(--l-ink);
        transition: transform 0.3s var(--l-ease), opacity 0.2s, width 0.3s;
        transform-origin: left center;
    }
    [data-theme="dark"] .navbar__burger-line { background: var(--l-parchment); }
    .navbar__burger.is-open .navbar__burger-line:nth-child(1) { transform: rotate(42deg) translateY(-1px); }
    .navbar__burger.is-open .navbar__burger-line:nth-child(2) { opacity: 0; width: 0; }
    .navbar__burger.is-open .navbar__burger-line:nth-child(3) { transform: rotate(-42deg) translateY(1px); }

    /* ── Mobile panel ── */
    .navbar__backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(26,16,8,0.45);
        z-index: 998;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .navbar__panel {
        display: flex;
        flex-direction: column;
    }
    .navbar__panel-foot { display: none; }

    /* ── Responsive breakpoint ── */
    @media (max-width: 1024px) {
        .navbar__links { display: none; }
        .navbar__tools { display: none; }
        .navbar__burger { display: flex; }
        .navbar__top-pill--hide-sm { display: none; }

        /* Slide-in panel */
        .navbar__backdrop { display: block; }
        .navbar__panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: min(320px, 88vw);
            height: 100dvh;
            background: var(--l-forest);
            z-index: 999;
            overflow-y: auto;
            transition: right 0.38s var(--l-ease);
            padding: 72px 0 32px;
        }
        .navbar__panel.is-open { right: 0; }
        .navbar__backdrop.is-open { opacity: 1; pointer-events: all; }

        .navbar__links {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            height: auto;
            gap: 0;
            flex: 1;
        }
        .navbar__links li { height: auto; width: 100%; }
        .navbar__link {
            display: block;
            height: auto;
            padding: 14px 32px;
            color: rgba(246,240,230,0.7);
            font-size: 0.8rem;
            border-bottom: 1px solid rgba(192,139,48,0.1);
        }
        .navbar__link::after { display: none; }
        .navbar__link:hover,
        .navbar__link.is-active { color: var(--l-gold-lt); background: rgba(192,139,48,0.08); }

        .navbar__panel-foot {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 28px 32px 0;
            margin-top: 16px;
            border-top: 1px solid rgba(192,139,48,0.12);
        }
        .navbar__panel-phone {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: rgba(246,240,230,0.55);
            text-decoration: none;
        }
        .navbar__panel-phone i { color: var(--l-gold); font-size: 0.72rem; }
        .navbar__panel-cta {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            background: var(--l-gold);
            color: var(--l-ink);
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            text-decoration: none;
            align-self: flex-start;
        }
    }

    @media (max-width: 480px) {
        .navbar__top { display: none; }
    }

    /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
       MAIN CONTENT spacing
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
    .main-content { min-height: 60vh; }

    /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
       FOOTER
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
    .footer {
        background: var(--l-ink);
        position: relative;
        overflow: hidden;
        font-family: var(--l-body);
    }
    [data-theme="dark"] .footer { background: #0a0603; }

    /* Radial light from top */
    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 900px;
        height: 2px;
        background: linear-gradient(to right, transparent, rgba(192,139,48,0.5), transparent);
        pointer-events: none;
    }
    .footer::after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 300px;
        background: radial-gradient(ellipse at 50% 0%, rgba(192,139,48,0.06), transparent 70%);
        pointer-events: none;
    }

    /* Grid */
    .footer__grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr;
        gap: 60px;
        padding: 72px 0 60px;
        position: relative;
        z-index: 1;
    }

    /* Brand col */
    .footer__brand-top { margin-bottom: 20px; }
    .footer__brand-logo img { height: 44px; width: auto; object-fit: contain; filter: brightness(0) invert(1); opacity: 0.88; }
    .footer__text {
        font-size: 0.88rem;
        font-weight: 300;
        line-height: 1.8;
        color: rgba(246,240,230,0.45);
        max-width: 34ch;
        margin: 0 0 24px;
    }
    .footer__social {
        display: flex;
        gap: 8px;
    }
    .footer__social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border: 1px solid rgba(192,139,48,0.2);
        color: rgba(246,240,230,0.45);
        font-size: 0.72rem;
        text-decoration: none;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
    }
    .footer__social-link:hover {
        border-color: var(--l-gold);
        color: var(--l-gold-lt);
        background: rgba(192,139,48,0.1);
    }

    /* Column headings */
    .footer__h4 {
        font-family: var(--l-display);
        font-size: 1.1rem;
        font-weight: 400;
        color: var(--l-parchment);
        margin: 0 0 24px;
        padding-bottom: 12px;
        position: relative;
    }
    .footer__h4--lined::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 32px;
        height: 1px;
        background: var(--l-gold);
    }

    /* Contact meta */
    .footer__meta { display: flex; flex-direction: column; gap: 16px; }
    .footer__meta-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.82rem;
        color: rgba(246,240,230,0.45);
    }
    .footer__meta-row i {
        color: var(--l-gold);
        font-size: 0.72rem;
        margin-top: 3px;
        flex-shrink: 0;
        width: 14px;
    }
    .footer__meta-label {
        font-size: 0.65rem;
        font-weight: 500;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(246,240,230,0.28);
        margin-bottom: 3px;
    }
    .footer__meta-value { color: rgba(246,240,230,0.62); line-height: 1.5; }
    .footer__meta-value a { color: inherit; text-decoration: none; }
    .footer__meta-value a:hover { color: var(--l-gold-lt); }
    .footer__meta-value--muted { color: rgba(246,240,230,0.38); font-size: 0.8rem; }

    /* Quick links */
    .footer__links-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .footer__link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.82rem;
        font-weight: 300;
        color: rgba(246,240,230,0.48);
        text-decoration: none;
        transition: color 0.2s, gap 0.2s;
    }
    .footer__link::before {
        content: '';
        display: block;
        width: 14px;
        height: 1px;
        background: var(--l-gold);
        opacity: 0.4;
        transition: width 0.2s, opacity 0.2s;
    }
    .footer__link:hover { color: var(--l-gold-lt); gap: 12px; }
    .footer__link:hover::before { width: 20px; opacity: 1; }

    /* Newsletter form */
    .footer__notice { font-size: 0.82rem; margin-bottom: 12px; }
    .footer__notice--success { color: var(--l-gold-lt); }
    .footer__notice--error   { color: #e07070; margin-top: 8px; }
    .footer__sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0,0,0,0); }
    .footer__form-row {
        display: flex;
        gap: 0;
        margin-bottom: 10px;
    }
    .footer__input {
        flex: 1;
        height: 42px;
        padding: 0 14px;
        background: rgba(246,240,230,0.06);
        border: 1px solid rgba(192,139,48,0.2);
        border-right: none;
        color: var(--l-parchment);
        font-family: var(--l-body);
        font-size: 0.82rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .footer__input::placeholder { color: rgba(246,240,230,0.28); }
    .footer__input:focus { border-color: var(--l-gold); }
    .footer__submit {
        height: 42px;
        padding: 0 18px;
        background: var(--l-gold);
        color: var(--l-ink);
        font-family: var(--l-body);
        font-size: 0.68rem;
        font-weight: 500;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s;
    }
    .footer__submit:hover { background: var(--l-gold-lt); }
    .footer__terms {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 0.72rem;
        color: rgba(246,240,230,0.32);
        line-height: 1.5;
        cursor: pointer;
    }
    .footer__terms input[type="checkbox"] { margin-top: 2px; accent-color: var(--l-gold); flex-shrink: 0; }

    /* Bottom bar */
    .footer__bottom {
        border-top: 1px solid rgba(192,139,48,0.1);
        padding: 20px 0;
        position: relative;
        z-index: 1;
    }
    .footer__bottom-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .footer__bottom p {
        font-size: 0.72rem;
        font-weight: 300;
        color: rgba(246,240,230,0.3);
        margin: 0;
    }
    .footer__bottom-links {
        display: flex;
        gap: 20px;
    }
    .footer__bottom-links a {
        font-size: 0.68rem;
        font-weight: 400;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(246,240,230,0.28);
        text-decoration: none;
        transition: color 0.2s;
    }
    .footer__bottom-links a:hover { color: var(--l-gold); }

    /* Footer responsive */
    @media (max-width: 1024px) {
        .footer__grid { grid-template-columns: 1fr 1fr; gap: 40px; }
    }
    @media (max-width: 640px) {
        .footer__grid { grid-template-columns: 1fr; gap: 40px; padding: 52px 0 40px; }
        .footer__bottom-inner { flex-direction: column; align-items: flex-start; gap: 8px; }
    }
    </style>

    @stack('styles')
</head>
<body>
@php
    $companyName  = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
    $logo         = \App\Models\Setting::where('key', 'site_logo')->value('value');
    $navPhone     = \App\Models\Setting::where('key', 'contact_phone')->value('value');
    $navPhoneTel  = $navPhone ? preg_replace('/[^\d+]/', '', $navPhone) : null;
@endphp

<div class="site-bg">
<div class="site-shell">

{{-- ══════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════ --}}
<nav class="navbar" id="site-navbar" aria-label="Primary navigation">

    {{-- Top info bar --}}
    <div class="navbar__top">
        <div class="container navbar__top-inner">
            <div class="navbar__top-left">
                @if($navPhone)
                    <a href="tel:{{ $navPhoneTel }}" class="navbar__top-pill">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <span>{{ $navPhone }}</span>
                    </a>
                @endif
                @if($emailTop = \App\Models\Setting::where('key', 'contact_email')->value('value'))
                    <a href="mailto:{{ $emailTop }}" class="navbar__top-pill navbar__top-pill--hide-sm">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <span>{{ $emailTop }}</span>
                    </a>
                @endif
            </div>

            <div class="navbar__top-right">
                @if($igTop = \App\Models\Setting::where('key', 'social_instagram')->value('value'))
                    <a href="{{ $igTop }}" class="navbar__top-icon" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                @endif
                @if($fbTop = \App\Models\Setting::where('key', 'social_facebook')->value('value'))
                    <a href="{{ $fbTop }}" class="navbar__top-icon" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                @endif
                @if($twTop = \App\Models\Setting::where('key', 'social_twitter')->value('value'))
                    <a href="{{ $twTop }}" class="navbar__top-icon" target="_blank" rel="noopener" aria-label="Twitter">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                @endif

                {{-- Lang + theme in top bar --}}
                <div class="navbar__top-tools">
                    <div class="navbar__lang-wrap">
                        <button class="navbar__top-lang-btn" id="lang-btn" type="button" aria-label="Language">
                            <i class="fa-solid fa-earth-africa" aria-hidden="true"></i>
                            <span>{{ strtoupper(app()->getLocale()) }}</span>
                        </button>
                        <div class="navbar__lang-drop" id="lang-dropdown">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a rel="alternate"
                                   hreflang="{{ $localeCode }}"
                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                   class="navbar__lang-item {{ app()->getLocale() == $localeCode ? 'is-active' : '' }}">
                                    {{ $properties['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <button id="theme-toggle" class="navbar__top-theme-btn" aria-label="Toggle dark mode" type="button">
                        <i class="fa-solid fa-moon" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Main bar --}}
    <div class="navbar__bar">
        <div class="container navbar__inner">

            {{-- Logo --}}
            <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="navbar__brand">
                @if($logo)
                    <img src="{{ $logo }}" alt="{{ $companyName }}" class="navbar__logo">
                @else
                    <img src="{{ asset('images/gmac-logo.png') }}" alt="{{ $companyName }}" class="navbar__logo">
                @endif
            </a>

            {{-- Backdrop for mobile --}}
            <div class="navbar__backdrop" id="navbar-backdrop" aria-hidden="true"></div>

            {{-- Nav panel (desktop: inline flex; mobile: slide-in) --}}
            <div class="navbar__panel" id="navbar-panel">
                <ul class="navbar__links" id="navbar-links">
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/')) }}"              class="navbar__link {{ request()->is('/') ? 'is-active' : '' }}">{{ __('messages.home') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}"       class="navbar__link {{ request()->is('*history*') ? 'is-active' : '' }}">{{ __('messages.history') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}"          class="navbar__link {{ request()->is('*shop*') || request()->is('*products*') ? 'is-active' : '' }}">{{ __('messages.nav_shop') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/news')) }}"          class="navbar__link {{ request()->is('*news*') ? 'is-active' : '' }}">{{ __('messages.news') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/gallery')) }}"       class="navbar__link {{ request()->is('*gallery*') ? 'is-active' : '' }}">{{ __('messages.gallery') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/washing-stations')) }}" class="navbar__link {{ request()->is('*washing-stations*') ? 'is-active' : '' }}">{{ __('messages.stations') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/team')) }}"          class="navbar__link {{ request()->is('*team*') ? 'is-active' : '' }}">Team</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}"       class="navbar__link {{ request()->is('*contact*') ? 'is-active' : '' }}">{{ __('messages.contact') }}</a></li>
                </ul>

                {{-- Mobile panel footer --}}
                <div class="navbar__panel-foot">
                    @if($navPhone)
                        <a href="tel:{{ $navPhoneTel }}" class="navbar__panel-phone">
                            <i class="fa-solid fa-phone" aria-hidden="true"></i>
                            <span>{{ $navPhone }}</span>
                        </a>
                    @endif
                    <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="navbar__panel-cta">
                        {{ __('messages.get_in_touch') ?? __('messages.contact') }}
                    </a>
                </div>
            </div>

            {{-- Desktop CTA buttons --}}
            <div class="navbar__tools">
                <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="navbar__cta navbar__cta--secondary">
                    {{ __('messages.get_in_touch') ?? __('messages.contact') }}
                </a>
                <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="navbar__cta">
                    {{ __('messages.nav_shop') }}
                </a>
            </div>

            {{-- Burger --}}
            <button type="button" class="navbar__burger" id="navbar-burger"
                    aria-label="Open menu" aria-expanded="false" aria-controls="navbar-panel">
                <span class="navbar__burger-line" aria-hidden="true"></span>
                <span class="navbar__burger-line" aria-hidden="true"></span>
                <span class="navbar__burger-line" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</nav>

{{-- ══════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════ --}}
<main class="main-content">
    @yield('content')
</main>

{{-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ --}}
<footer class="footer" role="contentinfo">
    @php
        $aboutShortFooter = \App\Models\Setting::where('key', 'about_short_text')->value('value')
            ?? 'Dedicated to bringing the finest Rwandan coffee to the world.';
        $addr   = \App\Models\Setting::where('key', 'contact_address')->value('value')   ?: 'KK 372 S, Kigali, Kicukiro, Rwanda';
        $addr2  = \App\Models\Setting::where('key', 'contact_address_2')->value('value');
        $phone  = \App\Models\Setting::where('key', 'contact_phone')->value('value')      ?: '+250 783 053 415';
        $phone2 = \App\Models\Setting::where('key', 'contact_phone_2')->value('value');
        $email  = \App\Models\Setting::where('key', 'contact_email')->value('value')      ?: 'info@gmac.coffee';
        $fb = \App\Models\Setting::where('key', 'social_facebook')->value('value');
        $ig = \App\Models\Setting::where('key', 'social_instagram')->value('value');
        $tw = \App\Models\Setting::where('key', 'social_twitter')->value('value');
        $li = \App\Models\Setting::where('key', 'social_linkedin')->value('value');
    @endphp

    <div class="container">
        <div class="footer__grid">

            {{-- Brand --}}
            <div class="footer__brand">
                <div class="footer__brand-top">
                    <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="footer__brand-logo" aria-label="{{ $companyName }}">
                        @if($logo)
                            <img src="{{ $logo }}" alt="{{ $companyName }}">
                        @else
                            <img src="{{ asset('images/gmac-logo.png') }}" alt="{{ $companyName }}">
                        @endif
                    </a>
                </div>
                <p class="footer__text">{{ $aboutShortFooter }}</p>
                <div class="footer__social" aria-label="Social links">
                    @if($fb)<a href="{{ $fb }}" class="footer__social-link" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>@endif
                    @if($ig)<a href="{{ $ig }}" class="footer__social-link" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if($tw)<a href="{{ $tw }}" class="footer__social-link" target="_blank" rel="noopener" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>@endif
                    @if($li)<a href="{{ $li }}" class="footer__social-link" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>@endif
                </div>
            </div>

            {{-- Contact info --}}
            <div class="footer__col">
                <h4 class="footer__h4 footer__h4--lined">Contact Info</h4>
                <div class="footer__meta">
                    <div class="footer__meta-row">
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <div>
                            <div class="footer__meta-label">Our locations</div>
                            <div class="footer__meta-value">{{ $addr }}</div>
                            @if($addr2)
                                <div class="footer__meta-value footer__meta-value--muted">{{ $addr2 }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="footer__meta-row">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <div>
                            <div class="footer__meta-label">Phone</div>
                            <div class="footer__meta-value">{{ $phone }}</div>
                            @if($phone2)
                                <div class="footer__meta-value footer__meta-value--muted">{{ $phone2 }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="footer__meta-row">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <div>
                            <div class="footer__meta-label">Email</div>
                            <div class="footer__meta-value">
                                <a href="mailto:{{ $email }}">{{ $email }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Newsletter --}}
            <div class="footer__col">
                <h4 class="footer__h4 footer__h4--lined">Newsletter</h4>
                <p class="footer__text">Get updates on new harvests, releases, and GMAC news.</p>

                @if(session('newsletter_success'))
                    <div class="footer__notice footer__notice--success">{{ session('newsletter_success') }}</div>
                @endif

                <form action="{{ url('/subscribe') }}" method="POST" class="footer__form">
                    @csrf
                    <label class="footer__sr-only" for="footer-email">Email address</label>
                    <div class="footer__form-row">
                        <input id="footer-email" type="email" name="email"
                               class="footer__input" placeholder="Your email address" required>
                        <button type="submit" class="footer__submit">Subscribe</button>
                    </div>
                    <label class="footer__terms">
                        <input type="checkbox" name="terms_ack" required>
                        <span>I agree to the terms &amp; conditions</span>
                    </label>
                </form>
                @error('email')
                    <div class="footer__notice footer__notice--error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="footer__bottom">
            <div class="footer__bottom-inner">
                <p>&copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
                <div class="footer__bottom-links">
                    <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}">{{ __('messages.contact') }}</a>
                    <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}">{{ __('messages.history') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>{{-- /site-shell --}}
</div>{{-- /site-bg --}}

@stack('scripts')

{{-- ══════════════════════════════════════════
     GLOBAL JS — navbar scroll + mobile menu
══════════════════════════════════════════ --}}
<script>
(function () {
    var navbar   = document.getElementById('site-navbar');
    var burger   = document.getElementById('navbar-burger');
    var panel    = document.getElementById('navbar-panel');
    var backdrop = document.getElementById('navbar-backdrop');

    /* Scroll shrink */
    var lastY = 0;
    window.addEventListener('scroll', function () {
        var y = window.scrollY;
        if (y > 60) {
            navbar.classList.add('is-scrolled');
        } else {
            navbar.classList.remove('is-scrolled');
        }
        lastY = y;
    }, { passive: true });

    /* Mobile menu open/close */
    function openMenu() {
        panel.classList.add('is-open');
        backdrop.classList.add('is-open');
        burger.classList.add('is-open');
        burger.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }
    function closeMenu() {
        panel.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        burger.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if (burger) {
        burger.addEventListener('click', function () {
            panel.classList.contains('is-open') ? closeMenu() : openMenu();
        });
    }
    if (backdrop) {
        backdrop.addEventListener('click', closeMenu);
    }

    /* Close on ESC */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });

    /* Dark mode toggle */
    var themeBtn = document.getElementById('theme-toggle');
    var html     = document.documentElement;
    if (themeBtn) {
        themeBtn.addEventListener('click', function () {
            var isDark = html.getAttribute('data-theme') === 'dark';
            html.setAttribute('data-theme', isDark ? 'light' : 'dark');
            themeBtn.querySelector('i').className = isDark
                ? 'fa-solid fa-moon'
                : 'fa-solid fa-sun';
            try { localStorage.setItem('gmac-theme', isDark ? 'light' : 'dark'); } catch(e){}
        });
    }

    /* Restore saved theme */
    try {
        var saved = localStorage.getItem('gmac-theme');
        if (saved) {
            html.setAttribute('data-theme', saved);
            if (themeBtn) {
                themeBtn.querySelector('i').className = saved === 'dark'
                    ? 'fa-solid fa-sun'
                    : 'fa-solid fa-moon';
            }
        }
    } catch(e){}

    /* Lang dropdown toggle (click-based for accessibility) */
    var langBtn  = document.getElementById('lang-btn');
    var langWrap = langBtn ? langBtn.closest('.navbar__lang-wrap') : null;
    if (langBtn && langWrap) {
        langBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            langWrap.classList.toggle('is-open');
        });
        document.addEventListener('click', function () {
            langWrap.classList.remove('is-open');
        });
    }
})();
</script>
</body>
</html>
