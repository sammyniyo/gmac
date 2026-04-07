@extends('layouts.frontend')

@section('title', 'Our Coffee Collection - GMAC Coffee')
@section('meta_description', 'Browse our premium selection of Rwandan green and roasted coffee beans. Sustainably sourced and expertly processed.')

@section('content')
@include('partials.frontend.page-hero', [
    'title' => __('messages.products'),
    'subtitle' => __('messages.slogan'),
])

<div class="container py-6">
    <div class="products-intro fade-in">
        <div class="products-kicker">Coffee Collection</div>
        <h2 class="products-intro-title">Discover green and roasted coffees prepared for quality, traceability, and <em>distinctive flavour.</em></h2>
        <p class="products-intro-text">Browse our collection by category and explore coffees crafted for specialty buyers, roasters, and coffee lovers.</p>
    </div>

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
    .products-intro {
        max-width: 760px;
        margin: 0 auto 2.5rem;
        text-align: center;
    }
    
    .products-kicker {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.45rem 0.95rem;
        border-radius: 999px;
        background: rgba(138, 99, 32, 0.1);
        border: 1px solid rgba(138, 99, 32, 0.16);
        color: #8a6320;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .products-intro-title {
        margin: 0 0 0.9rem;
        font-size: clamp(2.2rem, 4vw, 3.5rem);
        line-height: 1.05;
        color: #21160f;
    }

    .products-intro-title em {
        color: var(--clr-gold, #c9963f);
        font-style: italic;
    }

    .products-intro-text {
        max-width: 58ch;
        margin: 0 auto;
        color: rgba(26,16,8,0.62);
        font-size: 1rem;
        line-height: 1.8;
    }

    .filter-wrapper {
        text-align: center;
    }
    
    .filter-buttons {
        display: flex;
        justify-content: center;
        gap: 0.85rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }
    
    .filter-btn {
        background: rgba(253,250,245,0.95);
        border: 1px solid rgba(192,139,48,0.18);
        color: rgba(26,16,8,0.72);
        padding: 0.7rem 1.05rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.76rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all var(--transition-base);
        box-shadow: 0 4px 16px rgba(26,16,8,0.06);
    }

    .filter-btn:hover {
        background: rgba(201,150,63,0.10);
        border-color: rgba(192,139,48,0.35);
        color: rgba(26,16,8,0.88);
        transform: translateY(-2px);
    }
    .filter-btn.active {
        background: #1a0e08;
        border-color: var(--clr-gold, #c9963f);
        color: #f6f0e6;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(26,16,8,0.18);
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .product-card {
        background:
            radial-gradient(320px 140px at 100% 0%, rgba(201,150,63,0.08), transparent 60%),
            linear-gradient(180deg, #fdfaf5 0%, #f5ebe0 100%);
        border-radius: 26px;
        overflow: hidden;
        border: 1px solid rgba(201,150,63,0.12);
        box-shadow: 0 18px 42px rgba(26,16,8,0.07);
        transition: all var(--transition-base);
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 28px 64px rgba(26,16,8,0.12);
        border-color: rgba(201,150,63,0.28);
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
        background: linear-gradient(160deg, #2d1a0e 0%, #1a0e08 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: rgba(201,150,63,0.35);
    }

    .product-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(26,16,8,0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity var(--transition-base);
    }

    .product-overlay span {
        background: var(--clr-gold, #c9963f);
        color: #1a0e08;
        padding: 0.65rem 1.8rem;
        border-radius: 999px;
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
        padding: 1.45rem 1.4rem 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .tag {
        display: inline-block;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        background: rgba(138,99,32,0.1);
        color: #8a6320;
        padding: 0.38rem 0.95rem;
        border-radius: 20px;
        margin-bottom: 1rem;
        align-self: flex-start;
        font-weight: 700;
    }
    
    .product-title {
        font-size: 1.75rem;
        margin-bottom: 0.8rem;
        color: #21160f;
    }
    
    .product-title a {
        color: inherit;
        text-decoration: none;
    }
    
    .product-excerpt {
        color: rgba(26,16,8,0.6);
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
        line-height: 1.75;
    }
    
    .product-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid rgba(10,26,18,0.08);
    }
    
    .product-price {
        font-weight: 700;
        color: #1a0e08;
        font-size: 1.25rem;
    }
    
    .read-more {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.76rem;
        letter-spacing: 0.15em;
        color: #8a6320;
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
