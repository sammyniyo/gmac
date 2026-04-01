@extends('layouts.frontend')

@section('title', 'Washing Stations - GMAC Coffee')
@section('meta_description', 'Explore our state-of-the-art washing stations in Rwanda where our specialty coffee is processed with care.')

@section('content')
<section class="page-hero fade-in">
    <div class="container">
        <div class="page-hero-card">
            <div class="page-hero-kicker">GMAC Coffee</div>
            <h1 class="page-hero-title">{{ __('messages.our_stations') }}</h1>
            <p class="page-hero-subtitle">{{ __('messages.slogan') }}</p>
        </div>
    </div>
</section>

<div class="container py-6">
    @forelse($stations as $index => $station)
        <div class="station-block mb-6 fade-in {{ $index % 2 != 0 ? 'reverse' : '' }}">
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
                            <img src="{{ $media->getUrl('thumb') ?? $media->getUrl() }}" alt="Gallery" onclick="openLightbox('{{ $media->getUrl() }}', '{{ $station->name }} Gallery')">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="station-info">
                <h2 class="station-name">{{ $station->name }}</h2>
                <div class="station-location mb-2"><i class="fa-solid fa-location-dot text-gold mr-1"></i> {{ $station->location }}</div>
                
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

                <div class="station-description mt-2">
                    <h4 class="mb-1">Processing & Traceability</h4>
                    <p>{{ $station->processing ?? 'Traditional washed process with precise moisture control.' }}</p>
                    <p class="mt-1 text-sm italic">{{ $station->traceability ?? 'Fully traceable to the farm level.' }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-6">
            <p>Our washing station details are being updated.</p>
        </div>
    @endforelse
</div>
@endsection

@push('scripts')
<style>
    .station-block {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 4rem;
        align-items: start;
        padding: 4rem 0;
        border-bottom: 1px solid var(--clr-bg-alt);
    }
    
    .station-block.reverse {
        direction: rtl;
    }
    
    .station-block.reverse > * {
        direction: ltr;
    }
    
    .station-image {
        width: 100%;
        height: 450px;
        object-fit: cover;
        border-radius: var(--radius-card);
    }
    
    .station-placeholder {
        width: 100%;
        height: 450px;
        background: var(--clr-bg-alt);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: var(--clr-gold);
        border-radius: var(--radius-card);
    }
    
    .station-mini-gallery {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
    }
    
    .station-mini-gallery img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    
    .station-mini-gallery img:hover { opacity: 0.8; }
    
    .station-name {
        font-size: 2.5rem;
        color: var(--clr-deep-espresso);
        margin-bottom: 0.5rem;
    }
    
    [data-theme='dark'] .station-name { color: var(--clr-gold); }
    
    .station-location {
        font-size: 1.1rem;
        color: var(--clr-text-muted);
        font-weight: 500;
    }
    
    .station-specs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1.5rem;
        background: var(--clr-bg-alt);
        padding: 2rem;
        border-radius: 12px;
        margin: 2rem 0;
    }
    
    .spec-item {
        display: flex;
        flex-direction: column;
    }
    
    .spec-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--clr-text-muted);
        margin-bottom: 0.25rem;
    }
    
    .spec-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--clr-deep-espresso);
    }
    
    [data-theme='dark'] .spec-value { color: var(--clr-white); }
    [data-theme='dark'] .station-specs-grid { background: rgba(255,255,255,0.05); }
    
    @media (max-width: 992px) {
        .station-block {
            grid-template-columns: 1fr;
            gap: 2rem;
            direction: ltr !important;
        }
        .station-block.reverse { direction: ltr; }
        .station-image, .station-placeholder { height: 350px; }
    }
</style>
@endpush
