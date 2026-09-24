<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee')</title>
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::where('key', 'site_description')->value('value') ?? 'Premium Rwandan Coffee')">
    @include('partials.favicon')

    <!-- Google Fonts – loaded once here for the whole site -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400;1,9..144,500&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/frontend.css', 'resources/css/mobile.css', 'resources/js/frontend.js'])

    <!-- Layout styles (navbar + footer) -->
    <style>
    /* ─── Site-wide tokens ────────────────────────────────────────── */
    :root {
        --l-forest:    #7a6452;
        --l-forest-dk: #5c4a3c;
        --l-ink:       #3f3731;
        --l-parchment: #f5f3f0;
        --l-cream:     #f5f3f0;
        --l-gold:      #b89a6a;
        --l-gold-dk:   #9a7d4e;
        --l-gold-lt:   #d4b56a;
        --l-display:   'Fraunces', 'Times New Roman', serif;
        --l-body:      'Poppins', ui-sans-serif, sans-serif;
        --l-ease:      cubic-bezier(0.16, 1, 0.3, 1);
        --l-nav-h:     64px;
        --l-top-h:     36px;
    }
    [data-theme="dark"] {
        --l-parchment: #f6f1e8;
        --l-cream:     #101c18;
        --l-ink:       #f6f1e8;
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
        display: block;
        background: #5c4a3c;
        border-bottom: none;
        height: var(--l-top-h);
        overflow: hidden;
        transition: height 0.3s ease, opacity 0.3s ease;
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
        background: rgba(255, 255, 255, 0.9);
        border-bottom: 1px solid #dfe8f0;
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
    .navbar__link:hover { color: var(--l-ink); background: transparent; }
    [data-theme="dark"] .navbar__link:hover { color: var(--l-parchment); }
    .navbar__link:hover::after,
    .navbar__link.is-active::after { transform: scaleX(1); }
    .navbar__link.is-active { color: var(--l-gold-dk); font-weight: 600; background: transparent; }
    [data-theme="dark"] .navbar__link.is-active { color: var(--l-gold-lt); }

    /* CTA buttons in nav */
    .navbar__tools {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .navbar__tools--compact {
        gap: 12px;
        align-items: center;
    }
    .navbar__cta {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        font-family: var(--l-body);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        text-decoration: none;
        background: var(--l-forest);
        color: var(--l-parchment);
        border: none;
        border-radius: 999px;
        transition: background 0.2s, transform 0.2s var(--l-ease);
        white-space: nowrap;
    }
    .navbar__cta:hover { background: #24483f; color: #fff; transform: translateY(-1px); }
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
        .navbar__panel-row {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            gap: 10px;
            align-items: stretch;
        }
        .navbar__panel-row > a {
            flex: 1;
            justify-content: center;
            text-align: center;
            margin-bottom: 0;
        }
        .navbar__panel-shop {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 16px;
            background: var(--l-gold);
            color: var(--l-ink);
            border: none;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            text-decoration: none;
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
        .navbar__panel-social { display: flex; gap: 0.65rem; margin-bottom: 0.75rem; }
        .navbar__panel-social a {
            width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: 999px; border: 1px solid rgba(246,240,230,0.16); color: #f6f0e6; text-decoration: none;
        }
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
       FOOTER — light minimal
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
    .footer {
        background: var(--l-cream);
        border-top: 1px solid rgba(201,150,63,0.14);
        position: relative;
        overflow: hidden;
        font-family: var(--l-body);
    }
    [data-theme="dark"] .footer { background: #0a0603; border-top-color: rgba(192,139,48,0.12); }

    /* Subtle gold accent line at very top */
    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 900px;
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(192,139,48,0.45), transparent);
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
    .footer__brand-logo img { height: 44px; width: auto; object-fit: contain; opacity: 0.88; }
    [data-theme="dark"] .footer__brand-logo img { filter: brightness(0) invert(1); opacity: 0.82; }
    .footer__text {
        font-size: 0.88rem;
        font-weight: 300;
        line-height: 1.8;
        color: rgba(26,16,8,0.55);
        max-width: 34ch;
        margin: 0 0 24px;
    }
    [data-theme="dark"] .footer__text { color: rgba(246,240,230,0.45); }
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
        border: 1px solid rgba(192,139,48,0.22);
        color: rgba(26,16,8,0.45);
        font-size: 0.72rem;
        text-decoration: none;
        transition: border-color 0.2s, color 0.2s, background 0.2s;
    }
    [data-theme="dark"] .footer__social-link { color: rgba(246,240,230,0.45); }
    .footer__social-link:hover {
        border-color: var(--l-gold);
        color: var(--l-gold);
        background: rgba(192,139,48,0.08);
    }

    /* Column headings */
    .footer__h4 {
        font-family: var(--l-display);
        font-size: 1.1rem;
        font-weight: 400;
        color: var(--l-ink);
        margin: 0 0 24px;
        padding-bottom: 12px;
        position: relative;
    }
    [data-theme="dark"] .footer__h4 { color: var(--l-parchment); }
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
        color: rgba(26,16,8,0.55);
    }
    [data-theme="dark"] .footer__meta-row { color: rgba(246,240,230,0.45); }
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
        color: rgba(26,16,8,0.42);
        margin-bottom: 3px;
    }
    [data-theme="dark"] .footer__meta-label { color: rgba(246,240,230,0.28); }
    .footer__meta-value { color: rgba(26,16,8,0.72); line-height: 1.5; }
    [data-theme="dark"] .footer__meta-value { color: rgba(246,240,230,0.62); }
    .footer__meta-value a { color: inherit; text-decoration: none; }
    .footer__meta-value a:hover { color: var(--l-gold); }
    .footer__meta-value--muted { color: rgba(26,16,8,0.45); font-size: 0.8rem; }
    [data-theme="dark"] .footer__meta-value--muted { color: rgba(246,240,230,0.38); }

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
        color: rgba(26,16,8,0.55);
        text-decoration: none;
        transition: color 0.2s, gap 0.2s;
    }
    [data-theme="dark"] .footer__link { color: rgba(246,240,230,0.48); }
    .footer__link::before {
        content: '';
        display: block;
        width: 14px;
        height: 1px;
        background: var(--l-gold);
        opacity: 0.5;
        transition: width 0.2s, opacity 0.2s;
    }
    .footer__link:hover { color: var(--l-gold); gap: 12px; }
    [data-theme="dark"] .footer__link:hover { color: var(--l-gold-lt); }
    .footer__link:hover::before { width: 20px; opacity: 1; }

    /* Newsletter form */
    .footer__notice { font-size: 0.82rem; margin-bottom: 12px; }
    .footer__notice--success { color: var(--l-gold-dk); }
    [data-theme="dark"] .footer__notice--success { color: var(--l-gold-lt); }
    .footer__notice--error   { color: #c05050; margin-top: 8px; }
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
        background: rgba(26,16,8,0.04);
        border: 1px solid rgba(192,139,48,0.22);
        border-right: none;
        color: var(--l-ink);
        font-family: var(--l-body);
        font-size: 0.82rem;
        outline: none;
        transition: border-color 0.2s;
    }
    [data-theme="dark"] .footer__input { background: rgba(246,240,230,0.06); border-color: rgba(192,139,48,0.2); color: var(--l-parchment); }
    .footer__input::placeholder { color: rgba(26,16,8,0.35); }
    [data-theme="dark"] .footer__input::placeholder { color: rgba(246,240,230,0.28); }
    .footer__input:focus { border-color: var(--l-gold); }
    .footer__submit {
        height: 42px;
        padding: 0 18px;
        background: var(--l-gold);
        color: var(--l-cream);
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
    .footer__submit:hover { background: var(--l-gold-dk); }
    /* Bottom bar — full-bleed below main footer grid */
    .footer__bottom {
        border-top: 1px solid rgba(192,139,48,0.1);
        background: rgba(26,16,8,0.03);
        padding: 22px 0 28px;
        position: relative;
        z-index: 1;
        width: 100%;
        margin-left: 0;
        margin-right: 0;
    }
    [data-theme="dark"] .footer__bottom { background: rgba(246,240,230,0.02); }
    .footer__bottom-inner {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        justify-content: flex-start;
        gap: 1.25rem;
        width: 100%;
        max-width: 100%;
        flex-wrap: nowrap;
    }
    .footer__bottom p {
        font-size: 0.72rem;
        font-weight: 300;
        color: rgba(26,16,8,0.45);
        margin: 0;
    }
    [data-theme="dark"] .footer__bottom p { color: rgba(246,240,230,0.3); }
    .footer__bottom-links {
        display: flex;
        flex-wrap: wrap;
        gap: 12px 22px;
        justify-content: center;
        width: 100%;
    }
    .footer__bottom-links a {
        font-size: 0.68rem;
        font-weight: 400;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(26,16,8,0.45);
        text-decoration: none;
        transition: color 0.2s;
    }
    [data-theme="dark"] .footer__bottom-links a { color: rgba(246,240,230,0.28); }
    .footer__bottom-links a:hover { color: var(--l-gold); }

    .footer__credits {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
        max-width: 100%;
        text-align: center;
        align-items: center;
        padding: 1.35rem 1.25rem;
        background: rgba(26, 16, 8, 0.04);
        border: 1px solid rgba(201, 150, 63, 0.14);
        border-radius: 20px;
    }
    [data-theme="dark"] .footer__credits {
        background: rgba(246, 240, 230, 0.04);
        border-color: rgba(201, 150, 63, 0.12);
    }
    .footer__copy {
        font-size: 0.78rem;
        font-weight: 500;
        letter-spacing: 0.04em;
        color: rgba(26,16,8,0.55);
        margin: 0;
    }
    [data-theme="dark"] .footer__copy { color: rgba(246,240,230,0.45); }
    .footer__tagline {
        font-family: var(--l-display);
        font-size: 1.02rem;
        font-weight: 400;
        font-style: italic;
        color: rgba(26,16,8,0.48);
        margin: 0;
        max-width: 56ch;
        line-height: 1.5;
    }
    [data-theme="dark"] .footer__tagline { color: rgba(246,240,230,0.38); }
    .footer__legal {
        font-size: 0.68rem;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: rgba(26,16,8,0.4);
        margin: 0.15rem 0 0;
    }
    [data-theme="dark"] .footer__legal { color: rgba(246,240,230,0.28); }

    .navbar__cart {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 999px;
        background: rgba(26,16,8,0.06);
        color: var(--l-ink);
        text-decoration: none;
        transition: background 0.2s, color 0.2s, transform 0.2s var(--l-ease);
    }
    [data-theme="dark"] .navbar__cart {
        background: rgba(246,240,230,0.08);
        color: var(--l-parchment);
    }
    .navbar__cart:hover { background: rgba(201,150,63,0.15); color: var(--l-gold-dk); transform: translateY(-1px); }
    .navbar__cart-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 999px;
        background: var(--l-gold);
        color: var(--l-forest-dk);
        font-size: 0.62rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .site-quick-actions {
        position: fixed;
        right: max(16px, env(safe-area-inset-right));
        bottom: max(20px, env(safe-area-inset-bottom));
        z-index: 950;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
        pointer-events: none;
    }
    .site-quick-actions > * { pointer-events: auto; }

    @keyframes wa-pulse {
        0%, 100% { transform: scale(1); opacity: 0.55; }
        50% { transform: scale(1.15); opacity: 0.2; }
    }
    @keyframes wa-bob {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .site-wa-stack {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    /* Compact WhatsApp FAB — same footprint as scroll-to-top */
    .site-wa-fab {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        padding: 0;
        border: none;
        border-radius: 999px;
        cursor: pointer;
        color: #fff;
        background: #7a6452;
        box-shadow: 0 12px 28px rgba(92, 74, 60, 0.28);
        transition: transform 0.25s var(--l-ease), box-shadow 0.25s, background 0.2s;
        animation: wa-bob 2.8s ease-in-out infinite;
    }
    .site-wa-fab:hover {
        background: #8d7560;
        transform: translateY(-3px);
        box-shadow: 0 16px 36px rgba(92, 74, 60, 0.32);
        animation: none;
    }
    .site-wa-fab.is-open {
        background: #5c4a3c;
        animation: none;
        box-shadow: 0 10px 24px rgba(92, 74, 60, 0.26);
    }
    .site-wa-fab:focus-visible {
        outline: 2px solid var(--l-gold);
        outline-offset: 3px;
    }
    .site-wa-fab__ring {
        position: absolute;
        inset: -5px;
        border-radius: 999px;
        border: 2px solid rgba(122, 100, 82, 0.4);
        animation: wa-pulse 2s ease-out infinite;
        pointer-events: none;
    }
    .site-wa-fab.is-open .site-wa-fab__ring {
        animation: none;
        opacity: 0.35;
    }
    .site-wa-fab__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        line-height: 1;
    }

    /* Popover above the FAB */
    .site-wa-panel {
        position: absolute;
        right: 0;
        bottom: calc(100% + 12px);
        width: min(248px, calc(100vw - 32px));
        padding: 0.95rem 1rem 0.9rem;
        border-radius: 14px;
        background: var(--l-cream);
        color: var(--l-ink);
        box-shadow: 0 16px 40px rgba(26, 51, 44, 0.16);
        border: 1px solid rgba(26, 51, 44, 0.1);
        z-index: 2;
        text-align: left;
        transform-origin: 85% 100%;
        animation: wa-panel-in 0.28s cubic-bezier(0.22, 1, 0.36, 1);
    }
    [data-theme="dark"] .site-wa-panel {
        background: #1a120c;
        color: var(--l-parchment);
        border-color: rgba(201,150,63,0.28);
        box-shadow:
            0 4px 0 rgba(0,0,0,0.2),
            0 24px 56px rgba(0,0,0,0.45);
    }
    .site-wa-panel[hidden] {
        display: none !important;
    }
    @keyframes wa-panel-in {
        from {
            opacity: 0;
            transform: translateY(8px) scale(0.94);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .site-wa-panel__label {
        font-family: var(--l-body);
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: rgba(26,16,8,0.5);
        margin: 0 0 0.35rem;
    }
    [data-theme="dark"] .site-wa-panel__label {
        color: rgba(246,240,230,0.45);
    }
    .site-wa-panel__num {
        font-family: var(--l-body);
        font-size: 1.05rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        margin: 0 0 1rem;
        word-break: break-word;
    }
    .site-wa-panel__cta {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 11px 14px;
        border-radius: 12px;
        font-family: var(--l-body);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        text-decoration: none;
        color: #fff;
        background: #7a6452;
        border: none;
        box-shadow: none;
        transition: transform 0.2s, background 0.2s;
    }
    .site-wa-panel__cta:hover {
        background: #8d7560;
        transform: translateY(-1px);
    }
    .site-wa-panel__close {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 10px;
        background: rgba(26,16,8,0.06);
        color: rgba(26,16,8,0.55);
        font-size: 1.35rem;
        line-height: 1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: background 0.2s, color 0.2s;
    }
    [data-theme="dark"] .site-wa-panel__close {
        background: rgba(246,240,230,0.08);
        color: rgba(246,240,230,0.55);
    }
    .site-wa-panel__close:hover {
        background: rgba(26,16,8,0.1);
        color: var(--l-ink);
    }
    [data-theme="dark"] .site-wa-panel__close:hover {
        background: rgba(246,240,230,0.12);
        color: var(--l-parchment);
    }

    .site-fab {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 999px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        font-size: 1.15rem;
        box-shadow: 0 12px 32px rgba(26,16,8,0.18);
        transition: transform 0.25s var(--l-ease), box-shadow 0.25s;
    }
    .site-fab:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(26,16,8,0.22); }
    .site-fab--top {
        background: var(--l-cream);
        color: var(--l-ink);
        border: 1px solid rgba(201,150,63,0.35);
        opacity: 0;
        visibility: hidden;
        transform: translateY(8px);
        transition: opacity 0.3s, visibility 0.3s, transform 0.3s var(--l-ease);
    }
    [data-theme="dark"] .site-fab--top {
        background: #1a120c;
        color: var(--l-parchment);
        border-color: rgba(201,150,63,0.25);
    }
    .site-fab--top.is-visible {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .navbar__cta--quick { gap: 8px; }
    .navbar__cta-ico { font-size: 0.85rem; opacity: 0.9; }
    @media (min-width: 1025px) {
        .navbar__cta--quick .navbar__cta-ico { display: inline-block; }
    }
    @media (max-width: 1024px) {
        .navbar__cta-txt { display: none !important; }
        .navbar__cta--quick .navbar__cta-ico { display: block; margin: 0; }
        .navbar__cta--quick {
            width: 44px;
            height: 44px;
            padding: 0 !important;
            border-radius: 999px;
            justify-content: center;
        }
    }

    .navbar__panel-cart {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(201,150,63,0.25);
        border-radius: 999px;
        color: rgba(246,240,230,0.9);
        text-decoration: none;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .navbar__panel-row .navbar__panel-cart {
        margin-bottom: 0;
    }
    .navbar__panel-cart-badge {
        min-width: 22px;
        height: 22px;
        border-radius: 999px;
        background: var(--l-gold);
        color: var(--l-forest-dk);
        font-size: 0.65rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    /* Footer responsive */
    @media (max-width: 1024px) {
        .footer__grid { grid-template-columns: 1fr 1fr; gap: 40px; }
    }
    @media (max-width: 640px) {
        .footer__grid { grid-template-columns: 1fr; gap: 40px; padding: 52px 0 40px; }
        .footer__bottom-inner { align-items: stretch; gap: 1rem; }
    }

    /* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
       MOBILE APP SHELL
    ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
    .mobile-tabbar { display: none; }

    .navbar__panel-locales {
        display: none;
    }

    @media (max-width: 1024px) {
        .navbar__top { display: none; }
        .navbar__bar,
        .navbar__inner {
            height: 64px;
        }
        .navbar__logo { height: 34px; max-height: 34px; }
        .navbar__tools {
            display: flex !important;
            margin-left: auto;
            background: transparent;
            border: none;
            box-shadow: none;
            padding: 0;
            gap: 8px;
        }
        .navbar__cta { display: none !important; }
        .navbar__cart {
            width: 44px;
            height: 44px;
        }
        .navbar__burger {
            display: flex;
            margin-left: 0;
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(13,9,7,0.08);
        }
        [data-theme="dark"] .navbar__burger {
            background: rgba(246,240,230,0.08);
            border-color: rgba(246,240,230,0.14);
        }

        .navbar__panel {
            width: min(100%, 420px);
            padding: calc(72px + env(safe-area-inset-top)) 1.15rem calc(1.5rem + env(safe-area-inset-bottom));
            background: #f4f6f3;
        }
        [data-theme="dark"] .navbar__panel {
            background:
                radial-gradient(500px 220px at 100% 0%, rgba(212,162,74,0.12), transparent 60%),
                linear-gradient(180deg, #173229 0%, #102620 100%);
        }
        .navbar__link {
            padding: 0.95rem 1.1rem;
            font-size: 0.92rem;
            letter-spacing: 0.1em;
            min-height: 48px;
        }

        .navbar__panel-locales {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
        }
        .navbar__panel-locale {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
            height: 40px;
            padding: 0 0.7rem;
            border-radius: 999px;
            border: 1px solid rgba(201,150,63,0.28);
            color: rgba(26,16,8,0.72);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-decoration: none;
            background: rgba(255,255,255,0.7);
        }
        [data-theme="dark"] .navbar__panel-locale {
            color: rgba(246,240,230,0.8);
            background: rgba(246,240,230,0.06);
            border-color: rgba(201,150,63,0.22);
        }
        .navbar__panel-locale.is-active {
            background: var(--l-gold);
            border-color: var(--l-gold);
            color: #1a1008;
        }
        .navbar__panel-theme {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            height: 40px;
            padding: 0 0.9rem;
            border-radius: 999px;
            border: 1px solid rgba(201,150,63,0.28);
            background: rgba(255,255,255,0.7);
            color: rgba(26,16,8,0.72);
            font-family: var(--l-body);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
        }
        [data-theme="dark"] .navbar__panel-theme {
            background: rgba(246,240,230,0.06);
            color: rgba(246,240,230,0.8);
        }

        .mobile-tabbar {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 970;
            padding: 0.35rem 0.4rem calc(0.35rem + env(safe-area-inset-bottom));
            background: rgba(253, 250, 245, 0.94);
            border-top: 1px solid rgba(201, 150, 63, 0.2);
            box-shadow: 0 -12px 32px rgba(13, 9, 7, 0.08);
            backdrop-filter: blur(18px) saturate(1.2);
            -webkit-backdrop-filter: blur(18px) saturate(1.2);
        }
        [data-theme="dark"] .mobile-tabbar {
            background: rgba(16, 38, 32, 0.94);
            border-top-color: rgba(201, 150, 63, 0.16);
            box-shadow: 0 -12px 32px rgba(0, 0, 0, 0.28);
        }
        .mobile-tabbar__item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.22rem;
            min-height: 52px;
            padding: 0.35rem 0.2rem;
            border-radius: 14px;
            color: rgba(26, 16, 8, 0.52);
            text-decoration: none;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: background 0.2s, color 0.2s;
        }
        [data-theme="dark"] .mobile-tabbar__item {
            color: rgba(246, 240, 230, 0.5);
        }
        .mobile-tabbar__item i {
            font-size: 1.05rem;
        }
        .mobile-tabbar__item.is-active {
            color: var(--l-gold-dk);
            background: rgba(201, 150, 63, 0.12);
        }
        [data-theme="dark"] .mobile-tabbar__item.is-active {
            color: var(--l-gold-lt);
            background: rgba(201, 150, 63, 0.14);
        }
        .mobile-tabbar__icon-wrap {
            position: relative;
            display: inline-flex;
        }
        .mobile-tabbar__badge {
            position: absolute;
            top: -7px;
            right: -10px;
            min-width: 16px;
            height: 16px;
            padding: 0 4px;
            border-radius: 999px;
            background: var(--l-gold);
            color: #1a1008;
            font-size: 0.58rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body {
            padding-bottom: calc(72px + env(safe-area-inset-bottom));
        }
        .site-quick-actions {
            bottom: calc(84px + env(safe-area-inset-bottom));
        }
        .footer {
            padding-bottom: 0.5rem;
        }
    }
    </style>

    @vite(['resources/css/site.css'])
    @stack('styles')
</head>
<body>
@php
    $companyName  = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
    $logo         = \App\Models\Setting::where('key', 'site_logo')->value('value');
    $navPhone     = \App\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+250 783 053 415';
    $navPhoneTel  = $navPhone ? preg_replace('/[^\d+]/', '', $navPhone) : null;
    $navAddress   = \App\Models\Setting::where('key', 'contact_address')->value('value') ?: 'KK 372 St, Kigali, Kicukiro, Rwanda';
    $waDigits = preg_replace('/\D/', '', $navPhone ?: '+250783053415');
    if (strlen($waDigits) === 9) {
        $waDigits = '250'.$waDigits;
    }
    if (strlen($waDigits) < 10) {
        $waDigits = '250783053415';
    }
    $waDisplay = $navPhone ?: '+250 783 053 415';
    $waHref = 'https://wa.me/'.$waDigits.'?text='.rawurlencode(__('messages.whatsapp_prefill'));
    $igUrl = \App\Support\SiteLinks::instagram();
    $fbUrl = \App\Support\SiteLinks::facebook();
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
                @if($navAddress)
                    <span class="navbar__top-pill navbar__top-pill--hide-sm">
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <span>{{ $navAddress }}</span>
                    </span>
                @endif
                @php $emailTop = \App\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@gmac.coffee'; @endphp
                    <a href="mailto:{{ $emailTop }}" class="navbar__top-pill navbar__top-pill--hide-sm">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <span>{{ $emailTop }}</span>
                    </a>
            </div>

            <div class="navbar__top-right">
                <a href="{{ $igUrl }}" class="navbar__top-icon" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="{{ $fbUrl }}" class="navbar__top-icon" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
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

            {{-- Nav panel (desktop: inline flex; mobile: slide-in) --}}
            <div class="navbar__panel" id="navbar-panel">
                <button type="button" class="navbar__panel-close" id="navbar-close" aria-label="Close menu">&times;</button>
                <ul class="navbar__links" id="navbar-links">
                    <li>
                        <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="navbar__link {{ request()->is('/') ? 'is-active' : '' }}">{{ __('messages.home') }}</a>
                    </li>
                    <li>
                        <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="navbar__link {{ request()->is('*shop*') || request()->is('*products*') ? 'is-active' : '' }}">{{ __('messages.nav_shop') }}</a>
                    </li>
                    <li class="navbar__more {{ request()->is('*history*') || request()->is('*washing-stations*') || request()->is('*team*') ? 'is-current' : '' }}">
                        <button type="button" class="navbar__link navbar__more-btn" aria-expanded="false" aria-haspopup="true" aria-controls="nav-drop-origin">
                            Origin
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="navbar__more-drop" id="nav-drop-origin">
                            <div class="navbar__more-card">
                                <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="navbar__drop-item {{ request()->is('*history*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-landmark" aria-hidden="true"></i>
                                    <span>
                                        <strong>{{ __('messages.history') }}</strong>
                                        <em>Founded 2012 in Rwanda</em>
                                    </span>
                                </a>
                                <a href="{{ LaravelLocalization::localizeUrl(url('/washing-stations')) }}" class="navbar__drop-item {{ request()->is('*washing-stations*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-industry" aria-hidden="true"></i>
                                    <span>
                                        <strong>{{ __('messages.stations') }}</strong>
                                        <em>Karenge mill and beds</em>
                                    </span>
                                </a>
                                <a href="{{ LaravelLocalization::localizeUrl(url('/team')) }}" class="navbar__drop-item {{ request()->is('*team*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-users" aria-hidden="true"></i>
                                    <span>
                                        <strong>Team</strong>
                                        <em>The people behind the cup</em>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="navbar__more {{ request()->is('*news*') || request()->is('*gallery*') || request()->is('*reviews*') ? 'is-current' : '' }}">
                        <button type="button" class="navbar__link navbar__more-btn" aria-expanded="false" aria-haspopup="true" aria-controls="nav-drop-stories">
                            Stories
                            <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div class="navbar__more-drop" id="nav-drop-stories">
                            <div class="navbar__more-card">
                                <a href="{{ LaravelLocalization::localizeUrl(url('/news')) }}" class="navbar__drop-item {{ request()->is('*news*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
                                    <span>
                                        <strong>{{ __('messages.news') }}</strong>
                                        <em>Harvest notes and lots</em>
                                    </span>
                                </a>
                                <a href="{{ LaravelLocalization::localizeUrl(url('/gallery')) }}" class="navbar__drop-item {{ request()->is('*gallery*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-images" aria-hidden="true"></i>
                                    <span>
                                        <strong>{{ __('messages.gallery') }}</strong>
                                        <em>Beds, mill, and cupping</em>
                                    </span>
                                </a>
                                <a href="{{ LaravelLocalization::localizeUrl(url('/reviews')) }}" class="navbar__drop-item {{ request()->is('*reviews*') ? 'is-active' : '' }}">
                                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                                    <span>
                                        <strong>{{ __('messages.nav_reviews') }}</strong>
                                        <em>What buyers tell us</em>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="navbar__link {{ request()->is('*contact*') ? 'is-active' : '' }}">{{ __('messages.contact') }}</a>
                    </li>
                </ul>

                {{-- Mobile panel footer --}}
                <div class="navbar__panel-foot">
                    <div class="navbar__panel-social">
                        <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    </div>
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

            <div class="navbar__tools navbar__tools--compact">
                <a href="{{ route('cart.index') }}" class="navbar__cart" aria-label="{{ __('messages.view_cart') }}">
                    <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                    @if(($cartCount ?? 0) > 0)
                        <span class="navbar__cart-badge" aria-hidden="true">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="navbar__cta">
                    {{ __('messages.get_in_touch') }}
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
    <div class="navbar__backdrop" id="navbar-backdrop" aria-hidden="true"></div>
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
        $phone  = \App\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+250 783 053 415';
        $email  = \App\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@gmac.coffee';
        $address = \App\Models\Setting::where('key', 'contact_address')->value('value') ?: 'KK 372 St, Kigali, Kicukiro, Rwanda';
        $ig = $igUrl;
        $fb = $fbUrl;
    @endphp

    <div class="container footer__grid">
        <div class="footer__brand">
            <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="footer__logo">
                <img src="{{ $logo ?: asset('images/gmac-logo.png') }}" alt="{{ $companyName }}">
            </a>
            <p class="footer__text">{{ __('messages.footer_tagline') }}</p>
            <div class="footer__social">
                <a href="{{ $ig }}" class="footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="{{ $fb }}" class="footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            </div>
        </div>

        <div>
            <h2 class="footer__h4">Coffee</h2>
            <ul class="footer__links-list">
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}">{{ __('messages.nav_shop') }}</a></li>
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/products')) }}">{{ __('messages.products') }}</a></li>
                <li><a class="footer__link" href="{{ route('cart.index') }}">{{ __('messages.cart_title') }}</a></li>
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}">{{ __('messages.contact') }}</a></li>
                <li><a class="footer__link" href="{{ route('order.find') }}">{{ __('messages.order_find_title') }}</a></li>
            </ul>
        </div>

        <div>
            <h2 class="footer__h4">Origin &amp; stories</h2>
            <ul class="footer__links-list">
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/history')) }}">{{ __('messages.history') }}</a></li>
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/washing-stations')) }}">{{ __('messages.stations') }}</a></li>
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/team')) }}">Team</a></li>
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/news')) }}">{{ __('messages.news') }}</a></li>
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/gallery')) }}">{{ __('messages.gallery') }}</a></li>
                <li><a class="footer__link" href="{{ LaravelLocalization::localizeUrl(url('/reviews')) }}">{{ __('messages.nav_reviews') }}</a></li>
            </ul>
        </div>

        <div>
            <h2 class="footer__h4">{{ __('messages.contact') }}</h2>
            <div class="footer__meta">
                <div class="footer__meta-row">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                    <span>{{ $address }}</span>
                </div>
                <div class="footer__meta-row">
                    <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                </div>
                <div class="footer__meta-row">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a>
                </div>
            </div>
            <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="footer__cta">{{ __('messages.get_in_touch') }}</a>
        </div>
    </div>

    <div class="footer__bar">
        <div class="container footer__bar-inner">
            <p>&copy; {{ date('Y') }} {{ $companyName }}. {{ __('messages.footer_rights') }}</p>
            <p>{{ __('messages.footer_tagline') }}</p>
        </div>
    </div>
</footer>

<nav class="mobile-tabbar" aria-label="{{ __('messages.quick_actions') ?? 'Mobile navigation' }}">
    <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="mobile-tabbar__item {{ request()->routeIs('home') ? 'is-active' : '' }}">
        <i class="fa-solid fa-house" aria-hidden="true"></i>
        <span>{{ __('messages.home') }}</span>
    </a>
    <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="mobile-tabbar__item {{ request()->is('*shop*') || request()->is('*products*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-mug-hot" aria-hidden="true"></i>
        <span>{{ __('messages.nav_shop') }}</span>
    </a>
    <a href="{{ route('cart.index') }}" class="mobile-tabbar__item {{ request()->routeIs('cart.*') ? 'is-active' : '' }}">
        <span class="mobile-tabbar__icon-wrap">
            <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
            @if(($cartCount ?? 0) > 0)
                <span class="mobile-tabbar__badge">{{ $cartCount }}</span>
            @endif
        </span>
        <span>{{ __('messages.view_cart') }}</span>
    </a>
    <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="mobile-tabbar__item {{ request()->is('*contact*') ? 'is-active' : '' }}">
        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
        <span>{{ __('messages.contact') }}</span>
    </a>
</nav>

@if((session('cart_success') || session('cart_error')) && !request()->routeIs('cart.index'))
    <div class="g-toast {{ session('cart_error') ? 'is-err' : 'is-ok' }}" id="g-toast" role="status">
        <p>{{ session('cart_success') ?? session('cart_error') }}</p>
        @if(session('cart_success'))
            <a href="{{ route('cart.index') }}">{{ __('messages.view_cart') }}</a>
        @endif
    </div>
@endif

<div class="site-quick-actions" aria-label="{{ __('messages.quick_actions') ?? 'Quick actions' }}">
    <div class="site-wa-stack" id="wa-fab-root">
        <button type="button"
                class="site-wa-fab"
                id="wa-fab-toggle"
                aria-expanded="false"
                aria-haspopup="dialog"
                aria-controls="wa-contact-panel"
                title="{{ __('messages.whatsapp_cta') }}"
                aria-label="{{ __('messages.whatsapp_cta') }}">
            <span class="site-wa-fab__ring" aria-hidden="true"></span>
            <span class="site-wa-fab__icon" aria-hidden="true"><i class="fa-brands fa-whatsapp"></i></span>
        </button>
        <div class="site-wa-panel" id="wa-contact-panel" role="dialog" aria-label="{{ __('messages.whatsapp_cta') }}" hidden>
            <button type="button" class="site-wa-panel__close" id="wa-fab-close" aria-label="{{ __('messages.close') }}">&times;</button>
            <p class="site-wa-panel__label">{{ __('messages.whatsapp_cta') }}</p>
            <p class="site-wa-panel__num">{{ $waDisplay }}</p>
            <a href="{{ $waHref }}" class="site-wa-panel__cta" target="_blank" rel="noopener noreferrer">{{ __('messages.open_whatsapp') }}</a>
        </div>
    </div>
    <button type="button" class="site-fab site-fab--top" id="scroll-to-top" title="{{ __('messages.scroll_top') }}" aria-label="{{ __('messages.scroll_top') }}">
        <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
    </button>
</div>

</div>{{-- /site-shell --}}
</div>{{-- /site-bg --}}

@stack('scripts')

{{-- ══════════════════════════════════════════
     GLOBAL JS — navbar scroll + mobile menu
══════════════════════════════════════════ --}}
<script>
(function () {
    /* Dark mode toggle (header + mobile drawer) */
    var html = document.documentElement;
    function setThemeIcons(theme) {
        document.querySelectorAll('.js-theme-toggle i').forEach(function (icon) {
            icon.className = theme === 'dark' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
        });
    }
    document.querySelectorAll('.js-theme-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            setThemeIcons(next);
            try { localStorage.setItem('gmac-theme', next); } catch (e) {}
        });
    });

    /* Restore saved theme */
    try {
        var saved = localStorage.getItem('gmac-theme');
        if (saved) {
            html.setAttribute('data-theme', saved);
            setThemeIcons(saved);
        }
    } catch (e) {}

    var toast = document.getElementById('g-toast');
    if (toast) {
        setTimeout(function () { toast.classList.add('is-out'); }, 4200);
    }

    function closeNavDrops(except) {
        document.querySelectorAll('.navbar__more').forEach(function (wrap) {
            if (except && wrap === except) return;
            wrap.classList.remove('is-open');
            var otherBtn = wrap.querySelector('.navbar__more-btn');
            if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
        });
    }
    document.querySelectorAll('.navbar__more').forEach(function (wrap) {
        var btn = wrap.querySelector('.navbar__more-btn');
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var willOpen = !wrap.classList.contains('is-open');
            closeNavDrops(willOpen ? wrap : null);
            wrap.classList.toggle('is-open', willOpen);
            btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        });
        wrap.addEventListener('mouseenter', function () {
            if (window.innerWidth <= 1024) return;
            closeNavDrops(wrap);
            wrap.classList.add('is-open');
            btn.setAttribute('aria-expanded', 'true');
        });
        wrap.addEventListener('mouseleave', function () {
            if (window.innerWidth <= 1024) return;
            wrap.classList.remove('is-open');
            btn.setAttribute('aria-expanded', 'false');
        });
    });
    document.addEventListener('click', function (e) {
        if (e.target.closest && e.target.closest('.navbar__more')) return;
        closeNavDrops();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeNavDrops();
    });
    if (window.innerWidth <= 1024) {
        document.querySelectorAll('.navbar__more.is-current').forEach(function (wrap) {
            wrap.classList.add('is-open');
            var currentBtn = wrap.querySelector('.navbar__more-btn');
            if (currentBtn) currentBtn.setAttribute('aria-expanded', 'true');
        });
    }

    /* Scroll to top */
    var topBtn = document.getElementById('scroll-to-top');
    if (topBtn) {
        var toggleTop = function () {
            var y = window.scrollY || document.documentElement.scrollTop || 0;
            topBtn.classList.toggle('is-visible', y > 420);
        };
        toggleTop();
        window.addEventListener('scroll', toggleTop, { passive: true });
        topBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* WhatsApp FAB: compact toggle + contact panel */
    var waRoot = document.getElementById('wa-fab-root');
    var waToggle = document.getElementById('wa-fab-toggle');
    var waPanel = document.getElementById('wa-contact-panel');
    var waClose = document.getElementById('wa-fab-close');
    if (waRoot && waToggle && waPanel) {
        function setWaOpen(open) {
            waPanel.hidden = !open;
            waToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            waToggle.classList.toggle('is-open', open);
            if (open) {
                var cta = waPanel.querySelector('.site-wa-panel__cta');
                if (cta && typeof cta.focus === 'function') {
                    try { cta.focus({ preventScroll: true }); } catch (e) { cta.focus(); }
                }
            } else {
                try { waToggle.focus(); } catch (e) {}
            }
        }
        waToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            setWaOpen(waPanel.hidden);
        });
        if (waClose) {
            waClose.addEventListener('click', function (e) {
                e.stopPropagation();
                setWaOpen(false);
            });
        }
        document.addEventListener('click', function (e) {
            if (!waPanel.hidden && !waRoot.contains(e.target)) {
                setWaOpen(false);
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !waPanel.hidden) {
                setWaOpen(false);
            }
        });
    }
})();
</script>
</body>
</html>
