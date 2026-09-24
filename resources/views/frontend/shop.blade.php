@extends('layouts.frontend')

@section('title', 'Shop - GMAC Coffee')
@section('meta_description', 'Browse and shop premium Rwandan coffee products from GMAC.')

@section('content')
@include('partials.frontend.page-hero', [
    'title'   => __('messages.nav_shop'),
    'subtitle'=> 'Official roasted bags with GS1 barcodes — packed in Kigali, priced in Rwandan francs.',
    'eyebrow' => 'Coffee',
    'image' => \App\Support\FrontendShowcase::img('cherries'),
])

{{-- ══════════════════════════════════════════
     SHOP BODY
══════════════════════════════════════════ --}}
<section class="sp-section">
    <div class="container">
        {{-- ── Toolbar: count + filters ─────────────────────────── --}}
        <div class="sp-toolbar gh-reveal">
            <div class="sp-toolbar__left">
                <div class="sp-toolbar__meta">{{ $products->count() }} products available</div>
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
                    <img
                        src="{{ $product->displayImage() }}"
                        alt="{{ $product->name }}"
                        class="sp-card__img{{ $product->usesPackShot() ? ' is-pack' : '' }}"
                        loading="lazy"
                    >
                    <div class="sp-card__badge">{{ $product->packSize() }}</div>
                </a>

                <div class="sp-card__body">
                    <div class="sp-card__meta">
                        <span class="sp-card__swatch is-{{ $product->packColor() }}" aria-hidden="true"></span>
                        <span>{{ $product->packColorLabel() }}</span>
                        @if($product->packRoast())
                            <span class="sp-card__sep" aria-hidden="true"></span>
                            <span>{{ $product->packRoast() }}</span>
                        @endif
                    </div>
                    <h3 class="sp-card__name">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    @if($product->barcode)
                        <p class="g-barcode">{{ $product->barcode }}</p>
                    @endif

                    <div class="sp-card__foot">
                        @if($product->price)
                            <span class="sp-card__price">{{ $product->formattedPrice() }}</span>
                        @else
                            <span class="sp-card__price sp-card__price--inquiry">{{ __('messages.price_on_request') }}</span>
                        @endif
                        <div class="sp-card__actions">
                            <form action="{{ route('cart.add', $product->slug) }}" method="post" class="sp-card__cart-form">
                                @csrf
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="sp-card__add">{{ __('messages.add_to_cart') }}</button>
                            </form>
                            <a href="{{ route('products.show', $product->slug) }}" class="sp-card__cta">
                                {{ __('messages.details') }}
                                <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                            </a>
                        </div>
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
<section class="shop-cta">
    <div class="container">
        <div class="shop-cta__inner gh-reveal">
            <div class="shop-cta__label">Wholesale &amp; Export</div>
            <h2 class="shop-cta__h2">Interested in <em>bulk orders?</em></h2>
            <p class="shop-cta__sub">We work with importers, roasters, and specialty buyers worldwide. Contact us for availability, samples, and export conversations.</p>
            <div class="shop-cta__btns">
                <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="gh-btn gh-btn--gold">Contact Us</a>
                <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="shop-cta__link">Our Story</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap');

:root {
    --gh-forest:   #1a0e08;
    --gh-ink:      #21160f;
    --gh-parchment:#efe2cf;
    --gh-cream:    #f5ebe0;
    --gh-gold:     #7a6452;
    --gh-gold-dk:  #5c4a3c;
    --gh-gold-lt:  #8d7560;
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
.gh-btn--gold { background: #7a6452; color: #fff; }
.gh-btn--gold:hover { background: #8d7560; color: #fff; }
.gh-btn--outline-light { background: transparent; color: var(--gh-parchment); border: 1px solid rgba(246,240,230,0.25); }
.gh-btn--outline-light:hover { border-color: var(--gh-gold-lt); color: var(--gh-gold-lt); }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   SECTION SHELL
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.sp-section {
    padding: 3rem 0 5rem;
    background: #f5f3f0;
    position: relative;
}
[data-theme="dark"] .sp-section { background: var(--gh-cream); }

.sp-intro {
    max-width: 820px;
    margin: 0 auto 1.8rem;
    text-align: center;
}

.sp-intro__kicker {
    display: inline-flex;
    align-items: center;
    padding: 0.45rem 0.9rem;
    border-radius: 999px;
    background: #efe8df;
    border: 1px solid #e7e2db;
    color: #5c4a3c;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.sp-intro__title {
    margin: 0 0 0.8rem;
    font-family: var(--gh-display);
    font-size: clamp(2.2rem, 4vw, 3.6rem);
    font-weight: 300;
    line-height: 1.06;
    color: var(--clr-deep-espresso, #1a1008);
}

.sp-intro__title em {
    font-style: italic;
    color: var(--gh-gold-dk);
}

.sp-intro__text {
    max-width: 60ch;
    margin: 0 auto;
    color: var(--clr-text-muted);
    line-height: 1.85;
    font-size: 1rem;
}

.sp-steps {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0.9rem;
    margin: 0 0 1.8rem;
}

.sp-step {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 1rem 1.05rem;
    background: rgba(255,255,255,0.72);
    border: 1px solid rgba(13,9,7,0.06);
    border-radius: 20px;
    box-shadow: var(--shadow-sm);
}

.sp-step strong {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 999px;
    background: rgba(201,150,63,0.12);
    color: var(--gh-gold-dk);
    font-size: 0.95rem;
}

.sp-step span {
    color: var(--clr-text-main);
    font-size: 0.9rem;
    font-weight: 600;
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
    margin-bottom: 2.2rem;
}

.sp-toolbar__meta {
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
    margin-bottom: 0.5rem;
}
.sp-toolbar__heading {
    font-family: var(--gh-display);
    font-size: clamp(1.8rem, 3vw, 2.6rem);
    font-weight: 300;
    line-height: 1.06;
    color: var(--clr-deep-espresso, #1a1008);
    margin: 0;
}
[data-theme="dark"] .sp-toolbar__heading { color: var(--clr-text); }
.sp-toolbar__heading em { font-style: italic; color: var(--gh-gold-dk); }
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
    background: rgba(255,255,255,0.72);
    border: 1px solid rgba(13,9,7,0.08);
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
    background: #7a6452;
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
    background: #efe8df;
    border-color: transparent;
    color: #5c4a3c;
    box-shadow: none;
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
    background: rgba(201,150,63,0.14);
    color: var(--gh-gold-dk);
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
    background: rgba(255,255,255,0.88);
    border: 1px solid rgba(13,9,7,0.06);
    border-radius: 26px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.40s var(--gh-ease), box-shadow 0.40s var(--gh-ease);
    /* Filter hide animation */
    transition: transform 0.40s var(--gh-ease), box-shadow 0.40s var(--gh-ease), opacity 0.3s ease;
}
.sp-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 40px rgba(63, 55, 49, 0.10);
    border-color: #e7e2db;
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
    background: #f7f4f0;
    text-decoration: none;
    flex-shrink: 0;
}
.sp-card__img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
    transition: transform 0.65s var(--gh-ease);
}
.sp-card__img.is-pack {
    object-fit: contain;
    object-position: center 32%;
    padding: 0.7rem 0.7rem 0.35rem;
    box-sizing: border-box;
    background: #f7f4f0;
}
.sp-card:hover .sp-card__img { transform: scale(1.03); }
.sp-card__ph {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem;
    color: rgba(192,139,48,0.30);
    background: linear-gradient(160deg, #2d1a0e 0%, #1a0e08 55%, #0d0907 100%);
}

.sp-card__badge {
    position: absolute;
    top: 14px; left: 14px;
    background: #fff;
    border: 1px solid #e7e2db;
    padding: 6px 11px;
    border-radius: 999px;
    font-family: var(--gh-body);
    font-size: 0.68rem; font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: none;
    color: #5c4a3c;
    z-index: 2;
}

/* Body */
.sp-card__body {
    padding: 20px 22px 22px;
    display: flex; flex-direction: column; flex: 1;
}

.sp-card__meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-bottom: 0.65rem;
    color: #7a6452;
    font-size: 0.74rem;
    font-weight: 600;
}
.sp-card__swatch {
    width: 12px;
    height: 12px;
    border-radius: 999px;
    border: 1px solid rgba(63, 55, 49, 0.12);
    flex-shrink: 0;
}
.sp-card__swatch.is-red { background: #c0392b; }
.sp-card__swatch.is-chocolate { background: #c4a574; }
.sp-card__swatch.is-green { background: #2f7a4a; }
.sp-card__sep {
    width: 3px;
    height: 3px;
    border-radius: 999px;
    background: #c9bfb4;
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
.sp-card__name a:hover { color: #7a6452; }

.sp-card__excerpt {
    font-family: var(--gh-body);
    font-size: 0.88rem; font-weight: 300; line-height: 1.70;
    color: rgba(26,16,8,0.6);
    margin: 0 0 16px;
    flex: 1;
}
[data-theme="dark"] .sp-card__excerpt { color: rgba(199,214,205,0.75); }

.sp-card__foot {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid rgba(13,9,7,0.06);
}
.sp-card__foot > .sp-card__price,
.sp-card__foot > .sp-card__price--inquiry { align-self: flex-start; }
.sp-card__actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    justify-content: space-between;
}
.sp-card__cart-form { margin: 0; }
.sp-card__add {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 38px;
    padding: 0.55rem 1.05rem;
    font-family: var(--gh-body);
    font-size: 0.8rem;
    font-weight: 500;
    letter-spacing: 0.02em;
    text-transform: none;
    border: none;
    border-radius: 999px;
    cursor: pointer;
    background: #7a6452;
    color: #fff;
    transition: background 0.2s, transform 0.2s var(--gh-ease);
}
.sp-card__add:hover { background: #8d7560; }
@media (min-width: 480px) {
    .sp-card__foot {
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    .sp-card__actions { flex: 1; justify-content: flex-end; min-width: 0; }
}
.sp-card__price {
    font-family: var(--gh-display);
    font-size: 1.25rem; font-weight: 400;
    color: var(--gh-ink, #21160f);
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
    font-size: 0.8rem; font-weight: 500;
    letter-spacing: 0;
    text-transform: none;
    color: #7a6452;
    text-decoration: none;
    padding-bottom: 1px;
    transition: color 0.2s, gap 0.2s;
    white-space: nowrap;
}
.sp-card__cta:hover { color: #5c4a3c; gap: 9px; }

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
.shop-cta {
    margin-top: 2.75rem;
    padding: 0 0 5.5rem;
}

.shop-cta__inner {
    text-align: center;
    max-width: 760px;
    margin: 0 auto;
    padding: 2.5rem 2rem;
    background: #efe8df;
    border: 1px solid #e7e2db;
    border-radius: 30px;
}

.shop-cta__label {
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    color: #7a6452;
    margin-bottom: 1rem;
}

.shop-cta__h2 {
    margin: 0 0 0.8rem;
    font-family: var(--gh-display);
    font-size: clamp(2.2rem, 4vw, 3.5rem);
    font-weight: 300;
    line-height: 1.06;
    color: var(--clr-deep-espresso);
}

.shop-cta__h2 em {
    font-style: italic;
    color: #7a6452;
}

.shop-cta__sub {
    max-width: 54ch;
    margin: 0 auto 1.2rem;
    color: var(--clr-text-muted);
    line-height: 1.8;
}

.shop-cta__btns {
    display: flex;
    gap: 1rem;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}

.shop-cta__link {
    font-size: 0.86rem;
    font-weight: 600;
    letter-spacing: 0;
    text-transform: none;
    color: #7a6452;
}

.shop-cta__link:hover {
    color: #5c4a3c;
}

[data-theme="dark"] .sp-step {
    background: rgba(246,251,248,0.04);
    border-color: rgba(246,251,248,0.08);
}

[data-theme="dark"] .sp-step strong,
[data-theme="dark"] .sp-card__type {
    color: var(--gh-gold-lt);
}

[data-theme="dark"] .sp-step span {
    color: rgba(246, 240, 230, 0.8);
}

/* ── Responsive ─────────────────────────────────────────────────── */
@media (max-width: 860px) {
    .sp-steps { grid-template-columns: 1fr; }
    .sp-toolbar { flex-direction: column; align-items: flex-start; }
    .sp-toolbar__right { width: 100%; }
    .sp-filters {
        gap: 8px;
        flex-wrap: nowrap;
        overflow-x: auto;
        margin-inline: -1.15rem;
        padding: 0.15rem 1.15rem 0.4rem;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .sp-filters::-webkit-scrollbar { display: none; }
    .sp-filter { flex: 0 0 auto; min-height: 44px; }
    .sp-section { padding: 40px 0 56px; }
    .sp-grid { grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; }
}
@media (max-width: 520px) {
    .sp-grid { grid-template-columns: 1fr; }
    .sp-card__img-wrap { height: 210px; }
    .shop-cta__inner { padding: 2rem 1.25rem; }
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
