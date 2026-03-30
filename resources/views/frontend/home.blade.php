@extends('layouts.frontend')

@section('title', 'Welcome to GMAC Coffee')
@section('meta_description', 'Experience the finest Rwandan coffee. From our hills to your cup.')

@section('content')

<!-- Hero Section -->
<section class="hero">
    @foreach($slides as $index => $slide)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ $slide->image_url ?? $slide->getFirstMediaUrl('desktop_image') }}');">
            <div class="hero-overlay"></div>
            <div class="container hero-content fade-in">
                <h1 class="hero-title">{{ $slide->title }}</h1>
                @if($slide->subtitle)
                    <p class="hero-subtitle">{{ $slide->subtitle }}</p>
                @endif
                <div class="hero-actions mt-2">
                    @if($slide->button_text && $slide->button_link)
                        <a href="{{ $slide->button_link }}" class="btn btn-primary">{{ $slide->button_text }}</a>
                    @else
                        <a href="{{ LaravelLocalization::localizeUrl(url('/products')) }}" class="btn btn-primary">{{ __('messages.discover') }}</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    
    @if(count($slides) > 1)
        <!-- Simple slider controls if needed -->
        <button class="slider-btn prev"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="slider-btn next"><i class="fa-solid fa-chevron-right"></i></button>
    @endif
</section>

<!-- About Section -->
<section class="about-section py-6">
    <div class="container text-center fade-in">
        <h2 class="section-title">{{ __('messages.history') }}</h2>
        <div class="title-separator"></div>
        <p class="about-text mx-auto mt-2 text-lg text-gray-700" style="max-width: 800px; line-height: 1.8;">
            {{ \App\Models\Setting::where('key', 'about_short_text')->value('value') ?? 'GMAC Coffee represents the peak of Rwandan coffee farming. We cultivate, harvest, and process our beans with absolute dedication to quality and sustainability.' }}
        </p>
        <div class="mt-4">
            <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="btn btn-outline">{{ __('messages.read_more') }}</a>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products py-6 bg-alt">
    <div class="container fade-in">
        <div class="flex justify-between items-end mb-4 flex-wrap">
            <div>
                <h2 class="section-title text-left mb-0">{{ __('messages.featured_products') }}</h2>
                <div class="title-separator mx-0"></div>
            </div>
            <a href="{{ LaravelLocalization::localizeUrl(url('/products')) }}" class="view-all-link">{{ __('messages.products') }} <i class="fa-solid fa-arrow-right ml-1"></i></a>
        </div>
        
        <div class="product-grid mt-4">
            @forelse($featuredProducts as $product)
                <div class="product-card fade-in">
                    <a href="{{ route('products.show', $product->slug) }}" class="product-image-container">
                        @if($product->hasMedia('cover'))
                            <img src="{{ $product->getFirstMediaUrl('cover', 'thumb') ?? $product->getFirstMediaUrl('cover') }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            <div class="product-image-placeholder">
                                <i class="fa-solid fa-mug-hot"></i>
                            </div>
                        @endif
                        <div class="product-overlay">
                            <span>View Details</span>
                        </div>
                    </a>
                    <div class="product-info">
                        <span class="product-category tag">{{ $product->category->name }}</span>
                        <h3 class="product-title"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
                        <p class="product-excerpt">{{ Str::limit(strip_tags($product->description), 80) }}</p>
                    </div>
                </div>
            @empty
                <p>No products currently featured.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us / Features -->
<section class="features-section py-6" style="background-color: var(--clr-deep-espresso); color: var(--clr-cream);">
    <div class="container">
        <div class="text-center mb-4 fade-in">
            <h2 class="section-title" style="color: var(--clr-gold);">{{ __('messages.why_gmac') }}</h2>
            <div class="title-separator mx-auto" style="background-color: var(--clr-gold);"></div>
        </div>
        
        <div class="features-grid">
            <div class="feature-box fade-in">
                <div class="feature-icon"><i class="fa-solid fa-leaf"></i></div>
                <h3>{{ __('messages.sustainable') }}</h3>
                <p>{{ __('messages.sustainable_desc') }}</p>
            </div>
            <div class="feature-box fade-in" style="transition-delay: 0.1s;">
                <div class="feature-icon"><i class="fa-solid fa-award"></i></div>
                <h3>{{ __('messages.premium') }}</h3>
                <p>{{ __('messages.premium_desc') }}</p>
            </div>
            <div class="feature-box fade-in" style="transition-delay: 0.2s;">
                <div class="feature-icon"><i class="fa-solid fa-globe-africa"></i></div>
                <h3>{{ __('messages.global') }}</h3>
                <p>{{ __('messages.global_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Counters -->
@if(count($stats) > 0)
<section class="stats-section py-6 bg-alt">
    <div class="container fade-in">
        <div class="stats-grid">
            @foreach($stats as $index => $stat)
                <div class="stat-card fade-in" style="transition-delay: {{ $index * 0.1 }}s;">
                    @if($stat->icon)
                        <div class="stat-icon"><i class="{{ $stat->icon }}"></i></div>
                    @endif
                    <div class="stat-number">{{ $stat->number }}</div>
                    <div class="stat-title">{{ $stat->title }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="cta-section py-6 text-center" style="background-image: linear-gradient(rgba(28, 10, 0, 0.8), rgba(28, 10, 0, 0.8)), url('https://images.unsplash.com/photo-1511920170033-f8396924c348?q=80&w=2000&auto=format&fit=crop'); background-size: cover; background-attachment: fixed;">
    <div class="container fade-in">
        <h2 style="color: var(--clr-gold); font-size: 2.5rem; margin-bottom: 1rem;">Experience the Taste of Rwanda</h2>
        <p style="color: var(--clr-white); font-size: 1.2rem; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">Ready to discover what makes our coffee exceptional? Get in touch for wholesale inquiries or browse our catalog.</p>
        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ url('/products') }}" class="btn btn-primary">Shop Coffee</a>
            <a href="{{ url('/contact') }}" class="btn btn-outline" style="color: var(--clr-white); border-color: var(--clr-white);">Contact Us</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>
    /* Homepage Specific CSS */
    .hero {
        position: relative;
        height: 80vh;
        min-height: 600px;
        overflow: hidden;
        margin-top: -80px; /* Offset navbar */
    }
    
    .hero-slide {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    
    .hero-slide.active {
        opacity: 1;
        z-index: 1;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(28, 10, 0, 0.7));
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }
    
    .hero-title {
        font-size: 4rem;
        color: var(--clr-white) !important;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    
    [data-theme='dark'] .hero-title {
        color: var(--clr-white) !important;
    }
    
    .hero-subtitle {
        font-size: 1.5rem;
        color: var(--clr-cream);
        margin-bottom: 2rem;
        font-weight: 300;
        letter-spacing: 1px;
    }
    
    .section-title {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }
    
    .title-separator {
        width: 60px;
        height: 3px;
        background-color: var(--clr-gold);
        margin: 0 auto;
    }
    
    .title-separator.mx-0 {
        margin: 0;
    }
    
    .bg-alt {
        background-color: var(--clr-bg-alt);
    }
    
    /* Utility flex for homepage */
    .flex { display: flex; }
    .justify-between { justify-content: space-between; }
    .justify-center { justify-content: center; }
    .items-end { align-items: flex-end; }
    .items-center { align-items: center; }
    .flex-wrap { flex-wrap: wrap; }
    .gap-4 { gap: 1rem; }
    .ml-1 { margin-left: 0.25rem; }
    
    .view-all-link {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
        border-bottom: 1px solid transparent;
    }
    
    .view-all-link:hover {
        border-bottom-color: var(--clr-gold);
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .product-card {
        background: var(--clr-white);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform var(--transition-base), box-shadow var(--transition-base);
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .product-image-container {
        position: relative;
        display: block;
        height: 250px;
        overflow: hidden;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-slow);
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
    
    .product-card:hover .product-image {
        transform: scale(1.05);
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
        padding: 0.5rem 1.5rem;
        border-radius: 4px;
        font-weight: 500;
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
    }
    
    .tag {
        display: inline-block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: var(--clr-bg-alt);
        color: var(--clr-deep-espresso);
        padding: 0.2rem 0.8rem;
        border-radius: 20px;
        margin-bottom: 0.8rem;
    }
    
    [data-theme='dark'] .tag {
        background: rgba(255,255,255,0.1);
        color: var(--clr-gold);
    }
    
    .product-title {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }
    
    .product-title a {
        color: inherit;
    }
    
    .product-excerpt {
        color: var(--clr-text-muted);
        font-size: 0.95rem;
    }
    
    /* Features */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 3rem;
        margin-top: 3rem;
        text-align: center;
    }
    
    .feature-icon {
        font-size: 3rem;
        color: var(--clr-gold);
        margin-bottom: 1rem;
    }
    
    .feature-box h3 {
        color: var(--clr-white);
        font-family: var(--font-heading);
    }
    
    [data-theme='dark'] .feature-box h3 {
        color: var(--clr-gold);
    }
    
    .feature-box p {
        color: rgba(253, 249, 241, 0.8);
    }
    
    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        text-align: center;
    }
    
    .stat-card {
        padding: 2rem;
        background: var(--clr-white);
        border-top: 3px solid var(--clr-gold);
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
    }
    
    .stat-icon {
        font-size: 2rem;
        color: var(--clr-gold);
        margin-bottom: 1rem;
    }
    
    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: var(--clr-deep-espresso);
        font-family: var(--font-heading);
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    
    [data-theme='dark'] .stat-number {
        color: var(--clr-white);
    }
    
    .stat-title {
        font-size: 1.1rem;
        color: var(--clr-text-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    @media(max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
        .hero-subtitle { font-size: 1.2rem; }
    }
</style>
<script>
    // Very simple hero slider auto-play
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.hero-slide');
        if (slides.length <= 1) return;
        
        let currentSlide = 0;
        
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }, 6000);
    });
</script>
@endpush
