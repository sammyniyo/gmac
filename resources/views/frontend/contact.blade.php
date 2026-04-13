@extends('layouts.frontend')

@section('title', 'Contact Us - GMAC Coffee')
@section('meta_description', 'Get in touch with GMAC Coffee for wholesale inquiries, partnership opportunities, or general coffee talk.')

@section('content')
@php
    $contactAddress = \App\Models\Setting::where('key', 'contact_address')->value('value') ?? 'Kigali, Rwanda';
    $contactPhone = \App\Models\Setting::where('key', 'contact_phone')->value('value') ?? '+250 123 456 789';
    $contactEmail = \App\Models\Setting::where('key', 'contact_email')->value('value') ?? 'info@gmac.coffee';
@endphp

@include('partials.frontend.page-hero', [
    'title' => __('messages.contact_us'),
    'subtitle' => 'Reach out for wholesale, sourcing, export inquiries, or any question about GMAC Coffee.',
    'eyebrow' => 'GMAC Coffee',
])

<section class="contact-page">
    <div class="container">
        <div class="contact-intro fade-in">
            <div class="contact-kicker">{{ __('messages.get_in_touch') }}</div>
            <h2 class="contact-title">Let’s talk about coffee, supply, and <em>partnership.</em></h2>
            <p class="contact-copy">Whether you are a buyer, roaster, importer, or simply curious about our coffee, our team is ready to help you with clear answers and quick guidance.</p>
        </div>

        <div class="contact-grid fade-in">
            <div class="contact-sidebar">
                <div class="contact-cards">
                    <div class="contact-card">
                        <div class="card-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="card-text">
                            <h4>Our Office</h4>
                            <p>{{ $contactAddress }}</p>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="card-icon"><i class="fa-solid fa-phone"></i></div>
                        <div class="card-text">
                            <h4>Call Us</h4>
                            <p>{{ $contactPhone }}</p>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="card-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="card-text">
                            <h4>Email Us</h4>
                            <p>{{ $contactEmail }}</p>
                        </div>
                    </div>
                </div>

                <div class="contact-side-note">
                    <strong>Best for</strong>
                    <p>Wholesale requests, sourcing conversations, export coordination, and station or farm-related inquiries.</p>
                </div>

                <div class="social-box">
                    <h4>Follow Our Journey</h4>
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

            <div class="contact-form-wrapper shadow-lg">
                <div class="contact-form-head">
                    <div class="contact-kicker contact-kicker--small">Send a message</div>
                    <h3>Tell us what you need.</h3>
                    <p>Share your request and our team will get back to you as soon as possible.</p>
                </div>

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
                        <input type="text" id="subject" name="subject" class="form-control" value="{{ request('product') ? 'Inquiry about ' . request('product') : '' }}" placeholder="Wholesale inquiry, sample request, partnership...">
                    </div>

                    <div class="form-group mt-2">
                        <label for="message">{{ __('messages.message') }} *</label>
                        <textarea id="message" name="message" class="form-control" rows="6" required placeholder="Tell us about your request"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2 w-full">{{ __('messages.send_message') }}</button>
                </form>
            </div>
        </div>

        <div class="map-shell fade-in">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127593.425946979!2d30.0163351239868!3d-1.930190112443048!2m3!1f0!2f0!3f0!2f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca4258ed8e797%3A0xf32b36a5411d0bc8!2sKigali%2C%20Rwanda!5e0!3m2!1sen!2s!4v1711311545631!5m2!1sen!2s" width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
    .contact-page {
        padding: 3rem 0 5.5rem;
    }

    .contact-intro {
        max-width: 820px;
        margin: 0 auto 2rem;
        text-align: center;
    }

    .contact-kicker {
        display: inline-flex;
        align-items: center;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        background: rgba(201, 150, 63, 0.1);
        border: 1px solid rgba(201, 150, 63, 0.18);
        color: var(--clr-gold-hover);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .contact-kicker--small {
        margin-bottom: 0.8rem;
    }

    .contact-title {
        margin: 0 0 0.8rem;
        font-size: clamp(2.2rem, 4vw, 3.6rem);
        line-height: 1.06;
        color: var(--clr-deep-espresso);
    }

    .contact-title em {
        font-style: italic;
        color: var(--clr-gold);
    }

    .contact-copy {
        max-width: 60ch;
        margin: 0 auto;
        color: var(--clr-text-muted);
        line-height: 1.85;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 2rem;
        align-items: start;
    }

    .contact-sidebar {
        display: grid;
        gap: 1rem;
    }
    
    .contact-card {
        display: flex;
        gap: 1.4rem;
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

    .contact-side-note {
        padding: 1.3rem 1.35rem;
        background: rgba(201, 150, 63, 0.06);
        border: 1px solid rgba(201, 150, 63, 0.14);
        border-radius: 22px;
    }

    .contact-side-note strong {
        display: block;
        margin-bottom: 0.35rem;
        color: var(--clr-deep-espresso);
        font-size: 1rem;
    }

    .contact-side-note p,
    .contact-form-head p {
        margin: 0;
        color: var(--clr-text-muted);
        line-height: 1.75;
    }

    .social-box {
        padding: 1.25rem 1.3rem;
        background: rgba(255, 255, 255, 0.82);
        border: 1px solid rgba(13, 9, 7, 0.07);
        border-radius: 22px;
        box-shadow: var(--shadow-sm);
    }

    .social-box h4 {
        margin: 0 0 0.8rem;
        font-size: 1.15rem;
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

    .contact-form-head {
        margin-bottom: 1.25rem;
    }

    .contact-form-head h3 {
        margin: 0 0 0.5rem;
        font-size: 1.8rem;
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

    .map-shell {
        margin-top: 1.5rem;
        overflow: hidden;
        border-radius: 26px;
        border: 1px solid rgba(13, 9, 7, 0.07);
        box-shadow: var(--shadow-md);
    }

    .map-shell iframe {
        display: block;
        filter: saturate(0.7) contrast(1.02);
    }

    [data-theme='dark'] .contact-title,
    [data-theme='dark'] .contact-side-note strong,
    [data-theme='dark'] .contact-form-head h3,
    [data-theme='dark'] .social-box h4 {
        color: var(--clr-text-light);
    }

    [data-theme='dark'] .contact-copy,
    [data-theme='dark'] .contact-side-note p,
    [data-theme='dark'] .contact-form-head p,
    [data-theme='dark'] .card-text p {
        color: rgba(246, 240, 230, 0.7);
    }

    [data-theme='dark'] .contact-side-note,
    [data-theme='dark'] .social-box,
    [data-theme='dark'] .contact-form-wrapper {
        background: rgba(246, 240, 230, 0.05);
        border-color: rgba(246, 240, 230, 0.1);
    }
    
    @media (max-width: 992px) {
        .contact-grid { grid-template-columns: 1fr; gap: 3rem; }
        .contact-form-wrapper { padding: 2rem; }
    }
</style>
@endpush
