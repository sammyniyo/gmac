@extends('layouts.frontend')

@section('title', __('messages.cart_title') . ' - GMAC Coffee')

@section('content')
@include('partials.frontend.page-hero', [
    'title' => __('messages.cart_title'),
    'subtitle' => __('messages.cart_hero_subtitle'),
    'eyebrow' => 'GMAC Coffee',
])

<section class="cart-page py-6">
    <div class="container">
        @if(session('cart_success'))
            <div class="cart-flash cart-flash--ok">{{ session('cart_success') }}</div>
        @endif
        @if(session('cart_error'))
            <div class="cart-flash cart-flash--err">{{ session('cart_error') }}</div>
        @endif

        @if(count($items) === 0)
            <div class="cart-empty card p-4 text-center">
                <p class="mb-3">{{ __('messages.cart_empty') }}</p>
                <a href="{{ route('shop') }}" class="btn btn-primary">{{ __('messages.continue_shopping') }}</a>
            </div>
        @else
            <div class="cart-layout">
                <div class="cart-table-wrap card">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.product') }}</th>
                                <th>{{ __('messages.price') }}</th>
                                <th>{{ __('messages.quantity') }}</th>
                                <th>{{ __('messages.line_total') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $row)
                                @php
                                    $p = \App\Models\Product::where('id', $row['product_id'])->where('is_active', true)->first();
                                    $rowSlug = $row['slug'] ?? ($p->slug ?? null);
                                @endphp
                                <tr>
                                    <td>
                                        @if($p)
                                            <a href="{{ route('products.show', $p->slug) }}" class="cart-product-name">{{ $row['name'] }}</a>
                                        @else
                                            <span class="cart-product-name">{{ $row['name'] }}</span>
                                            @if(!empty($rowSlug))
                                                <span class="cart-unavailable">({{ __('messages.product_unavailable') ?? 'Unavailable' }})</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($row['price'] !== null)
                                            ${{ number_format((float) $row['price'], 2) }}
                                        @else
                                            <span class="text-gold">{{ __('messages.price_on_request') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($rowSlug)
                                            <form action="{{ route('cart.update', $rowSlug) }}" method="post" class="cart-qty-form">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="qty" value="{{ $row['qty'] }}" min="0" max="500" class="cart-qty-input input" aria-label="{{ __('messages.quantity') }}">
                                                <button type="submit" class="btn btn-outline btn-sm">{{ __('messages.update') }}</button>
                                            </form>
                                        @else
                                            {{ $row['qty'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($row['price'] !== null)
                                            ${{ number_format((float) $row['price'] * (int) $row['qty'], 2) }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        @if($rowSlug)
                                            <form action="{{ route('cart.remove', $rowSlug) }}" method="post" onsubmit="return confirm('{{ __('messages.remove_item_confirm') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cart-remove" aria-label="{{ __('messages.remove') }}">&times;</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <aside class="cart-summary card">
                    <h3 class="cart-summary__title">{{ __('messages.order_summary') }}</h3>
                    <p class="cart-summary__row">
                        <span>{{ __('messages.subtotal') }}</span>
                        <strong>${{ number_format($subtotal, 2) }}</strong>
                    </p>
                    <p class="cart-summary__note">{{ __('messages.no_payment_note') }}</p>
                    <a href="{{ route('checkout') }}" class="btn btn-primary w-full">{{ __('messages.proceed_checkout') }}</a>
                    <a href="{{ route('shop') }}" class="btn btn-outline w-full mt-1">{{ __('messages.continue_shopping') }}</a>
                </aside>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.cart-flash { padding: 0.85rem 1rem; border-radius: var(--radius-input); margin-bottom: 1.25rem; font-size: 0.9rem; }
.cart-flash--ok { background: rgba(15, 118, 110, 0.1); border: 1px solid rgba(15, 118, 110, 0.25); color: #0f766e; }
.cart-flash--err { background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.2); color: #b91c1c; }
.cart-layout { display: grid; gap: 1.5rem; grid-template-columns: 1fr; align-items: start; }
@media (min-width: 960px) { .cart-layout { grid-template-columns: 1fr 320px; } }
.cart-table-wrap { overflow-x: auto; padding: 0; }
.cart-table { width: 100%; min-width: 560px; border-collapse: collapse; }
.cart-table th, .cart-table td { padding: 0.85rem 1rem; text-align: left; border-bottom: 1px solid rgba(13, 9, 7, 0.08); font-size: 0.9rem; }
[data-theme='dark'] .cart-table th, [data-theme='dark'] .cart-table td { border-bottom-color: rgba(246, 240, 230, 0.08); }
.cart-table th { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--clr-text-subtle); }
.cart-product-name { font-weight: 600; color: var(--clr-text-main); text-decoration: none; }
.cart-product-name:hover { color: var(--clr-gold); }
.cart-qty-form { display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; }
.cart-qty-input { width: 72px; min-height: 2.5rem; padding: 0.4rem 0.5rem; }
.btn-sm { padding: 0.45rem 0.85rem; font-size: 0.75rem; }
.cart-remove { background: transparent; border: none; color: var(--clr-text-muted); font-size: 1.35rem; line-height: 1; cursor: pointer; padding: 0.25rem; }
.cart-remove:hover { color: #dc2626; }
.cart-unavailable { font-size: 0.75rem; color: var(--clr-text-subtle); margin-left: 0.35rem; }
.cart-summary { padding: 1.5rem; position: sticky; top: calc(var(--site-header-h, 96px) + 1rem); }
.cart-summary__title { font-family: var(--font-heading); font-size: 1.35rem; margin: 0 0 1rem; }
.cart-summary__row { display: flex; justify-content: space-between; margin: 0 0 1rem; font-size: 0.95rem; }
.cart-summary__note { font-size: 0.82rem; color: var(--clr-text-muted); line-height: 1.55; margin: 0 0 1.25rem; }
.w-full { width: 100%; justify-content: center; }
.mt-1 { margin-top: 0.5rem; }
.p-4 { padding: 2rem; }
</style>
@endpush
