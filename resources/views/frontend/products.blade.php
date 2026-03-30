@extends('layouts.frontend')

@section('title', 'Our Coffee Collection - GMAC Coffee')
@section('meta_description', 'Browse our premium selection of Rwandan green and roasted coffee beans. Sustainably sourced and expertly processed.')

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-image: linear-gradient(rgba(28, 10, 0, 0.6), rgba(28, 10, 0, 0.6)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2000&auto=format&fit=crop');">
    <div class="container fade-in">
        <h1 class="page-title">{{ __('messages.products') }}</h1>
        <p class="page-subtitle">{{ __('messages.slogan') }}</p>
    </div>
</div>

<div class="container py-6">
    <!-- Category Filter -->
    <div class="filter-wrapper mb-4 fade-in">
        <div class="filter-buttons">
            <button class="filter-btn active" data-category="all">{{ __('messages.all_products') }}</button>
            @foreach($categories as $category)
                <button class="filter-btn" data-category="cat-{{ $category->id }}">{{ __('messages.' . strtolower($category->name)) ?? $category->name }}</button>
            @endforeach
        </div>
    </div>

    <!-- Products Grid -->
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
                        <span>{{ __('messages.read_more') }}</span>
                    </div>
                </a>
                <div class="product-info">
                    <span class="product-category tag">{{ $product->category->name ?? 'Specialty' }}</span>
                    <h3 class="product-title"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                    <p class="product-excerpt">{{ $product->short_description ?? Str::limit(strip_tags($product->description), 100) }}</p>
                    <div class="product-footer mt-1">
                        @if($product->price)
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                        @endif
                        <a href="{{ route('products.show', $product->slug) }}" class="read-more">{{ __('messages.details') }} <i class="fa-solid fa-chevron-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-6 w-full">
                <p class="text-xl text-gray-500">No products found at the moment. Please check back later.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<style>
    .page-header {
        height: 350px;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-top: -80px;
        padding-top: 80px;
    }
    
    .page-title {
        font-size: 3.5rem;
        margin-bottom: 0.5rem;
        color: white !important;
    }
    
    .page-subtitle {
        font-size: 1.2rem;
        color: var(--clr-cream);
    }
    
    .filter-wrapper {
        text-align: center;
    }
    
    .filter-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    
    .filter-btn {
        background: transparent;
        border: 2px solid var(--clr-gold);
        color: var(--clr-gold);
        padding: 0.6rem 1.5rem;
        border-radius: 30px;
        font-weight: 500;
        cursor: pointer;
        transition: all var(--transition-base);
    }
    
    .filter-btn:hover, .filter-btn.active {
        background: var(--clr-gold);
        color: white;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2.5rem;
        margin-top: 2rem;
    }
    
    .product-card {
        background: var(--clr-white);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all var(--transition-base);
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }
    
    .product-image-container {
        position: relative;
        height: 280px;
        overflow: hidden;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-slow);
    }
    
    .product-card:hover .product-image {
        transform: scale(1.1);
    }
    
    .product-image-placeholder {
        width: 100%;
        height: 100%;
        background-color: var(--clr-bg-alt);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--clr-gold);
    }
    
    .product-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(28, 10, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity var(--transition-base);
    }
    
    .product-overlay span {
        background: var(--clr-gold);
        color: white;
        padding: 0.6rem 1.8rem;
        border-radius: 4px;
        font-weight: 600;
        transform: translateY(20px);
        transition: transform var(--transition-base);
    }
    
    .product-card:hover .product-overlay {
        opacity: 1;
    }
    
    .product-card:hover .product-overlay span {
        transform: translateY(0);
    }
    
    .product-info {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .tag {
        display: inline-block;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: var(--clr-bg-alt);
        color: var(--clr-deep-espresso);
        padding: 0.3rem 1rem;
        border-radius: 20px;
        margin-bottom: 1rem;
        align-self: flex-start;
    }
    
    .product-title {
        font-size: 1.5rem;
        margin-bottom: 0.8rem;
    }
    
    .product-title a {
        color: inherit;
        text-decoration: none;
    }
    
    .product-excerpt {
        color: var(--clr-text-muted);
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .product-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--clr-bg-alt);
    }
    
    .product-price {
        font-weight: 700;
        color: var(--clr-gold);
        font-size: 1.25rem;
    }
    
    .read-more {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        color: var(--clr-deep-espresso);
    }
    
    [data-theme='dark'] .read-more {
        color: var(--clr-gold);
    }
    
    /* Filtering logic styles */
    .filter-item.hidden {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.filter-item');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                btn.classList.add('active');
                
                const category = btn.getAttribute('data-category');
                
                items.forEach(item => {
                    if (category === 'all' || item.classList.contains(category)) {
                        item.classList.remove('hidden');
                        // Optional: trigger re-animation
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transition = 'opacity 0.5s ease-in-out';
                        }, 10);
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });
    });
</script>
@endpush
