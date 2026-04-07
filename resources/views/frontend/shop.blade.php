@extends('layouts.frontend')

@section('title', 'Shop - GMAC Coffee')
@section('meta_description', 'Browse and shop premium Rwandan coffee products from GMAC.')

@section('content')
@include('partials.frontend.page-hero', [
    'title'   => __('messages.products'),
    'subtitle'=> __('messages.slogan'),
    'eyebrow' => 'GMAC Coffee',
])

{{-- ══════════════════════════════════════════
     SHOP BODY
══════════════════════════════════════════ --}}
<section class="sp-section">
    <div class="container">

        {{-- ── Toolbar: count + filters ─────────────────────────── --}}
        <div class="sp-toolbar gh-reveal">
            <div class="sp-toolbar__left">
                <div class="gh-eyebrow">
                    <span class="gh-eyebrow__line"></span>
                    {{ __('messages.products') }}
                </div>
                <h2 class="sp-toolbar__heading">
                    Our finest <em>selections.</em>
                </h2>
            </div>

            <div class="sp-toolbar__right">
                <div class="sp-filters" id="sp-filters" role="group" aria-label="Filter by category">
                    <button class="sp-filter is-active" data-category="all" aria-pressed="true">
                        <span>{{ __('messages.all_products') }}</span>
                        <span class="sp-filter__count" id="sp-count-all">{{ $products->count() }}</span>
                    </button>
                    @foreach($categories as $category)
                        <button class="sp-filter" data-category="cat-{{ $category->id }}" aria-pressed="false">
                            <span>{{ $category->name }}</span>
                            <span class="sp-filter__count">{{ $products->where('product_category_id', $category->id)->count() }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Product grid ─────────────────────────────────────── --}}
        <div class="sp-grid" id="sp-grid">
            @forelse($products as $i => $product)
            <article
                class="sp-card gh-reveal filter-item cat-{{ $product->product_category_id }}"
                style="--reveal-delay: {{ ($i % 4) * 0.08 }}s"
                data-category="cat-{{ $product->product_category_id }}"
            >
                {{-- Image --}}
                <a href="{{ route('products.show', $product->slug) }}" class="sp-card__img-wrap" tabindex="-1" aria-hidden="true">
                    @if($product->hasMedia('cover'))
                        <img
                            src="{{ $product->getFirstMediaUrl('cover', 'thumb') ?: $product->getFirstMediaUrl('cover') }}"
                            alt="{{ $product->name }}"
                            class="sp-card__img"
                            loading="lazy"
                        >
                    @else
                        <div class="sp-card__ph" aria-hidden="true">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                    @endif

                    {{-- Hover overlay --}}
                    <div class="sp-card__overlay" aria-hidden="true">
                        <span class="sp-card__overlay-label">{{ __('messages.details') }}</span>
                    </div>

                    {{-- Category badge on image --}}
                    <div class="sp-card__badge">{{ $product->category->name ?? 'Specialty' }}</div>
                </a>

                {{-- Body --}}
                <div class="sp-card__body">
                    <h3 class="sp-card__name">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    <p class="sp-card__excerpt">
                        {{ $product->short_description ?? Str::limit(strip_tags($product->description), 100) }}
                    </p>

                    <div class="sp-card__foot">
                        @if($product->price)
                            <span class="sp-card__price">${{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="sp-card__price sp-card__price--inquiry">{{ __('messages.contact') }}</span>
                        @endif
                        <a href="{{ route('products.show', $product->slug) }}" class="sp-card__cta">
                            {{ __('messages.read_more') }}
                            <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="sp-empty">
                <i class="fa-solid fa-mug-hot sp-empty__icon" aria-hidden="true"></i>
                <p class="sp-empty__text">No products found at the moment. Please check back later.</p>
            </div>
            @endforelse
        </div>

        {{-- No-results message (shown by JS when filter yields 0) --}}
        <div class="sp-no-results" id="sp-no-results" aria-live="polite" hidden>
            <i class="fa-solid fa-filter sp-no-results__icon" aria-hidden="true"></i>
            <p>No products in this category.</p>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     CTA — same as homepage
══════════════════════════════════════════ --}}
<section class="gh-cta">
    <div class="container">
        <div class="gh-cta__inner gh-reveal">
            <div class="gh-cta__label">Wholesale &amp; Export</div>
            <h2 class="gh-cta__h2">Interested in <em>bulk orders?</em></h2>
            <p class="gh-cta__sub">We work with importers, roasters, and specialty buyers worldwide. Get in touch for export pricing and availability.</p>
            <div class="gh-cta__btns">
                <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="gh-btn gh-btn--gold">Contact Us</a>
                <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="gh-btn gh-btn--outline-light">Our Story</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap');

:root {
    --gh-forest:   #234535;
    --gh-ink:      #21160f;
    --gh-parchment:#efe2cf;
    --gh-cream:    #e7dac4;
    --gh-gold:     var(--clr-gold, #c08b30);
    --gh-gold-dk:  #8a6320;
    --gh-gold-lt:  #d8b76b;
    --gh-display:  'Cormorant Garamond', Georgia, serif;
    --gh-body:     'DM Sans', var(--font-body, sans-serif);
    --gh-ease:     cubic-bezier(0.16, 1, 0.3, 1);
}
[data-theme="dark"] {
    --gh-parchment: #1a1008;
    --gh-cream:     #120d07;
    --gh-ink:       #f6f0e6;
}

/* ── Shared ──────────────────────────────────────────────────────── */
.gh-reveal {
    opacity: 0; transform: translateY(28px);
    transition: opacity 0.75s var(--gh-ease), transform 0.75s var(--gh-ease);
    transition-delay: var(--reveal-delay, 0s);
}
.gh-reveal.is-visible { opacity: 1; transform: none; }

.gh-eyebrow {
    display: flex; align-items: center; gap: 10px;
    font-family: var(--gh-body); font-size: 0.72rem; font-weight: 500;
    letter-spacing: 0.22em; text-transform: uppercase;
    color: var(--gh-gold-dk); margin-bottom: 10px;
}
.gh-eyebrow__line { display: block; width: 28px; height: 1px; background: currentColor; flex-shrink: 0; }

.gh-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 28px; font-family: var(--gh-body);
    font-size: 0.75rem; font-weight: 500;
    letter-spacing: 0.15em; text-transform: uppercase;
    text-decoration: none; border: none; cursor: pointer;
    transition: background 0.22s, color 0.22s, border-color 0.22s, transform 0.22s var(--gh-ease);
}
.gh-btn:hover { transform: translateY(-2px); }
.gh-btn--gold { background: var(--gh-gold); color: var(--gh-ink); }
.gh-btn--gold:hover { background: var(--gh-gold-lt); color: var(--gh-ink); }
.gh-btn--outline-light { background: transparent; color: var(--gh-parchment); border: 1px solid rgba(246,240,230,0.25); }
.gh-btn--outline-light:hover { border-color: var(--gh-gold-lt); color: var(--gh-gold-lt); }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   SECTION SHELL
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.sp-section {
    padding: 72px 0 100px;
    background:
        radial-gradient(800px 340px at 15% 0%, rgba(31,157,106,0.08), transparent 60%),
        radial-gradient(760px 320px at 85% 100%, rgba(138,99,32,0.1), transparent 60%),
        linear-gradient(180deg, #f1e7d7 0%, #e8dbc6 100%);
    position: relative;
}
[data-theme="dark"] .sp-section { background: var(--gh-cream); }

/* Ghost watermark */
.sp-section::before {
    content: 'SHOP';
    position: absolute; top: 60px; right: -20px;
    font-family: var(--gh-display);
    font-size: clamp(80px, 12vw, 160px);
    font-weight: 600;
    color: rgba(138,99,32,0.06);
    letter-spacing: 0.1em;
    pointer-events: none; user-select: none;
    white-space: nowrap;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   TOOLBAR
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.sp-toolbar {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 32px;
    flex-wrap: wrap;
    margin-bottom: 52px;
}
.sp-toolbar__heading {
    font-family: var(--gh-display);
    font-size: clamp(2rem, 3.2vw, 3rem);
    font-weight: 300;
    line-height: 1.06;
    color: var(--clr-deep-espresso, #1a1008);
    margin: 0;
}
[data-theme="dark"] .sp-toolbar__heading { color: var(--clr-text); }
.sp-toolbar__heading em { font-style: italic; color: var(--gh-forest); }
[data-theme="dark"] .sp-toolbar__heading em { color: var(--gh-gold-lt); }

/* ── Filter buttons ──────────────────────────────────────────────── */
.sp-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}
.sp-filter {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    font-family: var(--gh-body);
    font-size: 0.70rem;
    font-weight: 500;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--clr-text-muted, #6b7280);
    background: rgba(244,236,223,0.9);
    border: 1px solid rgba(10,26,18,0.10);
    cursor: pointer;
    transition: background 0.22s, border-color 0.22s, color 0.22s, transform 0.22s var(--gh-ease), box-shadow 0.22s;
    position: relative;
    white-space: nowrap;
}
.sp-filter::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 2px;
    background: var(--gh-gold);
    transform: scaleX(0);
    transition: transform 0.28s var(--gh-ease);
}
.sp-filter:hover {
    background: rgba(250,244,235,0.98);
    border-color: rgba(192,139,48,0.25);
    color: var(--gh-gold-dk);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(26,16,8,0.07);
}
.sp-filter.is-active {
    background: linear-gradient(135deg, #234535 0%, #1a3327 100%);
    border-color: #234535;
    color: #f4ecdf;
    box-shadow: 0 12px 30px rgba(35,69,53,0.24);
}
.sp-filter.is-active::after { transform: scaleX(1); }

[data-theme="dark"] .sp-filter {
    background: rgba(246,251,248,0.06);
    border-color: rgba(246,251,248,0.10);
    color: rgba(199,214,205,0.75);
}
[data-theme="dark"] .sp-filter:hover {
    background: rgba(246,251,248,0.10);
    border-color: rgba(232,201,122,0.28);
    color: var(--gh-gold-lt);
}
[data-theme="dark"] .sp-filter.is-active {
    background: rgba(30,64,48,0.65);
    border-color: rgba(232,201,122,0.35);
    color: var(--gh-parchment);
}

.sp-filter__count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 5px;
    border-radius: 999px;
    background: rgba(192,139,48,0.12);
    color: var(--gh-gold-dk);
    font-size: 0.60rem;
    font-weight: 700;
    letter-spacing: 0;
    line-height: 1;
    transition: background 0.22s, color 0.22s;
}
.sp-filter.is-active .sp-filter__count {
    background: rgba(246,240,230,0.20);
    color: var(--gh-gold-lt);
}
[data-theme="dark"] .sp-filter__count { color: var(--gh-gold-lt); background: rgba(232,201,122,0.10); }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   PRODUCT GRID
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.sp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 28px;
}

/* ── Card ───────────────────────────────────────────────────────── */
.sp-card {
    background:
        radial-gradient(320px 140px at 100% 0%, rgba(31,157,106,0.08), transparent 60%),
        linear-gradient(180deg, rgba(244,236,223,0.94) 0%, rgba(239,226,207,0.96) 100%);
    border: 1px solid rgba(192,139,48,0.10);
    border-radius: 28px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.40s var(--gh-ease), box-shadow 0.40s var(--gh-ease);
    /* Filter hide animation */
    transition: transform 0.40s var(--gh-ease), box-shadow 0.40s var(--gh-ease), opacity 0.3s ease;
}
.sp-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 28px 56px rgba(26,16,8,0.12);
    border-color: rgba(31,157,106,0.18);
}
[data-theme="dark"] .sp-card {
    background: rgba(246,251,248,0.04);
    border-color: rgba(246,251,248,0.08);
}

/* Image wrap */
.sp-card__img-wrap {
    display: block;
    position: relative;
    height: 260px;
    overflow: hidden;
    background: linear-gradient(180deg, #dfe8df 0%, #d4dfd5 100%);
    text-decoration: none;
    flex-shrink: 0;
}
.sp-card__img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
    transition: transform 0.65s var(--gh-ease), filter 0.4s ease;
    filter: saturate(0.92);
}
.sp-card:hover .sp-card__img {
    transform: scale(1.06);
    filter: saturate(1.05);
}
.sp-card__ph {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem;
    color: rgba(192,139,48,0.28);
    background: linear-gradient(160deg, #1e4030 0%, #0d2018 55%, #261200 100%);
}

/* Overlay on hover */
.sp-card__overlay {
    position: absolute; inset: 0;
    background: rgba(26,16,8,0);
    display: flex; align-items: center; justify-content: center;
    transition: background 0.35s ease;
}
.sp-card:hover .sp-card__overlay { background: rgba(26,16,8,0.35); }
.sp-card__overlay-label {
    font-family: var(--gh-body);
    font-size: 0.68rem; font-weight: 500;
    letter-spacing: 0.22em; text-transform: uppercase;
    color: var(--gh-parchment);
    border: 1px solid rgba(246,240,230,0.55);
    padding: 9px 22px;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s var(--gh-ease);
}
.sp-card:hover .sp-card__overlay-label { opacity: 1; transform: none; }

/* Category badge on image */
.sp-card__badge {
    position: absolute;
    top: 16px; left: 0;
    background: rgba(244,236,223,0.96);
    border-top: 2px solid var(--gh-gold);
    padding: 5px 14px 5px 12px;
    font-family: var(--gh-body);
    font-size: 0.60rem; font-weight: 600;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--gh-gold-dk);
    z-index: 2;
}
[data-theme="dark"] .sp-card__badge { background: #1a1008; color: var(--gh-gold-lt); }

/* Body */
.sp-card__body {
    padding: 20px 22px 22px;
    border-top: 1px solid rgba(192,139,48,0.10);
    display: flex; flex-direction: column; flex: 1;
}
.sp-card__name {
    font-family: var(--gh-display);
    font-size: 1.35rem; font-weight: 400;
    line-height: 1.18;
    color: var(--clr-deep-espresso, #1a1008);
    margin: 0 0 8px;
}
[data-theme="dark"] .sp-card__name { color: var(--clr-text); }
.sp-card__name a { color: inherit; text-decoration: none; transition: color 0.2s; }
.sp-card__name a:hover { color: var(--gh-forest); }
[data-theme="dark"] .sp-card__name a:hover { color: var(--gh-gold-lt); }

.sp-card__excerpt {
    font-family: var(--gh-body);
    font-size: 0.88rem; font-weight: 300; line-height: 1.70;
    color: rgba(24,49,38,0.72);
    margin: 0 0 16px;
    flex: 1;
}
[data-theme="dark"] .sp-card__excerpt { color: rgba(199,214,205,0.75); }

.sp-card__foot {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid rgba(192,139,48,0.08);
}
.sp-card__price {
    font-family: var(--gh-display);
    font-size: 1.25rem; font-weight: 400;
    color: #234535;
    line-height: 1;
}
[data-theme="dark"] .sp-card__price { color: var(--clr-text); }
.sp-card__price--inquiry {
    font-family: var(--gh-body);
    font-size: 0.68rem; font-weight: 500;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--gh-gold-dk);
}
[data-theme="dark"] .sp-card__price--inquiry { color: var(--gh-gold-lt); }

.sp-card__cta {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: var(--gh-body);
    font-size: 0.68rem; font-weight: 500;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--gh-gold-dk);
    text-decoration: none;
    border-bottom: 1px solid rgba(138,95,20,0.28);
    padding-bottom: 1px;
    transition: color 0.2s, border-color 0.2s, gap 0.2s;
    white-space: nowrap;
}
.sp-card__cta:hover { color: var(--gh-forest); border-color: var(--gh-forest); gap: 9px; }
[data-theme="dark"] .sp-card__cta { color: var(--gh-gold-lt); border-color: rgba(232,201,122,0.28); }
[data-theme="dark"] .sp-card__cta:hover { color: var(--gh-gold-lt); border-color: var(--gh-gold-lt); }

/* ── Empty / no-results ─────────────────────────────────────────── */
.sp-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    display: flex; flex-direction: column; align-items: center; gap: 18px;
}
.sp-empty__icon { font-size: 3rem; color: rgba(192,139,48,0.25); }
.sp-empty__text { font-family: var(--gh-body); font-size: 1rem; color: var(--clr-text-muted); }

.sp-no-results {
    text-align: center;
    padding: 60px 20px;
    display: flex; flex-direction: column; align-items: center; gap: 14px;
}
.sp-no-results[hidden] { display: none; }
.sp-no-results__icon { font-size: 2.4rem; color: rgba(192,139,48,0.22); }
.sp-no-results p { font-family: var(--gh-body); color: var(--clr-text-muted); font-size: 0.95rem; }

/* ── Filter hide/show animation ─────────────────────────────────── */
.sp-card.is-hidden {
    opacity: 0;
    pointer-events: none;
    position: absolute;
    visibility: hidden;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   CTA (shared from homepage)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.gh-cta { padding: 120px 0; background: var(--gh-ink); position: relative; overflow: hidden; }
[data-theme="dark"] .gh-cta { background: #0f0a05; }
.gh-cta::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse 80% 55% at 50% 0%, rgba(192,139,48,0.1), transparent 70%); pointer-events: none; }
.gh-cta__inner { position: relative; z-index: 1; text-align: center; max-width: 680px; margin: 0 auto; }
.gh-cta__label { font-family: var(--gh-body); font-size: 0.68rem; font-weight: 500; letter-spacing: 0.24em; text-transform: uppercase; color: var(--gh-gold); margin-bottom: 20px; display: flex; align-items: center; justify-content: center; gap: 12px; }
.gh-cta__label::before, .gh-cta__label::after { content: ''; display: block; width: 28px; height: 1px; background: var(--gh-gold); }
.gh-cta__h2 { font-family: var(--gh-display); font-size: clamp(2.8rem, 5vw, 4.4rem); font-weight: 300; line-height: 1.04; color: var(--gh-parchment); margin-bottom: 16px; }
.gh-cta__h2 em { font-style: italic; color: var(--gh-gold-lt); }
.gh-cta__sub { font-family: var(--gh-body); font-size: 0.95rem; font-weight: 300; color: rgba(246,240,230,0.46); line-height: 1.8; margin-bottom: 44px; max-width: 50ch; margin-left: auto; margin-right: auto; }
.gh-cta__btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

/* ── Responsive ─────────────────────────────────────────────────── */
@media (max-width: 860px) {
    .sp-toolbar { flex-direction: column; align-items: flex-start; }
    .sp-toolbar__right { width: 100%; }
    .sp-filters { gap: 6px; }
    .sp-section { padding: 52px 0 72px; }
    .sp-grid { grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; }
}
@media (max-width: 520px) {
    .sp-grid { grid-template-columns: 1fr; }
    .sp-card__img-wrap { height: 220px; }
}
</style>

<script>
(function () {
    'use strict';

    /* ── Scroll reveal ──────────────────────────────────────────── */
    var revEls = document.querySelectorAll('.gh-reveal');
    var revIO  = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('is-visible'); revIO.unobserve(e.target); }
        });
    }, { threshold: 0.08 });
    revEls.forEach(function (el) { revIO.observe(el); });

    /* ── Filter logic ───────────────────────────────────────────── */
    var filterBar  = document.getElementById('sp-filters');
    var grid       = document.getElementById('sp-grid');
    var noResults  = document.getElementById('sp-no-results');
    if (!filterBar || !grid) return;

    var buttons = Array.from(filterBar.querySelectorAll('.sp-filter'));
    var cards   = Array.from(grid.querySelectorAll('.sp-card'));

    filterBar.addEventListener('click', function (e) {
        var btn = e.target.closest('.sp-filter');
        if (!btn) return;

        /* Update active state */
        buttons.forEach(function (b) {
            b.classList.remove('is-active');
            b.setAttribute('aria-pressed', 'false');
        });
        btn.classList.add('is-active');
        btn.setAttribute('aria-pressed', 'true');

        var cat = btn.dataset.category;
        var visible = 0;

        cards.forEach(function (card, i) {
            var show = cat === 'all' || card.dataset.category === cat;
            if (show) {
                card.style.display = '';
                /* Stagger re-reveal */
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(function () {
                    card.style.transition = 'opacity 0.42s ease, transform 0.42s var(--gh-ease)';
                    card.style.opacity    = '1';
                    card.style.transform  = 'none';
                }, visible * 60);
                visible++;
            } else {
                card.style.transition = 'opacity 0.25s ease';
                card.style.opacity    = '0';
                setTimeout(function () { card.style.display = 'none'; }, 260);
            }
        });

        /* No-results message */
        if (noResults) {
            noResults.hidden = visible > 0;
        }
    });
})();
</script>
@endpush
