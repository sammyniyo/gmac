@extends('layouts.frontend')

@section('title', __('messages.cart_title') . ' - GMAC Coffee')

@section('content')
@php
    $itemCount = (int) ($count ?? collect($items)->sum('qty'));
    $suggestions = $suggestions ?? collect();
@endphp
<section class="bag">
    <div class="container">
        <header class="bag__head">
            <p class="bag__crumb">
                <a href="{{ route('shop') }}">{{ __('messages.nav_shop') }}</a>
                <span>/</span>
                {{ __('messages.cart_title') }}
            </p>
            <h1>{{ __('messages.cart_title') }}</h1>
            <p class="bag__meta">
                @if($itemCount)
                    {{ $itemCount }} {{ $itemCount === 1 ? 'bag' : 'bags' }} ready to request. Nothing is charged here.
                @else
                    Choose a roasted bag, then email the list to GMAC.
                @endif
            </p>
        </header>

        @include('partials.frontend.cart-steps', ['current' => 1, 'canCheckout' => $itemCount > 0])

        @if(session('cart_success'))
            <div class="bag__flash bag__flash--ok">{{ session('cart_success') }}</div>
        @endif
        @if(session('cart_error'))
            <div class="bag__flash bag__flash--err">{{ session('cart_error') }}</div>
        @endif

        @if($itemCount === 0)
            <div class="bag__empty">
                <p class="bag__kicker">Empty bag</p>
                <h2>{{ __('messages.cart_empty') }}</h2>
                <p>Add a 250g, 500g, or 1kg roasted bag. We reply by email with availability — no card is taken on this site.</p>
                <a href="{{ route('shop') }}" class="bag__btn bag__btn--inline">{{ __('messages.continue_shopping') }}</a>
            </div>
        @else
            <div class="bag__grid">
                <div class="bag__sheet">
                    @foreach($items as $row)
                        <article class="bag__row" data-unit="{{ $row['price'] ?? '' }}">
                            <a class="bag__media" href="{{ $row['product'] ? route('products.show', $row['product']->slug) : route('shop') }}">
                                <img src="{{ $row['image'] }}" alt="{{ $row['name'] }}" class="{{ !empty($row['pack']) ? 'is-pack' : '' }}">
                            </a>

                            <div class="bag__info">
                                @if($row['product'])
                                    <a href="{{ route('products.show', $row['product']->slug) }}" class="bag__name">{{ $row['name'] }}</a>
                                @else
                                    <span class="bag__name">{{ $row['name'] }}</span>
                                @endif

                                <p class="bag__meta-line">
                                    @if(!empty($row['size']))
                                        <span>{{ $row['size'] }}</span>
                                    @endif
                                    @if(!empty($row['color']))
                                        <span class="bag__chip">
                                            @if(!empty($row['color_key']))
                                                <i class="bag__swatch is-{{ $row['color_key'] }}" aria-hidden="true"></i>
                                            @endif
                                            {{ $row['color'] }}
                                        </span>
                                    @endif
                                    @if(!empty($row['roast']))
                                        <span>{{ $row['roast'] }}</span>
                                    @endif
                                </p>

                                <p class="bag__unit">
                                    @if($row['price'] !== null)
                                        {{ \App\Models\Product::rwf((float) $row['price']) }}
                                        <em>each</em>
                                    @else
                                        {{ __('messages.price_on_request') }}
                                    @endif
                                </p>
                                @if(!empty($row['barcode']))
                                    <p class="bag__code">{{ $row['barcode'] }}</p>
                                @endif
                            </div>

                            <div class="bag__controls">
                                <form action="{{ route('cart.update', $row['slug']) }}" method="post" class="bag-stepper js-bag-stepper">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" data-step="-1" aria-label="Decrease quantity">−</button>
                                    <input type="number" name="qty" value="{{ $row['qty'] }}" min="0" max="500" inputmode="numeric" aria-label="{{ __('messages.quantity') }}">
                                    <button type="button" data-step="1" aria-label="Increase quantity">+</button>
                                </form>
                                <form action="{{ route('cart.remove', $row['slug']) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bag__remove">{{ __('messages.remove') }}</button>
                                </form>
                            </div>

                            <div class="bag__line js-bag-line">
                                {{ $row['line'] !== null ? \App\Models\Product::rwf($row['line']) : '—' }}
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="bag__sum">
                    <p class="bag__kicker">Request</p>
                    <h2>{{ __('messages.order_summary') }}</h2>
                    <div class="bag__sum-row">
                        <span>{{ $itemCount }} {{ $itemCount === 1 ? 'bag' : 'bags' }}</span>
                        <strong>{{ \App\Models\Product::rwf($subtotal) }}</strong>
                    </div>
                    <p class="bag__note">{{ __('messages.no_payment_note') }}</p>
                    <a href="{{ route('checkout') }}" class="bag__btn">{{ __('messages.proceed_checkout') }}</a>
                    <a href="{{ route('shop') }}" class="bag__textlink">{{ __('messages.continue_shopping') }}</a>
                    <a href="mailto:info@gmac.coffee" class="bag__textlink">info@gmac.coffee</a>
                </aside>
            </div>
        @endif

        @if($suggestions->isNotEmpty())
            <section class="bag__more">
                <p class="bag__kicker">{{ $itemCount ? 'Also in the shop' : 'Start with a bag' }}</p>
                <h3>{{ $itemCount ? 'Add another size or colour' : 'Retail roasted bags' }}</h3>
                <div class="bag__more-grid">
                    @foreach($suggestions as $product)
                        <article class="bag__card">
                            <a href="{{ route('products.show', $product->slug) }}" class="bag__card-media">
                                <img src="{{ $product->displayImage() }}" alt="{{ $product->name }}" class="{{ $product->usesPackShot() ? 'is-pack' : '' }}">
                            </a>
                            <div class="bag__card-body">
                                <p class="bag__kicker">{{ $product->packSize() }} · {{ $product->packColorLabel() }}</p>
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                @if($product->barcode)
                                    <p class="g-barcode">{{ $product->barcode }}</p>
                                @endif
                                <p class="bag__card-price">{{ $product->formattedPrice() }}</p>
                                <form action="{{ route('cart.add', $product->slug) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit">{{ __('messages.add_to_cart') }}</button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.bag { padding: 2rem 0 5rem; background: #f5f3f0; }
.bag__head { max-width: 40rem; margin-bottom: 1.2rem; }
.bag__crumb { margin: 0 0 0.55rem; color: #8a8178; font-size: 0.78rem; }
.bag__crumb a { color: inherit; text-decoration: none; }
.bag__crumb a:hover { color: #7a6452; }
.bag__crumb span { margin: 0 0.4rem; }
.bag__head h1 {
    margin: 0 0 0.4rem;
    font-family: Fraunces, serif;
    font-size: clamp(2rem, 4vw, 2.8rem);
    font-weight: 500;
    color: #2a1c14;
}
.bag__meta { margin: 0; color: #7d736a; font-size: 0.95rem; line-height: 1.55; }
.bag__kicker {
    margin: 0 0 0.3rem;
    color: #7a6452;
    font-size: 0.74rem;
    font-weight: 600;
}
.bag__meta-line {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin: 0 0 0.7rem;
    color: #7a6452;
    font-size: 0.74rem;
    font-weight: 600;
}
.bag__meta-line > span {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    min-height: 26px;
    padding: 0 0.55rem;
    border-radius: 999px;
    background: #f5f3f0;
    color: #5c4a3c;
}
.bag__swatch {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    border: 1px solid rgba(63,55,49,.12);
    flex-shrink: 0;
}
.bag__swatch.is-red { background: #c0392b; }
.bag__swatch.is-chocolate { background: #c4a574; }
.bag__swatch.is-green { background: #2f7a4a; }
.bag__flash { padding: 0.8rem 1rem; margin-bottom: 1rem; font-size: 0.9rem; border-radius: 12px; }
.bag__flash--ok { background: #efe8df; color: #3d2918; }
.bag__flash--err { background: #f3e4e1; color: #9a3b2f; }

.bag__empty {
    max-width: 34rem;
    padding: 2.2rem 2rem;
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 18px;
}
.bag__empty h2 { margin: 0 0 0.5rem; font-family: Fraunces, serif; font-weight: 500; font-size: 1.7rem; color: #2a1c14; }
.bag__empty p { margin: 0 0 1.25rem; color: #7d736a; line-height: 1.65; }

.bag__grid { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 1.25rem; align-items: start; }
.bag__sheet { background: #fff; border: 1px solid #e7e2db; border-radius: 18px; overflow: hidden; }
.bag__row {
    display: grid;
    grid-template-columns: 112px minmax(0, 1fr) auto auto;
    align-items: center;
    gap: 1.1rem 1.4rem;
    padding: 1.25rem 1.35rem;
    border-bottom: 1px solid #eee8e1;
}
.bag__row:last-child { border-bottom: 0; }
.bag__media {
    display: grid;
    place-items: center;
    width: 112px;
    height: 112px;
    background: #fff;
    border: 1px solid #eee8e1;
    border-radius: 16px;
    overflow: hidden;
}
.bag__media img { width: 88px; height: 88px; object-fit: contain; display: block; background: #fff; }
.bag__name {
    display: block;
    margin: 0 0 0.45rem;
    font-family: Fraunces, serif;
    font-size: 1.15rem;
    font-weight: 500;
    line-height: 1.25;
    color: #2a1c14;
    text-decoration: none;
}
.bag__name:hover { color: #7a6452; }
.bag__unit {
    margin: 0;
    color: #3f3731;
    font-size: 0.95rem;
    font-weight: 600;
}
.bag__unit em {
    margin-left: 0.3rem;
    font-style: normal;
    font-weight: 500;
    color: #8a8178;
    font-size: 0.8rem;
}
.bag__code {
    margin: 0.35rem 0 0;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    color: #8a8178;
}
.bag__controls {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.55rem;
}
.bag-stepper {
    display: inline-flex;
    align-items: center;
    border: 1px solid #e7e2db;
    border-radius: 999px;
    overflow: hidden;
    background: #f5f3f0;
}
.bag-stepper button {
    width: 38px;
    height: 38px;
    border: 0;
    background: transparent;
    color: #3f3731;
    cursor: pointer;
    font-size: 1.15rem;
    line-height: 1;
}
.bag-stepper button:hover { background: #efe8df; }
.bag-stepper input {
    width: 38px;
    height: 38px;
    border: 0;
    border-left: 1px solid #e7e2db;
    border-right: 1px solid #e7e2db;
    text-align: center;
    font: 600 0.92rem/1 Poppins, sans-serif;
    color: #2a1c14;
    background: #fff;
    -moz-appearance: textfield;
    appearance: textfield;
}
.bag-stepper input::-webkit-outer-spin-button,
.bag-stepper input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.bag__remove {
    border: 0;
    background: none;
    padding: 0;
    color: #8a8178;
    font-size: 0.78rem;
    font-weight: 500;
    cursor: pointer;
}
.bag__remove:hover { color: #9a3b2f; }
.bag__line {
    min-width: 7.5rem;
    font-family: Fraunces, serif;
    font-size: 1.25rem;
    font-weight: 500;
    color: #2a1c14;
    text-align: right;
    white-space: nowrap;
}

.bag__sum {
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 18px;
    padding: 1.35rem 1.3rem 1.45rem;
    position: sticky;
    top: 6.5rem;
}
.bag__sum h2 { margin: 0 0 1rem; font-family: Fraunces, serif; font-size: 1.4rem; font-weight: 500; color: #2a1c14; }
.bag__sum-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee8e1;
}
.bag__sum-row strong { font-size: 1.2rem; }
.bag__note { margin: 0 0 1.15rem; color: #7d736a; font-size: 0.84rem; line-height: 1.6; }
.bag__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 46px;
    background: #7a6452;
    color: #fff;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 500;
    border: 0;
    cursor: pointer;
}
.bag__btn:hover { background: #8d7560; color: #fff; }
.bag__btn--inline { width: auto; padding: 0 1.2rem; display: inline-flex; }
.bag__textlink { display: block; margin-top: 0.75rem; text-align: center; color: #7a6452; font-size: 0.86rem; text-decoration: none; }

.bag__more { margin-top: 2.4rem; }
.bag__more h3 { margin: 0 0 1rem; font-family: Fraunces, serif; font-size: 1.5rem; color: #2a1c14; }
.bag__more-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; }
.bag__card { background: #fff; border: 1px solid #e7e2db; border-radius: 18px; overflow: hidden; }
.bag__card-media { display: block; background: #efe8df; }
.bag__card-media img { width: 100%; height: 180px; object-fit: cover; display: block; }
.bag__card-media img.is-pack { object-fit: contain; background: #fff; }
.bag__card-body { padding: 1rem 1.05rem 1.15rem; }
.bag__card-body a { color: #2a1c14; font-family: Fraunces, serif; font-size: 1.05rem; text-decoration: none; }
.bag__card-price { margin: 0.35rem 0 0.75rem; color: #5c4a3c; font-weight: 600; }
.bag__card-body button {
    min-height: 38px;
    padding: 0 0.9rem;
    border: 0;
    border-radius: 999px;
    background: #7a6452;
    color: #fff;
    cursor: pointer;
    font: inherit;
    font-size: 0.82rem;
}

@media (max-width: 880px) {
    .bag__grid, .bag__more-grid { grid-template-columns: 1fr; }
    .bag__row { grid-template-columns: 88px minmax(0, 1fr); gap: 0.9rem; }
    .bag__media { width: 88px; height: 88px; }
    .bag__media img { width: 68px; height: 68px; }
    .bag__controls { flex-direction: row; justify-content: flex-start; grid-column: 2; }
    .bag__line { grid-column: 2; text-align: left; }
    .bag__sum { position: static; }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    function rwf(n) { return Math.round(n).toLocaleString('en-US') + ' frw'; }
    document.querySelectorAll('.js-bag-stepper').forEach(function (form) {
        var input = form.querySelector('input[name="qty"]');
        var row = form.closest('.bag__row');
        var line = row ? row.querySelector('.js-bag-line') : null;
        var unit = row ? parseFloat(row.getAttribute('data-unit') || '') : NaN;
        function paint() {
            if (!input) return;
            var n = Math.max(0, Math.min(500, parseInt(input.value || '1', 10) || 0));
            input.value = n;
            if (line && !isNaN(unit)) line.textContent = rwf(unit * n);
        }
        form.querySelectorAll('[data-step]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (!input) return;
                input.value = (parseInt(input.value || '1', 10) || 1) + parseInt(btn.getAttribute('data-step'), 10);
                paint();
                form.submit();
            });
        });
        if (input) input.addEventListener('change', function () { paint(); form.submit(); });
    });
})();
</script>
@endpush
