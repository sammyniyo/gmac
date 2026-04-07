@extends('layouts.frontend')

@section('title', 'Team - GMAC Coffee')
@section('meta_description', 'Meet the team behind GMAC Coffee.')

@section('content')
<section class="page-hero fade-in">
    <div class="container">
        <div class="page-hero-card">
            <div class="page-hero-kicker">GMAC Coffee</div>
            <h1 class="page-hero-title">Our Team</h1>
            <p class="page-hero-subtitle">The people behind our quality and sustainability.</p>
        </div>
    </div>
</section>

<section class="container py-6">
    <div class="team-grid fade-in">
        @foreach($team as $member)
            <div class="team-card">
                <div class="team-photo">
                    @if(!empty($member['photo']))
                        <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}">
                    @else
                        <div class="team-photo-ph">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    @endif
                </div>
                <div class="team-body">
                    <div class="team-role">{{ $member['role'] }}</div>
                    <h3 class="team-name">{{ $member['name'] }}</h3>
                    <p class="team-bio">{{ $member['bio'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="team-cta fade-in">
        <div class="team-cta-card">
            <div>
                <h2 class="team-cta-title">Want to work with us?</h2>
                <p class="team-cta-sub">Contact us for partnerships, wholesale, and community projects.</p>
            </div>
            <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="btn btn-primary">{{ __('messages.contact') }}</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>
    .team-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-top: 10px;
    }
    @media (max-width: 980px) { .team-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 640px) { .team-grid { grid-template-columns: 1fr; } }

    .team-card {
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(13, 9, 7, 0.07);
        border-radius: var(--radius-card);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform 0.28s, box-shadow 0.28s, border-color 0.28s;
    }
    .team-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(201, 150, 63, 0.20);
    }
    [data-theme="dark"] .team-card {
        background: rgba(246, 240, 230, 0.05);
        border-color: rgba(246, 240, 230, 0.10);
    }

    .team-photo {
        height: 220px;
        background: linear-gradient(135deg, var(--clr-bg-alt) 0%, var(--clr-bg-warm) 100%);
        display: flex; align-items: center; justify-content: center;
    }
    .team-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .team-photo-ph { font-size: 2.5rem; color: rgba(201, 150, 63, 0.40); }

    .team-body { padding: 18px 18px 22px; }
    .team-role {
        display: inline-flex;
        padding: 5px 12px;
        border-radius: 999px;
        background: rgba(201, 150, 63, 0.12);
        border: 1px solid rgba(201, 150, 63, 0.22);
        color: var(--clr-gold);
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    [data-theme="dark"] .team-role { color: var(--clr-gold-light); }
    .team-name { margin: 0 0 8px; font-size: 1.3rem; }
    .team-bio { color: var(--clr-text-subtle); margin: 0; font-size: 0.88rem; }

    .team-cta { margin-top: 3rem; }
    .team-cta-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        background: linear-gradient(135deg, rgba(201, 150, 63, 0.10) 0%, rgba(13, 9, 7, 0.04) 100%);
        border: 1px solid rgba(201, 150, 63, 0.22);
        border-radius: 24px;
        padding: 2rem 2.25rem;
    }
    [data-theme="dark"] .team-cta-card {
        background: rgba(201, 150, 63, 0.08);
        border-color: rgba(201, 150, 63, 0.16);
    }
    .team-cta-title { margin: 0 0 6px; font-size: 1.6rem; }
    .team-cta-sub { margin: 0; color: var(--clr-text-muted); }
    @media (max-width: 640px) { .team-cta-card { flex-direction: column; align-items: flex-start; } }
</style>
@endpush

