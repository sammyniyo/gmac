@extends('layouts.frontend')

@section('title', $product->name . ' - GMAC Coffee')
@section('meta_description', $product->short_description ?? Str::limit(strip_tags($product->description), 160))

@section('content')
<div class="container py-4">
    <nav class="breadcrumb mb-2 fade-in">
        <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}">{{ __('messages.home') }}</a> / 
        <a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}">{{ __('messages.products') }}</a> / 
        <span class="active">{{ $product->name }}</span>
    </nav>

    <div class="product-detail-grid fade-in">
        <!-- Main Image/Gallery -->
        <div class="product-visuals">
            <div class="main-image-wrapper">
                @if($product->hasMedia('cover'))
                    <img src="{{ $product->getFirstMediaUrl('cover') }}" alt="{{ $product->name }}" class="main-product-image" id="main-image">
                @else
                    <div class="main-image-placeholder">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                @endif
            </div>
            
            @if($product->hasMedia('gallery'))
                <div class="gallery-thumbs mt-1">
                    @foreach($product->getMedia('gallery') as $media)
                        <div class="thumb-wrapper">
                            <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}" alt="Gallery image" class="gallery-thumb" onclick="document.getElementById('main-image').src='{{ $media->getUrl() }}'">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="product-details-content">
            <div class="product-header">
                <span class="tag">{{ $product->category->name ?? 'Specialty' }}</span>
                <h1 class="detail-title">{{ $product->name }}</h1>
                @if($product->price)
                    <div class="detail-price mt-1">${{ number_format($product->price, 2) }}</div>
                @endif
            </div>

            <div class="detail-description mt-2">
                <h3 class="subsection-title">Description</h3>
                <div class="rich-text">
                    {!! $product->description !!}
                </div>
            </div>

            @if($product->features && count($product->features) > 0)
                <div class="detail-features mt-2">
                    <h3 class="subsection-title">Flavor Profile & Specifications</h3>
                    <ul class="features-list">
                        @foreach($product->features as $feature)
                            <li><i class="fa-solid fa-check-circle text-gold mr-1"></i> {{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="detail-cta mt-4 p-2 bg-alt rounded">
                <h3 class="subsection-title mb-1">{{ __('messages.add_to_cart') }}</h3>
                <p class="mb-2">{{ __('messages.no_payment_note') }}</p>
                <form action="{{ route('cart.add', $product->slug) }}" method="post" class="detail-cart-row">
                    @csrf
                    <div class="detail-qty-wrap">
                        <label for="detail-qty" class="detail-qty-label">{{ __('messages.quantity') }}</label>
                        <input type="number" id="detail-qty" name="qty" value="1" min="1" max="500" class="input detail-qty-input">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('messages.add_to_cart') }}</button>
                </form>
                <div class="detail-cta-links mt-1">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline">{{ __('messages.view_cart') }}</a>
                    <a href="{{ LaravelLocalization::localizeUrl(url('/contact?product=' . urlencode($product->name))) }}" class="btn btn-outline">{{ __('messages.contact') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products (Same category) -->
@php
    $related = \App\Models\Product::where('product_category_id', $product->product_category_id)
        ->where('id', '!=', $product->id)
        ->where('is_active', true)
        ->take(3)
        ->get();
@endphp

@if($related->count() > 0)
<section class="related-products py-6 bg-alt mt-4">
    <div class="container fade-in">
        <h2 class="section-title text-center">You might also like</h2>
        <div class="title-separator mb-4"></div>
        
        <div class="product-grid">
            @foreach($related as $rel)
                <div class="product-card">
                    <a href="{{ route('products.show', $rel->slug) }}" class="product-image-container" style="height: 200px;">
                        @if($rel->hasMedia('cover'))
                            <img src="{{ $rel->getFirstMediaUrl('cover', 'thumb') ?? $rel->getFirstMediaUrl('cover') }}" alt="{{ $rel->name }}" class="product-image">
                        @else
                            <div class="product-image-placeholder">
                                <i class="fa-solid fa-mug-hot" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                    </a>
                    <div class="product-info p-1">
                        <h4 class="mb-0"><a href="{{ route('products.show', $rel->slug) }}">{{ $rel->name }}</a></h4>
                        <span class="text-gold font-bold">${{ number_format($rel->price, 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<style>
    .breadcrumb {
        font-size: 0.9rem;
        color: var(--clr-text-muted);
    }
    
    .breadcrumb a {
        color: inherit;
        text-decoration: none;
    }
    
    .breadcrumb .active {
        color: var(--clr-gold);
        font-weight: 600;
    }
    
    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: start;
    }
    
    .main-image-wrapper {
        border-radius: var(--radius-card);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        background: var(--clr-bg-alt);
        height: 500px;
    }
    
    .main-product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .main-image-placeholder {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: var(--clr-gold);
    }
    
    .gallery-thumbs {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    
    .thumb-wrapper {
        flex: 0 0 100px;
        height: 100px;
        border-radius: 14px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color var(--transition-fast);
    }
    
    .thumb-wrapper:hover {
        border-color: var(--clr-gold);
    }
    
    .gallery-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .detail-title {
        font-size: 2.6rem;
        margin-top: 0.5rem;
        color: var(--clr-text-main);
    }
    
    .detail-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--clr-gold);
        font-family: var(--font-heading);
    }
    
    .subsection-title {
        font-size: 1.1rem;
        font-family: var(--font-heading);
        font-weight: 400;
        letter-spacing: 0.04em;
        border-bottom: 2px solid rgba(201, 150, 63, 0.55);
        display: inline-block;
        padding-bottom: 4px;
        margin-bottom: 1.5rem;
    }
    
    .rich-text {
        color: var(--clr-text-main);
        line-height: 1.8;
    }
    
    .features-list {
        list-style: none;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .features-list li {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .text-gold { color: var(--clr-gold); }
    .mr-1 { margin-right: 0.25rem; }
    .p-2 { padding: 2rem; }
    .p-1 { padding: 1rem; }
    .rounded { border-radius: var(--radius-card); }
    .font-bold { font-weight: 700; }
    
    .detail-cart-row {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 1rem;
    }
    .detail-qty-wrap {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }
    .detail-qty-label {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--clr-text-muted);
    }
    .detail-qty-input {
        width: 88px;
        min-height: 2.75rem;
    }
    .detail-cta-links {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    @media (max-width: 992px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .main-image-wrapper {
            height: 400px;
        }
    }
</style>
@endpush
