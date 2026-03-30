@extends('layouts.frontend')

@section('title', 'Our History - GMAC Coffee')
@section('meta_description', 'Learn about the rich history of GMAC Coffee, our mission, vision, and dedication to Rwandan coffee excellence.')

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-image: linear-gradient(rgba(28, 10, 0, 0.7), rgba(28, 10, 0, 0.7)), url('https://images.unsplash.com/photo-1518832553480-cd0e625ed3e6?q=80&w=2000&auto=format&fit=crop');">
    <div class="container fade-in">
        <h1 class="page-title">{{ __('messages.history') }}</h1>
        <p class="page-subtitle">{{ __('messages.slogan') }}</p>
    </div>
</div>

<div class="container py-6">
    <div class="history-content fade-in">
        <div class="history-text">
            <h2 class="section-title text-center mb-2">{{ __('messages.our_legacy') }}</h2>
            <div class="title-separator mb-4"></div>
            
            <p class="lead-text text-center mx-auto mb-4" style="max-width: 800px; font-size: 1.2rem; color: var(--clr-text-muted);">
                GMAC was born from a deep love for Rwandan coffee and a profound respect for the generations of farmers who cultivate it on the "Land of a Thousand Hills".
            </p>
            
            <div class="history-grid mt-4">
                <div class="history-card fade-in">
                    <h3><i class="fa-solid fa-seedling text-gold mr-2"></i> {{ __('messages.our_roots') }}</h3>
                    <p>Starting as a small family cooperative, we recognized the untapped potential of our volcanic soil and high-altitude climate. We set out to refine the washing and roasting process while ensuring fair compensation for local growers.</p>
                </div>
                
                <div class="history-card fade-in" style="transition-delay: 0.1s;">
                    <h3><i class="fa-solid fa-hand-holding-hand text-gold mr-2"></i> {{ __('messages.our_mission') }}</h3>
                    <p>To produce the world's finest specialty coffee by fostering sustainable agricultural practices, empowering local communities, and maintaining absolute transparency from bean to cup.</p>
                </div>
                
                <div class="history-card fade-in" style="transition-delay: 0.2s;">
                    <h3><i class="fa-solid fa-eye text-gold mr-2"></i> {{ __('messages.our_vision') }}</h3>
                    <p>To be universally recognized as the premier ambassador of Rwandan coffee culture, continuously lifting the standard for ethical sourcing, environmental stewardship, and extraordinary flavor.</p>
                </div>
                
                <div class="history-card fade-in" style="transition-delay: 0.3s;">
                    <h3><i class="fa-solid fa-certificate text-gold mr-2"></i> {{ __('messages.our_commitment') }}</h3>
                    <p>Every bean of GMAC coffee is rigorously hand-sorted. We invest back into our washing stations, building infrastructure that serves both our quality control and the surrounding community's needs.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Values Section -->
<section class="values-section py-6 bg-alt">
    <div class="container text-center fade-in">
        <h2 class="section-title">{{ __('messages.core_values') }}</h2>
        <div class="title-separator"></div>
        
        <div class="values-flex mt-4">
            <div class="value-item">
                <div class="value-circle">1</div>
                <h4>{{ __('messages.integrity') }}</h4>
                <p>Honest dealing with farmers and partners.</p>
            </div>
            <div class="value-item">
                <div class="value-circle">2</div>
                <h4>{{ __('messages.quality') }}</h4>
                <p>No compromises on our specialty grade.</p>
            </div>
            <div class="value-item">
                <div class="value-circle">3</div>
                <h4>{{ __('messages.sustainable') }}</h4>
                <p>Protecting Rwanda's natural ecosystems.</p>
            </div>
            <div class="value-item">
                <div class="value-circle">4</div>
                <h4>{{ __('messages.community') }}</h4>
                <p>Rising together through shared success.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
    .page-header {
        height: 400px;
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
        color: var(--clr-white) !important;
        margin-bottom: 0.5rem;
    }
    
    .page-subtitle {
        font-size: 1.2rem;
        color: var(--clr-cream);
        font-weight: 300;
    }
    
    .history-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .history-card {
        background: var(--clr-white);
        padding: 2.5rem;
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
        border-top: 4px solid var(--clr-gold);
    }
    
    .text-gold {
        color: var(--clr-gold);
    }
    
    .mr-2 {
        margin-right: 0.5rem;
    }
    
    /* Values */
    .values-flex {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 3rem;
    }
    
    .value-item {
        max-width: 200px;
    }
    
    .value-circle {
        width: 80px;
        height: 80px;
        background: var(--clr-gold);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-family: var(--font-heading);
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow-md);
    }
    
    .value-item h4 {
        margin-bottom: 0.5rem;
    }
</style>
@endpush
