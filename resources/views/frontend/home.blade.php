@extends('layouts.frontend')

@section('title', 'Welcome to GMAC Coffee')
@section('meta_description', 'Experience the finest Rwandan coffee. From our hills to your cup.')

@section('content')

@php
    $heroSlide  = $slides->first();
    $heroTitle  = $heroSlide->title    ?? (__('messages.slogan') ?? 'Premium Rwandan Coffee');
    $heroSub    = $heroSlide->subtitle ?? (__('messages.slogan') ?? 'From our hills to your cup.');
    // HeroSlide has no Spatie media — use image_url only, never call getFirstMediaUrl()
    $heroImage  = $heroSlide->image_url ?? null;
    $heroSlides = $slides
        ->map(function ($s) {
            return (object) [
                'title' => $s->title ?? null,
                'subtitle' => $s->subtitle ?? null,
                'image_url' => $s->image_url ?? null,
            ];
        })
        ->filter(fn ($s) => !empty($s->image_url))
        ->values();
    $tagline    = \App\Models\Setting::where('key', 'company_tagline')->value('value') ?? 'Coffee with character';
    $aboutShort = \App\Models\Setting::where('key', 'about_short_text')->value('value')
                  ?? 'GMAC Coffee represents the peak of Rwandan coffee farming. We cultivate, harvest, and process our beans with absolute dedication to quality and sustainability.';
@endphp

{{-- ══════════════════════════════════════════
     HERO — split panel
══════════════════════════════════════════ --}}
<section class="gh-hero">
    <div class="gh-hero__copy">

        <div class="gh-kicker">
            <span class="gh-kicker__line"></span>
            {{ $tagline }}
        </div>

        <h1 class="gh-hero__h1">
            <span id="gh-hero-title" class="gh-hero__text">{!! nl2br(e($heroTitle)) !!}</span>
            <em id="gh-hero-subtitle" class="gh-hero__text gh-hero__text--sub">{{ $heroSub }}</em>
        </h1>

        <p class="gh-hero__body">
            {{ $aboutShort }}
        </p>

        <div class="gh-hero__actions">
            <a href="{{ LaravelLocalization::localizeUrl(url('/products')) }}" class="gh-btn gh-btn--gold">
                {{ __('messages.discover') }}
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
            </a>
            <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="gh-btn gh-btn--ghost">
                {{ __('messages.contact') }}
            </a>
        </div>

        <div class="gh-hero__badges">
            <span class="gh-badge"><i class="fa-solid fa-leaf" aria-hidden="true"></i> {{ __('messages.sustainable') }}</span>
            <span class="gh-badge"><i class="fa-solid fa-award" aria-hidden="true"></i> {{ __('messages.premium') }}</span>
            <span class="gh-badge"><i class="fa-solid fa-location-dot" aria-hidden="true"></i> Rwanda</span>
        </div>

        @if($featuredProducts->count() > 0)
        <div class="gh-hero__mini">
            <div class="gh-mini__label">{{ __('messages.featured_products') }}</div>
            <div class="gh-mini__grid">
                @foreach($featuredProducts->take(3) as $p)
                <a class="gh-mini__card" href="{{ route('products.show', $p->slug) }}">
                    <div class="gh-mini__img">
                        @if($p->hasMedia('cover'))
                            <img src="{{ $p->getFirstMediaUrl('cover', 'thumb') ?: $p->getFirstMediaUrl('cover') }}" alt="{{ $p->name }}">
                        @else
                            <i class="fa-solid fa-mug-hot" aria-hidden="true"></i>
                        @endif
                    </div>
                    <div class="gh-mini__name">{{ $p->name }}</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="gh-hero__visual">
        <div class="gh-hero__blob" aria-hidden="true"></div>
        @if($heroSlides->count() > 0)
            <div class="gh-hero__slider" id="gh-hero-slider" data-interval="4200" aria-label="Hero image slider">
                <div class="gh-hero__track" aria-live="polite">
                    @foreach($heroSlides as $s)
                        <div
                            class="gh-hero__slide {{ $loop->first ? 'is-active' : '' }}"
                            data-slide
                            data-title="{{ e($s->title ?? $heroTitle) }}"
                            data-subtitle="{{ e($s->subtitle ?? $heroSub) }}"
                        >
                            <img class="gh-hero__slide-img" src="{{ $s->image_url }}" alt="{{ e($s->title ?? $heroTitle) }}">
                        </div>
                    @endforeach
                </div>

                @if($heroSlides->count() > 1)
                    <div class="gh-hero__controls" aria-label="Hero slider controls">
                        <button type="button" class="gh-hero__arrow" data-prev aria-label="Previous image">
                            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="gh-hero__arrow" data-next aria-label="Next image">
                            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="gh-hero__dots" role="tablist" aria-label="Hero slider dots">
                        @foreach($heroSlides as $s)
                            <button
                                type="button"
                                class="gh-hero__dot {{ $loop->first ? 'is-active' : '' }}"
                                data-dot="{{ $loop->index }}"
                                aria-label="Go to image {{ $loop->iteration }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                role="tab"
                            ></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @elseif($heroImage)
            <img class="gh-hero__img" src="{{ $heroImage }}" alt="{{ $heroTitle }}">
        @else
            <div class="gh-hero__img-ph" aria-hidden="true">
                <i class="fa-solid fa-mug-hot"></i>
            </div>
        @endif

        <div class="gh-hero__vcard" aria-hidden="true">
            <div class="gh-hero__vcard-label">Trusted by</div>
            <div class="gh-hero__vcard-text">Partners &amp; Buyers Worldwide</div>
        </div>

        <div class="gh-hero__scroll" aria-hidden="true">
            <div class="gh-hero__scroll-line"></div>
            <span>Scroll</span>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     MARQUEE
══════════════════════════════════════════ --}}
<div class="gh-marquee" aria-hidden="true">
    <div class="gh-marquee__track" id="gh-marquee-track">
        @foreach(range(1,6) as $i)
            <span class="gh-marquee__item">Single Origin <span class="gh-marquee__dot"></span></span>
            <span class="gh-marquee__item">Rwanda Specialty <span class="gh-marquee__dot"></span></span>
            <span class="gh-marquee__item">Sustainably Grown <span class="gh-marquee__dot"></span></span>
            <span class="gh-marquee__item">Export Quality <span class="gh-marquee__dot"></span></span>
        @endforeach
    </div>
</div>

{{-- ══════════════════════════════════════════
     ABOUT
══════════════════════════════════════════ --}}
<section class="gh-about gh-reveal">
    <div class="container">
        <div class="gh-about__inner">
            <div class="gh-about__copy">
                <div class="gh-eyebrow">
                    <span class="gh-eyebrow__line"></span>
                    {{ __('messages.history') }}
                </div>
                <h2 class="gh-about__h2">
                    The story of<br>
                    <em>exceptional</em><br>
                    Rwandan coffee.
                </h2>
                <p class="gh-about__text">{{ $aboutShort }}</p>
                <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="gh-btn gh-btn--dark">
                    {{ __('messages.read_more') }}
                    <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
                </a>
            </div>

            <div class="gh-about__visual">
                <div class="gh-about__frame">
                    @if($heroImage)
                        <img src="{{ $heroImage }}" alt="GMAC Coffee">
                    @else
                        <div class="gh-about__ph" aria-hidden="true">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                    @endif
                </div>
                <div class="gh-about__accent" aria-hidden="true"></div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FEATURED PRODUCTS
══════════════════════════════════════════ --}}
<section class="gh-products">
    <div class="container">
        <div class="gh-section-hdr gh-reveal">
            <div>
                <div class="gh-eyebrow">
                    <span class="gh-eyebrow__line"></span>
                    {{ __('messages.featured_products') }}
                </div>
                <h2 class="gh-section-title">Our finest <em>selections.</em></h2>
            </div>
            <a href="{{ LaravelLocalization::localizeUrl(url('/products')) }}" class="gh-link-arrow">
                {{ __('messages.products') }}
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg>
            </a>
        </div>

        <div class="gh-pgrid">
            @forelse($featuredProducts as $product)
            <div class="gh-pcard gh-reveal" style="--reveal-delay:{{ $loop->index * 0.08 }}s">
                <a href="{{ route('products.show', $product->slug) }}" class="gh-pcard__img-wrap">
                    @if($product->hasMedia('cover'))
                        <img src="{{ $product->getFirstMediaUrl('cover', 'thumb') ?: $product->getFirstMediaUrl('cover') }}" alt="{{ $product->name }}" class="gh-pcard__img">
                    @else
                        <div class="gh-pcard__ph" aria-hidden="true"><i class="fa-solid fa-mug-hot"></i></div>
                    @endif
                    <div class="gh-pcard__overlay"><span>View Details</span></div>
                </a>
                <div class="gh-pcard__body">
                    <span class="gh-pcard__cat">{{ $product->category->name }}</span>
                    <h3 class="gh-pcard__name">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    <p class="gh-pcard__excerpt">{{ Str::limit(strip_tags($product->description), 90) }}</p>
                </div>
            </div>
            @empty
                <p class="gh-empty">No products currently featured.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     WHY GMAC
══════════════════════════════════════════ --}}
<section class="gh-why">
    <div class="container">
        <div class="gh-why__hdr gh-reveal">
            <div class="gh-eyebrow gh-eyebrow--light">
                <span class="gh-eyebrow__line"></span>
                {{ __('messages.why_gmac') }}
            </div>
            <h2 class="gh-why__h2">Why choose <em>GMAC Coffee?</em></h2>
            <p class="gh-why__sub">Premium processing, transparent partnerships, and consistent export quality—built to last.</p>
        </div>

        <div class="gh-why__grid">
            <div class="gh-why__item gh-reveal" style="--reveal-delay:0.05s">
                <div class="gh-why__num">01</div>
                <div class="gh-why__icon"><i class="fa-solid fa-leaf" aria-hidden="true"></i></div>
                <h3 class="gh-why__title">{{ __('messages.sustainable') }}</h3>
                <p class="gh-why__body">{{ __('messages.sustainable_desc') }}</p>
            </div>
            <div class="gh-why__item gh-reveal" style="--reveal-delay:0.15s">
                <div class="gh-why__num">02</div>
                <div class="gh-why__icon"><i class="fa-solid fa-award" aria-hidden="true"></i></div>
                <h3 class="gh-why__title">{{ __('messages.premium') }}</h3>
                <p class="gh-why__body">{{ __('messages.premium_desc') }}</p>
            </div>
            <div class="gh-why__item gh-reveal" style="--reveal-delay:0.25s">
                <div class="gh-why__num">03</div>
                <div class="gh-why__icon"><i class="fa-solid fa-globe-africa" aria-hidden="true"></i></div>
                <h3 class="gh-why__title">{{ __('messages.global') }}</h3>
                <p class="gh-why__body">{{ __('messages.global_desc') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     STATS
══════════════════════════════════════════ --}}
@if(count($stats) > 0)
<section class="gh-stats">
    <div class="container">
        <div class="gh-stats__grid">
            @foreach($stats as $index => $stat)
            <div class="gh-stat gh-reveal" style="--reveal-delay:{{ $index * 0.1 }}s">
                @if($stat->icon)
                    <div class="gh-stat__icon"><i class="{{ $stat->icon }}" aria-hidden="true"></i></div>
                @endif
                <div class="gh-stat__num">{{ $stat->number }}</div>
                <div class="gh-stat__lbl">{{ $stat->title }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     CTA
══════════════════════════════════════════ --}}
<section class="gh-cta">
    <div class="container">
        <div class="gh-cta__inner gh-reveal">
            <div class="gh-cta__label">Wholesale &amp; Partnerships</div>
            <h2 class="gh-cta__h2">Taste the <em>hills</em> of Rwanda.</h2>
            <p class="gh-cta__sub">Ready to discover what makes our coffee exceptional? Get in touch for pricing, export, and availability.</p>
            <div class="gh-cta__btns">
                <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="gh-btn gh-btn--gold">Shop Coffee</a>
                <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="gh-btn gh-btn--outline-light">Contact Us</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
/* ─── Google Fonts ─────────────────────────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap');

/* ─── Page tokens (extend the existing frontend.css vars) ──────── */
:root {
    --gh-forest:   #1a0e08;
    --gh-ink:      #1a0e08;
    --gh-parchment:#f6f0e6;
    --gh-cream:    #fdfaf5;
    --gh-gold:     var(--clr-gold);
    --gh-gold-dk:  #8a6420;
    --gh-gold-lt:  #e8c97a;
    --gh-display:  'Cormorant Garamond', Georgia, serif;
    --gh-body:     'DM Sans', var(--font-body, sans-serif);
    --gh-ease:     cubic-bezier(0.16, 1, 0.3, 1);
}
[data-theme="dark"] {
    --gh-parchment: #1a0e08;
    --gh-cream:     #0d0907;
    --gh-ink:       #f6f0e6;
}

/* ─── Reveal animation ─────────────────────────────────────────── */
.gh-reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.75s var(--gh-ease), transform 0.75s var(--gh-ease);
    transition-delay: var(--reveal-delay, 0s);
}
.gh-reveal.is-visible { opacity: 1; transform: none; }

/* ─── Shared components ────────────────────────────────────────── */
.gh-eyebrow {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--gh-body);
    font-size: 0.72rem;
    font-weight: 500;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
    margin-bottom: 16px;
}
.gh-eyebrow--light { color: var(--gh-gold-lt); }
.gh-eyebrow__line { display: block; width: 28px; height: 1px; background: currentColor; flex-shrink: 0; }

.gh-section-hdr {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
    margin-bottom: 48px;
}
.gh-section-title {
    font-family: var(--gh-display);
    font-size: clamp(2.2rem, 3.5vw, 3.2rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--clr-deep-espresso);
}
[data-theme="dark"] .gh-section-title { color: var(--clr-text); }
.gh-section-title em { font-style: italic; color: var(--gh-gold); }
[data-theme="dark"] .gh-section-title em { color: var(--gh-gold-lt); }

.gh-link-arrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: var(--gh-body);
    font-size: 0.75rem;
    font-weight: 500;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
    text-decoration: none;
    border-bottom: 1px solid rgba(138,95,20,0.3);
    padding-bottom: 2px;
    white-space: nowrap;
    transition: color 0.2s, border-color 0.2s;
    align-self: flex-end;
}
.gh-link-arrow:hover { color: var(--gh-gold); border-color: var(--gh-gold); }

/* Buttons */
.gh-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
    font-family: var(--gh-body);
    font-size: 0.75rem;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.22s, color 0.22s, border-color 0.22s, transform 0.22s var(--gh-ease);
}
.gh-btn:hover { transform: translateY(-2px); }
.gh-btn--gold { background: var(--gh-gold); color: var(--gh-ink); }
.gh-btn--gold:hover { background: var(--gh-gold-lt); color: var(--gh-ink); }
.gh-btn--dark { background: var(--gh-forest); color: var(--gh-parchment); }
.gh-btn--dark:hover { background: #100804; color: var(--gh-parchment); }
.gh-btn--ghost {
    background: transparent;
    color: rgba(246,240,230,0.55);
    border: 1px solid rgba(246,240,230,0.22);
}
.gh-btn--ghost:hover { border-color: var(--gh-gold-lt); color: var(--gh-gold-lt); }
.gh-btn--outline-light {
    background: transparent;
    color: var(--gh-parchment);
    border: 1px solid rgba(246,240,230,0.25);
}
.gh-btn--outline-light:hover { border-color: var(--gh-gold-lt); color: var(--gh-gold-lt); }

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   HERO
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.gh-hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: calc(100vh - 70px);
}

/* Left copy panel */
.gh-hero__copy {
    background: var(--gh-forest);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 60px 52px 68px 60px;
    position: relative;
    overflow: hidden;
}
/* Decorative circles */
.gh-hero__copy::before,
.gh-hero__copy::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.gh-hero__copy::before {
    top: -180px; left: -180px;
    width: 480px; height: 480px;
    border: 1px solid rgba(192,139,48,0.14);
}
.gh-hero__copy::after {
    top: -120px; left: -120px;
    width: 320px; height: 320px;
    border: 1px solid rgba(192,139,48,0.08);
}

.gh-kicker {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    color: var(--gh-gold);
    margin-bottom: 24px;
    position: relative;
    z-index: 1;
}
.gh-kicker__line { display: block; width: 32px; height: 1px; background: var(--gh-gold); }

.gh-hero__h1 {
    font-family: var(--gh-display);
    font-size: clamp(2.8rem, 4.5vw, 5rem);
    font-weight: 300;
    line-height: 1.02;
    color: var(--gh-parchment);
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}
.gh-hero__h1 em { display: block; font-style: italic; color: var(--gh-gold-lt); }

/* Animated hero text (on slide change) */
.gh-hero__text {
    display: inline-block;
    will-change: transform, opacity, filter;
}
.gh-hero__copy.is-text-animating .gh-hero__text {
    animation: gh-hero-text-in 0.78s var(--gh-ease) both;
}
.gh-hero__copy.is-text-animating .gh-hero__text--sub {
    animation-delay: 0.08s;
}
@keyframes gh-hero-text-in {
    0%   { opacity: 0; transform: translateY(14px); filter: blur(6px); }
    60%  { opacity: 1; transform: translateY(0);   filter: blur(0);  }
    100% { opacity: 1; transform: translateY(0);   filter: blur(0);  }
}

.gh-hero__body {
    font-family: var(--gh-body);
    font-size: 0.95rem;
    font-weight: 300;
    line-height: 1.8;
    color: rgba(246,240,230,0.58);
    max-width: 40ch;
    margin-bottom: 32px;
    position: relative;
    z-index: 1;
}

.gh-hero__actions {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.gh-hero__badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 24px;
    position: relative;
    z-index: 1;
}
.gh-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border: 1px solid rgba(192,139,48,0.28);
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 400;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(232,201,122,0.72);
}

/* Mini product teasers */
.gh-hero__mini {
    margin-top: 28px;
    position: relative;
    z-index: 1;
}
.gh-mini__label {
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: rgba(246,240,230,0.4);
    margin-bottom: 10px;
}
.gh-mini__grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}
.gh-mini__card {
    display: block;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(192,139,48,0.15);
    padding: 10px;
    text-decoration: none;
    color: inherit;
    transition: background 0.2s, transform 0.2s;
}
.gh-mini__card:hover { background: rgba(192,139,48,0.1); transform: translateY(-2px); }
.gh-mini__img {
    height: 70px;
    overflow: hidden;
    background: rgba(13,9,7,0.30);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    color: var(--gh-gold);
    margin-bottom: 8px;
}
.gh-mini__img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gh-mini__name {
    font-family: var(--gh-body);
    font-size: 0.78rem;
    font-weight: 400;
    color: rgba(246,240,230,0.75);
    line-height: 1.2;
}

/* Right visual panel */
.gh-hero__visual {
    position: relative;
    overflow: hidden;
    background: var(--gh-ink);
}
.gh-hero__blob {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(60% 70% at 30% 25%, rgba(201,150,63,0.18), transparent 60%),
        radial-gradient(55% 55% at 75% 70%, rgba(45,26,14,0.50), transparent 60%),
        linear-gradient(160deg, #2d1a0e 0%, #1a0e08 45%, #0d0907 100%);
}

/* Hero visual slider */
.gh-hero__slider {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
}
.gh-hero__track {
    position: relative;
    width: 100%;
    height: 100%;
}
.gh-hero__slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transform: scale(1.04);
    transition: opacity 0.55s ease, transform 6s cubic-bezier(0.65,0,0.35,1);
    will-change: opacity, transform;
}
.gh-hero__slide.is-active {
    opacity: 1;
    transform: scale(1.0);
}
.gh-hero__slide-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.gh-hero__visual:hover .gh-hero__slide.is-active { transform: scale(0.985); }

.gh-hero__controls {
    position: absolute;
    right: 22px;
    bottom: 28px;
    z-index: 3;
    display: flex;
    gap: 10px;
}
.gh-hero__arrow {
    width: 44px;
    height: 44px;
    border-radius: 999px;
    border: 1px solid rgba(246,240,230,0.22);
    background: rgba(10,26,18,0.22);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: rgba(246,240,230,0.88);
    cursor: pointer;
    transition: transform 0.2s var(--gh-ease), background 0.2s, border-color 0.2s;
}
.gh-hero__arrow:hover {
    transform: translateY(-2px);
    background: rgba(10,26,18,0.34);
    border-color: rgba(232,201,122,0.5);
}

.gh-hero__dots {
    position: absolute;
    left: 22px;
    bottom: 28px;
    z-index: 3;
    display: flex;
    gap: 8px;
    padding: 8px 10px;
    border-radius: 999px;
    background: rgba(10,26,18,0.18);
    border: 1px solid rgba(246,240,230,0.12);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}
.gh-hero__dot {
    width: 8px;
    height: 8px;
    border-radius: 999px;
    border: 1px solid rgba(246,240,230,0.35);
    background: transparent;
    cursor: pointer;
    transition: transform 0.2s var(--gh-ease), background 0.2s, border-color 0.2s, width 0.2s;
}
.gh-hero__dot.is-active {
    width: 22px;
    background: rgba(232,201,122,0.9);
    border-color: rgba(232,201,122,0.9);
}
.gh-hero__dot:hover { transform: translateY(-1px); }
.gh-hero__img {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.75;
    transition: transform 8s cubic-bezier(0.65,0,0.35,1), opacity 0.6s;
    transform: scale(1.04);
}
.gh-hero__visual:hover .gh-hero__img { transform: scale(1.0); }
.gh-hero__img-ph {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 6rem;
    color: rgba(192,139,48,0.25);
}

/* Floating info card */
.gh-hero__vcard {
    position: absolute;
    bottom: 40px;
    left: 0;
    background: var(--gh-parchment);
    border-top: 3px solid var(--gh-gold);
    padding: 14px 20px;
    z-index: 2;
}
[data-theme="dark"] .gh-hero__vcard { background: #1a1008; }
.gh-hero__vcard-label {
    font-family: var(--gh-body);
    font-size: 0.62rem;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
    margin-bottom: 4px;
}
.gh-hero__vcard-text {
    font-family: var(--gh-display);
    font-size: 1.1rem;
    font-weight: 400;
    color: var(--gh-ink);
    line-height: 1.2;
}
[data-theme="dark"] .gh-hero__vcard-text { color: var(--gh-parchment); }

/* Scroll indicator */
.gh-hero__scroll {
    position: absolute;
    right: 28px;
    bottom: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    z-index: 2;
}
.gh-hero__scroll span {
    font-family: var(--gh-body);
    font-size: 0.6rem;
    font-weight: 400;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: rgba(246,240,230,0.28);
    writing-mode: vertical-rl;
}
.gh-hero__scroll-line {
    width: 1px;
    height: 44px;
    background: linear-gradient(to bottom, var(--gh-gold), transparent);
    animation: gh-scroll-pulse 2.2s ease-in-out infinite;
}
@keyframes gh-scroll-pulse {
    0%, 100% { opacity: 0.4; }
    50%       { opacity: 1;   }
}

@media (max-width: 900px) {
    .gh-hero { grid-template-columns: 1fr; }
    .gh-hero__copy { padding: 60px 24px 52px; min-height: 70vh; justify-content: center; }
    .gh-hero__copy::before, .gh-hero__copy::after { display: none; }
    .gh-hero__visual { min-height: 50vh; }
    .gh-hero__scroll { display: none; }
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   MARQUEE
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.gh-marquee {
    background: var(--gh-gold);
    padding: 13px 0;
    overflow: hidden;
    white-space: nowrap;
}
.gh-marquee__track {
    display: inline-flex;
    animation: gh-marquee 28s linear infinite;
}
.gh-marquee__item {
    display: inline-flex;
    align-items: center;
    gap: 16px;
    padding: 0 24px;
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--gh-ink);
}
.gh-marquee__dot {
    display: inline-block;
    width: 3px;
    height: 3px;
    background: var(--gh-ink);
    border-radius: 50%;
    opacity: 0.4;
}
@keyframes gh-marquee {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   ABOUT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.gh-about {
    padding: 120px 0;
    background: var(--gh-cream);
    position: relative;
    overflow: hidden;
}
[data-theme="dark"] .gh-about { background: var(--gh-cream); }
/* Ghost watermark */
.gh-about::before {
    content: 'GMAC';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: var(--gh-display);
    font-size: clamp(100px, 16vw, 200px);
    font-weight: 600;
    color: rgba(192,139,48,0.045);
    letter-spacing: 0.1em;
    white-space: nowrap;
    pointer-events: none;
    user-select: none;
}
.gh-about__inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
    position: relative;
    z-index: 1;
}
.gh-about__h2 {
    font-family: var(--gh-display);
    font-size: clamp(2.2rem, 3.5vw, 3.4rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--clr-deep-espresso);
    margin-bottom: 20px;
}
[data-theme="dark"] .gh-about__h2 { color: var(--clr-text); }
.gh-about__h2 em { font-style: italic; color: var(--gh-gold); }
[data-theme="dark"] .gh-about__h2 em { color: var(--gh-gold-lt); }
.gh-about__text {
    font-family: var(--gh-body);
    font-size: 0.95rem;
    font-weight: 300;
    line-height: 1.85;
    color: var(--clr-text-muted);
    max-width: 44ch;
    margin-bottom: 32px;
}
.gh-about__visual { position: relative; }
.gh-about__frame {
    aspect-ratio: 3 / 4;
    overflow: hidden;
    background: #1a0e08;
}
.gh-about__frame img { width: 100%; height: 100%; object-fit: cover; }
.gh-about__ph {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 5rem; color: rgba(192,139,48,0.25);
}
.gh-about__accent {
    position: absolute;
    bottom: -20px;
    right: -20px;
    width: 100px;
    height: 100px;
    border: 1px solid var(--gh-gold);
    pointer-events: none;
    z-index: -1;
}

@media (max-width: 900px) {
    .gh-about__inner { grid-template-columns: 1fr; gap: 48px; }
    .gh-about__visual { order: -1; }
    .gh-about { padding: 80px 0; }
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   PRODUCTS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.gh-products {
    padding: 100px 0;
    background: var(--clr-bg-alt);
}
.gh-pgrid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}
.gh-empty { color: var(--clr-text-muted); font-size: 0.95rem; }

.gh-pcard {
    background: var(--clr-white);
    overflow: hidden;
    border: 1px solid rgba(192,139,48,0.1);
    transition: transform 0.38s var(--gh-ease), box-shadow 0.38s;
}
.gh-pcard:hover { transform: translateY(-6px); box-shadow: 0 24px 48px rgba(26,16,8,0.1); }

.gh-pcard__img-wrap {
    display: block;
    position: relative;
    height: 240px;
    overflow: hidden;
    background: #1a0e08;
}
.gh-pcard__img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.55s var(--gh-ease);
}
.gh-pcard:hover .gh-pcard__img { transform: scale(1.05); }
.gh-pcard__ph {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 3.5rem; color: rgba(201,150,63,0.30);
    background: linear-gradient(160deg, #2d1a0e, #0d0907);
}
.gh-pcard__overlay {
    position: absolute;
    inset: 0;
    background: rgba(26,16,8,0);
    display: flex; align-items: center; justify-content: center;
    transition: background 0.3s;
}
.gh-pcard:hover .gh-pcard__overlay { background: rgba(26,16,8,0.32); }
.gh-pcard__overlay span {
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--gh-parchment);
    border: 1px solid rgba(246,240,230,0.55);
    padding: 9px 20px;
    opacity: 0;
    transform: translateY(8px);
    transition: opacity 0.3s, transform 0.3s;
}
.gh-pcard:hover .gh-pcard__overlay span { opacity: 1; transform: none; }

.gh-pcard__body {
    padding: 18px 20px 22px;
    border-top: 1px solid rgba(192,139,48,0.12);
}
.gh-pcard__cat {
    font-family: var(--gh-body);
    font-size: 0.65rem;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
    margin-bottom: 8px;
    display: block;
}
.gh-pcard__name {
    font-family: var(--gh-display);
    font-size: 1.3rem;
    font-weight: 400;
    color: var(--clr-deep-espresso);
    margin-bottom: 8px;
    line-height: 1.2;
}
[data-theme="dark"] .gh-pcard__name { color: var(--clr-text); }
.gh-pcard__name a { color: inherit; text-decoration: none; }
.gh-pcard__excerpt {
    font-family: var(--gh-body);
    font-size: 0.88rem;
    font-weight: 300;
    color: var(--clr-text-muted);
    line-height: 1.65;
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   WHY GMAC
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.gh-why {
    padding: 120px 0;
    background:
        radial-gradient(900px 420px at 18% 0%, rgba(201,150,63,0.14), transparent 62%),
        radial-gradient(900px 420px at 82% 65%, rgba(45,26,14,0.60), transparent 62%),
        linear-gradient(160deg, #2d1a0e 0%, #1a0e08 55%, #0d0907 100%);
    position: relative;
    overflow: hidden;
}
/* Decorative ring */
.gh-why::after {
    content: '';
    position: absolute;
    right: -200px;
    top: 50%;
    transform: translateY(-50%);
    width: 600px;
    height: 600px;
    border: 1px solid rgba(192,139,48,0.08);
    border-radius: 50%;
    pointer-events: none;
}
.gh-why__hdr {
    max-width: 520px;
    margin-bottom: 64px;
}
.gh-why__sub {
    margin-top: 14px;
    font-family: var(--gh-body);
    font-size: 0.95rem;
    font-weight: 300;
    color: rgba(246,240,230,0.60);
    line-height: 1.75;
    max-width: 56ch;
}
.gh-why__h2 {
    font-family: var(--gh-display);
    font-size: clamp(2.2rem, 3.5vw, 3.4rem);
    font-weight: 300;
    line-height: 1.08;
    color: var(--gh-parchment);
}
.gh-why__h2 em { font-style: italic; color: var(--gh-gold-lt); }
.gh-why__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
.gh-why__item {
    position: relative;
    padding: 42px 36px;
    border-radius: 22px;
    background: rgba(246,240,230,0.04);
    border: 1px solid rgba(246,240,230,0.10);
    box-shadow: 0 18px 40px rgba(0,0,0,0.18);
    transition: transform 0.35s var(--gh-ease), background 0.35s, border-color 0.35s;
    overflow: hidden;
}
.gh-why__item::before {
    content: '';
    position: absolute;
    inset: -2px;
    background:
        radial-gradient(520px 200px at 20% 10%, rgba(201,150,63,0.12), transparent 62%),
        radial-gradient(520px 200px at 85% 80%, rgba(45,26,14,0.40), transparent 62%);
    opacity: 0;
    transition: opacity 0.35s ease;
    pointer-events: none;
}
.gh-why__item:hover {
    transform: translateY(-8px);
    background: rgba(246,240,230,0.06);
    border-color: rgba(232,201,122,0.20);
}
.gh-why__item:hover::before { opacity: 1; }
.gh-why__num {
    font-family: var(--gh-display);
    font-size: 5.2rem;
    font-weight: 300;
    color: rgba(232,201,122,0.12);
    line-height: 1;
    position: absolute;
    right: 18px;
    top: 14px;
    margin: 0;
    pointer-events: none;
}
.gh-why__icon {
    width: 54px;
    height: 54px;
    border-radius: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: rgba(232,201,122,0.92);
    background: rgba(232,201,122,0.10);
    border: 1px solid rgba(232,201,122,0.18);
    margin-bottom: 16px;
    position: relative;
    z-index: 1;
}
.gh-why__title {
    font-family: var(--gh-display);
    font-size: 1.45rem;
    font-weight: 400;
    color: var(--gh-parchment);
    margin-bottom: 10px;
    line-height: 1.2;
    position: relative;
    z-index: 1;
}
.gh-why__body {
    font-family: var(--gh-body);
    font-size: 0.88rem;
    font-weight: 300;
    color: rgba(246,240,230,0.60);
    line-height: 1.75;
    position: relative;
    z-index: 1;
}

@media (max-width: 900px) {
    .gh-why__grid { grid-template-columns: 1fr; }
    .gh-why__item { border-right: none; }
    .gh-why { padding: 80px 0; }
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   STATS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.gh-stats {
    padding: 88px 0;
    background: var(--gh-cream);
    border-top: 1px solid rgba(192,139,48,0.1);
    border-bottom: 1px solid rgba(192,139,48,0.1);
}
[data-theme="dark"] .gh-stats { background: var(--gh-cream); }
.gh-stats__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
}
.gh-stat {
    padding: 36px 28px;
    text-align: center;
    border-right: 1px solid rgba(192,139,48,0.12);
    transition: background 0.3s;
}
.gh-stat:last-child { border-right: none; }
.gh-stat:hover { background: rgba(192,139,48,0.04); }
.gh-stat__icon {
    font-size: 1.6rem;
    color: var(--gh-gold);
    margin-bottom: 12px;
    opacity: 0.75;
}
.gh-stat__num {
    font-family: var(--gh-display);
    font-size: clamp(2.5rem, 4vw, 3.5rem);
    font-weight: 300;
    color: var(--clr-deep-espresso);
    line-height: 1;
    margin-bottom: 8px;
}
[data-theme="dark"] .gh-stat__num { color: var(--clr-text); }
.gh-stat__lbl {
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--clr-text-muted);
}

/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   CTA
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.gh-cta {
    padding: 130px 0;
    background: var(--gh-ink);
    position: relative;
    overflow: hidden;
}
[data-theme="dark"] .gh-cta { background: #0f0a05; }
.gh-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 80% 55% at 50% 0%, rgba(192,139,48,0.1), transparent 70%);
    pointer-events: none;
}
.gh-cta__inner {
    position: relative;
    z-index: 1;
    text-align: center;
    max-width: 680px;
    margin: 0 auto;
}
.gh-cta__label {
    font-family: var(--gh-body);
    font-size: 0.68rem;
    font-weight: 500;
    letter-spacing: 0.24em;
    text-transform: uppercase;
    color: var(--gh-gold);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}
.gh-cta__label::before, .gh-cta__label::after {
    content: '';
    display: block;
    width: 28px;
    height: 1px;
    background: var(--gh-gold);
}
.gh-cta__h2 {
    font-family: var(--gh-display);
    font-size: clamp(2.8rem, 5vw, 4.8rem);
    font-weight: 300;
    line-height: 1.04;
    color: var(--gh-parchment);
    margin-bottom: 16px;
}
.gh-cta__h2 em { font-style: italic; color: var(--gh-gold-lt); }
.gh-cta__sub {
    font-family: var(--gh-body);
    font-size: 0.95rem;
    font-weight: 300;
    color: rgba(246,240,230,0.46);
    line-height: 1.8;
    margin-bottom: 44px;
    max-width: 50ch;
    margin-left: auto;
    margin-right: auto;
}
.gh-cta__btns {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
}
</style>

<script>
(function() {
    /* ── Scroll reveal ── */
    var els = document.querySelectorAll('.gh-reveal');
    var io  = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    els.forEach(function(el) { io.observe(el); });

    /* ── Marquee duplicate for seamless loop ── */
    var track = document.getElementById('gh-marquee-track');
    if (track) { track.innerHTML += track.innerHTML; }
})();
</script>
@endpush
