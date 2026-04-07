@php
    $companyName = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
    $logo        = \App\Models\Setting::where('key', 'site_logo')->value('value');
    $navPhone    = \App\Models\Setting::where('key', 'contact_phone')->value('value');
    $navPhoneTel = $navPhone ? preg_replace('/[^\d+]/', '', $navPhone) : null;
@endphp

<nav class="gnav" id="site-navbar" aria-label="Primary navigation">

    {{-- ── Top utility strip ──────────────────────────────────────── --}}
    <div class="gnav__strip" id="gnav-strip">
        <div class="container gnav__strip-inner">
            <div class="gnav__strip-left">
                @if($navPhone)
                    <a href="tel:{{ $navPhoneTel }}" class="gnav__strip-item">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        {{ $navPhone }}
                    </a>
                @endif
                <span class="gnav__strip-item gnav__strip-item--location">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                    Rwamagana, Eastern Province, Rwanda
                </span>
            </div>
            <div class="gnav__strip-right">
                {{-- Language switcher slot --}}
                @if(count(LaravelLocalization::getSupportedLocales()) > 1)
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                           class="gnav__strip-lang {{ App::getLocale() === $localeCode ? 'is-active' : '' }}">
                            {{ strtoupper($localeCode) }}
                        </a>
                    @endforeach
                @endif
                <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="gnav__strip-cta">
                    <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                    {{ __('messages.get_in_touch') ?? 'Get in touch' }}
                </a>
            </div>
        </div>
    </div>

    {{-- ── Main bar ────────────────────────────────────────────────── --}}
    <div class="gnav__bar" id="gnav-bar">
        <div class="container gnav__bar-inner">

            {{-- Brand --}}
            <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="gnav__brand" aria-label="{{ $companyName }} — Home">
                @if($logo)
                    <img src="{{ $logo }}" alt="{{ $companyName }}" class="gnav__logo">
                @else
                    <img src="{{ asset('images/gmac-logo.png') }}" alt="{{ $companyName }}" class="gnav__logo">
                @endif
                <span class="gnav__brand-wordmark">{{ $companyName }}</span>
            </a>

            {{-- Desktop links --}}
            <ul class="gnav__links" role="list">
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/')) }}"
                       class="gnav__link {{ request()->is('/') || request()->is(App::getLocale()) || request()->is(App::getLocale().'/') ? 'is-active' : '' }}">
                    {{ __('messages.home') }}
                </a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}"
                       class="gnav__link {{ request()->is('*history*') ? 'is-active' : '' }}">
                    {{ __('messages.history') }}
                </a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}"
                       class="gnav__link {{ request()->is('*shop*') || request()->is('*products*') ? 'is-active' : '' }}">
                    {{ __('messages.nav_shop') }}
                </a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/news')) }}"
                       class="gnav__link {{ request()->is('*news*') ? 'is-active' : '' }}">
                    {{ __('messages.news') }}
                </a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/gallery')) }}"
                       class="gnav__link {{ request()->is('*gallery*') ? 'is-active' : '' }}">
                    {{ __('messages.gallery') }}
                </a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/washing-stations')) }}"
                       class="gnav__link {{ request()->is('*washing-stations*') ? 'is-active' : '' }}">
                    {{ __('messages.stations') }}
                </a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/team')) }}"
                       class="gnav__link {{ request()->is('*team*') ? 'is-active' : '' }}">
                    Team
                </a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}"
                       class="gnav__link {{ request()->is('*contact*') ? 'is-active' : '' }}">
                    {{ __('messages.contact') }}
                </a></li>
            </ul>

            {{-- Desktop CTA --}}
            <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="gnav__shop-btn">
                <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                {{ __('messages.nav_shop') }}
            </a>

            {{-- Burger --}}
            <button type="button" class="gnav__burger" id="gnav-burger"
                    aria-label="Open menu" aria-expanded="false" aria-controls="gnav-drawer">
                <span class="gnav__burger-bar" aria-hidden="true"></span>
                <span class="gnav__burger-bar" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    {{-- ── Mobile drawer ───────────────────────────────────────────── --}}
    <div class="gnav__backdrop" id="gnav-backdrop" aria-hidden="true"></div>

    <div class="gnav__drawer" id="gnav-drawer" aria-hidden="true">
        <div class="gnav__drawer-head">
            <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="gnav__brand" aria-label="{{ $companyName }}">
                @if($logo)
                    <img src="{{ $logo }}" alt="{{ $companyName }}" class="gnav__logo">
                @else
                    <img src="{{ asset('images/gmac-logo.png') }}" alt="{{ $companyName }}" class="gnav__logo">
                @endif
            </a>
            <button type="button" class="gnav__drawer-close" id="gnav-close" aria-label="Close menu">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <ul class="gnav__drawer-links" role="list">
            <li><a href="{{ LaravelLocalization::localizeUrl(url('/')) }}"       class="gnav__drawer-link {{ request()->is('/') ? 'is-active' : '' }}">{{ __('messages.home') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="gnav__drawer-link {{ request()->is('*history*') ? 'is-active' : '' }}">{{ __('messages.history') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}"    class="gnav__drawer-link {{ request()->is('*shop*') || request()->is('*products*') ? 'is-active' : '' }}">{{ __('messages.nav_shop') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeUrl(url('/news')) }}"    class="gnav__drawer-link {{ request()->is('*news*') ? 'is-active' : '' }}">{{ __('messages.news') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeUrl(url('/gallery')) }}" class="gnav__drawer-link {{ request()->is('*gallery*') ? 'is-active' : '' }}">{{ __('messages.gallery') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeUrl(url('/washing-stations')) }}" class="gnav__drawer-link {{ request()->is('*washing-stations*') ? 'is-active' : '' }}">{{ __('messages.stations') }}</a></li>
            <li><a href="{{ LaravelLocalization::localizeUrl(url('/team')) }}"    class="gnav__drawer-link {{ request()->is('*team*') ? 'is-active' : '' }}">Team</a></li>
            <li><a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="gnav__drawer-link {{ request()->is('*contact*') ? 'is-active' : '' }}">{{ __('messages.contact') }}</a></li>
        </ul>

        <div class="gnav__drawer-foot">
            @if($navPhone)
                <a href="tel:{{ $navPhoneTel }}" class="gnav__drawer-phone">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    {{ $navPhone }}
                </a>
            @endif
            <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="gnav__drawer-cta">
                {{ __('messages.nav_shop') }}
            </a>
        </div>
    </div>
</nav>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,400&family=DM+Sans:wght@300;400;500&display=swap');

/* ── Tokens ─────────────────────────────────────────────────────── */
:root {
    --gnav-forest:    #1f5a44;
    --gnav-ink:       #183126;
    --gnav-parchment: #ffffff;
    --gnav-gold:      var(--clr-gold, #1f9d6a);
    --gnav-gold-lt:   #73caa2;
    --gnav-gold-dk:   #167650;
    --gnav-display:   'Cormorant Garamond', Georgia, serif;
    --gnav-body:      'DM Sans', sans-serif;
    --gnav-ease:      cubic-bezier(0.16, 1, 0.3, 1);
    --gnav-strip-h:   34px;
    --gnav-bar-h:     66px;
    --gnav-total-h:   calc(var(--gnav-strip-h) + var(--gnav-bar-h));
}

/* ── LAYOUT: hero must bleed under navbar ───────────────────────
   Remove any body padding-top or spacer divs from your layout.
   Instead, offset just the sections that need it (non-hero pages):

   In your frontend.blade.php layout, do NOT add padding-top to body.
   For pages that DON'T have a full-bleed hero (use page-hero partial),
   the page-hero already has enough top padding built in.
   For the homepage gh-hero, it fills 100vh so it naturally covers the nav.

   If you have a <div class="content-wrapper"> or similar in layout.blade.php
   that adds margin/padding-top, remove it or set it to 0.
────────────────────────────────────────────────────────────────── */

/* Non-hero pages: keep the hero close to the header without colliding with it */
.ph-hero { padding-top: calc(var(--gnav-total-h) + 20px); }

/* ── NAV root ───────────────────────────────────────────────────── */
.gnav {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 9000;
}

/* ── STRIP ──────────────────────────────────────────────────────── */
.gnav__strip {
    height: var(--gnav-strip-h);
    background: rgba(255,255,255,0.82);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(24,49,38,0.08);
    overflow: hidden;
    max-height: var(--gnav-strip-h);
    transition: max-height 0.38s var(--gnav-ease), opacity 0.28s ease;
}
.gnav.is-scrolled .gnav__strip {
    max-height: 0;
    opacity: 0;
    pointer-events: none;
}
.gnav__strip-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    gap: 16px;
}
.gnav__strip-left,
.gnav__strip-right {
    display: flex;
    align-items: center;
    gap: 20px;
}
.gnav__strip-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--gnav-body);
    font-size: 0.65rem;
    font-weight: 400;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(24,49,38,0.62);
    text-decoration: none;
    transition: color 0.2s;
}
.gnav__strip-item:hover { color: var(--gnav-gold-dk); }
.gnav__strip-item--location { display: none; }
@media (min-width: 1024px) { .gnav__strip-item--location { display: inline-flex; } }
.gnav__strip-lang {
    font-family: var(--gnav-body);
    font-size: 0.62rem;
    font-weight: 500;
    letter-spacing: 0.16em;
    color: rgba(24,49,38,0.42);
    text-decoration: none;
    transition: color 0.2s;
    padding: 2px 4px;
}
.gnav__strip-lang.is-active,
.gnav__strip-lang:hover { color: var(--gnav-gold-dk); }
.gnav__strip-cta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--gnav-body);
    font-size: 0.62rem;
    font-weight: 500;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--gnav-gold-dk);
    text-decoration: none;
    border: 1px solid rgba(31,157,106,0.18);
    padding: 4px 12px;
    transition: background 0.2s, border-color 0.2s, color 0.2s;
}
.gnav__strip-cta:hover { background: rgba(31,157,106,0.08); border-color: rgba(31,157,106,0.32); }

/* ── MAIN BAR ───────────────────────────────────────────────────── */
.gnav__bar {
    height: var(--gnav-bar-h);
    background: rgba(255,255,255,0.92) !important;
    border-bottom: 1px solid rgba(24,49,38,0.08);
    transition: background 0.45s var(--gnav-ease),
                box-shadow 0.45s var(--gnav-ease),
                border-color 0.45s ease;
}
.gnav.is-scrolled .gnav__bar {
    background: rgba(255,255,255,0.97) !important;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 14px 36px rgba(18,59,47,0.08);
    border-bottom-color: rgba(24,49,38,0.08);
}

.gnav__bar-inner {
    display: flex;
    align-items: center;
    height: 100%;
    gap: 0;
}

/* ── BRAND ──────────────────────────────────────────────────────── */
.gnav__brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    flex-shrink: 0;
    margin-right: auto;
}
.gnav__logo {
    height: 38px;
    width: auto;
    display: block;
    object-fit: contain;
    filter: none;
    transition: opacity 0.35s ease;
}
.gnav__brand-wordmark {
    font-family: var(--gnav-display);
    font-size: 1.18rem;
    font-weight: 300;
    letter-spacing: 0.08em;
    color: var(--gnav-ink);
    white-space: nowrap;
    /* Hide on small screens */
    display: none;
}
@media (min-width: 1100px) { .gnav__brand-wordmark { display: block; } }

/* ── DESKTOP LINKS ──────────────────────────────────────────────── */
.gnav__links {
    display: none;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 0;
    align-items: center;
    height: 100%;
}
@media (min-width: 960px) {
    .gnav__links {
        display: flex;
        margin: 0 auto;
    }
}
.gnav__link {
    display: flex;
    align-items: center;
    height: 100%;
    padding: 0 14px;
    font-family: var(--gnav-body);
    font-size: 0.72rem;
    font-weight: 400;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: rgba(24,49,38,0.68);
    text-decoration: none;
    position: relative;
    transition: color 0.22s;
    white-space: nowrap;
}
.gnav__link::after {
    content: '';
    position: absolute;
    bottom: 0; left: 14px; right: 14px;
    height: 2px;
    background: var(--gnav-gold);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.28s var(--gnav-ease);
}
.gnav__link:hover { color: var(--gnav-ink); }
.gnav__link:hover::after,
.gnav__link.is-active::after { transform: scaleX(1); }
.gnav__link.is-active { color: var(--gnav-gold-dk); }

/* ── SHOP CTA BUTTON ────────────────────────────────────────────── */
.gnav__shop-btn {
    display: none;
    align-items: center;
    gap: 7px;
    margin-left: 20px;
    padding: 9px 20px;
    background: linear-gradient(135deg, var(--gnav-gold) 0%, #39b57f 100%);
    color: #ffffff;
    font-family: var(--gnav-body);
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    text-decoration: none;
    border: none;
    flex-shrink: 0;
    transition: background 0.22s, transform 0.22s var(--gnav-ease);
    box-shadow: 0 12px 28px rgba(31,157,106,0.18);
}
.gnav__shop-btn:hover {
    background: linear-gradient(135deg, var(--gnav-gold-dk) 0%, var(--gnav-gold) 100%);
    transform: translateY(-1px);
}
@media (min-width: 960px) { .gnav__shop-btn { display: inline-flex; } }

/* ── BURGER ─────────────────────────────────────────────────────── */
.gnav__burger {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 40px;
    height: 40px;
    background: rgba(31,157,106,0.06);
    border: 1px solid rgba(24,49,38,0.1);
    padding: 0 10px;
    cursor: pointer;
    margin-left: 12px;
    transition: border-color 0.2s;
    flex-shrink: 0;
}
.gnav__burger:hover { border-color: rgba(31,157,106,0.26); }
@media (min-width: 960px) { .gnav__burger { display: none; } }

.gnav__burger-bar {
    display: block;
    width: 100%;
    height: 1.5px;
    background: rgba(24,49,38,0.82);
    border-radius: 1px;
    transition: transform 0.32s var(--gnav-ease), opacity 0.2s;
    transform-origin: center;
}
/* X state */
.gnav__burger.is-open .gnav__burger-bar:nth-child(1) { transform: translateY(3.25px) rotate(45deg); }
.gnav__burger.is-open .gnav__burger-bar:nth-child(2) { transform: translateY(-3.25px) rotate(-45deg); }

/* ── BACKDROP ───────────────────────────────────────────────────── */
.gnav__backdrop {
    position: fixed;
    inset: 0;
    background: rgba(18,49,38,0.2);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    z-index: 8998;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.35s ease;
}
.gnav__backdrop.is-open {
    opacity: 1;
    pointer-events: auto;
}

/* ── DRAWER ─────────────────────────────────────────────────────── */
.gnav__drawer {
    position: fixed;
    top: 0; right: 0; bottom: 0;
    width: min(340px, 88vw);
    z-index: 8999;
    background: #ffffff;
    border-left: 1px solid rgba(24,49,38,0.08);
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.42s var(--gnav-ease);
    overflow-y: auto;
}
.gnav__drawer.is-open {
    transform: translateX(0);
}

.gnav__drawer-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid rgba(24,49,38,0.08);
    flex-shrink: 0;
}
.gnav__drawer-head .gnav__logo { height: 32px; }

.gnav__drawer-close {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    background: transparent;
    border: 1px solid rgba(24,49,38,0.12);
    color: rgba(24,49,38,0.58);
    font-size: 1rem;
    cursor: pointer;
    transition: border-color 0.2s, color 0.2s;
}
.gnav__drawer-close:hover { border-color: rgba(31,157,106,0.3); color: var(--gnav-gold-dk); }

.gnav__drawer-links {
    list-style: none;
    margin: 0;
    padding: 16px 0;
    flex: 1;
}
.gnav__drawer-link {
    display: flex;
    align-items: center;
    padding: 14px 28px;
    font-family: var(--gnav-body);
    font-size: 0.80rem;
    font-weight: 400;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: rgba(24,49,38,0.68);
    text-decoration: none;
    border-left: 2px solid transparent;
    transition: color 0.2s, border-color 0.2s, background 0.2s;
    position: relative;
}
.gnav__drawer-link:hover {
    color: var(--gnav-ink);
    background: rgba(31,157,106,0.06);
    border-left-color: rgba(31,157,106,0.24);
}
.gnav__drawer-link.is-active {
    color: var(--gnav-gold-dk);
    border-left-color: var(--gnav-gold);
    background: rgba(31,157,106,0.08);
}

/* Staggered slide-in for drawer items */
.gnav__drawer.is-open .gnav__drawer-link {
    animation: gnav-drawer-item-in 0.45s var(--gnav-ease) both;
}
.gnav__drawer-links li:nth-child(1)  .gnav__drawer-link { animation-delay: 0.05s; }
.gnav__drawer-links li:nth-child(2)  .gnav__drawer-link { animation-delay: 0.10s; }
.gnav__drawer-links li:nth-child(3)  .gnav__drawer-link { animation-delay: 0.14s; }
.gnav__drawer-links li:nth-child(4)  .gnav__drawer-link { animation-delay: 0.18s; }
.gnav__drawer-links li:nth-child(5)  .gnav__drawer-link { animation-delay: 0.22s; }
.gnav__drawer-links li:nth-child(6)  .gnav__drawer-link { animation-delay: 0.26s; }
.gnav__drawer-links li:nth-child(7)  .gnav__drawer-link { animation-delay: 0.30s; }
.gnav__drawer-links li:nth-child(8)  .gnav__drawer-link { animation-delay: 0.34s; }
@keyframes gnav-drawer-item-in {
    from { opacity: 0; transform: translateX(14px); }
    to   { opacity: 1; transform: translateX(0); }
}

.gnav__drawer-foot {
    padding: 24px;
    border-top: 1px solid rgba(24,49,38,0.08);
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex-shrink: 0;
}
.gnav__drawer-phone {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--gnav-body);
    font-size: 0.80rem;
    font-weight: 400;
    color: rgba(24,49,38,0.58);
    text-decoration: none;
    letter-spacing: 0.05em;
    transition: color 0.2s;
}
.gnav__drawer-phone:hover { color: var(--gnav-gold-dk); }
.gnav__drawer-cta {
    display: block;
    text-align: center;
    padding: 13px 20px;
    background: linear-gradient(135deg, var(--gnav-gold) 0%, #39b57f 100%);
    color: #ffffff;
    font-family: var(--gnav-body);
    font-size: 0.72rem;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    text-decoration: none;
    transition: background 0.22s;
}
.gnav__drawer-cta:hover { background: linear-gradient(135deg, var(--gnav-gold-dk) 0%, var(--gnav-gold) 100%); }
</style>

<script>
(function () {
    'use strict';

    var nav      = document.getElementById('site-navbar');
    var bar      = document.getElementById('gnav-bar');
    var burger   = document.getElementById('gnav-burger');
    var drawer   = document.getElementById('gnav-drawer');
    var backdrop = document.getElementById('gnav-backdrop');
    var closeBtn = document.getElementById('gnav-close');
    var SCROLL_THRESHOLD = 10;

    /* ── Scroll: transparent → solid ─────────────────────────── */
    function onScroll() {
        if (window.scrollY > SCROLL_THRESHOLD) {
            nav.classList.add('is-scrolled');
        } else {
            nav.classList.remove('is-scrolled');
        }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // run once on load

    /* ── Drawer open / close ──────────────────────────────────── */
    function openDrawer() {
        drawer.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
        backdrop.classList.add('is-open');
        burger.classList.add('is-open');
        burger.setAttribute('aria-expanded', 'true');
        burger.setAttribute('aria-label', 'Close menu');
        document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
        drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        backdrop.classList.remove('is-open');
        burger.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
        burger.setAttribute('aria-label', 'Open menu');
        document.body.style.overflow = '';
    }

    burger.addEventListener('click', function () {
        drawer.classList.contains('is-open') ? closeDrawer() : openDrawer();
    });
    backdrop.addEventListener('click', closeDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);

    /* Close on Escape */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer.classList.contains('is-open')) closeDrawer();
    });

    /* ── Close drawer on nav link click (SPA / anchor) ───────── */
    drawer.querySelectorAll('.gnav__drawer-link').forEach(function (link) {
        link.addEventListener('click', closeDrawer);
    });
})();
</script>
