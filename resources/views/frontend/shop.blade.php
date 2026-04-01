@extends('layouts.frontend')

@section('title', 'Shop - GMAC Coffee')
@section('meta_description', 'Browse and shop premium Rwandan coffee products from GMAC.')

@section('content')
<section class="page-hero fade-in">
    <div class="container">
        <div class="page-hero-card">
            <div class="page-hero-kicker">GMAC Coffee</div>
            <h1 class="page-hero-title">{{ __('messages.products') }}</h1>
            <p class="page-hero-subtitle">{{ __('messages.slogan') }}</p>
        </div>
    </div>
</section>

<section class="container py-6">
    <div class="shop-toolbar fade-in">
        <div class="filter-buttons" id="shop-filters">
            <button class="filter-btn active" data-category="all">{{ __('messages.all_products') }}</button>
            @foreach($categories as $category)
                <button class="filter-btn" data-category="cat-{{ $category->id }}">{{ $category->name }}</button>
            @endforeach
        </div>
    </div>

    <div class="product-grid fade-in" id="product-grid">
        @forelse($products as $product)
            <div class="product-card filter-item cat-{{ $product->product_category_id }}">
                <a href="{{ route('products.show', $product->slug) }}" class="product-image-container">
                    @if($product->hasMedia('cover'))
                        <img src="{{ $product->getFirstMediaUrl('cover', 'thumb') ?? $product->getFirstMediaUrl('cover') }}" alt="{{ $product->name }}" class="product-image">
                    @else
                        <div class="product-image-placeholder">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                    @endif
                    <div class="product-overlay">
                        <span>{{ __('messages.details') }}</span>
                    </div>
                </a>

                <div class="product-info">
                    <span class="product-category tag">{{ $product->category->name ?? 'Specialty' }}</span>
                    <h3 class="product-title">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    <p class="product-excerpt">{{ $product->short_description ?? Str::limit(strip_tags($product->description), 100) }}</p>
                    <div class="product-footer mt-1">
                        @if($product->price)
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                        @endif
                        <a href="{{ route('products.show', $product->slug) }}" class="read-more">{{ __('messages.read_more') }} <i class="fa-solid fa-chevron-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-6 w-full">
                <p class="text-xl text-gray-500">No products found at the moment. Please check back later.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection

@push('scripts')
<style>
    .shop-toolbar { margin-top: 22px; }
    .filter-buttons { display:flex; flex-wrap: wrap; gap: 10px; }
    .filter-btn {
        background: rgba(255,255,255,0.72);
        border: 1px solid rgba(31,157,106,0.22);
        color: rgba(10, 26, 18, 0.90);
        padding: 0.65rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        cursor: pointer;
        transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
    }
    .filter-btn:hover { transform: translateY(-1px); box-shadow: 0 14px 30px rgba(10,26,18,.10); }
    .filter-btn.active { background: rgba(31,157,106,0.16); border-color: rgba(31,157,106,0.35); }
    [data-theme="dark"] .filter-btn { background: rgba(246,251,248,0.06); border-color: rgba(246,251,248,0.10); color: rgba(246,251,248,.9); }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('#shop-filters .filter-btn');
        const items = document.querySelectorAll('#product-grid .filter-item');
        if (!buttons.length || !items.length) return;

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const cat = btn.dataset.category;
                items.forEach(it => {
                    if (cat === 'all') { it.style.display = ''; return; }
                    it.style.display = it.classList.contains(cat) ? '' : 'none';
                });
            });
        });
    });
</script>
@endpush

