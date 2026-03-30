<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee')</title>
    
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::where('key', 'site_description')->value('value') ?? 'Premium Rwandan Coffee')">

    <!-- Fonts are included in frontend.css -->
    
    <!-- Vite Assets -->
    @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
    
    <!-- AlpineJS for scattered frontend interactivity if needed, but mainly we use vanilla JS -->
</head>
<body>
    @php
        $companyName = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
        $logo = \App\Models\Setting::where('key', 'site_logo')->value('value');
    @endphp

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="{{ url('/') }}" class="nav-brand">
                @if($logo)
                    <img src="{{ $logo }}" alt="{{ $companyName }} Logo">
                @else
                    <h2 style="font-family: var(--font-heading); color: var(--clr-gold); font-size: 1.5rem; margin:0;">
                        {{ $companyName }}
                    </h2>
                @endif
            </a>
            
            <ul class="nav-links">
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('messages.home') }}</a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/products')) }}" class="nav-link {{ request()->is('*products*') ? 'active' : '' }}">{{ __('messages.products') }}</a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/news')) }}" class="nav-link {{ request()->is('*news*') ? 'active' : '' }}">{{ __('messages.news') }}</a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/gallery')) }}" class="nav-link {{ request()->is('*gallery*') ? 'active' : '' }}">{{ __('messages.gallery') }}</a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/washing-stations')) }}" class="nav-link {{ request()->is('*washing-stations*') ? 'active' : '' }}">{{ __('messages.stations') }}</a></li>
                <li><a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="nav-link {{ request()->is('*contact*') ? 'active' : '' }}">{{ __('messages.contact') }}</a></li>
            </ul>
            
            <div class="nav-actions">
                <div class="lang-switcher">
                    <button class="lang-btn" id="lang-btn">
                        <i class="fa-solid fa-earth-africa"></i>
                        <span>{{ strtoupper(app()->getLocale()) }}</span>
                    </button>
                    <div class="lang-dropdown" id="lang-dropdown">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="lang-item {{ app()->getLocale() == $localeCode ? 'active' : '' }}">
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <button id="theme-toggle" class="theme-toggle" aria-label="Toggle Dark Mode">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>

            <button class="mobile-menu-btn" aria-label="Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 80px; min-height: 70vh;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid fade-in">
                <div class="footer-brand">
                    <h3>{{ $companyName }}</h3>
                    <p class="footer-text">
                        {{ \App\Models\Setting::where('key', 'about_short_text')->value('value') ?? 'Dedicated to bringing the finest Rwandan coffee to the world.' }}
                    </p>
                    <div class="social-links">
                        @if($fb = \App\Models\Setting::where('key', 'social_facebook')->value('value'))
                            <a href="{{ $fb }}" class="social-link" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                        @endif
                        @if($ig = \App\Models\Setting::where('key', 'social_instagram')->value('value'))
                            <a href="{{ $ig }}" class="social-link" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        @endif
                        @if($tw = \App\Models\Setting::where('key', 'social_twitter')->value('value'))
                            <a href="{{ $tw }}" class="social-link" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                        @endif
                    </div>
                </div>

                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/products') }}">Shop Coffee</a></li>
                        <li><a href="{{ url('/history') }}">Our History</a></li>
                        <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                        <li><a href="{{ url('/contact') }}">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-contact">
                    <h4>Contact Us</h4>
                    @if($addr = \App\Models\Setting::where('key', 'contact_address')->value('value'))
                        <p><i class="fa-solid fa-location-dot"></i> <span>{{ $addr }}</span></p>
                    @endif
                    @if($phone = \App\Models\Setting::where('key', 'contact_phone')->value('value'))
                        <p><i class="fa-solid fa-phone"></i> <span>{{ $phone }}</span></p>
                    @endif
                    @if($email = \App\Models\Setting::where('key', 'contact_email')->value('value'))
                        <p><i class="fa-solid fa-envelope"></i> <span><a href="mailto:{{ $email }}" style="color: inherit;">{{ $email }}</a></span></p>
                    @endif
                </div>

                <div class="footer-newsletter">
                    <h4>Newsletter</h4>
                    <p class="footer-text">Subscribe to receive updates on new arrivals and special offers.</p>
                    
                    @if(session('newsletter_success'))
                        <div style="color: #4CAF50; margin-bottom: 10px; font-weight: bold;">
                            {{ session('newsletter_success') }}
                        </div>
                    @endif
                    
                    <form action="{{ url('/subscribe') }}" method="POST" class="newsletter-form">
                        @csrf
                        <input type="email" name="email" class="newsletter-input" placeholder="Your Email Address" required>
                        <button type="submit" class="newsletter-btn"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                    @error('email') <span style="color: #f44336; font-size: 0.85rem; margin-top:5px; display:block;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="footer-bottom fade-in">
                <p>&copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
