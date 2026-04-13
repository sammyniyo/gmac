@extends('layouts.frontend')

@section('title', __('messages.order_thanks_title') . ' - GMAC Coffee')

@section('content')
@include('partials.frontend.page-hero', [
    'title' => __('messages.order_thanks_title'),
    'subtitle' => __('messages.order_thanks_subtitle'),
    'eyebrow' => $order->reference,
])

<section class="py-6">
    <div class="container">
        <div class="card p-4 text-center" style="max-width: 640px; margin: 0 auto;">
            <p class="mb-2" style="color: var(--clr-text-muted);">{{ __('messages.order_reference_label') }}</p>
            <p class="section-title text-gold" style="font-size: 1.75rem; margin-bottom: 1rem;">{{ $order->reference }}</p>
            <p style="color: var(--clr-text-muted); line-height: 1.75;">{{ __('messages.order_thanks_body') }}</p>
            <div class="mt-3 flex flex-wrap" style="justify-content: center; gap: 0.75rem;">
                <a href="{{ route('shop') }}" class="btn btn-primary">{{ __('messages.continue_shopping') }}</a>
                <a href="{{ route('contact') }}" class="btn btn-outline">{{ __('messages.contact') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
