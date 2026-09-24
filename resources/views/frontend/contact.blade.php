@extends('layouts.frontend')

@section('title', 'Contact Us - GMAC Coffee')
@section('meta_description', 'Get in touch with GMAC Coffee for wholesale inquiries, partnership opportunities, or general coffee talk.')

@section('content')
@php
    $contactAddress = \App\Models\Setting::where('key', 'contact_address')->value('value') ?: 'KK 372 St, Kigali, Kicukiro, Rwanda';
    $contactPhone = \App\Models\Setting::where('key', 'contact_phone')->value('value') ?: '+250 783 053 415';
    $contactEmail = \App\Models\Setting::where('key', 'contact_email')->value('value') ?: 'info@gmac.coffee';
    $whatsApp = preg_replace('/\D+/', '', $contactPhone);
    $productInquiry = \Illuminate\Support\Str::limit(trim(strip_tags((string) request('product'))), 80, '');
    if ($productInquiry !== '' && preg_match('/https?:\/\/|www\./i', $productInquiry)) {
        $productInquiry = '';
    }
    $topics = $topics ?? \App\Http\Requests\ContactMessageRequest::TOPICS;
    $defaultSubject = old('subject', $productInquiry !== '' ? 'Retail bags' : 'Wholesale inquiry');
@endphp

@include('partials.frontend.page-hero', [
    'title' => __('messages.contact'),
    'subtitle' => 'Wholesale, samples, export, or a visit to origin — write to us and we will reply with a clear next step.',
    'eyebrow' => 'GMAC Coffee',
    'image' => \App\Support\FrontendShowcase::img('farm'),
])

<section class="ct-page">
    <div class="container">
        <div class="ct-layout">
            <aside class="ct-aside fade-in">
                <p class="ct-kicker">{{ __('messages.get_in_touch') }}</p>
                <h2 class="ct-title">Write to GMAC in Kigali.</h2>
                <p class="ct-lead">Wholesale, samples, export, or a visit to Karenge — send a short note and we reply from info@gmac.coffee.</p>

                <div class="ct-cards">
                    <a class="ct-card" href="https://maps.google.com/?q={{ urlencode($contactAddress) }}" target="_blank" rel="noopener noreferrer">
                        <span class="ct-card__icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
                        <span>
                            <strong>Visit</strong>
                            <em>{{ $contactAddress }}</em>
                        </span>
                    </a>
                    <a class="ct-card" href="mailto:{{ $contactEmail }}">
                        <span class="ct-card__icon" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
                        <span>
                            <strong>Email</strong>
                            <em>{{ $contactEmail }}</em>
                        </span>
                    </a>
                    <a class="ct-card" href="tel:{{ preg_replace('/\s+/', '', $contactPhone) }}">
                        <span class="ct-card__icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                        <span>
                            <strong>Phone</strong>
                            <em>{{ $contactPhone }}</em>
                        </span>
                    </a>
                    <div class="ct-card ct-card--static">
                        <span class="ct-card__icon" aria-hidden="true"><i class="fa-regular fa-clock"></i></span>
                        <span>
                            <strong>Office hours</strong>
                            <em>Monday – Friday, 08:00 – 17:00 CAT</em>
                        </span>
                    </div>
                </div>

                <div class="ct-aside__actions">
                    <a class="ct-wa" href="https://wa.me/{{ $whatsApp }}" target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                        Message on WhatsApp
                    </a>
                    <div class="ct-social">
                        <p>{{ __('messages.follow_us') }}</p>
                        <a href="{{ \App\Support\SiteLinks::instagram() }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i> Instagram</a>
                        <a href="{{ \App\Support\SiteLinks::facebook() }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i> Facebook</a>
                    </div>
                    <p class="ct-aside__note">Typical reply within one business day.</p>
                </div>
            </aside>

            <div class="ct-panel fade-in">
                <div class="ct-panel__head">
                    <p class="ct-kicker">Send a message</p>
                    <h2>Tell us what you need.</h2>
                    <p>Pick a topic, then write a short note. We reply by email — nothing is charged here.</p>
                </div>

                @if(session('success'))
                    <div class="ct-alert" role="status">
                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($productInquiry)
                    <p class="ct-product">About <strong>{{ $productInquiry }}</strong></p>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="ct-form" id="ct-form">
                    @csrf
                    <input type="hidden" name="form_started" value="{{ time() }}">
                    @if($productInquiry)
                        <input type="hidden" name="product" value="{{ $productInquiry }}">
                    @endif
                    <div class="ct-hp" aria-hidden="true">
                        <label for="website">Leave blank</label>
                        <input type="text" id="website" name="website" value="" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="ct-form__row">
                        <div class="ct-field">
                            <label for="name">{{ __('messages.name') }} *</label>
                            <input type="text" id="name" name="name" class="form-control" required maxlength="80" minlength="2" value="{{ old('name') }}" placeholder="Your name" autocomplete="name">
                            @error('name')<span class="ct-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="ct-field">
                            <label for="email">{{ __('messages.email') }} *</label>
                            <input type="email" id="email" name="email" class="form-control" required maxlength="120" value="{{ old('email') }}" placeholder="you@company.com" autocomplete="email">
                            @error('email')<span class="ct-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="ct-field">
                        <label for="subject">{{ __('messages.subject') }} *</label>
                        <select id="subject" name="subject" class="form-control" required>
                            @foreach($topics as $topic)
                                <option value="{{ $topic }}" {{ $defaultSubject === $topic ? 'selected' : '' }}>{{ $topic }}</option>
                            @endforeach
                        </select>
                        @error('subject')<span class="ct-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="ct-field">
                        <label for="message">{{ __('messages.message') }} *</label>
                        <textarea id="message" name="message" class="form-control" rows="6" required minlength="12" maxlength="2000" placeholder="Volume, process, destination, or the question you want answered.">{{ old('message') }}</textarea>
                        @error('message')<span class="ct-error">{{ $message }}</span>@enderror
                        @error('form_started')<span class="ct-error">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="ct-submit" id="ct-submit">
                        {{ __('messages.send_message') }}
                    </button>
                    <p class="ct-privacy">{{ __('messages.contact_privacy') }}</p>
                </form>
            </div>
        </div>

        <div class="ct-reasons fade-in">
            <article class="ct-reason">
                <i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i>
                <h3>Wholesale &amp; export</h3>
                <p>Share destination, preferred process, and volume. We will confirm available lots and shipping windows.</p>
            </article>
            <article class="ct-reason">
                <i class="fa-solid fa-flask" aria-hidden="true"></i>
                <h3>Samples</h3>
                <p>Ask for Karenge washed, honey, natural, or the women’s association lot — we send with cupping notes.</p>
            </article>
            <article class="ct-reason">
                <i class="fa-solid fa-mountain-sun" aria-hidden="true"></i>
                <h3>Visit origin</h3>
                <p>Buyers are welcome at the station in Rwamagana. Write ahead so we can plan receiving and a cupping table.</p>
            </article>
        </div>

        <div class="ct-map fade-in">
            <div class="ct-map__copy">
                <p class="ct-kicker">Find us</p>
                <h2>KK 372 St, Kigali.</h2>
                <p>Office in Kicukiro — meetings by appointment. The washing station is in Karenge Sector, Rwamagana District, about an hour from the city.</p>
            </div>
            <div class="map-shell">
                <iframe src="https://maps.google.com/maps?q=KK+372+St,+Kicukiro,+Kigali,+Rwanda&z=16&output=embed" width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy" title="GMAC Coffee office, KK 372 St, Kigali"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>
.ct-page { padding: 2.5rem 0 5rem; background: #f5f3f0; }

.ct-layout {
    display: grid;
    grid-template-columns: minmax(0, 0.92fr) minmax(0, 1.08fr);
    gap: 2rem;
    align-items: start;
}

.ct-kicker {
    margin: 0 0 0.5rem;
    color: #7a6452;
    font-size: 0.8rem;
    font-weight: 600;
}

.ct-title,
.ct-panel__head h2,
.ct-map__copy h2 {
    margin: 0 0 0.7rem;
    font-size: clamp(1.7rem, 3vw, 2.15rem);
    font-weight: 600;
    line-height: 1.2;
    color: #2a1c14;
}

.ct-lead,
.ct-panel__head p,
.ct-map__copy p,
.ct-reason p {
    margin: 0;
    color: #6b5344;
    line-height: 1.7;
}

.ct-lead { max-width: 46ch; margin-bottom: 1.4rem; }

.ct-cards { display: grid; gap: 0.65rem; }
.ct-card {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    padding: 0.95rem 1.05rem;
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 16px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 10px 28px rgba(42, 28, 20, 0.04);
    transition: transform .22s ease, box-shadow .22s ease;
}
.ct-card:hover { transform: translateY(-2px); box-shadow: 0 16px 36px rgba(42, 28, 20, 0.08); }
.ct-card--static { cursor: default; }
.ct-card__icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #efe8df;
    color: #7a6452;
    flex-shrink: 0;
}
.ct-card strong { display: block; font-size: 0.78rem; color: #7d736a; font-weight: 600; }
.ct-card em { display: block; margin-top: 0.12rem; font-style: normal; color: #2a1c14; font-size: 0.95rem; font-weight: 500; }

.ct-aside__actions { margin-top: 1.25rem; }
.ct-wa {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    min-height: 46px;
    padding: 0 1.15rem;
    border-radius: 999px;
    background: #7a6452;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
}
.ct-wa:hover { background: #7a6452; color: #fff; }
.ct-social { margin-top: 1rem; }
.ct-social p { margin: 0 0 0.45rem; font-size: 0.75rem; font-weight: 600; color: #7d736a; }
.ct-social a {
    display: inline-flex; align-items: center; gap: 0.4rem; margin-right: 0.7rem;
    color: #5c4a3c; font-size: 0.86rem; font-weight: 500; text-decoration: none;
}
.ct-aside__note { margin: 0.7rem 0 0; color: #7d736a; font-size: 0.82rem; }

.ct-panel {
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 22px;
    padding: 1.7rem 1.7rem 1.8rem;
    box-shadow: 0 16px 44px rgba(42, 28, 20, 0.06);
}
.ct-panel__head { margin-bottom: 1.15rem; }
.ct-panel__head h2 { font-size: 1.55rem; }
.ct-panel__head p { margin-top: 0.4rem; }

.ct-alert {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1rem;
    padding: 0.85rem 1rem;
    border-radius: 12px;
    background: #efe8df;
    color: #3d2918;
    font-size: 0.9rem;
}

.ct-product {
    margin: 0 0 1rem;
    padding: 0.65rem 0.85rem;
    border-radius: 12px;
    background: #efe8df;
    color: #5c4a3c;
    font-size: 0.86rem;
}
.ct-product strong { color: #2a1c14; font-weight: 600; }
.ct-hp {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}
.ct-form {
    position: relative;
    display: grid;
    gap: 1.05rem;
    background: transparent;
    border: 0;
    box-shadow: none;
}
.ct-form select.form-control {
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    background-color: #fff !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%237a6452' d='M1 1.5l5 5 5-5'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 1rem center !important;
    padding-right: 2.4rem;
}

.ct-form__row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.ct-field label {
    display: block;
    margin-bottom: 0.4rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: #3f3731;
}
.ct-field .form-control {
    width: 100%;
    min-height: 46px;
    padding: 0.7rem 0.9rem;
}
.ct-field textarea.form-control { min-height: 140px; resize: vertical; }
.ct-error { display: block; margin-top: 0.35rem; color: #9a3b2f; font-size: 0.78rem; }

.ct-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    min-height: 48px;
    padding: 0 1.3rem;
    border: 0;
    border-radius: 999px;
    background: #7a6452;
    color: #fff;
    font: 500 0.92rem/1 Poppins, sans-serif;
    cursor: pointer;
    width: 100%;
}
.ct-submit:hover { background: #8d7560; }
.ct-submit:disabled { opacity: 0.7; cursor: wait; }
.ct-privacy { margin: 0; text-align: center; color: #8a8178; font-size: 0.78rem; }

.ct-reasons {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    margin: 2.25rem 0;
}
.ct-reason {
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 18px;
    padding: 1.3rem 1.25rem 1.4rem;
}
.ct-reason i { color: #b89a6a; margin-bottom: 0.7rem; display: block; }
.ct-reason h3 { margin: 0 0 0.4rem; font-size: 1.05rem; color: #2a1c14; }

.ct-map {
    display: grid;
    grid-template-columns: minmax(0, 0.7fr) minmax(0, 1.3fr);
    gap: 1.5rem;
    align-items: center;
}
.ct-map__copy { max-width: 36ch; }
.map-shell {
    overflow: hidden;
    border-radius: 22px;
    border: 1px solid #e7e2db;
    background: #fff;
    min-height: 320px;
    box-shadow: 0 12px 36px rgba(42, 28, 20, 0.05);
}
.map-shell iframe { display: block; width: 100%; height: 100%; min-height: 340px; }

@media (max-width: 900px) {
    .ct-layout,
    .ct-form__row,
    .ct-reasons,
    .ct-map { grid-template-columns: 1fr; }
    .ct-panel { padding: 1.25rem 1.1rem 1.4rem; }
    .ct-page { padding: 1.5rem 0 3.5rem; }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('ct-form');
    var submit = document.getElementById('ct-submit');
    if (form && submit) {
        form.addEventListener('submit', function () {
            submit.disabled = true;
        });
    }
});
</script>
@endpush
