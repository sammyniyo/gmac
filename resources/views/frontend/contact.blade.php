@extends('layouts.frontend')

@section('title', 'Contact Us - GMAC Coffee')
@section('meta_description', 'Get in touch with GMAC Coffee for wholesale inquiries, partnership opportunities, or general coffee talk.')

@section('content')
<section class="page-hero fade-in">
    <div class="container">
        <div class="page-hero-card">
            <div class="page-hero-kicker">GMAC Coffee</div>
            <h1 class="page-hero-title">{{ __('messages.contact_us') }}</h1>
            <p class="page-hero-subtitle">{{ __('messages.get_in_touch') }}</p>
        </div>
    </div>
</section>

<div class="container py-6">
    <div class="contact-grid fade-in">
        <!-- Contact Info -->
        <div class="contact-sidebar">
            <h2 class="section-title text-left">{{ __('messages.get_in_touch') }}</h2>
            <div class="title-separator mx-0 mb-4"></div>
            
            <p class="mb-4">Whether you have a question about our coffee, our stations, or wholesale opportunities, our team is ready to assist you.</p>

            <div class="contact-cards">
                <div class="contact-card">
                    <div class="card-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="card-text">
                        <h4>Our Office</h4>
                        <p>{{ \App\Models\Setting::where('key', 'contact_address')->value('value') ?? 'Kigali, Rwanda' }}</p>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="card-icon"><i class="fa-solid fa-phone"></i></div>
                    <div class="card-text">
                        <h4>Call Us</h4>
                        <p>{{ \App\Models\Setting::where('key', 'contact_phone')->value('value') ?? '+250 123 456 789' }}</p>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="card-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="card-text">
                        <h4>Email Us</h4>
                        <p>{{ \App\Models\Setting::where('key', 'contact_email')->value('value') ?? 'info@gmac.coffee' }}</p>
                    </div>
                </div>
            </div>

            <div class="social-box mt-4">
                <h4 class="mb-1">Follow Our Journey</h4>
                <div class="flex gap-1">
                    @if($fb = \App\Models\Setting::where('key', 'social_facebook')->value('value'))
                        <a href="{{ $fb }}" class="social-link" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    @endif
                    @if($ig = \App\Models\Setting::where('key', 'social_instagram')->value('value'))
                        <a href="{{ $ig }}" class="social-link" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if($tw = \App\Models\Setting::where('key', 'social_twitter')->value('value'))
                        <a href="{{ $tw }}" class="social-link" target="_blank" rel="noopener" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form-wrapper shadow-lg">
            @if(session('success'))
                <div class="alert alert-success mb-2 fade-in">
                    <i class="fa-solid fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">{{ __('messages.name') }} *</label>
                        <input type="text" id="name" name="name" class="form-control" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('messages.email') }} *</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="john@example.com">
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label for="subject">{{ __('messages.subject') }}</label>
                    <input type="text" id="subject" name="subject" class="form-control" value="{{ request('product') ? 'Inquiry about ' . request('product') : '' }}" placeholder="...">
                </div>

                <div class="form-group mt-2">
                    <label for="message">{{ __('messages.message') }} *</label>
                    <textarea id="message" name="message" class="form-control" rows="6" required placeholder="..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-2 w-full">{{ __('messages.send_message') }}</button>
            </form>
        </div>
    </div>
</div>

<!-- Map Section -->
<section class="map-section mt-4 fade-in">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127593.425946979!2d30.0163351239868!3d-1.930190112443048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca4258ed8e797%3A0xf32b36a5411d0bc8!2sKigali%2C%20Rwanda!5e0!3m2!1sen!2s!4v1711311545631!5m2!1sen!2s" width="100%" height="450" style="border:0; filter: grayscale(1) invert(0.9) opacity(0.8);" allowfullscreen="" loading="lazy"></iframe>
</section>

@endsection

@push('scripts')
<style>
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 5rem;
        align-items: start;
    }
    
    .contact-card {
        display: flex;
        gap: 1.4rem;
        margin-bottom: 1.5rem;
        padding: 1.4rem;
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(13, 9, 7, 0.07);
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-sm);
        transition: transform 0.28s, box-shadow 0.28s, border-color 0.28s;
    }

    [data-theme='dark'] .contact-card {
        background: rgba(246, 240, 230, 0.05);
        border-color: rgba(246, 240, 230, 0.10);
    }

    .contact-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: rgba(201, 150, 63, 0.22);
    }

    .card-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--clr-gold) 0%, #daa83f 100%);
        color: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(201, 150, 63, 0.28);
    }

    .card-text h4 { margin-bottom: 0.25rem; font-size: 1.05rem; }
    .card-text p { color: var(--clr-text-subtle); font-size: 0.9rem; }

    .contact-form-wrapper {
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(13, 9, 7, 0.07);
        padding: 2.75rem;
        border-radius: 24px;
        box-shadow: var(--shadow-md);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    /* form-control styles come from resources/css/frontend.css */
    
    .alert-success {
        background: rgba(201, 150, 63, 0.10);
        color: var(--clr-gold-hover);
        padding: 1rem 1.25rem;
        border-radius: 12px;
        border-left: 4px solid var(--clr-gold);
    }
    
    .w-full { width: 100%; }
    
    @media (max-width: 992px) {
        .contact-grid { grid-template-columns: 1fr; gap: 3rem; }
        .contact-form-wrapper { padding: 2rem; }
    }
</style>
@endpush
