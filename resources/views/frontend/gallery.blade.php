@extends('layouts.frontend')

@section('title', 'Gallery - GMAC Coffee')
@section('meta_description', 'A visual journey through our coffee farms, washing stations, and processing facilities in Rwanda.')

@section('content')
@include('partials.frontend.mag-hero', [
    'variant' => 'gallery',
    'title' => __('messages.gallery'),
    'subtitle' => __('messages.gallery_hero_subtitle'),
    'mosaic' => $items->take(6),
])

<div class="container py-6">
    <div class="gallery-page fade-in">
        @php
            $bentoMods = ['hero', 'tall', 'sq', 'sq', 'wide', 'wide'];
        @endphp
        <div class="gallery-bento" id="gallery-bento" role="list">
            @forelse($items as $item)
                @php
                    $full = $item->getFirstMediaUrl('image');
                    $thumb = $item->getFirstMediaUrl('image', 'thumb') ?: $full;
                    $mod = $bentoMods[$loop->index % count($bentoMods)];
                @endphp
                <div class="gallery-bento__cell gallery-bento__cell--{{ $mod }}" role="listitem">
                    <button type="button"
                            class="gallery-tile"
                            data-gallery-open
                            data-src="{{ e($full) }}"
                            data-title="{{ e($item->title ?? '') }}"
                            data-caption="{{ e($item->caption ?? '') }}">
                        <img src="{{ $thumb }}"
                             alt="{{ $item->title ?? __('messages.gallery') }}"
                             loading="lazy"
                             decoding="async"
                             width="800"
                             height="600">
                        <span class="gallery-tile__shine" aria-hidden="true"></span>
                        <span class="gallery-tile__overlay">
                            <span class="gallery-tile__meta">
                                @if($item->title)
                                    <span class="gallery-tile__title">{{ $item->title }}</span>
                                @endif
                                @if($item->category)
                                    <span class="gallery-tile__tag">{{ $item->category }}</span>
                                @endif
                            </span>
                            <span class="gallery-tile__zoom" aria-hidden="true">
                                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                            </span>
                        </span>
                    </button>
                </div>
            @empty
                <p class="gallery-bento__empty">Our gallery is being curated. Check back soon for scenes from the thousand hills.</p>
            @endforelse
        </div>
    </div>
</div>

<div id="gallery-lightbox"
     class="gallery-lightbox"
     role="dialog"
     aria-modal="true"
     aria-label="{{ __('messages.gallery') }}"
     hidden>
    <button type="button" class="gallery-lightbox__backdrop" data-gallery-close aria-label="Close"></button>
    <div class="gallery-lightbox__panel">
        <button type="button" class="gallery-lightbox__close" data-gallery-close aria-label="Close">&times;</button>
        <img class="gallery-lightbox__img" src="" alt="">
        <div class="gallery-lightbox__caption" data-gallery-caption></div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .gallery-page { margin-bottom: 2rem; }

    .gallery-bento {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-auto-rows: 52px;
        gap: 1rem;
        grid-auto-flow: dense;
    }

    .gallery-bento__cell--hero { grid-column: span 8; grid-row: span 4; }
    .gallery-bento__cell--tall { grid-column: span 4; grid-row: span 4; }
    .gallery-bento__cell--sq   { grid-column: span 4; grid-row: span 2; }
    .gallery-bento__cell--wide { grid-column: span 6; grid-row: span 3; }

    .gallery-bento__empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem 1.5rem;
        font-size: 1.05rem;
        color: var(--clr-text-muted, rgba(26, 14, 8, 0.5));
        margin: 0;
    }

    .gallery-tile {
        position: relative;
        display: block;
        width: 100%;
        height: 100%;
        min-height: 0;
        padding: 0;
        margin: 0;
        border: none;
        border-radius: 18px;
        overflow: hidden;
        cursor: zoom-in;
        background: var(--clr-bg-alt, rgba(26, 14, 8, 0.06));
        box-shadow: 0 4px 24px rgba(13, 9, 7, 0.08);
        transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease;
    }

    .gallery-tile:focus-visible {
        outline: 2px solid var(--clr-gold, #d4a24a);
        outline-offset: 3px;
    }

    .gallery-tile:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 18px 40px rgba(13, 9, 7, 0.14);
    }

    .gallery-tile img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.7s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .gallery-tile:hover img { transform: scale(1.06); }

    .gallery-tile__shine {
        position: absolute;
        inset: 0;
        background: linear-gradient(125deg, transparent 40%, rgba(255,255,255,0.12) 48%, transparent 56%);
        opacity: 0;
        transition: opacity 0.5s ease;
        pointer-events: none;
    }

    .gallery-tile:hover .gallery-tile__shine { opacity: 1; }

    .gallery-tile__overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        padding: 1rem 1.1rem;
        background: linear-gradient(to top, rgba(13, 9, 7, 0.82) 0%, rgba(13, 9, 7, 0.2) 45%, transparent 72%);
        opacity: 0;
        transition: opacity 0.35s ease;
        pointer-events: none;
        gap: 12px;
    }

    .gallery-tile:hover .gallery-tile__overlay,
    .gallery-tile:focus-visible .gallery-tile__overlay {
        opacity: 1;
    }

    .gallery-tile__meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .gallery-tile__title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: #fdfaf5;
        line-height: 1.25;
    }

    .gallery-tile__tag {
        font-size: 0.62rem;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--clr-gold, #e8c97a);
    }

    .gallery-tile__zoom {
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: rgba(246, 240, 230, 0.12);
        border: 1px solid rgba(246, 240, 230, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--clr-gold, #e8c97a);
        font-size: 0.95rem;
    }

    .gallery-lightbox {
        position: fixed;
        inset: 0;
        z-index: 3000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
    }

    .gallery-lightbox[hidden] { display: none !important; }

    .gallery-lightbox__backdrop {
        position: absolute;
        inset: 0;
        border: none;
        padding: 0;
        margin: 0;
        background: rgba(8, 5, 4, 0.88);
        backdrop-filter: blur(10px);
        cursor: zoom-out;
    }

    .gallery-lightbox__panel {
        position: relative;
        z-index: 1;
        max-width: min(1100px, 96vw);
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        pointer-events: none;
    }

    .gallery-lightbox__panel > * { pointer-events: auto; }

    .gallery-lightbox__close {
        position: absolute;
        top: -2.5rem;
        right: 0;
        border: none;
        background: transparent;
        color: #f6f0e6;
        font-size: 2.25rem;
        line-height: 1;
        cursor: pointer;
        padding: 4px 10px;
        opacity: 0.85;
        transition: opacity 0.2s;
    }

    .gallery-lightbox__close:hover { opacity: 1; }

    .gallery-lightbox__img {
        max-width: 100%;
        max-height: min(78vh, 820px);
        width: auto;
        height: auto;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.45);
    }

    .gallery-lightbox__caption {
        color: rgba(246, 240, 230, 0.88);
        font-size: 0.98rem;
        line-height: 1.55;
        text-align: center;
        max-width: 640px;
    }

    .gallery-lightbox__caption:empty { display: none; }

    @media (max-width: 1024px) {
        .gallery-bento__cell--hero { grid-column: span 7; }
        .gallery-bento__cell--tall { grid-column: span 5; }
    }

    @media (max-width: 720px) {
        .gallery-bento {
            grid-template-columns: repeat(6, 1fr);
            grid-auto-rows: 48px;
            gap: 0.65rem;
        }
        .gallery-bento__cell--hero,
        .gallery-bento__cell--tall,
        .gallery-bento__cell--sq,
        .gallery-bento__cell--wide {
            grid-column: span 6;
            grid-row: span 3;
        }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    var root = document.getElementById('gallery-bento');
    var lb = document.getElementById('gallery-lightbox');
    if (!root || !lb) return;

    var imgEl = lb.querySelector('.gallery-lightbox__img');
    var capEl = lb.querySelector('[data-gallery-caption]');
    var lastFocus = null;

    function openLb(src, caption) {
        lastFocus = document.activeElement;
        imgEl.src = src;
        imgEl.alt = caption || '{{ __('messages.gallery') }}';
        capEl.textContent = caption || '';
        lb.hidden = false;
        document.body.style.overflow = 'hidden';
        lb.querySelector('.gallery-lightbox__close').focus();
    }

    function closeLb() {
        lb.hidden = true;
        imgEl.removeAttribute('src');
        document.body.style.overflow = '';
        if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
    }

    root.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-gallery-open]');
        if (!btn) return;
        var src = btn.getAttribute('data-src');
        if (!src) return;
        var title = btn.getAttribute('data-title') || '';
        var cap = btn.getAttribute('data-caption') || '';
        var text = [title, cap].filter(Boolean).join(' — ');
        openLb(src, text);
    });

    lb.addEventListener('click', function (e) {
        if (e.target.hasAttribute('data-gallery-close')) closeLb();
    });

    document.addEventListener('keydown', function (e) {
        if (!lb.hidden && e.key === 'Escape') closeLb();
    });
})();
</script>
@endpush
