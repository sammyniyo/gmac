@extends('layouts.frontend')

@section('title', __('messages.order_find_title') . ' - GMAC Coffee')

@section('content')
<section class="bag">
    <div class="container">
        <header class="bag__head">
            <p class="bag__crumb">
                <a href="{{ route('shop') }}">{{ __('messages.nav_shop') }}</a>
                <span>/</span>
                {{ __('messages.order_find_title') }}
            </p>
            <h1>{{ __('messages.order_find_title') }}</h1>
            <p class="bag__meta">{{ __('messages.order_find_help') }}</p>
        </header>

        <div class="xo-layout {{ !empty($order) ? 'is-found' : '' }}">
            <div class="xo-panel">
                <form action="{{ route('order.lookup') }}" method="POST" class="xo-form">
                    @csrf
                    <div class="xo-field">
                        <label for="reference">{{ __('messages.order_reference_label') }} *</label>
                        <input type="text" id="reference" name="reference" class="form-control" value="{{ old('reference', $order->reference ?? '') }}" required maxlength="40" autocomplete="off" placeholder="GMAC-XXXXXXXX">
                        @error('reference')<span class="xo-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="xo-field">
                        <label for="email">{{ __('messages.email') }} *</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $order->email ?? '') }}" required maxlength="120" autocomplete="email">
                        @error('email')<span class="xo-error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="bag__btn">{{ __('messages.order_find_submit') }}</button>
                </form>
            </div>

            @if(!empty($order))
                <aside class="bag__sum">
                    <p class="bag__kicker">{{ $order->reference }}</p>
                    <h2>{{ __('messages.order_find_status', ['status' => $order->status]) }}</h2>
                    <p class="bag__note">{{ $order->customer_name }} · {{ $order->email }}</p>
                    <p class="bag__note">{{ $order->phone }}</p>
                    @if($order->address)
                        <p class="bag__note">{{ trim(collect([$order->address, $order->city, $order->country])->filter()->implode(', ')) }}</p>
                    @endif
                    <ul class="xo-lines">
                        @foreach(($order->items ?? []) as $item)
                            <li>
                                <span>
                                    <strong>{{ $item['name'] ?? 'Bag' }}</strong>
                                    <em>× {{ $item['qty'] ?? 0 }}</em>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="bag__sum-row">
                        <span>{{ __('messages.subtotal') }}</span>
                        <strong>{{ \App\Models\Product::rwf((float) $order->subtotal) }}</strong>
                    </div>
                    <p class="bag__note">{{ __('messages.no_payment_note') }}</p>
                </aside>
            @endif
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.bag { padding: 2rem 0 5rem; background: #f5f3f0; }
.bag__head { max-width: 42rem; margin-bottom: 1.2rem; }
.bag__crumb { margin: 0 0 0.55rem; color: #8a8178; font-size: 0.78rem; }
.bag__crumb a { color: inherit; text-decoration: none; }
.bag__crumb span { margin: 0 0.4rem; }
.bag__head h1 { margin: 0 0 0.4rem; font-family: Fraunces, serif; font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 500; color: #2a1c14; }
.bag__meta { margin: 0; color: #7d736a; font-size: 0.95rem; line-height: 1.55; }
.xo-layout { display: grid; grid-template-columns: minmax(0, 1fr); gap: 1.25rem; max-width: 520px; }
.xo-layout.is-found { max-width: none; grid-template-columns: minmax(0, 1fr) 340px; }
.xo-panel, .bag__sum { background: #fff; border: 1px solid #e7e2db; border-radius: 18px; padding: 1.5rem 1.45rem; }
.xo-form { display: grid; gap: 1rem; }
.xo-field label { display: block; margin-bottom: 0.4rem; font-size: 0.82rem; font-weight: 600; color: #3f3731; }
.xo-field .form-control { width: 100%; min-height: 46px; padding: 0.7rem 0.9rem; border-radius: 12px; }
.xo-error { display: block; margin-top: 0.3rem; color: #9a3b2f; font-size: 0.78rem; }
.bag__kicker { margin: 0 0 0.35rem; color: #9a7d4e; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; }
.bag__sum h2 { margin: 0 0 0.7rem; font-family: Fraunces, serif; font-size: 1.35rem; font-weight: 500; }
.bag__note { margin: 0 0 0.45rem; color: #7d736a; font-size: 0.84rem; line-height: 1.55; }
.xo-lines { list-style: none; margin: 0 0 1rem; padding: 0; display: grid; gap: 0.55rem; }
.xo-lines strong { display: block; color: #2a1c14; }
.xo-lines em { font-style: normal; color: #7d736a; }
.bag__sum-row { display: flex; justify-content: space-between; margin: 0 0 1rem; padding-top: 0.85rem; border-top: 1px solid #eee8e1; }
.bag__btn {
    display: flex; align-items: center; justify-content: center;
    width: 100%; min-height: 46px; border: 0; background: #7a6452; color: #fff;
    font-weight: 500; cursor: pointer; border-radius: 999px;
}
@media (max-width: 800px) { .xo-layout.is-found { grid-template-columns: 1fr; } }
</style>
@endpush
