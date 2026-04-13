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
        <div class="sp-intro gh-reveal">
            <div class="sp-intro__kicker">Coffee Selection</div>
            <h2 class="sp-intro__title">Cleanly presented <em>green coffee.</em></h2>
            <p class="sp-intro__text">Browse the demo products, check the price, then follow the simple buying steps below.</p>
        </div>

        <div class="sp-steps gh-reveal">
            <div class="sp-step">
                <strong>1</strong>
                <span>{{ __('messages.shop_step_1') }}</span>
            </div>
            <div class="sp-step">
                <strong>2</strong>
                <span>{{ __('messages.shop_step_2') }}</span>
            </div>
            <div class="sp-step">
                <strong>3</strong>
                <span>{{ __('messages.shop_step_3') }}</span>
            </div>
        </div>

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
                    <div class="sp-card__type">Green Coffee</div>
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
                            <span class="sp-card__price sp-card__price--inquiry">{{ __('messages.price_on_request') }}</span>
                        @endif
                        <div class="sp-card__actions">
                            <form action="{{ route('cart.add', $product->slug) }}" method="post" class="sp-card__cart-form">
                                @csrf
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" class="sp-card__add">{{ __('messages.add_to_cart') }}</button>
                            </form>
                            <a href="{{ route('products.show', $product->slug) }}" class="sp-card__cta">
                                {{ __('messages.read_more') }}
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
    --gh-gold:     var(--clr-gold, #c9963f);
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
    padding: 3rem 0 5rem;
    background:
        radial-gradient(800px 340px at 15% 0%, rgba(201,150,63,0.08), transparent 60%),
        linear-gradient(180deg, #fdfaf5 0%, #f5ebe0 100%);
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
    background: rgba(201,150,63,0.1);
    border: 1px solid rgba(201,150,63,0.16);
    color: var(--gh-gold-dk);
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
    background: rgba(201,150,63,0.16);
    border-color: rgba(201,150,63,0.26);
    color: var(--gh-gold-dk);
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
    transform: translateY(-7px);
    box-shadow: 0 24px 48px rgba(26,16,8,0.12);
    border-color: rgba(201,150,63,0.18);
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
    background: linear-gradient(180deg, #efe3d0 0%, #e2d4be 100%);
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
    color: rgba(192,139,48,0.30);
    background: linear-gradient(160deg, #2d1a0e 0%, #1a0e08 55%, #0d0907 100%);
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
    border-radius: 999px;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s var(--gh-ease);
}
.sp-card:hover .sp-card__overlay-label { opacity: 1; transform: none; }

/* Category badge on image */
.sp-card__badge {
    position: absolute;
    top: 16px; left: 16px;
    background: rgba(255,255,255,0.9);
    border: 1px solid rgba(201,150,63,0.18);
    padding: 6px 12px;
    border-radius: 999px;
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
    display: flex; flex-direction: column; flex: 1;
}

.sp-card__type {
    display: inline-flex;
    align-items: center;
    align-self: flex-start;
    margin-bottom: 0.7rem;
    padding: 0.32rem 0.7rem;
    border-radius: 999px;
    background: rgba(22, 118, 80, 0.1);
    border: 1px solid rgba(22, 118, 80, 0.16);
    color: #167650;
    font-size: 0.66rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
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
.sp-card__name a:hover { color: var(--gh-gold-dk); }
[data-theme="dark"] .sp-card__name a:hover { color: var(--gh-gold-lt); }

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
    padding: 0.55rem 1rem;
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border: none;
    border-radius: 999px;
    cursor: pointer;
    background: linear-gradient(135deg, var(--gh-gold) 0%, #c9933a 100%);
    color: #fff;
    box-shadow: 0 8px 20px rgba(184, 137, 61, 0.28);
    transition: transform 0.2s var(--gh-ease), box-shadow 0.2s;
}
.sp-card__add:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(184, 137, 61, 0.35); }
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
    font-size: 0.68rem; font-weight: 500;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--gh-gold-dk);
    text-decoration: none;
    border-bottom: 1px solid rgba(138,95,20,0.28);
    padding-bottom: 1px;
    transition: color 0.2s, border-color 0.2s, gap 0.2s;
    white-space: nowrap;
}
.sp-card__cta:hover { color: var(--gh-gold-dk); border-color: var(--gh-gold-dk); gap: 9px; }
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
.shop-cta {
    margin-top: 2.75rem;
    padding: 0 0 5.5rem;
}

.shop-cta__inner {
    text-align: center;
    max-width: 760px;
    margin: 0 auto;
    padding: 2.5rem 2rem;
    background: linear-gradient(135deg, rgba(201,150,63,0.1) 0%, rgba(13,9,7,0.03) 100%);
    border: 1px solid rgba(201,150,63,0.16);
    border-radius: 30px;
}

.shop-cta__label {
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
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
    color: var(--gh-gold-dk);
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
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
}

.shop-cta__link:hover {
    color: var(--gh-gold);
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
    .sp-filters { gap: 6px; }
    .sp-section { padding: 52px 0 72px; }
    .sp-grid { grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; }
}
@media (max-width: 520px) {
    .sp-grid { grid-template-columns: 1fr; }
    .sp-card__img-wrap { height: 220px; }
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
