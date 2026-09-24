@extends('layouts.frontend')

@section('title', $product->name . ' - GMAC Coffee')
@section('meta_description', $product->short_description ?? Str::limit(strip_tags($product->description), 160))

@section('content')
@php
    $barcode = $product->barcode;
    $barcodeSvg = $barcode ? \App\Support\Ean13Barcode::svg($barcode, 2, 64) : null;
    $unitPrice = $product->price !== null ? (float) $product->price : null;
    $roast = $product->packRoast();
    $aboutLead = 'A '.$product->packSize().' roasted Arabica bag in the '.$product->packColorLabel().' envelope'
        .($roast ? ', finished as a '.strtolower($roast) : '')
        .'. Packed in Niboye, Kigali by Green Mountain Arabica Coffee Ltd.';
@endphp

<section class="pd-page">
    <div class="container">
        <nav class="pd-crumb" aria-label="Breadcrumb">
            <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}">{{ __('messages.home') }}</a>
            <span>/</span>
            <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}">{{ __('messages.nav_shop') }}</a>
            <span>/</span>
            <em>{{ $product->name }}</em>
        </nav>

        <div class="pd-layout">
            <div class="pd-gallery">
                <button type="button" class="pd-gallery__stage" id="pd-zoom" aria-label="View larger image">
                    <img
                        src="{{ $gallery[0]['src'] }}"
                        alt="{{ $product->name }}"
                        id="pd-main-image"
                        class="{{ !empty($gallery[0]['pack']) ? 'is-pack' : '' }}"
                    >
                    <span class="pd-gallery__hint" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="7" cy="7" r="4.2"/><path d="M10.4 10.4 14 14"/></svg>
                    </span>
                </button>
                @if($gallery->count() > 1)
                    <div class="pd-thumbs" role="list">
                        @foreach($gallery as $i => $shot)
                            <button
                                type="button"
                                class="pd-thumb {{ $i === 0 ? 'is-active' : '' }}"
                                data-src="{{ $shot['src'] }}"
                                data-pack="{{ !empty($shot['pack']) ? '1' : '0' }}"
                                aria-label="{{ $shot['label'] }}"
                            >
                                <img src="{{ $shot['src'] }}" alt="{{ $shot['label'] }}" class="{{ !empty($shot['pack']) ? 'is-pack' : '' }}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="pd-info">
                <p class="pd-kicker">{{ $product->packSize() }} · {{ $product->packColorLabel() }}@if($product->packRoast()) · {{ $product->packRoast() }}@endif</p>
                <h1 class="pd-title">{{ $product->name }}</h1>
                @if($unitPrice !== null)
                    <p class="pd-price" id="pd-unit-price" data-unit="{{ $unitPrice }}">{{ $product->formattedPrice() }}</p>
                @else
                    <p class="pd-price pd-price--soft">{{ __('messages.price_on_request') }}</p>
                @endif
                <p class="pd-lead">{{ $aboutLead }}</p>

                @if(isset($colours) && $colours->count() > 1)
                    <div class="pd-colours">
                        <p>Envelope colour</p>
                        <div class="pd-colours__row">
                            @foreach($colours as $colour)
                                <a
                                    href="{{ route('products.show', $colour->slug) }}"
                                    class="pd-colour is-{{ $colour->packColor() }} {{ $colour->id === $product->id ? 'is-active' : '' }}"
                                >
                                    <span class="pd-colour__swatch" aria-hidden="true"></span>
                                    <span>
                                        <strong>{{ $colour->packColorLabel() }}</strong>
                                        <em>{{ $colour->packRoast() ?: $colour->formattedPrice() }}</em>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($variants->count() > 1)
                    <div class="pd-sizes">
                        <p>Size</p>
                        <div class="pd-sizes__row">
                            @foreach($variants as $variant)
                                <a
                                    href="{{ route('products.show', $variant->slug) }}"
                                    class="pd-size {{ $variant->id === $product->id ? 'is-active' : '' }}"
                                >
                                    <strong>{{ $variant->packSize() }}</strong>
                                    <span>{{ $variant->formattedPrice() }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="pd-buy">
                    <p class="pd-buy__note">{{ __('messages.no_payment_note') }}</p>
                    <form action="{{ route('cart.add', $product->slug) }}" method="post" class="pd-buy__form" id="pd-cart-form">
                        @csrf
                        <div class="pd-stepper">
                            <span>{{ __('messages.quantity') }}</span>
                            <div class="pd-stepper__row">
                                <button type="button" class="pd-stepper__btn" data-step="-1" aria-label="Decrease quantity">−</button>
                                <input id="pd-qty" type="number" name="qty" value="1" min="1" max="500">
                                <button type="button" class="pd-stepper__btn" data-step="1" aria-label="Increase quantity">+</button>
                            </div>
                        </div>
                        <button type="submit" class="pd-add">
                            <span>{{ __('messages.add_to_cart') }}</span>
                            @if($unitPrice !== null)
                                <em id="pd-line">{{ \App\Models\Product::rwf($unitPrice) }}</em>
                            @endif
                        </button>
                    </form>
                    <div class="pd-buy__links">
                        <a href="{{ route('cart.index') }}">{{ __('messages.view_cart') }}</a>
                        <a href="{{ LaravelLocalization::localizeUrl(url('/contact?product=' . urlencode($product->name))) }}">{{ __('messages.contact') }}</a>
                    </div>
                    <div class="pd-share">
                        <p>{{ __('messages.share_product') }}</p>
                        <div class="pd-share__row">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook">Facebook</a>
                            <a href="https://wa.me/?text={{ rawurlencode($product->name.' '.url()->current()) }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">WhatsApp</a>
                            <a href="{{ \App\Support\SiteLinks::instagram() }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram">Instagram</a>
                            <button type="button" class="pd-share__copy" id="pd-copy-link" data-link="{{ url()->current() }}" data-label="{{ __('messages.copy_link') }}">{{ __('messages.copy_link') }}</button>
                        </div>
                    </div>
                </div>

                @if($barcode)
                    <aside class="pd-barcode" id="pd-barcode">
                        <div class="pd-barcode__art" aria-hidden="true">
                            {!! $barcodeSvg !!}
                        </div>
                        <div class="pd-barcode__meta">
                            <p class="pd-barcode__kicker">GS1 barcode</p>
                            <p class="pd-barcode__gtin" id="pd-barcode-value">{{ $barcode }}</p>
                        </div>
                        <button type="button" class="pd-barcode__copy" id="pd-copy" data-code="{{ $barcode }}">Copy</button>
                    </aside>
                @endif
            </div>
        </div>

        <div class="pd-tabs">
            <div class="pd-tabs__nav" role="tablist">
                <button type="button" class="pd-tab is-active" data-tab="about" role="tab" aria-selected="true">About this bag</button>
                <button type="button" class="pd-tab" data-tab="specs" role="tab" aria-selected="false">Details</button>
                <button type="button" class="pd-tab" data-tab="origin" role="tab" aria-selected="false">Origin</button>
            </div>
            <div class="pd-tabs__panel is-active" data-panel="about">
                <div class="pd-copy">
                    <p>{{ $aboutLead }}</p>
                    <p>Pick the envelope colour first, then the size. Red is dark roast, chocolate is light roast, and each bag has its own official GS1 barcode for retail.</p>
                    <p>There is no online payment. Add the bags you want, send the list to info@gmac.coffee, and we reply with availability and next steps.</p>
                </div>
            </div>
            <div class="pd-tabs__panel" data-panel="specs" hidden>
                <ul class="pd-specs">
                    <li>Net weight {{ $product->packSize() }}</li>
                    <li>{{ $product->packColorLabel() }} envelope</li>
                    @if($roast)<li>{{ $roast }}</li>@endif
                    <li>Arabica · roasted</li>
                    <li>Origin Rwanda</li>
                    @if($barcode)<li>GTIN {{ $barcode }}</li>@endif
                </ul>
                <p class="pd-spec-line"><strong>Pack</strong> {{ $product->packSize() }} · {{ $product->packColorLabel() }}</p>
                <p class="pd-spec-line"><strong>Price</strong> {{ $product->formattedPrice() ?? __('messages.price_on_request') }}</p>
                <p class="pd-spec-line"><strong>Made by</strong> Green Mountain Arabica Coffee Ltd, Kigali</p>
                @if($barcode)
                    <p class="pd-spec-line"><strong>GTIN / barcode</strong> {{ $barcode }}</p>
                @endif
            </div>
            <div class="pd-tabs__panel" data-panel="origin" hidden>
                <p>Green Mountain Arabica Coffee Ltd packs this retail bag in Niboye Sector, Kicukiro District, Kigali, Rwanda. Cherry is received at Karenge, then washed, dried, milled, roasted, and packed with a registered GS1 barcode.</p>
                <p>Republic of Rwanda · Kigali City · Kicukiro District · Niboye Sector · info@gmac.coffee</p>
            </div>
        </div>

        @if($related->count() > 0)
            <div class="pd-related">
                <div class="pd-related__head">
                    <p class="pd-kicker">More bags</p>
                    <h2>You might also like</h2>
                </div>
                <div class="pd-related__grid">
                    @foreach($related as $rel)
                        <article class="pd-card">
                            <a href="{{ route('products.show', $rel->slug) }}" class="pd-card__media">
                                <img src="{{ $rel->displayImage() }}" alt="{{ $rel->name }}" class="{{ $rel->usesPackShot() ? 'is-pack' : '' }}">
                            </a>
                            <div class="pd-card__body">
                                <span>{{ $rel->packSize() }} · {{ $rel->packColorLabel() }}</span>
                                <h3><a href="{{ route('products.show', $rel->slug) }}">{{ $rel->name }}</a></h3>
                                @if($rel->barcode)
                                    <p class="pd-card__code">{{ $rel->barcode }}</p>
                                @endif
                                @if($rel->price)
                                    <strong>{{ $rel->formattedPrice() }}</strong>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<div class="pd-lightbox" id="pd-lightbox" hidden>
    <button type="button" class="pd-lightbox__back" data-close-lightbox aria-label="Close"></button>
    <img src="" alt="{{ $product->name }}" id="pd-lightbox-img">
</div>
@endsection

@push('styles')
<style>
.pd-page { padding: 1.5rem 0 5rem; background: #f5f3f0; }
.pd-crumb { display: flex; flex-wrap: wrap; gap: 0.45rem; color: #7d736a; font-size: 0.82rem; margin-bottom: 1.3rem; }
.pd-crumb a { color: inherit; text-decoration: none; }
.pd-crumb a:hover { color: #3f3731; }
.pd-crumb em { font-style: normal; color: #3f3731; font-weight: 600; }

.pd-layout { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 2rem; align-items: start; }

.pd-info { position: sticky; top: 6.4rem; }

.pd-gallery__stage {
    position: relative;
    display: grid;
    place-items: center;
    width: 100%;
    aspect-ratio: 1 / 1;
    border: 1px solid #e7e2db;
    padding: 0;
    border-radius: 22px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 16px 44px rgba(42,28,20,.06);
    cursor: zoom-in;
}
.pd-gallery__stage img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center 32%;
    display: block;
    padding: 0.55rem 0.85rem 0.35rem;
    box-sizing: border-box;
    background: #fff;
}
.pd-gallery__stage img:not(.is-pack) { object-fit: cover; object-position: 50% 40%; padding: 0; }
.pd-gallery__hint {
    position: absolute;
    right: 0.9rem;
    bottom: 0.9rem;
    width: 34px;
    height: 34px;
    display: grid;
    place-items: center;
    border-radius: 999px;
    background: #fff;
    color: #7a6452;
    border: 1px solid #e7e2db;
}
.pd-gallery { min-width: 0; }
.pd-thumbs {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 0.7rem;
    margin-top: 0.85rem;
    width: 100%;
}
.pd-thumb {
    position: relative;
    aspect-ratio: 1 / 1;
    min-width: 0;
    min-height: 0;
    padding: 0;
    border: 1px solid #e7e2db;
    background: #f7f4f0;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
}
.pd-thumb.is-active { border-color: #7a6452; box-shadow: 0 0 0 2px rgba(122,100,82,.2); }
.pd-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: 50% 42%;
    display: block;
}
.pd-thumb img.is-pack {
    object-fit: contain;
    object-position: center 32%;
    padding: 0.35rem 0.35rem 0.2rem;
    box-sizing: border-box;
    background: #f7f4f0;
}

.pd-kicker { margin: 0 0 0.35rem; color: #7a6452; font-size: 0.78rem; font-weight: 600; }
.pd-title { margin: 0 0 0.35rem; font-size: clamp(1.7rem, 3.4vw, 2.25rem); line-height: 1.15; color: #2a1c14; }
.pd-price { margin: 0 0 0.7rem; font-size: 1.55rem; font-weight: 600; color: #2a1c14; }
.pd-price--soft { font-size: 1rem; color: #7a6452; }
.pd-lead { margin: 0 0 1.1rem; color: #6b5344; line-height: 1.65; max-width: 46ch; font-size: 0.95rem; }

.pd-colours { margin: 0 0 0.9rem; }
.pd-colours p,
.pd-sizes p { margin: 0 0 0.45rem; font-size: 0.78rem; font-weight: 600; color: #7d736a; }
.pd-colours__row { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 0.45rem; }
.pd-colour {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-height: 52px;
    padding: 0.5rem 0.65rem;
    border-radius: 14px;
    border: 1px solid #e7e2db;
    background: #fff;
    color: #3f3731;
    text-decoration: none;
}
.pd-colour strong { display: block; font-size: 0.82rem; line-height: 1.2; }
.pd-colour em { display: block; font-style: normal; color: #7d736a; font-size: 0.72rem; margin-top: 0.15rem; }
.pd-colour__swatch {
    width: 22px;
    height: 22px;
    border-radius: 999px;
    flex-shrink: 0;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1px #d8cfc4;
}
.pd-colour.is-red .pd-colour__swatch { background: #c0392b; }
.pd-colour.is-chocolate .pd-colour__swatch { background: linear-gradient(135deg, #c4a574, #8d6e45); }
.pd-colour.is-green .pd-colour__swatch { background: #3f7a4d; }
.pd-colour.is-active { border-color: #7a6452; background: #efe8df; }

.pd-sizes { margin: 0 0 1rem; }
.pd-sizes__row { display: flex; flex-wrap: wrap; gap: 0.5rem; }
.pd-size {
    display: grid;
    gap: 0.15rem;
    min-width: 92px;
    padding: 0.7rem 0.85rem;
    border-radius: 14px;
    border: 1px solid #e7e2db;
    background: #fff;
    color: #3f3731;
    text-decoration: none;
}
.pd-size strong { font-size: 0.95rem; }
.pd-size span { color: #7d736a; font-size: 0.75rem; }
.pd-size.is-active { border-color: #7a6452; background: #efe8df; }

.pd-barcode {
    margin: 0.9rem 0 0;
    padding: 0.75rem 0.9rem;
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 16px;
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr) auto;
    gap: 0.75rem;
    align-items: center;
}
.pd-barcode__kicker { margin: 0 0 0.15rem; color: #7d736a; font-size: 0.7rem; font-weight: 600; }
.pd-barcode__gtin {
    margin: 0;
    font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
    font-size: 0.95rem;
    letter-spacing: 0.06em;
    color: #1a120c;
    font-weight: 700;
}
.pd-barcode__copy {
    border: 1px solid #e7e2db;
    background: #f5f3f0;
    color: #5c4a3c;
    border-radius: 999px;
    min-height: 36px;
    padding: 0 0.85rem;
    font: 500 0.78rem/1 Poppins, sans-serif;
    cursor: pointer;
}
.pd-barcode__copy.is-done { background: #7a6452; color: #fff; border-color: #7a6452; }
.pd-barcode__art {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 52px;
    background: #fff;
    overflow: hidden;
}
.pd-barcode__art svg { max-width: 100%; height: 52px; }

.pd-buy { background: #fff; border: 1px solid #e7e2db; border-radius: 20px; padding: 1.15rem 1.2rem 1.25rem; box-shadow: 0 12px 32px rgba(42,28,20,.05); }
.pd-buy__note { margin: 0 0 0.9rem; color: #7d736a; font-size: 0.85rem; line-height: 1.55; }
.pd-buy__form { display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: flex-end; }
.pd-stepper { display: grid; gap: 0.35rem; }
.pd-stepper > span { font-size: 0.75rem; font-weight: 600; color: #7d736a; }
.pd-stepper__row { display: flex; align-items: center; border: 1px solid #e7e2db; border-radius: 999px; overflow: hidden; background: #f5f3f0; }
.pd-stepper__btn {
    width: 42px;
    min-height: 46px;
    border: 0;
    background: transparent;
    color: #3f3731;
    font-size: 1.2rem;
    cursor: pointer;
}
.pd-stepper input {
    width: 54px;
    min-height: 46px;
    border: 0;
    background: transparent;
    text-align: center;
    font: 600 1rem/1 Poppins, sans-serif;
}
.pd-add {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    min-height: 46px;
    padding: 0 1.2rem;
    border: 0;
    border-radius: 999px;
    background: #7a6452;
    color: #fff;
    font: 500 0.9rem/1 Poppins, sans-serif;
    cursor: pointer;
    flex: 1;
}
.pd-add:hover { background: #8d7560; }
.pd-add em { font-style: normal; font-weight: 600; }
.pd-buy__links { display: flex; gap: 1rem; margin-top: 0.85rem; }
.pd-buy__links a { color: #7a6452; font-size: 0.86rem; font-weight: 600; text-decoration: none; }
.pd-share { margin-top: 1rem; padding-top: 0.9rem; border-top: 1px solid #eee8e1; }
.pd-share p { margin: 0 0 0.45rem; font-size: 0.75rem; font-weight: 600; color: #7d736a; }
.pd-share__row { display: flex; flex-wrap: wrap; gap: 0.45rem; }
.pd-share__row a, .pd-share__copy {
    min-height: 34px; padding: 0 0.75rem; border-radius: 999px; border: 1px solid #e7e2db;
    background: #f5f3f0; color: #5c4a3c; font: 500 0.75rem/1 Poppins, sans-serif; text-decoration: none;
    display: inline-flex; align-items: center; cursor: pointer;
}

.pd-tabs { margin-top: 2.6rem; background: #fff; border: 1px solid #e7e2db; border-radius: 20px; padding: 0.4rem 1.25rem 1.4rem; }
.pd-tabs__nav { display: flex; gap: 0.4rem; border-bottom: 1px solid #e7e2db; margin-bottom: 1.1rem; }
.pd-tab {
    border: 0;
    background: none;
    padding: 0.95rem 0.85rem;
    color: #7d736a;
    font: 600 0.86rem/1 Poppins, sans-serif;
    cursor: pointer;
    border-bottom: 2px solid transparent;
}
.pd-tab.is-active { color: #3f3731; border-bottom-color: #7a6452; }
.pd-copy, .pd-tabs__panel { color: #6b5344; line-height: 1.75; }
.pd-copy p { margin: 0 0 0.85rem; }
.pd-specs { list-style: none; margin: 0 0 1rem; padding: 0; display: flex; flex-wrap: wrap; gap: 0.45rem; }
.pd-specs li { background: #f5f3f0; border-radius: 999px; padding: 0.4rem 0.8rem; font-size: 0.8rem; color: #5c4a3c; }
.pd-spec-line { margin: 0 0 0.55rem; }
.pd-spec-line strong { display: inline-block; min-width: 8rem; color: #3f3731; }

.pd-related { margin-top: 3.2rem; }
.pd-related__head { margin-bottom: 1.1rem; }
.pd-related__head h2 { margin: 0; font-size: 1.5rem; color: #2a1c14; }
.pd-related__grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1rem; }
.pd-card { background: #fff; border: 1px solid #e7e2db; border-radius: 18px; overflow: hidden; }
.pd-card__media img { width: 100%; height: 170px; object-fit: cover; display: block; }
.pd-card__media img.is-pack { object-fit: contain; background: #fff; }
.pd-card__body { padding: 0.95rem 1rem 1.1rem; }
.pd-card__body span { color: #9a7d4e; font-size: 0.7rem; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; }
.pd-card__body h3 { margin: 0.3rem 0 0.35rem; font-size: 1rem; }
.pd-card__body a { color: #2a1c14; text-decoration: none; }
.pd-card__code { margin: 0 0 0.35rem; font-family: ui-monospace, Menlo, Consolas, monospace; font-size: 0.72rem; letter-spacing: .04em; color: #7a6452; }
.pd-card__body strong { color: #2a1c14; }

.pd-lightbox {
    position: fixed;
    inset: 0;
    z-index: 2400;
    display: grid;
    place-items: center;
    padding: 2rem;
}
.pd-lightbox[hidden] { display: none; }
.pd-lightbox__back { position: absolute; inset: 0; border: 0; background: rgba(26,16,8,.72); cursor: pointer; }
.pd-lightbox img { position: relative; z-index: 1; max-width: min(920px, 92vw); max-height: 86vh; border-radius: 18px; background: #fff; }

@media (max-width: 900px) {
    .pd-layout, .pd-related__grid { grid-template-columns: 1fr; }
    .pd-info { position: static; }
    .pd-gallery__stage { aspect-ratio: 4 / 5; }
    .pd-thumbs { grid-template-columns: repeat(4, minmax(0, 1fr)); }
    .pd-barcode { grid-template-columns: 1fr auto; }
    .pd-barcode__art { grid-column: 1 / -1; }
    .pd-add { width: 100%; }
    .pd-colours__row { grid-template-columns: 1fr; }
}
@media (max-width: 520px) {
    .pd-thumbs { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    var main = document.getElementById('pd-main-image');
    var thumbs = document.querySelectorAll('.pd-thumb');
    thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            thumbs.forEach(function (t) { t.classList.remove('is-active'); });
            thumb.classList.add('is-active');
            if (!main) return;
            main.src = thumb.getAttribute('data-src');
            main.classList.toggle('is-pack', thumb.getAttribute('data-pack') === '1');
        });
    });

    var qty = document.getElementById('pd-qty');
    var line = document.getElementById('pd-line');
    var priceEl = document.getElementById('pd-unit-price');
    var unit = priceEl ? parseFloat(priceEl.getAttribute('data-unit') || '0') : 0;
    function formatFrw(n) {
        return Math.round(n).toLocaleString('en-US') + ' frw';
    }
    function syncLine() {
        if (!qty || !line || !unit) return;
        var n = Math.max(1, Math.min(500, parseInt(qty.value || '1', 10)));
        qty.value = n;
        line.textContent = formatFrw(unit * n);
    }
    document.querySelectorAll('.pd-stepper__btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!qty) return;
            qty.value = (parseInt(qty.value || '1', 10) || 1) + parseInt(btn.getAttribute('data-step'), 10);
            syncLine();
        });
    });
    if (qty) qty.addEventListener('input', syncLine);

    var copyLink = document.getElementById('pd-copy-link');
    if (copyLink) {
        copyLink.addEventListener('click', function () {
            var href = copyLink.getAttribute('data-link') || window.location.href;
            if (navigator.clipboard) navigator.clipboard.writeText(href);
            copyLink.textContent = 'Copied';
            setTimeout(function () { copyLink.textContent = copyLink.getAttribute('data-label') || 'Copy link'; }, 1400);
        });
    }

    var copyBtn = document.getElementById('pd-copy');
    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            var code = copyBtn.getAttribute('data-code') || '';
            if (navigator.clipboard) navigator.clipboard.writeText(code);
            copyBtn.textContent = 'Copied';
            copyBtn.classList.add('is-done');
            setTimeout(function () {
                copyBtn.textContent = 'Copy';
                copyBtn.classList.remove('is-done');
            }, 1600);
        });
    }

    var tabs = document.querySelectorAll('.pd-tab');
    var panels = document.querySelectorAll('.pd-tabs__panel');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var id = tab.getAttribute('data-tab');
            tabs.forEach(function (t) {
                t.classList.toggle('is-active', t === tab);
                t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
            });
            panels.forEach(function (panel) {
                var on = panel.getAttribute('data-panel') === id;
                panel.classList.toggle('is-active', on);
                panel.hidden = !on;
            });
        });
    });

    var lightbox = document.getElementById('pd-lightbox');
    var lightImg = document.getElementById('pd-lightbox-img');
    var zoom = document.getElementById('pd-zoom');
    if (zoom && lightbox && lightImg) {
        zoom.addEventListener('click', function () {
            lightImg.src = main ? main.src : zoom.querySelector('img').src;
            lightbox.hidden = false;
        });
        lightbox.querySelectorAll('[data-close-lightbox]').forEach(function (el) {
            el.addEventListener('click', function () { lightbox.hidden = true; });
        });
    }
})();
</script>
@endpush
