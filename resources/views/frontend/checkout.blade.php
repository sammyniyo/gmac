@extends('layouts.frontend')

@section('title', __('messages.checkout_title') . ' - GMAC Coffee')

@section('content')
@include('partials.frontend.page-hero', [
    'title' => __('messages.checkout_title'),
    'subtitle' => __('messages.checkout_subtitle'),
    'eyebrow' => 'GMAC Coffee',
])

<section class="checkout-page py-6">
    <div class="container">
        <div class="checkout-grid">
            <div class="checkout-form-card contact-form-card">
                <h2 class="section-title" style="font-size: 1.5rem; margin-bottom: 0.5rem;">{{ __('messages.your_details') }}</h2>
                <p class="mb-3" style="color: var(--clr-text-muted); font-size: 0.92rem;">{{ __('messages.checkout_form_help') }}</p>

                <form action="{{ route('checkout.store') }}" method="POST" class="checkout-form">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="customer_name">{{ __('messages.full_name') }} <span class="text-gold">*</span></label>
                            <input type="text" id="customer_name" name="customer_name" class="input" value="{{ old('customer_name') }}" required autocomplete="name">
                            @error('customer_name')<span class="footer__notice footer__notice--error" style="display:block;margin-top:6px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('messages.email') }} <span class="text-gold">*</span></label>
                            <input type="email" id="email" name="email" class="input" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')<span class="footer__notice footer__notice--error" style="display:block;margin-top:6px;">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">{{ __('messages.phone') }} <span class="text-gold">*</span></label>
                        <input type="text" id="phone" name="phone" class="input" value="{{ old('phone') }}" required autocomplete="tel">
                        @error('phone')<span class="footer__notice footer__notice--error" style="display:block;margin-top:6px;">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="company">{{ __('messages.company') }}</label>
                        <input type="text" id="company" name="company" class="input" value="{{ old('company') }}" autocomplete="organization">
                        @error('company')<span class="footer__notice footer__notice--error" style="display:block;margin-top:6px;">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="country">{{ __('messages.country') }}</label>
                            <input type="text" id="country" name="country" class="input" value="{{ old('country') }}" autocomplete="country-name">
                            @error('country')<span class="footer__notice footer__notice--error" style="display:block;margin-top:6px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="city">{{ __('messages.city') }}</label>
                            <input type="text" id="city" name="city" class="input" value="{{ old('city') }}" autocomplete="address-level2">
                            @error('city')<span class="footer__notice footer__notice--error" style="display:block;margin-top:6px;">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">{{ __('messages.address') }}</label>
                        <textarea id="address" name="address" class="textarea" rows="3" autocomplete="street-address">{{ old('address') }}</textarea>
                        @error('address')<span class="footer__notice footer__notice--error" style="display:block;margin-top:6px;">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="notes">{{ __('messages.order_notes') }}</label>
                        <textarea id="notes" name="notes" class="textarea" rows="3" placeholder="{{ __('messages.order_notes_placeholder') }}">{{ old('notes') }}</textarea>
                        @error('notes')<span class="footer__notice footer__notice--error" style="display:block;margin-top:6px;">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full" style="margin-top: 0.5rem;">{{ __('messages.submit_order') }}</button>
                </form>
            </div>

            <aside class="checkout-aside card" style="padding: 1.5rem;">
                <h3 class="section-title" style="font-size: 1.25rem;">{{ __('messages.order_summary') }}</h3>
                <ul class="checkout-lines">
                    @foreach($items as $row)
                        <li class="checkout-line">
                            <span>{{ $row['name'] }} × {{ $row['qty'] }}</span>
                            <span>
                                @if($row['price'] !== null)
                                    ${{ number_format((float) $row['price'] * (int) $row['qty'], 2) }}
                                @else
                                    —
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
                <div class="checkout-total">
                    <span>{{ __('messages.subtotal') }}</span>
                    <strong>${{ number_format($subtotal, 2) }}</strong>
                </div>
                <p class="cart-summary__note" style="margin-top:1rem;">{{ __('messages.no_payment_note') }}</p>
                <a href="{{ route('cart.index') }}" class="btn btn-outline w-full mt-1">{{ __('messages.edit_cart') }}</a>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.checkout-grid { display: grid; gap: 2rem; grid-template-columns: 1fr; align-items: start; }
@media (min-width: 900px) { .checkout-grid { grid-template-columns: 1.1fr 0.9fr; } }
.checkout-lines { list-style: none; margin: 0 0 1rem; padding: 0; display: grid; gap: 0.65rem; font-size: 0.9rem; color: var(--clr-text-muted); }
.checkout-line { display: flex; justify-content: space-between; gap: 1rem; }
.checkout-total { display: flex; justify-content: space-between; font-size: 1.1rem; padding-top: 1rem; border-top: 1px solid rgba(13, 9, 7, 0.08); }
[data-theme='dark'] .checkout-total { border-top-color: rgba(246, 240, 230, 0.1); }
</style>
@endpush
