@extends('layouts.frontend')

@section('title', 'Welcome to GMAC Coffee')
@section('meta_description', 'Experience the finest Rwandan coffee. From our hills to your cup.')

@section('content')

@php
    if ($heroSlides->isEmpty()) {
        $heroSlides = collect(\App\Support\FrontendShowcase::heroSlides())->map(fn (array $row) => (object) [
            'title' => $row['title'],
            'subtitle' => $row['subtitle'],
            'image_url' => $row['image'],
            'image_position' => $row['position'] ?? 'center 40%',
            'button_text' => $row['button_text'],
            'button_href' => LaravelLocalization::localizeUrl(url($row['button_link'])),
        ]);
    }
    $firstHero = $heroSlides->first();
    $heroPrimaryLabel = ($firstHero && filled($firstHero->button_text ?? null)) ? $firstHero->button_text : __('messages.discover');
    $heroPrimaryHref = $firstHero->button_href ?? LaravelLocalization::localizeUrl(url('/shop'));
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
                    <img
                        class="gh-hero__slide-img"
                        src="{{ $s->image_url }}"
                        alt="{{ e($s->title ?? $heroTitle) }}"
                        style="object-position: {{ $s->image_position ?? 'center 40%' }};"
                        @if($loop->first) fetchpriority="high" @else loading="lazy" @endif
                    >
                </div>
            @endforeach
        </div>

        <div class="gh-hero__overlay"></div>

        <div class="container gh-hero__inner">
            <div class="gh-hero__copy">
                <div class="gh-hero__badge">
                    <span>{{ $tagline ?: 'GMAC Coffee' }}</span>
                </div>
                <h1 class="gh-hero__h1">
                    <span id="gh-hero-title" class="gh-hero__text">{!! nl2br(e($heroTitle)) !!}</span>
                </h1>
                <p id="gh-hero-subtitle" class="gh-hero__lead">{{ $heroSub }}</p>
                <div class="gh-hero__actions" id="gh-hero-actions">
                    <a href="{{ $heroPrimaryHref }}" id="gh-hero-cta-primary" class="gh-btn gh-btn--gold">
                        {{ $heroPrimaryLabel }}
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" id="gh-hero-cta-secondary" class="gh-btn gh-btn--ghost">
                        {{ __('messages.contact') }}
                    </a>
                </div>
            </div>
        </div>

        @if($heroSlides->count() > 1)
            <button type="button" class="gh-hero__nav gh-hero__nav--prev" data-prev aria-label="Previous slide">
                <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
            </button>
            <button type="button" class="gh-hero__nav gh-hero__nav--next" data-next aria-label="Next slide">
                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            </button>
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

<section class="home-stats">
    <div class="container">
        <div class="home-stats__grid">
            @foreach($stats as $stat)
                <div class="home-stat gh-reveal">
                    <strong>{{ $stat->number }}</strong>
                    <span>{{ $stat->title }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="home-section home-section--portal">
    <div class="container home-portal">
        <div class="home-portal__left gh-reveal">
            <p class="home-kicker">{{ __('messages.history') }}</p>
            <h2 class="home-title">{{ $aboutTitleBefore }} {{ $aboutTitleEm }}</h2>
            <ul class="home-portal__list">
                <li>
                    <i class="fa-solid fa-leaf" aria-hidden="true"></i>
                    <span>{{ __('messages.sustainable') }} — {{ __('messages.sustainable_desc') }}</span>
                </li>
                <li>
                    <i class="fa-solid fa-award" aria-hidden="true"></i>
                    <span>{{ __('messages.premium') }} — {{ __('messages.premium_desc') }}</span>
                </li>
                <li>
                    <i class="fa-solid fa-globe-africa" aria-hidden="true"></i>
                    <span>{{ __('messages.global') }} — {{ __('messages.global_desc') }}</span>
                </li>
            </ul>
            <div class="home-portal__copy">
                <p>{{ $aboutShort }}</p>
                <p>{{ $aboutParagraph2 }}</p>
                <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="home-link">
                    {{ __('messages.read_more') }}
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="home-portal__right gh-reveal">
            <figure class="home-portal__frame">
                <img src="{{ $brandStoryImage }}" alt="GMAC Coffee at origin">
            </figure>
        </div>
    </div>
</section>

<section class="home-section home-section--process">
    <div class="container">
        <div class="home-heading gh-reveal">
            <p class="home-kicker">From seedling to cup</p>
            <h2 class="home-title">Five steps we never skip</h2>
            <p class="home-copy">Quality at GMAC is a sequence: seedlings, the farm, harvest, processing, and a cupping table that still tells the hill it came from.</p>
        </div>
        <div class="home-process">
            @foreach($processSteps as $step)
                <article class="home-process__item gh-reveal">
                    @if(!empty($step['image']))
                        <div class="home-process__media">
                            <img src="{{ \App\Support\FrontendShowcase::img($step['image']) }}" alt="{{ $step['title'] }}"@if($step['image'] === 'harvest') class="is-harvest"@endif>
                        </div>
                    @endif
                    <div class="home-process__body">
                        <span class="home-process__num">{{ $step['step'] }}</span>
                        <h3>{{ $step['title'] }}</h3>
                        <p>{{ $step['text'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($featuredProducts->count() > 0)
<section class="home-section">
    <div class="container">
        <div class="home-heading home-heading--row gh-reveal">
            <div>
                <p class="home-kicker">{{ __('messages.featured_products') }}</p>
                <h2 class="home-title">Retail roasted bags</h2>
                <p class="home-copy">{{ $whyLead }}</p>
            </div>
            <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="home-link">Browse the shop <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="home-products">
            @foreach($featuredProducts->take(3) as $product)
                <article class="home-product gh-reveal">
                    <a href="{{ route('products.show', $product->slug) }}" class="home-product__media">
                        <img src="{{ $product->displayImage() }}" alt="{{ $product->name }}" class="{{ $product->usesPackShot() ? 'is-pack' : '' }}">
                    </a>
                    <div class="home-product__body">
                        <div class="home-product__pack">
                            <span class="home-product__swatch is-{{ $product->packColor() }}" aria-hidden="true"></span>
                            <span>{{ $product->packSize() }} · {{ $product->packColorLabel() }}{{ $product->packRoast() ? ' · '.$product->packRoast() : '' }}</span>
                        </div>
                        <h3 class="home-product__title">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        @if($product->barcode)
                            <p class="g-barcode">{{ $product->barcode }}</p>
                        @endif
                        <div class="home-product__meta">
                            @if($product->price)
                                <span class="home-product__price">{{ $product->formattedPrice() }}</span>
                            @endif
                            <div class="home-product__actions">
                                <form action="{{ route('cart.add', $product->slug) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="sp-card__add">{{ __('messages.add_to_cart') }}</button>
                                </form>
                                <a href="{{ route('products.show', $product->slug) }}" class="home-link">{{ __('messages.details') }}</a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($testimonials->isNotEmpty())
<section class="home-section">
    <div class="container home-faq">
        <div class="gh-reveal">
            <p class="home-kicker">{{ $reviewsKicker }}</p>
            <h2 class="home-title">{{ $reviewsTitle }} {{ $reviewsTitleEm }}</h2>
            <p class="home-copy">{{ $reviewsLead }}</p>
        </div>
        <div class="home-reviews">
            @foreach($testimonials as $review)
                <article class="home-review gh-reveal">
                    <div class="home-review__stars" aria-hidden="true">
                        @for($i = 0; $i < (int) ($review->rating ?? 5); $i++)
                            <i class="fa-solid fa-star"></i>
                        @endfor
                    </div>
                    <p class="home-review__quote">“{{ $review->quote }}”</p>
                    <div class="home-review__name">{{ $review->name }}</div>
                    <div class="home-review__role">{{ $review->role }} · {{ $review->company }}</div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="home-section home-section--cta">
    <div class="container">
        <div class="home-cta gh-reveal">
            <p class="home-kicker">{{ $ctaKicker }}</p>
            <h2 class="home-title">{{ $ctaTitle }} {{ $ctaTitleEm }}</h2>
            <p class="home-copy">{{ $ctaLead }}</p>
            <div class="home-cta__actions">
                <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="gh-btn gh-btn--gold">Shop coffee</a>
                <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="gh-btn gh-btn--ghost home-cta__ghost">{{ __('messages.contact') }}</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
.gh-reveal { opacity: 0; transform: translateY(16px); transition: opacity .5s ease, transform .5s ease; }
.gh-reveal.is-visible { opacity: 1; transform: none; }
.gh-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 44px;
    padding: 0.7rem 1.2rem;
    border-radius: 999px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    border: 1px solid transparent;
}
.gh-btn--gold { background: #7a6452; color: #fff; }
.gh-btn--ghost { background: #fff; color: #3f3731; border-color: rgba(255,255,255,.7); }

.gh-hero { position: relative; min-height: min(78vh, 720px); overflow: hidden; background: #5c4a3c; }
.gh-hero__slider, .gh-hero__track, .gh-hero__slide { position: absolute; inset: 0; }
.gh-hero__slide { opacity: 0; transition: opacity .8s ease; }
.gh-hero__slide.is-active { opacity: 1; z-index: 1; }
.gh-hero__slide-img { width: 100%; height: 100%; object-fit: cover; object-position: center 40%; display: block; transform: scale(1.04); }
.gh-hero__slide.is-active .gh-hero__slide-img { animation: ghKen 7.5s ease-out forwards; }
@keyframes ghKen { from { transform: scale(1.08); } to { transform: scale(1); } }
.gh-hero__copy.is-text-animating .gh-hero__badge,
.gh-hero__copy.is-text-animating .gh-hero__h1,
.gh-hero__copy.is-text-animating .gh-hero__lead,
.gh-hero__copy.is-text-animating .gh-hero__actions {
    animation: ghIn .7s ease both;
}
.gh-hero__copy.is-text-animating .gh-hero__h1 { animation-delay: .08s; }
.gh-hero__copy.is-text-animating .gh-hero__lead { animation-delay: .16s; }
.gh-hero__copy.is-text-animating .gh-hero__actions { animation-delay: .24s; }
@keyframes ghIn { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
.gh-hero__nav {
    position: absolute; top: 50%; z-index: 5; transform: translateY(-50%);
    width: 42px; height: 42px; border: 1px solid rgba(255,255,255,.28);
    background: rgba(255,255,255,.12); color: #fff; border-radius: 999px;
    cursor: pointer; backdrop-filter: blur(8px);
}
.gh-hero__nav--prev { left: 1.25rem; }
.gh-hero__nav--next { right: 1.25rem; }
.gh-hero__nav:hover { background: rgba(255,255,255,.22); }
.gh-hero__ambient-fallback {
    position: absolute; inset: 0;
    background: linear-gradient(160deg, #3d2918 0%, #5a3d28 50%, #2a1c14 100%);
}
.gh-hero__ambient-fallback .gh-hero__slide-img { position: absolute; inset: 0; }
.gh-hero__overlay {
    position: absolute; inset: 0; z-index: 1;
    background: linear-gradient(180deg, rgba(28,16,10,.18) 0%, rgba(28,16,10,.42) 42%, rgba(28,16,10,.78) 100%);
}
.gh-hero__inner {
    position: relative; z-index: 2;
    min-height: min(78vh, 720px);
    display: flex; align-items: flex-end;
    padding: 5.5rem 0 8.5rem;
}
.gh-hero__copy { max-width: 40rem; color: #fff; }
.gh-hero__badge {
    display: inline-flex; align-items: center;
    margin-bottom: 1rem;
    padding: 0.4rem 0.85rem;
    border-radius: 999px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.18);
    color: rgba(255,255,255,.88);
    font-size: 0.78rem; font-weight: 500;
}
.gh-hero__h1 {
    font-family: 'Fraunces', 'Times New Roman', serif;
    font-size: clamp(2.6rem, 5.4vw, 4.2rem);
    font-weight: 500; line-height: 1.08;
    letter-spacing: -0.02em;
    color: #fff; margin: 0 0 0.85rem;
}
.gh-hero__lead { color: rgba(255,255,255,.78); font-size: 1.02rem; line-height: 1.7; margin: 0 0 1.4rem; }
.gh-hero__actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.gh-hero__dots {
    position: absolute; left: 1.5rem; bottom: 6.5rem; z-index: 4;
    display: flex; gap: 0.4rem;
}
.gh-hero__dot {
    width: 18px; height: 3px; border: none; border-radius: 99px;
    background: rgba(255,255,255,.35); cursor: pointer;
}
.gh-hero__dot.is-active { background: #b08d4a; width: 28px; }

.home-stats {
    position: relative;
    z-index: 4;
    padding: 0;
    background: #fff;
    border-bottom: 1px solid #e7e2db;
}
.home-stats__grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
}
.home-stat {
    background: none;
    border: 0;
    border-right: 1px solid #e7e2db;
    border-radius: 0;
    padding: 1.4rem 1.2rem;
    box-shadow: none;
    text-align: center;
}
.home-stat:last-child { border-right: 0; }
.home-stat strong {
    display: block;
    font-family: 'Fraunces', 'Times New Roman', serif;
    font-size: 1.7rem;
    font-weight: 500;
    color: #3f3731;
    letter-spacing: -0.03em;
}
.home-stat span { display: block; margin-top: 0.25rem; color: #7d736a; font-size: 0.8rem; }

.home-section { padding: 5rem 0; background: #f5f3f0; }
.home-kicker {
    color: #9a7d4e;
    font-size: 0.72rem;
    font-weight: 500;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    margin: 0 0 0.7rem;
}
.home-title {
    font-family: 'Fraunces', 'Times New Roman', serif;
    font-size: clamp(2rem, 3.4vw, 2.7rem);
    font-weight: 500;
    color: #3f3731;
    margin: 0 0 0.8rem;
    line-height: 1.15;
    letter-spacing: -0.02em;
}
.home-copy { color: #6b5344; line-height: 1.75; max-width: 54ch; }
.home-link { display: inline-flex; align-items: center; gap: 0.4rem; color: #3d2918; font-size: 0.88rem; font-weight: 600; text-decoration: none; }
.home-heading--row { display: flex; align-items: flex-end; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; }

.home-portal { display: grid; grid-template-columns: minmax(0, 1fr) minmax(280px, 1.05fr); gap: 3.25rem; align-items: stretch; }
.home-portal__left { display: flex; flex-direction: column; justify-content: center; }
.home-portal__left .home-title { margin-bottom: 1.15rem; }
.home-portal__list { list-style: none; padding: 0; margin: 0 0 1.35rem; display: grid; gap: 0.85rem; }
.home-portal__list li { display: flex; gap: 0.8rem; align-items: flex-start; color: #6b5344; line-height: 1.55; font-size: 0.95rem; }
.home-portal__list i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    flex-shrink: 0;
    margin-top: 0.05rem;
    border-radius: 999px;
    background: #efe8df;
    color: #9a7d4e;
    font-size: 0.72rem;
}
.home-portal__copy p { color: #6b5344; line-height: 1.75; margin: 0 0 0.85rem; max-width: 48ch; }
.home-portal__copy p:last-of-type { margin-bottom: 1rem; }
.home-portal__frame {
    margin: 0;
    height: 100%;
    min-height: 420px;
    background: #efe8df;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 18px 44px rgba(42, 28, 20, 0.08);
}
.home-portal__frame img { width: 100%; height: 100%; object-fit: cover; object-position: 50% 12%; display: block; }

.home-process { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 1.15rem; margin-top: 2.2rem; }
.home-process__item {
    display: flex;
    flex-direction: column;
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 16px;
    padding: 0;
    overflow: hidden;
    min-height: 100%;
    box-shadow: 0 10px 28px rgba(42,28,20,.06);
}
.home-process__media { height: 176px; margin: 0; overflow: hidden; flex-shrink: 0; background: #f5f3f0; }
.home-process__media img { width: 100%; height: 100%; object-fit: cover; object-position: 50% 22%; display: block; border-radius: 0; }
.home-process__media img.is-harvest { object-fit: contain; object-position: center; background: #f5f3f0; }
.home-process__body { padding: 1.05rem 1.1rem 1.2rem; display: flex; flex-direction: column; flex: 1; }
.home-process__num {
    display: block;
    color: #9a7d4e;
    font-family: 'Fraunces', 'Times New Roman', serif;
    font-weight: 500;
    font-size: 0.92rem;
    letter-spacing: 0.06em;
    margin: 0 0 0.45rem;
}
.home-process__item h3 { margin: 0 0 0.4rem; font-size: 1.12rem; color: #3f3731; }
.home-process__item p { margin: 0; color: #6b5344; font-size: 0.88rem; line-height: 1.6; }

.home-products, .home-reviews { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-top: 2rem; }
.home-product, .home-review {
    background: none;
    border: 0;
    border-radius: 0;
    overflow: hidden;
}
.home-product__media { display: block; overflow: hidden; }
.home-product__media img, .home-product__placeholder { width: 100%; height: 280px; object-fit: cover; display: block; transition: transform .6s ease; }
.home-product__media img.is-pack { object-fit: contain; background: #f7f4f0; }
.home-product:hover .home-product__media img { transform: scale(1.04); }
.home-product__placeholder { background: #efe6d8; display: flex; align-items: center; justify-content: center; color: #c4a15a; font-size: 2rem; }
.home-product__body { padding: 1.1rem 1.15rem 1.25rem; }
.home-review { padding: 1.2rem 1.15rem 1.3rem; }
.home-product__pack { display: flex; align-items: center; gap: 0.4rem; color: #7a6452; font-size: 0.74rem; font-weight: 600; }
.home-product__swatch { width: 12px; height: 12px; border-radius: 999px; border: 1px solid rgba(63,55,49,.12); flex-shrink: 0; }
.home-product__swatch.is-red { background: #c0392b; }
.home-product__swatch.is-chocolate { background: #c4a574; }
.home-product__swatch.is-green { background: #2f7a4a; }
.home-product__title { font-family: 'Fraunces', 'Times New Roman', serif; font-size: 1.35rem; font-weight: 500; margin: 0.4rem 0 0.5rem; }
.home-product__title a { color: inherit; text-decoration: none; }
.home-review__quote { color: #6b5344; font-size: 0.95rem; line-height: 1.65; margin: 0 0 0.8rem; }
.home-product__meta { display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap; }
.home-product__actions { display: flex; align-items: center; gap: 0.7rem; }
.home-product__price { font-weight: 600; color: #3f3731; }
.home-product .sp-card__add {
    min-height: 38px;
    padding: 0.5rem 1rem;
    border: 0;
    border-radius: 999px;
    background: #7a6452;
    color: #fff;
    font: 500 0.8rem/1 Poppins, sans-serif;
    cursor: pointer;
}
.home-product .sp-card__add:hover { background: #8d7560; }
.home-product__actions form { margin: 0; }
.home-review__stars { color: #b89a6a; font-size: 0.72rem; letter-spacing: 0.12em; margin-bottom: 0.65rem; }
.home-review__quote { font-family: 'Fraunces', 'Times New Roman', serif; font-size: 1.15rem; font-style: italic; color: #3f3731; }
.home-review__name { font-weight: 600; }
.home-review__role { color: #7d736a; font-size: 0.75rem; margin-top: 0.2rem; }

.home-cta {
    background:
        radial-gradient(circle at 20% 20%, rgba(228,201,138,.16), transparent 28%),
        #5c4a3c;
    color: #fff;
    border-radius: 24px;
    padding: 4.2rem 1.8rem;
    text-align: center;
}
.home-section--cta { padding: 3.5rem 0 4.5rem; background: #f5f3f0; }
.home-section--cta .home-kicker { color: #e4c98a; }
.home-section--cta .home-title, .home-section--cta .home-copy { color: #fff; margin-left: auto; margin-right: auto; }
.home-cta__actions { display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap; margin-top: 1.2rem; }
.home-cta__ghost { background: transparent !important; color: #fff !important; border-color: rgba(255,255,255,.28) !important; }

@media (max-width: 1180px) {
    .home-process { grid-template-columns: repeat(3, minmax(0, 1fr)); }
}
@media (max-width: 900px) {
    .home-portal, .home-products, .home-reviews, .home-process { grid-template-columns: 1fr; }
    .home-stats__grid { grid-template-columns: 1fr 1fr; }
    .home-stat { border-right: 0; border-bottom: 1px solid #e7e2db; }
    .home-portal__frame { min-height: 280px; height: 320px; }
    .gh-hero__inner { padding: 4.5rem 0 4.5rem; }
}
</style>
<script>
(function() {
    var els = document.querySelectorAll('.gh-reveal');
    var io  = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.1 });
    els.forEach(function(el) { io.observe(el); });
})();
</script>
@endpush
