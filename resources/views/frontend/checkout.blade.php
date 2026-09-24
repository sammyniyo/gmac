@extends('layouts.frontend')

@section('title', __('messages.checkout_title') . ' - GMAC Coffee')

@section('content')
@php
    $notify = \App\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@gmac.coffee';
    $itemCount = (int) ($count ?? collect($items)->sum('qty'));
    $countries = $countries ?? \App\Support\Countries::all();
    $selectedCountry = old('country_code', 'RW');
    $selectedDial = $countries[$selectedCountry]['dial'] ?? '250';
@endphp
<section class="bag">
    <div class="container">
        <header class="bag__head">
            <p class="bag__crumb">
                <a href="{{ route('shop') }}">{{ __('messages.nav_shop') }}</a>
                <span>/</span>
                <a href="{{ route('cart.index') }}">{{ __('messages.cart_title') }}</a>
                <span>/</span>
                {{ __('messages.checkout_title') }}
            </p>
            <h1>{{ __('messages.checkout_title') }}</h1>
            <p class="bag__meta">{{ __('messages.checkout_subtitle') }} We send it to {{ $notify }}.</p>
        </header>

        @include('partials.frontend.cart-steps', ['current' => 2])

        <div class="xo-layout">
            <div class="xo-panel">
                <p class="bag__kicker">{{ __('messages.your_details') }}</p>
                <h2>Who should we reply to?</h2>
                <p class="xo-help">{{ __('messages.checkout_form_help') }}</p>

                <div class="xo-topics" role="group" aria-label="Request type">
                    @foreach(['Wholesale', 'Retail bags', 'Sample request', 'Export'] as $topic)
                        <button type="button" class="xo-topic js-xo-topic" data-note="{{ $topic }}">{{ $topic }}</button>
                    @endforeach
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" class="xo-form" id="xo-form">
                    @csrf
                    <input type="hidden" name="form_started" value="{{ time() }}">
                    <div class="xo-hp" aria-hidden="true">
                        <label for="website">Leave blank</label>
                        <input type="text" id="website" name="website" value="" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="xo-row">
                        <div class="xo-field">
                            <label for="customer_name">{{ __('messages.full_name') }} *</label>
                            <input type="text" id="customer_name" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required minlength="2" maxlength="80" autocomplete="name">
                            @error('customer_name')<span class="xo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="xo-field">
                            <label for="email">{{ __('messages.email') }} *</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required maxlength="120" autocomplete="email" inputmode="email">
                            @error('email')<span class="xo-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="xo-row">
                        <div class="xo-field">
                            <label for="country_code">{{ __('messages.country') }} *</label>
                            <select id="country_code" name="country_code" class="form-control" required>
                                @foreach($countries as $code => $row)
                                    <option value="{{ $code }}" data-dial="{{ $row['dial'] }}" {{ $selectedCountry === $code ? 'selected' : '' }}>
                                        {{ $row['name'] }} (+{{ $row['dial'] }})
                                    </option>
                                @endforeach
                            </select>
                            @error('country_code')<span class="xo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="xo-field">
                            <label for="phone">{{ __('messages.phone') }} *</label>
                            <div class="xo-phone">
                                <span class="xo-phone__dial" id="xo-dial">+{{ $selectedDial }}</span>
                                <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required inputmode="tel" autocomplete="tel" placeholder="788 123 456">
                            </div>
                            <p class="xo-hint">{{ __('messages.order_phone_hint') }}</p>
                            @error('phone')<span class="xo-error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="xo-row">
                        <div class="xo-field">
                            <label for="city">{{ __('messages.city') }} *</label>
                            <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}" required minlength="2" maxlength="80" autocomplete="address-level2">
                            @error('city')<span class="xo-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="xo-field">
                            <label for="company">{{ __('messages.company') }}</label>
                            <input type="text" id="company" name="company" class="form-control" value="{{ old('company') }}" maxlength="120" autocomplete="organization">
                        </div>
                    </div>
                    <div class="xo-field">
                        <label for="address">{{ __('messages.address') }} *</label>
                        <textarea id="address" name="address" class="form-control" rows="3" required minlength="8" maxlength="240" autocomplete="street-address" placeholder="{{ __('messages.order_address_placeholder') }}">{{ old('address') }}</textarea>
                        @error('address')<span class="xo-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="xo-field">
                        <label for="notes">{{ __('messages.order_notes') }}</label>
                        <textarea id="notes" name="notes" class="form-control" rows="3" maxlength="2000" placeholder="{{ __('messages.order_notes_placeholder') }}">{{ old('notes') }}</textarea>
                        @error('notes')<span class="xo-error">{{ $message }}</span>@enderror
                        @error('form_started')<span class="xo-error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="bag__btn">{{ __('messages.submit_order') }}</button>
                    <p class="xo-privacy">{{ __('messages.order_privacy') }}</p>
                </form>
            </div>

            <aside class="bag__sum">
                <p class="bag__kicker">{{ $itemCount }} {{ $itemCount === 1 ? 'bag' : 'bags' }}</p>
                <h2>{{ __('messages.order_summary') }}</h2>
                <ul class="xo-lines">
                    @foreach($items as $row)
                        <li>
                            <span class="xo-line-media">
                                <img src="{{ $row['image'] }}" alt="" class="{{ !empty($row['pack']) ? 'is-pack' : '' }}">
                            </span>
                            <span>
                                <strong>{{ $row['name'] }}</strong>
                                <em>× {{ $row['qty'] }}@if(!empty($row['size'])) · {{ $row['size'] }}@endif</em>
                                @if(!empty($row['barcode']))
                                    <em class="g-barcode">{{ $row['barcode'] }}</em>
                                @endif
                            </span>
                            <b>
                                @if($row['line'] !== null)
                                    {{ \App\Models\Product::rwf($row['line']) }}
                                @else
                                    —
                                @endif
                            </b>
                        </li>
                    @endforeach
                </ul>
                <div class="bag__sum-row">
                    <span>{{ __('messages.subtotal') }}</span>
                    <strong>{{ \App\Models\Product::rwf($subtotal) }}</strong>
                </div>
                <p class="bag__note">{{ __('messages.no_payment_note') }}</p>
                <a href="{{ route('cart.index') }}" class="bag__textlink">{{ __('messages.edit_cart') }}</a>
            </aside>
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
.bag__kicker { margin: 0 0 0.35rem; color: #9a7d4e; font-size: 0.72rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; }
.xo-layout { display: grid; grid-template-columns: minmax(0, 1fr) 340px; gap: 1.25rem; align-items: start; }
.xo-panel { background: #fff; border: 1px solid #e7e2db; border-radius: 18px; padding: 1.5rem 1.45rem 1.6rem; }
.xo-panel h2 { margin: 0 0 0.45rem; font-family: Fraunces, serif; font-size: 1.5rem; font-weight: 500; color: #2a1c14; }
.xo-help { margin: 0 0 1rem; color: #7d736a; font-size: 0.9rem; line-height: 1.6; }
.xo-topics { display: flex; flex-wrap: wrap; gap: 0.45rem; margin-bottom: 1.15rem; }
.xo-topic {
    min-height: 34px;
    padding: 0 0.8rem;
    border-radius: 999px;
    border: 1px solid #e7e2db;
    background: #f5f3f0;
    color: #5c4a3c;
    font: inherit;
    font-size: 0.8rem;
    cursor: pointer;
}
.xo-topic.is-on, .xo-topic:hover { border-color: #7a6452; color: #2a1c14; background: #efe8df; }
.xo-form { display: grid; gap: 1rem; position: relative; }
.xo-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.xo-field label { display: block; margin-bottom: 0.4rem; font-size: 0.82rem; font-weight: 600; color: #3f3731; }
.xo-field .form-control { width: 100%; min-height: 46px; padding: 0.7rem 0.9rem; border-radius: 12px; }
.xo-hp { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }
.xo-phone { display: flex; align-items: stretch; border: 1px solid #e7e2db; border-radius: 12px; overflow: hidden; background: #fff; }
.xo-phone__dial {
    display: inline-flex; align-items: center; padding: 0 0.8rem;
    background: #f5f3f0; color: #5c4a3c; font-weight: 600; font-size: 0.86rem;
    border-right: 1px solid #e7e2db; min-width: 4.4rem;
}
.xo-phone .form-control { border: 0; border-radius: 0; min-height: 46px; }
.xo-hint { margin: 0.35rem 0 0; color: #8a8178; font-size: 0.74rem; }
.xo-privacy { margin: 0.35rem 0 0; color: #8a8178; font-size: 0.78rem; line-height: 1.5; }
.xo-error { display: block; margin-top: 0.3rem; color: #9a3b2f; font-size: 0.78rem; }
.xo-lines { list-style: none; margin: 0 0 1rem; padding: 0; display: grid; gap: 0.75rem; }
.xo-lines li { display: grid; grid-template-columns: 48px 1fr auto; gap: 0.65rem; align-items: start; color: #6b5344; font-size: 0.86rem; }
.xo-line-media { width: 48px; height: 48px; border-radius: 10px; overflow: hidden; background: #efe8df; }
.xo-line-media img { width: 100%; height: 100%; object-fit: cover; display: block; }
.xo-line-media img.is-pack { object-fit: contain; background: #fff; }
.xo-lines strong { display: block; color: #2a1c14; font-weight: 600; }
.xo-lines em { display: block; font-style: normal; color: #7d736a; }
.bag__sum { background: #fff; border: 1px solid #e7e2db; border-radius: 18px; padding: 1.35rem 1.3rem 1.45rem; position: sticky; top: 6.5rem; }
.bag__sum h2 { margin: 0 0 1rem; font-family: Fraunces, serif; font-size: 1.35rem; font-weight: 500; }
.bag__sum-row { display: flex; justify-content: space-between; margin: 0 0 1rem; padding-bottom: 1rem; border-bottom: 1px solid #eee8e1; }
.bag__note { margin: 0 0 0.4rem; color: #7d736a; font-size: 0.84rem; line-height: 1.6; }
.bag__btn {
    display: flex; align-items: center; justify-content: center;
    width: 100%; min-height: 46px; border: 0; background: #7a6452; color: #fff;
    text-decoration: none; font-weight: 500; cursor: pointer; border-radius: 999px;
}
.bag__btn:hover { background: #8d7560; color: #fff; }
.bag__textlink { display: block; text-align: center; margin-top: 0.85rem; color: #7a6452; font-size: 0.86rem; text-decoration: none; }
@media (max-width: 860px) {
    .xo-layout, .xo-row { grid-template-columns: 1fr; }
    .bag__sum { position: static; }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    var notes = document.getElementById('notes');
    var country = document.getElementById('country_code');
    var dial = document.getElementById('xo-dial');
    if (country && dial) {
        country.addEventListener('change', function () {
            var opt = country.options[country.selectedIndex];
            dial.textContent = '+' + (opt.getAttribute('data-dial') || '');
        });
    }
    document.querySelectorAll('.js-xo-topic').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.js-xo-topic').forEach(function (el) { el.classList.toggle('is-on', el === btn); });
            if (!notes) return;
            var tag = btn.getAttribute('data-note');
            if (notes.value && notes.value.indexOf(tag) === -1) {
                notes.value = tag + ' — ' + notes.value;
            } else if (!notes.value) {
                notes.value = tag + ': ';
            }
            notes.focus();
        });
    });
})();
</script>
@endpush
