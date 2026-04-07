@php
    $companyName = \App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee';
    $logo = \App\Models\Setting::where('key', 'site_logo')->value('value');
    $aboutShortFooter = \App\Models\Setting::where('key', 'about_short_text')->value('value')
        ?? 'Dedicated to bringing the finest Rwandan coffee to the world.';
    $addr = \App\Models\Setting::where('key', 'contact_address')->value('value') ?: 'KK 372 S, Kigali, Kicukiro, Rwanda';
    $addr2 = \App\Models\Setting::where('key', 'contact_address_2')->value('value');
    $phone = \App\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+250 783 053 415';
    $phone2 = \App\Models\Setting::where('key', 'contact_phone_2')->value('value');
    $email = \App\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@gmac.coffee';
    $fb = \App\Models\Setting::where('key', 'social_facebook')->value('value');
    $ig = \App\Models\Setting::where('key', 'social_instagram')->value('value');
    $tw = \App\Models\Setting::where('key', 'social_twitter')->value('value');
    $li = \App\Models\Setting::where('key', 'social_linkedin')->value('value');
@endphp

<footer class="footer" role="contentinfo">
    <div class="container">
        <div class="footer__grid">
            <div class="footer__brand">
                <div class="footer__brand-top">
                    <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="footer__brand-logo" aria-label="{{ $companyName }}">
                        @if($logo)
                            <img src="{{ $logo }}" alt="{{ $companyName }}">
                        @else
                            <img src="{{ asset('images/gmac-logo.png') }}" alt="{{ $companyName }}">
                        @endif
                    </a>
                </div>
                <p class="footer__text">{{ $aboutShortFooter }}</p>
                <div class="footer__social" aria-label="Social links">
                    @if($fb)<a href="{{ $fb }}" class="footer__social-link" target="_blank" rel="noopener" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>@endif
                    @if($ig)<a href="{{ $ig }}" class="footer__social-link" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>@endif
                    @if($tw)<a href="{{ $tw }}" class="footer__social-link" target="_blank" rel="noopener" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>@endif
                    @if($li)<a href="{{ $li }}" class="footer__social-link" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>@endif
                </div>
            </div>

            <div class="footer__col">
                <h4 class="footer__h4 footer__h4--lined">Contact</h4>
                <div class="footer__meta">
                    <div class="footer__meta-row">
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <div>
                            <div class="footer__meta-value">{{ $addr }}</div>
                            @if($addr2)
                                <div class="footer__meta-value footer__meta-value--muted">{{ $addr2 }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="footer__meta-row">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <div>
                            <div class="footer__meta-value"><a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a></div>
                            @if($phone2)
                                <div class="footer__meta-value footer__meta-value--muted"><a href="tel:{{ preg_replace('/[^\d+]/', '', $phone2) }}">{{ $phone2 }}</a></div>
                            @endif
                        </div>
                    </div>
                    <div class="footer__meta-row">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <div class="footer__meta-value">
                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer__col">
                <h4 class="footer__h4 footer__h4--lined">Explore</h4>
                <ul class="footer__links-list">
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/')) }}" class="footer__link">{{ __('messages.home') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}" class="footer__link">{{ __('messages.history') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/shop')) }}" class="footer__link">{{ __('messages.nav_shop') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="footer__link">{{ __('messages.contact') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="footer__bottom">
            <div class="footer__bottom-inner">
                <p>&copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
                <div class="footer__bottom-links">
                    <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}">{{ __('messages.contact') }}</a>
                    <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}">{{ __('messages.history') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
