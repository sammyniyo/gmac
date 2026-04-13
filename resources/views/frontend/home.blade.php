@extends('layouts.frontend')

@section('title', 'Welcome to GMAC Coffee')
@section('meta_description', 'Experience the finest Rwandan coffee. From our hills to your cup.')

@section('content')

@php
    $firstHero = $heroSlides->first();
    $heroPrimaryLabel = ($firstHero && filled($firstHero->button_text ?? null)) ? $firstHero->button_text : __('messages.discover');
    $heroPrimaryHref = $firstHero->button_href ?? LaravelLocalization::localizeUrl(url('/products'));
@endphp

<section class="gh-hero">
    <div
        class="gh-hero__slider"
        id="gh-hero-slider"
        data-interval="4200"
        aria-label="Hero image slider"
        data-default-primary-label="{{ e(__('messages.discover')) }}"
        data-default-primary-href="{{ e(LaravelLocalization::localizeUrl(url('/products'))) }}"
        data-secondary-label="{{ e(__('messages.contact')) }}"
        data-secondary-href="{{ e(LaravelLocalization::localizeUrl(url('/contact'))) }}"
    >
        @if($heroSlides->isEmpty())
            <div class="gh-hero__ambient-fallback" aria-hidden="true"></div>
        @else
        <div class="gh-hero__track" aria-live="polite">
            @foreach($heroSlides as $s)
                <div
                    class="gh-hero__slide {{ $loop->first ? 'is-active' : '' }}"
                    data-slide
                    data-title="{{ e($s->title ?? $heroTitle) }}"
                    data-subtitle="{{ e($s->subtitle ?? $heroSub) }}"
                    data-primary-label="{{ e(filled($s->button_text ?? null) ? $s->button_text : __('messages.discover')) }}"
                    data-primary-href="{{ e($s->button_href) }}"
                >
                    <img class="gh-hero__slide-img" src="{{ $s->image_url }}" alt="{{ e($s->title ?? $heroTitle) }}">
                </div>
            @endforeach
        </div>
        @endif

        <div class="gh-hero__overlay"></div>

        <div class="container gh-hero__inner">
            <div class="gh-hero__copy">
                <div class="gh-kicker">{{ $tagline }}</div>

                <h1 class="gh-hero__h1">
                    <span id="gh-hero-title" class="gh-hero__text">{!! nl2br(e($heroTitle)) !!}</span>
                    <em id="gh-hero-subtitle" class="gh-hero__text gh-hero__text--sub">{{ $heroSub }}</em>
                </h1>

                <p class="gh-hero__body">{{ $aboutShort }}</p>

                <div class="gh-hero__actions" id="gh-hero-actions">
                    <a href="{{ $heroPrimaryHref }}" id="gh-hero-cta-primary" class="gh-btn gh-btn--gold">
                        {{ $heroPrimaryLabel }}
                    </a>
                    <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" id="gh-hero-cta-secondary" class="gh-btn gh-btn--ghost">
                        {{ __('messages.contact') }}
                    </a>
                </div>

                <div class="gh-hero__badges">
                    @foreach($heroBadges as $badgeLabel)
                        <span class="gh-badge">{{ $badgeLabel }}</span>
                    @endforeach
                </div>
            </div>
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
</section>

<section class="home-section home-section--about">
    <div class="container">
        <div class="home-about gh-reveal">
            <div class="home-about__media">
                <img src="{{ $brandStoryImage }}" alt="{{ __('messages.home_about_image_alt') }}">
            </div>
            <div class="home-about__content">
                <div class="home-kicker">{{ __('messages.history') }}</div>
                <h2 class="home-title">{{ $aboutTitleBefore }}<em>{{ $aboutTitleEm }}</em></h2>
                <p class="home-copy">{{ $aboutShort }}</p>
                <p class="home-copy">{{ $aboutParagraph2 }}</p>
                <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="home-link">
                    {{ __('messages.read_more') }}
                    <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="home-section home-section--why">
    <div class="container">
        <div class="home-heading gh-reveal">
            <div class="home-kicker">{{ __('messages.why_gmac') }}</div>
            <h2 class="home-title home-title--center">Why people choose <em>GMAC Coffee.</em></h2>
            <p class="home-copy home-copy--center">{{ $whyLead }}</p>
        </div>

        <div class="home-why">
            <article class="home-card gh-reveal" style="--reveal-delay:0.05s">
                <div class="home-card__icon"><i class="fa-solid fa-leaf" aria-hidden="true"></i></div>
                <h3 class="home-card__title">{{ __('messages.sustainable') }}</h3>
                <p class="home-card__body">{{ __('messages.sustainable_desc') }}</p>
            </article>
            <article class="home-card gh-reveal" style="--reveal-delay:0.12s">
                <div class="home-card__icon"><i class="fa-solid fa-award" aria-hidden="true"></i></div>
                <h3 class="home-card__title">{{ __('messages.premium') }}</h3>
                <p class="home-card__body">{{ __('messages.premium_desc') }}</p>
            </article>
            <article class="home-card gh-reveal" style="--reveal-delay:0.19s">
                <div class="home-card__icon"><i class="fa-solid fa-globe-africa" aria-hidden="true"></i></div>
                <h3 class="home-card__title">{{ __('messages.global') }}</h3>
                <p class="home-card__body">{{ __('messages.global_desc') }}</p>
            </article>
        </div>
    </div>
</section>

@if(count($stats) > 0)
<section class="home-section home-section--stats">
    <div class="container">
        <div class="home-stats">
            @foreach($stats as $index => $stat)
                <div class="home-stat gh-reveal" style="--reveal-delay:{{ $index * 0.08 }}s">
                    @if($stat->icon)
                        <div class="home-stat__icon"><i class="{{ $stat->icon }}" aria-hidden="true"></i></div>
                    @endif
                    <div class="home-stat__num">{{ $stat->number }}</div>
                    <div class="home-stat__label">{{ $stat->title }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($testimonials->isNotEmpty())
<section class="home-section home-section--reviews">
    <div class="container">
        <div class="home-heading gh-reveal">
            <div class="home-kicker">{{ $reviewsKicker }}</div>
            <h2 class="home-title home-title--center">{{ $reviewsTitle }}<em>{{ $reviewsTitleEm }}</em></h2>
            <p class="home-copy home-copy--center">{{ $reviewsLead }}</p>
        </div>

        <div class="home-reviews">
            @foreach($testimonials as $review)
                <article class="home-review gh-reveal" style="--reveal-delay:{{ $loop->index * 0.08 }}s">
                    <div class="home-review__stars" aria-hidden="true">
                        @foreach(range(1, max(1, (int) ($review->rating ?? 5))) as $star)
                            <i class="fa-solid fa-star"></i>
                        @endforeach
                    </div>
                    <p class="home-review__quote">"{{ $review->quote }}"</p>
                    <div class="home-review__meta">
                        <div class="home-review__name">{{ $review->name }}</div>
                        <div class="home-review__role">{{ $review->role }} · {{ $review->company }}</div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($featuredProducts->count() > 0)
<section class="home-section home-section--products">
    <div class="container">
        <div class="home-heading home-heading--split gh-reveal">
            <div>
                <div class="home-kicker">{{ __('messages.featured_products') }}</div>
                <h2 class="home-title">Our featured <em>selection.</em></h2>
            </div>
            <a href="{{ LaravelLocalization::localizeUrl(url('/products')) }}" class="home-link">
                {{ __('messages.products') }}
                <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
            </a>
        </div>

        <div class="home-products">
            @foreach($featuredProducts->take(3) as $product)
                <article class="home-product gh-reveal" style="--reveal-delay:{{ $loop->index * 0.08 }}s">
                    <a href="{{ route('products.show', $product->slug) }}" class="home-product__media">
                        @if($product->hasMedia('products'))
                            <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}">
                        @else
                            <div class="home-product__placeholder"><i class="fa-solid fa-mug-hot" aria-hidden="true"></i></div>
                        @endif
                    </a>
                    <div class="home-product__body">
                        <span class="home-product__category">{{ $product->category->name }}</span>
                        <h3 class="home-product__title">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="home-product__text">{{ Str::limit(strip_tags($product->description), 90) }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="home-section home-section--cta">
    <div class="container">
        <div class="home-cta gh-reveal">
            <div class="home-kicker">{{ $ctaKicker }}</div>
            <h2 class="home-title home-title--center">{{ $ctaTitle }}<em>{{ $ctaTitleEm }}</em></h2>
            <p class="home-copy home-copy--center">{{ $ctaLead }}</p>
            <div class="home-cta__actions">
                <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="gh-btn gh-btn--gold">Shop Coffee</a>
                <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="gh-btn gh-btn--dark">Contact Us</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap');

:root {
    --gh-forest: #2d1f15;
    --gh-ink: #21160f;
    --gh-parchment: #f7f1e7;
    --gh-cream: #f6f0e7;
    --gh-surface: #fffdf9;
    --gh-line: rgba(33, 22, 15, 0.08);
    --gh-gold: #d4a24a;
    --gh-gold-dk: #9a7028;
    --gh-gold-lt: #e8c97a;
    --gh-display:  'Cormorant Garamond', Georgia, serif;
    --gh-body:     'DM Sans', var(--font-body, sans-serif);
    --gh-ease:     cubic-bezier(0.16, 1, 0.3, 1);
}
[data-theme="dark"] {
    --gh-parchment: #17110d;
    --gh-cream: #100c09;
    --gh-surface: #1b140f;
    --gh-line: rgba(247, 241, 231, 0.08);
    --gh-ink: #f7f1e7;
}

.gh-reveal {
    opacity: 0;
    transform: translateY(28px) scale(0.99);
    filter: blur(2px);
    transition: opacity 0.7s var(--gh-ease), transform 0.7s var(--gh-ease), filter 0.7s var(--gh-ease);
    transition-delay: var(--reveal-delay, 0s);
}
.gh-reveal.is-visible { opacity: 1; transform: none; filter: none; }

@media (prefers-reduced-motion: reduce) {
    .gh-reveal {
        opacity: 1;
        transform: none;
        filter: none;
        transition: none;
    }
}

.gh-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    justify-content: center;
    padding: 0.95rem 1.55rem;
    font-family: var(--gh-body);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 999px;
    border: 1px solid transparent;
    cursor: pointer;
    transition: background 0.22s, color 0.22s, border-color 0.22s, transform 0.22s var(--gh-ease), box-shadow 0.22s;
}
.gh-btn:hover { transform: translateY(-2px); }
.gh-btn--gold {
    background: linear-gradient(135deg, var(--gh-gold) 0%, #e8b84e 55%, #c9933a 100%);
    color: #ffffff;
    box-shadow: 0 14px 36px rgba(212, 162, 74, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.12) inset;
}
.gh-btn--gold:hover { color: #ffffff; box-shadow: 0 18px 44px rgba(212, 162, 74, 0.42), 0 0 0 1px rgba(255, 255, 255, 0.18) inset; }
.gh-btn--dark {
    background: #2d1f15;
    color: #ffffff;
}
.gh-btn--dark:hover { color: #ffffff; background: #21160f; }
.gh-btn--ghost {
    background: rgba(255,255,255,0.12);
    color: #ffffff;
    border-color: rgba(255,255,255,0.28);
    backdrop-filter: blur(10px);
}
.gh-btn--ghost:hover { color: #ffffff; border-color: rgba(255,255,255,0.45); }

.gh-hero {
    position: relative;
    min-height: min(88vh, 820px);
    overflow: hidden;
    background: #20150f;
}

.gh-hero__ambient-fallback {
    position: absolute;
    inset: 0;
    z-index: 0;
    background:
        radial-gradient(ellipse 85% 55% at 18% 28%, rgba(212, 162, 74, 0.18), transparent 52%),
        linear-gradient(145deg, #2a1d15 0%, #3d2a1c 38%, #1a120d 100%);
}

.gh-hero__slider,
.gh-hero__track,
.gh-hero__slide {
    position: absolute;
    inset: 0;
}

.gh-hero__h1 {
    font-family: var(--gh-display);
    font-size: clamp(3rem, 6vw, 5.6rem);
    font-weight: 300;
    line-height: 0.98;
    color: #ffffff;
    margin: 0 0 1.1rem;
    max-width: 10ch;
}
.gh-hero__h1 em {
    display: block;
    font-style: normal;
    font-family: var(--gh-body);
    font-size: clamp(1rem, 1.4vw, 1.2rem);
    font-weight: 400;
    line-height: 1.6;
    color: rgba(255,255,255,0.84);
    margin-top: 0.85rem;
    max-width: 34ch;
}

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
    0% { opacity: 0; transform: translateY(14px); filter: blur(6px); }
    100% { opacity: 1; transform: translateY(0); filter: blur(0); }
}

.gh-hero__inner {
    position: relative;
    z-index: 2;
    min-height: min(88vh, 820px);
    display: flex;
    align-items: center;
}

.gh-hero__copy {
    max-width: 640px;
    padding: calc(var(--gnav-total-h, 100px) + 2rem) 0 5rem;
}

@keyframes gh-kicker-pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(212, 162, 74, 0); border-color: rgba(255,255,255,0.16); }
    50% { box-shadow: 0 0 28px rgba(212, 162, 74, 0.2); border-color: rgba(232, 201, 122, 0.35); }
}

.gh-kicker {
    display: inline-flex;
    align-items: center;
    padding: 0.45rem 0.9rem;
    border-radius: 999px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.16);
    color: rgba(255,255,255,0.86);
    font-family: var(--gh-body);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    margin-bottom: 1.25rem;
}

@media (prefers-reduced-motion: no-preference) {
    .gh-kicker { animation: gh-kicker-pulse 6s ease-in-out infinite; }
}

.gh-hero__body {
    font-family: var(--gh-body);
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.8;
    color: rgba(255,255,255,0.78);
    max-width: 52ch;
    margin-bottom: 1.8rem;
}

.gh-hero__actions {
    display: flex;
    gap: 0.9rem;
    flex-wrap: wrap;
}

.gh-hero__badges {
    display: flex;
    gap: 0.7rem;
    flex-wrap: wrap;
    margin-top: 1.25rem;
}
.gh-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.45rem 0.8rem;
    border: 1px solid rgba(255,255,255,0.16);
    background: rgba(255,255,255,0.1);
    border-radius: 999px;
    font-family: var(--gh-body);
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.82);
}

.gh-hero__overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    background:
        radial-gradient(ellipse 80% 50% at 20% 30%, rgba(212, 162, 74, 0.12), transparent 55%),
        linear-gradient(90deg, rgba(20,14,10,0.85) 0%, rgba(20,14,10,0.48) 42%, rgba(20,14,10,0.15) 100%),
        linear-gradient(180deg, rgba(20,14,10,0.25) 0%, rgba(20,14,10,0.68) 100%);
    pointer-events: none;
}

.gh-hero__slide {
    opacity: 0;
    transform: scale(1.06);
    transition: opacity 0.65s var(--gh-ease), transform 8s cubic-bezier(0.25, 0.1, 0.25, 1);
    will-change: opacity, transform;
}
.gh-hero__slide.is-active {
    opacity: 1;
    transform: scale(1.0);
}

@media (prefers-reduced-motion: reduce) {
    .gh-hero__slide {
        transition: opacity 0.35s ease;
        transform: none;
    }
    .gh-hero__slide.is-active { transform: none; }
}
.gh-hero__slide-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.gh-hero__controls {
    position: absolute;
    right: 2rem;
    bottom: 2rem;
    z-index: 4;
    display: flex;
    gap: 0.65rem;
}
.gh-hero__arrow {
    width: 46px;
    height: 46px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,0.24);
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(10px);
    color: #ffffff;
    cursor: pointer;
    transition: transform 0.2s var(--gh-ease), background 0.2s, border-color 0.2s;
}
.gh-hero__arrow:hover {
    transform: translateY(-2px);
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.4);
}

.gh-hero__dots {
    position: absolute;
    left: 50%;
    bottom: 2rem;
    transform: translateX(-50%);
    z-index: 4;
    display: flex;
    gap: 0.5rem;
    padding: 0.65rem 0.85rem;
    border-radius: 999px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.16);
    backdrop-filter: blur(10px);
}
.gh-hero__dot {
    width: 8px;
    height: 8px;
    border-radius: 999px;
    border: none;
    background: rgba(255,255,255,0.45);
    cursor: pointer;
    transition: transform 0.2s var(--gh-ease), background 0.2s, width 0.2s;
}
.gh-hero__dot.is-active {
    width: 24px;
    background: var(--gh-gold-lt);
}
.gh-hero__dot:hover { transform: translateY(-1px); }

@media (max-width: 900px) {
    .gh-hero,
    .gh-hero__inner {
        min-height: 78vh;
    }

    .gh-hero__copy {
        padding: calc(var(--gnav-total-h, 100px) + 1rem) 0 6rem;
    }

    .gh-hero__h1 {
        max-width: none;
    }

    .gh-hero__controls {
        right: 1rem;
        bottom: 1rem;
    }

    .gh-hero__dots {
        bottom: 1rem;
    }
}

.home-section {
    padding: 5.5rem 0;
    background: var(--gh-cream);
}

.home-section--why,
.home-section--products,
.home-section--reviews {
    background:
        radial-gradient(900px 400px at 0% 0%, rgba(212, 162, 74, 0.06), transparent 55%),
        #fbf8f3;
}

.home-section--stats {
    padding-top: 0;
}

.home-kicker {
    color: var(--gh-gold-dk);
    font-family: var(--gh-body);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    margin-bottom: 0.9rem;
}

.home-title {
    font-family: var(--gh-display);
    font-size: clamp(2.2rem, 4vw, 3.6rem);
    font-weight: 300;
    line-height: 1.05;
    color: var(--gh-ink);
    margin: 0 0 1rem;
}

.home-title em {
    color: var(--gh-gold-dk);
    font-style: italic;
}

.home-title--center,
.home-copy--center {
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}

.home-copy {
    font-family: var(--gh-body);
    font-size: 1rem;
    line-height: 1.8;
    color: rgba(24, 49, 38, 0.72);
    max-width: 60ch;
}

.home-heading {
    max-width: 760px;
    margin: 0 auto 2.5rem;
}

.home-heading--split {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    align-items: end;
    gap: 1.25rem;
}

.home-link {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    color: var(--gh-gold-dk);
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    text-decoration: none;
}

.home-about {
    display: grid;
    grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
    gap: 2.5rem;
    align-items: center;
    background: var(--gh-surface);
    border: 1px solid var(--gh-line);
    border-radius: 28px;
    padding: 1.4rem;
    box-shadow: 0 18px 40px rgba(33, 22, 15, 0.05);
    transition: box-shadow 0.4s var(--gh-ease), border-color 0.4s, transform 0.4s var(--gh-ease);
}

.home-about:hover {
    box-shadow: 0 28px 56px rgba(33, 22, 15, 0.09);
    border-color: rgba(212, 162, 74, 0.18);
}

.home-about__media {
    overflow: hidden;
    border-radius: 22px;
}

.home-about__media img {
    width: 100%;
    aspect-ratio: 4 / 3;
    object-fit: cover;
    border-radius: 22px;
    display: block;
    transition: transform 0.7s var(--gh-ease);
}

@media (prefers-reduced-motion: no-preference) {
    .home-about:hover .home-about__media img { transform: scale(1.04); }
}

.home-why {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.2rem;
}

.home-card {
    background: var(--gh-surface);
    border: 1px solid var(--gh-line);
    border-radius: 24px;
    padding: 2rem 1.6rem;
    box-shadow: 0 16px 36px rgba(33, 22, 15, 0.04);
    transition: transform 0.35s var(--gh-ease), box-shadow 0.35s var(--gh-ease), border-color 0.35s;
}

@media (prefers-reduced-motion: no-preference) {
    .home-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 28px 52px rgba(33, 22, 15, 0.1);
        border-color: rgba(212, 162, 74, 0.2);
    }
}

.home-card__icon {
    width: 52px;
    height: 52px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    background: rgba(184, 137, 61, 0.12);
    color: var(--gh-gold-dk);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.home-card__title {
    font-family: var(--gh-display);
    font-size: 1.5rem;
    font-weight: 400;
    color: var(--gh-ink);
    margin: 0 0 0.7rem;
}

.home-card__body {
    font-family: var(--gh-body);
    font-size: 0.95rem;
    line-height: 1.75;
    color: rgba(24, 49, 38, 0.72);
    margin: 0;
}

.home-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    background: #2d1f15;
    border-radius: 28px;
    padding: 1.25rem;
}

.home-reviews {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.home-review {
    background: var(--gh-surface);
    border: 1px solid var(--gh-line);
    border-radius: 24px;
    padding: 1.7rem 1.5rem;
    box-shadow: 0 16px 36px rgba(33, 22, 15, 0.04);
    transition: transform 0.35s var(--gh-ease), box-shadow 0.35s var(--gh-ease), border-color 0.35s;
}

@media (prefers-reduced-motion: no-preference) {
    .home-review:hover {
        transform: translateY(-6px);
        box-shadow: 0 24px 48px rgba(33, 22, 15, 0.08);
        border-color: rgba(212, 162, 74, 0.18);
    }
}

.home-review__stars {
    display: flex;
    gap: 0.35rem;
    margin-bottom: 1rem;
    color: var(--gh-gold);
    font-size: 0.85rem;
}

.home-review__quote {
    margin: 0 0 1.1rem;
    font-size: 0.98rem;
    line-height: 1.8;
    color: rgba(24, 49, 38, 0.76);
}

.home-review__name {
    font-family: var(--gh-display);
    font-size: 1.25rem;
    color: var(--gh-ink);
}

.home-review__role {
    margin-top: 0.2rem;
    font-size: 0.78rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
}

.home-stat {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 1.7rem 1.2rem;
    text-align: center;
}

.home-stat__icon {
    font-size: 1.3rem;
    color: var(--gh-gold-lt);
    margin-bottom: 0.7rem;
}

.home-stat__num {
    font-family: var(--gh-display);
    font-size: clamp(2.3rem, 4vw, 3.3rem);
    color: #ffffff;
    line-height: 1;
    margin-bottom: 0.45rem;
}

.home-stat__label {
    color: rgba(255,255,255,0.72);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
}

.home-products {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.4rem;
}

.home-product {
    background: var(--gh-surface);
    border: 1px solid var(--gh-line);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 16px 36px rgba(33, 22, 15, 0.04);
    transition: transform 0.35s var(--gh-ease), box-shadow 0.35s var(--gh-ease), border-color 0.35s;
}

@media (prefers-reduced-motion: no-preference) {
    .home-product:hover {
        transform: translateY(-8px);
        box-shadow: 0 28px 56px rgba(33, 22, 15, 0.11);
        border-color: rgba(212, 162, 74, 0.22);
    }
}

.home-product__media {
    display: block;
    background: #d9e4dc;
}

.home-product__media img,
.home-product__placeholder {
    width: 100%;
    height: 240px;
    display: block;
    object-fit: cover;
    transition: transform 0.65s var(--gh-ease);
}

@media (prefers-reduced-motion: no-preference) {
    .home-product:hover .home-product__media img { transform: scale(1.06); }
}

.home-product__placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gh-gold);
    font-size: 3rem;
}

.home-product__body {
    padding: 1.4rem;
}

.home-product__category {
    display: inline-block;
    margin-bottom: 0.7rem;
    color: var(--gh-gold-dk);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
}

.home-product__title {
    font-family: var(--gh-display);
    font-size: 1.55rem;
    font-weight: 400;
    color: var(--gh-ink);
    margin: 0 0 0.55rem;
}

.home-product__title a {
    color: inherit;
    text-decoration: none;
}

.home-product__text {
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.75;
    color: rgba(24, 49, 38, 0.72);
}

.home-cta {
    background:
        radial-gradient(ellipse 100% 80% at 50% 0%, rgba(212, 162, 74, 0.15), transparent 55%),
        linear-gradient(165deg, #3a281c 0%, #2d1f15 45%, #1f1510 100%);
    border-radius: 30px;
    padding: 3.2rem 2rem;
    text-align: center;
    box-shadow: 0 32px 64px rgba(33, 22, 15, 0.2);
    border: 1px solid rgba(212, 162, 74, 0.12);
}

.home-section--cta .home-kicker,
.home-section--cta .home-title,
.home-section--cta .home-copy {
    color: #ffffff;
}

.home-section--cta .home-title em {
    color: var(--gh-gold-lt);
}

.home-section--cta .home-copy {
    max-width: 54ch;
    color: rgba(255,255,255,0.76);
}

.home-cta__actions {
    display: flex;
    gap: 0.9rem;
    justify-content: center;
    flex-wrap: wrap;
}

@media (max-width: 980px) {
    .home-about,
    .home-products,
    .home-why,
    .home-reviews {
        grid-template-columns: 1fr;
    }

    .home-heading--split {
        grid-template-columns: 1fr;
        align-items: start;
    }
}

@media (max-width: 640px) {
    .home-section {
        padding: 4rem 0;
    }

    .home-about {
        padding: 1rem;
    }

    .home-cta {
        padding: 2.4rem 1.2rem;
    }
}
</style>

<script>
(function() {
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
})();
</script>
@endpush
