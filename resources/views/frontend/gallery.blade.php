@extends('layouts.frontend')

@section('title', 'Gallery - GMAC Coffee')
@section('meta_description', 'A visual journey through our coffee farms, washing stations, and processing facilities in Rwanda.')

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-image: linear-gradient(rgba(28, 10, 0, 0.6), rgba(28, 10, 0, 0.6)), url('https://images.unsplash.com/photo-1501333190117-7437fa05868f?q=80&w=2000&auto=format&fit=crop');">
    <div class="container fade-in">
        <h1 class="page-title">{{ __('messages.gallery') }}</h1>
        <p class="page-subtitle">{{ __('messages.slogan') }}</p>
    </div>
</div>

<div class="container py-6">
    <div class="gallery-wrapper fade-in">
        <div class="masonry-grid" id="gallery-grid">
            @forelse($items as $item)
                <div class="gallery-item fade-in">
                    <div class="gallery-card" onclick="openLightbox('{{ $item->getFirstMediaUrl('image') }}', '{{ $item->caption }}')">
                        <img src="{{ $item->getFirstMediaUrl('image', 'thumb') ?? $item->getFirstMediaUrl('image') }}" alt="{{ $item->title ?? 'Gallery Image' }}">
                        <div class="gallery-overlay">
                            <div class="overlay-content">
                                <h3>{{ $item->title }}</h3>
                                @if($item->category)<span class="tag">{{ $item->category }}</span>@endif
                                <i class="fa-solid fa-expand-alt mt-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-6 w-full">
                    <p class="text-xl text-gray-500">Our gallery is currently being curated. Check back soon for beautiful scenes from Rwanda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Custom Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="close-lightbox">&times;</span>
    <img id="lightbox-img" src="" alt="Full size image">
    <div id="lightbox-caption" class="lightbox-caption"></div>
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
        color: white !important;
    }
    
    /* Masonry Layout */
    .masonry-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-auto-rows: 10px;
        gap: 0 1.5rem;
    }
    
    .gallery-card {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        transition: transform var(--transition-base), box-shadow var(--transition-base);
    }
    
    .gallery-card img {
        width: 100%;
        display: block;
        transition: transform var(--transition-slow);
    }
    
    .gallery-card:hover {
        transform: scale(1.02);
        box-shadow: var(--shadow-md);
    }
    
    .gallery-card:hover img {
        transform: scale(1.05);
    }
    
    .gallery-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to top, rgba(28, 10, 0, 0.8), transparent);
        display: flex;
        align-items: flex-end;
        padding: 1.5rem;
        opacity: 0;
        transition: opacity var(--transition-base);
    }
    
    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }
    
    .overlay-content h3 {
        color: white;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }
    
    .overlay-content i {
        color: var(--clr-gold);
        font-size: 1.2rem;
    }
    
    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 2000;
        top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.9);
        backdrop-filter: blur(5px);
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 2rem;
    }
    
    .lightbox img {
        max-width: 90%;
        max-height: 80vh;
        border-radius: 4px;
        box-shadow: 0 0 30px rgba(0,0,0,0.5);
    }
    
    .close-lightbox {
        position: absolute;
        top: 2rem; right: 2rem;
        color: white;
        font-size: 3rem;
        cursor: pointer;
    }
    
    .lightbox-caption {
        color: var(--clr-cream);
        margin-top: 1.5rem;
        font-size: 1.1rem;
        text-align: center;
        max-width: 600px;
    }
    
    @media (max-width: 600px) {
        .masonry-grid { grid-template-columns: 1fr; }
    }
</style>

<script>
    function openLightbox(src, caption) {
        const lb = document.getElementById('lightbox');
        const img = document.getElementById('lightbox-img');
        const cap = document.getElementById('lightbox-caption');
        
        img.src = src;
        cap.textContent = caption || "";
        lb.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Stop scrolling
    }
    
    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = 'auto'; // Resume scrolling
    }
    
    // Masonry effect logic
    function resizeAllGridItems() {
        const allItems = document.getElementsByClassName("gallery-item");
        for (let x = 0; x < allItems.length; x++) {
            resizeGridItem(allItems[x]);
        }
    }

    function resizeGridItem(item) {
        const grid = document.getElementById("gallery-grid");
        const rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
        const rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('gap'));
        const content = item.querySelector('.gallery-card');
        const rowSpan = Math.ceil((content.getBoundingClientRect().height + rowGap) / (rowHeight + rowGap));
        item.style.gridRowEnd = "span " + rowSpan;
    }

    window.onload = resizeAllGridItems;
    window.addEventListener("resize", resizeAllGridItems);
    
    // Also run after images are loaded
    document.querySelectorAll('.gallery-card img').forEach(img => {
        img.addEventListener('load', () => {
            resizeGridItem(img.closest('.gallery-item'));
        });
    });
</script>
@endpush
