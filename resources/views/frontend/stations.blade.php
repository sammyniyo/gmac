@extends('layouts.frontend')

@section('title', 'Washing Stations - GMAC Coffee')
@section('meta_description', 'Explore our state-of-the-art washing stations in Rwanda where our specialty coffee is processed with care.')

@section('content')
@include('partials.frontend.page-hero', [
    'title' => __('messages.our_stations'),
    'subtitle' => 'The places where our cherries are received, processed, and prepared with care for quality-focused buyers.',
    'eyebrow' => 'GMAC Coffee',
])

<section class="stations-page">
    <div class="container">
        <div class="stations-intro fade-in">
            <div class="stations-kicker">Origin &amp; Processing</div>
            <h2 class="stations-intro-title">Discover the places where our cherries are processed with <em>care and full traceability.</em></h2>
            <p class="stations-intro-text">Each station reflects our commitment to cleaner processing, stronger farmer relationships, and the distinctive character of Rwandan coffee.</p>
        </div>

        <div class="stations-summary fade-in">
            <div class="stations-summary__item">
                <strong>{{ $stations->count() }}</strong>
                <span>Managed stations</span>
            </div>
            <div class="stations-summary__item">
                <strong>Traceable</strong>
                <span>Farm-linked sourcing</span>
            </div>
            <div class="stations-summary__item">
                <strong>Specialty</strong>
                <span>Washed and experimental lots</span>
            </div>
        </div>

        @forelse($stations as $index => $station)
            <article class="station-block fade-in {{ $index % 2 !== 0 ? 'reverse' : '' }}">
                <div class="station-visuals">
                    @if($station->hasMedia('cover'))
                        <img src="{{ $station->getFirstMediaUrl('cover') }}" alt="{{ $station->name }}" class="station-image shadow-lg">
                    @else
                        <div class="station-placeholder shadow-lg">
                            <i class="fa-solid fa-industry"></i>
                        </div>
                    @endif

                    @if($station->hasMedia('gallery'))
                        <div class="station-mini-gallery mt-1">
                            @foreach($station->getMedia('gallery')->take(4) as $media)
                                <button type="button" class="station-thumb" onclick="openStationsLightbox('{{ $media->getUrl() }}', '{{ $station->name }} Gallery')">
                                    <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}" alt="Gallery image for {{ $station->name }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="station-info">
                    <div class="station-eyebrow">Washing Station</div>
                    <h2 class="station-name">{{ $station->name }}</h2>
                    <div class="station-location"><i class="fa-solid fa-location-dot text-gold mr-1"></i> {{ $station->location }}</div>

                    <div class="station-specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">Altitude</span>
                            <span class="spec-value">{{ $station->altitude ?? 'N/A' }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Soil type</span>
                            <span class="spec-value">{{ $station->type_of_soil ?? 'N/A' }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Variety</span>
                            <span class="spec-value">{{ $station->coffee_variety ?? 'N/A' }}</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Farmers</span>
                            <span class="spec-value">{{ $station->farmers_working ?? '0' }}+</span>
                        </div>
                        @if($station->cupping_score)
                            <div class="spec-item">
                                <span class="spec-label">Cupping Score</span>
                                <span class="spec-value text-gold">{{ $station->cupping_score }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="station-description">
                        <h4>Processing &amp; Traceability</h4>
                        <p>{{ $station->processing ?? 'Traditional washed process with precise moisture control.' }}</p>
                        <p class="station-description__trace">{{ $station->traceability ?? 'Fully traceable to the farm level.' }}</p>
                    </div>
                </div>
            </article>
        @empty
            <div class="text-center py-6">
                <p>Our washing station details are being updated.</p>
            </div>
        @endforelse
    </div>
</section>

<div id="stations-lightbox" class="stations-lightbox" onclick="closeStationsLightbox()">
    <span class="stations-lightbox__close">&times;</span>
    <img id="stations-lightbox-img" src="" alt="Full size station image">
    <div id="stations-lightbox-caption" class="stations-lightbox__caption"></div>
</div>
@endsection

@push('scripts')
<style>
    .stations-page {
        padding: 3rem 0 5.5rem;
    }

    .stations-intro {
        max-width: 780px;
        margin: 0 auto 2.75rem;
        text-align: center;
    }

    .stations-kicker {
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

    .stations-intro-title {
        margin: 0 0 0.9rem;
        font-size: clamp(2.2rem, 4vw, 3.5rem);
        line-height: 1.05;
        color: #21160f;
    }

    .stations-intro-title em {
        color: var(--clr-gold, #c9963f);
        font-style: italic;
    }

    .stations-intro-text {
        max-width: 58ch;
        margin: 0 auto;
        color: rgba(24,49,38,0.74);
        font-size: 1rem;
        line-height: 1.8;
    }

    .stations-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stations-summary__item {
        padding: 1.2rem 1.3rem;
        text-align: center;
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(13, 9, 7, 0.07);
        border-radius: 22px;
        box-shadow: var(--shadow-sm);
    }

    .stations-summary__item strong {
        display: block;
        font-family: var(--font-heading);
        font-size: 2rem;
        line-height: 1;
        color: var(--clr-deep-espresso);
    }

    .stations-summary__item span {
        display: block;
        margin-top: 0.4rem;
        color: var(--clr-text-muted);
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .station-block {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 2.25rem;
        align-items: start;
        padding: 2rem;
        background:
            radial-gradient(360px 160px at 100% 0%, rgba(201,150,63,0.08), transparent 60%),
            linear-gradient(180deg, #fdfaf5 0%, #f5ebe0 100%);
        border: 1px solid rgba(201,150,63,0.12);
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(10,26,18,0.08);
    }
    
    .station-block.reverse {
        direction: rtl;
    }
    
    .station-block.reverse > * {
        direction: ltr;
    }

    .station-eyebrow {
        display: inline-flex;
        align-items: center;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        background: rgba(201, 150, 63, 0.1);
        border: 1px solid rgba(201, 150, 63, 0.16);
        color: var(--clr-gold-hover);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    
    .station-image {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: 24px;
    }
    
    .station-placeholder {
        width: 100%;
        height: 450px;
        background: linear-gradient(160deg, #2d1a0e 0%, #1a0e08 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: var(--clr-gold);
        border-radius: 24px;
    }
    
    .station-mini-gallery {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
    }

    .station-thumb {
        padding: 0;
        border: none;
        background: transparent;
        cursor: pointer;
    }

    .station-mini-gallery img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        transition: opacity 0.2s, transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .station-mini-gallery img:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 12px 24px rgba(10,26,18,0.12); }
    
    .station-name {
        font-size: clamp(2rem, 3vw, 2.8rem);
        color: #21160f;
        margin-bottom: 0.5rem;
    }
    
    [data-theme='dark'] .station-name { color: var(--clr-gold); }
    
    .station-location {
        font-size: 1.1rem;
        color: rgba(24,49,38,0.72);
        font-weight: 500;
        margin-bottom: 1.25rem;
    }
    
    .station-specs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        background: rgba(201,150,63,0.06);
        padding: 2rem;
        border-radius: 24px;
        margin: 2rem 0;
        border: 1px solid rgba(201,150,63,0.14);
    }
    
    .spec-item {
        display: flex;
        flex-direction: column;
    }
    
    .spec-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: #8a6320;
        margin-bottom: 0.25rem;
        font-weight: 700;
    }
    
    .spec-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a0e08;
    }
    
    [data-theme='dark'] .spec-value { color: var(--clr-white); }
    [data-theme='dark'] .station-specs-grid { background: rgba(255,255,255,0.05); }

    .station-description {
        padding: 1.25rem 1.35rem;
        border-radius: 22px;
        background: rgba(201,150,63,0.05);
        border: 1px solid rgba(201,150,63,0.14);
    }

    .station-description h4 {
        margin-bottom: 0.5rem;
        color: #1a0e08;
        font-size: 1.1rem;
    }

    .station-description p {
        color: rgba(26,16,8,0.62);
        line-height: 1.75;
    }

    .station-description__trace {
        margin-top: 0.6rem;
        font-style: italic;
    }

    .stations-lightbox {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 2000;
        background:
            radial-gradient(circle at top, rgba(201,150,63,0.10), transparent 28%),
            rgba(12,10,8,0.94);
        backdrop-filter: blur(10px);
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 2rem;
    }

    .stations-lightbox img {
        max-width: 90%;
        max-height: 80vh;
        border-radius: 18px;
        box-shadow: 0 24px 70px rgba(0,0,0,0.45);
        border: 1px solid rgba(244,236,223,0.14);
    }

    .stations-lightbox__close {
        position: absolute;
        top: 2rem;
        right: 2rem;
        color: white;
        font-size: 3rem;
        cursor: pointer;
    }

    .stations-lightbox__caption {
        color: #f4ecdf;
        margin-top: 1.5rem;
        font-size: 1.1rem;
        text-align: center;
        max-width: 600px;
    }

    [data-theme='dark'] .stations-summary__item,
    [data-theme='dark'] .station-block {
        background: rgba(246, 240, 230, 0.05);
        border-color: rgba(246, 240, 230, 0.1);
    }

    [data-theme='dark'] .stations-summary__item strong,
    [data-theme='dark'] .stations-intro-title,
    [data-theme='dark'] .station-name,
    [data-theme='dark'] .spec-value,
    [data-theme='dark'] .station-description h4 {
        color: var(--clr-text-light);
    }

    [data-theme='dark'] .stations-summary__item span,
    [data-theme='dark'] .stations-intro-text,
    [data-theme='dark'] .station-location,
    [data-theme='dark'] .station-description p {
        color: rgba(246, 240, 230, 0.7);
    }
    
    @media (max-width: 992px) {
        .stations-summary {
            grid-template-columns: 1fr;
        }

        .station-block {
            grid-template-columns: 1fr;
            gap: 2rem;
            direction: ltr !important;
            padding: 1.35rem;
        }
        .station-block.reverse { direction: ltr; }
        .station-image, .station-placeholder { height: 350px; }
    }
</style>

<script>
    function openStationsLightbox(src, caption) {
        const lb = document.getElementById('stations-lightbox');
        const img = document.getElementById('stations-lightbox-img');
        const cap = document.getElementById('stations-lightbox-caption');

        img.src = src;
        cap.textContent = caption || '';
        lb.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeStationsLightbox() {
        document.getElementById('stations-lightbox').style.display = 'none';
        document.body.style.overflow = '';
    }
</script>
@endpush
