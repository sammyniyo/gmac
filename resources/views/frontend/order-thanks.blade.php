@extends('layouts.frontend')

@section('title', __('messages.order_thanks_title') . ' - GMAC Coffee')

@section('content')
@php
    $lines = collect($order->items ?? []);
    $notify = \App\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@gmac.coffee';
@endphp
<section class="bag">
    <div class="container">
        @include('partials.frontend.cart-steps', ['current' => 3])

        <div class="th-layout">
            <div class="th-panel">
                <p class="bag__kicker">{{ __('messages.order_reference_label') }}</p>
                <h1 id="th-ref">{{ $order->reference }}</h1>
                <button type="button" class="th-copy" id="th-copy" data-code="{{ $order->reference }}">{{ __('messages.copy_reference') }}</button>
                <p>{{ __('messages.order_thanks_body') }}</p>
                <ol class="th-next">
                    <li>We received the bag list and your details.</li>
                    <li>Someone writes back to <strong>{{ $order->email }}</strong> or {{ $order->phone }}.</li>
                    <li>Nothing was charged. Availability is confirmed by email.</li>
                </ol>
                <div class="th-actions">
                    <a href="{{ route('shop') }}" class="bag__btn bag__btn--inline">{{ __('messages.continue_shopping') }}</a>
                    <a href="{{ route('order.find') }}" class="bag__textlink">{{ __('messages.order_find_title') }}</a>
                    <a href="{{ route('contact') }}" class="bag__textlink">{{ __('messages.contact') }}</a>
                    <a href="mailto:{{ $notify }}" class="bag__textlink">{{ $notify }}</a>
                </div>
            </div>

            <aside class="bag__sum">
                <p class="bag__kicker">Requested</p>
                <h2>{{ $order->customer_name }}</h2>
                <ul class="xo-lines">
                    @foreach($lines as $item)
                        <li>
                            <span>
                                <strong>{{ $item['name'] ?? 'Bag' }}</strong>
                                <em>× {{ $item['qty'] ?? 0 }}</em>
                                @if(!empty($item['barcode']))
                                    <em class="g-barcode">{{ $item['barcode'] }}</em>
                                @endif
                            </span>
                            <b>
                                @if(isset($item['line']) && $item['line'] !== null)
                                    {{ \App\Models\Product::rwf((float) $item['line']) }}
                                @elseif(!empty($item['price']))
                                    {{ \App\Models\Product::rwf((float) $item['price'] * (int) ($item['qty'] ?? 0)) }}
                                @else
                                    —
                                @endif
                            </b>
                        </li>
                    @endforeach
                </ul>
                <div class="bag__sum-row">
                    <span>{{ __('messages.subtotal') }}</span>
                    <strong>{{ \App\Models\Product::rwf((float) $order->subtotal) }}</strong>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.bag { padding: 2rem 0 5.5rem; background: #f5f3f0; }
.th-layout { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 1.25rem; align-items: start; }
.th-panel, .bag__sum { background: #fff; border: 1px solid #e7e2db; border-radius: 18px; padding: 1.6rem 1.5rem; }
.bag__kicker { margin: 0 0 0.4rem; color: #9a7d4e; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; }
.th-panel h1, .bag__sum h2 { margin: 0 0 0.7rem; font-family: Fraunces, serif; font-weight: 500; color: #2a1c14; }
.th-panel h1 { font-size: clamp(1.8rem, 4vw, 2.5rem); letter-spacing: 0.04em; }
.th-panel p { margin: 0 0 1.2rem; color: #6b5344; line-height: 1.7; }
.th-next { margin: 0 0 1.4rem; padding-left: 1.15rem; color: #6b5344; line-height: 1.7; }
.th-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem 1rem; }
.bag__btn {
    display: inline-flex; align-items: center; justify-content: center;
    min-height: 46px; padding: 0 1.2rem; background: #7a6452; color: #fff;
    text-decoration: none; font-weight: 500; border-radius: 999px;
}
.bag__btn:hover { background: #8d7560; color: #fff; }
.bag__textlink { color: #7a6452; font-size: 0.86rem; text-decoration: none; }
.xo-lines { list-style: none; margin: 0 0 1rem; padding: 0; display: grid; gap: 0.7rem; }
.xo-lines li { display: flex; justify-content: space-between; gap: 1rem; color: #6b5344; font-size: 0.88rem; }
.xo-lines strong { display: block; color: #2a1c14; }
.xo-lines em { display: block; font-style: normal; color: #7d736a; }
.bag__sum-row { display: flex; justify-content: space-between; padding-top: 0.8rem; border-top: 1px solid #eee8e1; }
.th-copy {
    border: 1px solid #e7e2db; background: #f5f3f0; color: #5c4a3c;
    border-radius: 999px; min-height: 36px; padding: 0 0.9rem;
    font: 500 0.8rem/1 Poppins, sans-serif; cursor: pointer; margin: 0 0 1rem;
}
@media (max-width: 800px) { .th-layout { grid-template-columns: 1fr; } }
</style>
@endpush

@push('scripts')
<script>
(function () {
    var btn = document.getElementById('th-copy');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var code = btn.getAttribute('data-code') || '';
        if (navigator.clipboard) navigator.clipboard.writeText(code);
        btn.textContent = 'Copied';
        setTimeout(function () { btn.textContent = 'Copy reference'; }, 1400);
    });
})();
</script>
@endpush
