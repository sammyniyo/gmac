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
        background: rgba(255,255,255,0.82);
        border: 1px solid rgba(10, 26, 18, 0.08);
        border-radius: var(--radius-card);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .team-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
    [data-theme="dark"] .team-card { background: rgba(246,251,248,0.06); border-color: rgba(246,251,248,0.10); }

    .team-photo { height: 200px; background: rgba(10,26,18,0.06); display:flex; align-items:center; justify-content:center; }
    .team-photo img { width: 100%; height: 100%; object-fit: cover; display:block; }
    .team-photo-ph { font-size: 2.2rem; color: rgba(31,157,106,0.9); }

    .team-body { padding: 16px 16px 18px; }
    .team-role {
        display:inline-flex;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(31,157,106,0.16);
        color: rgba(10,26,18,0.86);
        font-weight: 700;
        font-size: .82rem;
        margin-bottom: 10px;
    }
    [data-theme="dark"] .team-role { color: rgba(246,251,248,0.90); }
    .team-name { margin: 0 0 8px; font-size: 1.35rem; }
    .team-bio { color: var(--clr-text-muted); margin: 0; }

    .team-cta { margin-top: 26px; }
    .team-cta-card {
        display:flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        background: rgba(31,157,106,0.12);
        border: 1px solid rgba(31,157,106,0.20);
        border-radius: 24px;
        padding: 18px 18px;
    }
    [data-theme="dark"] .team-cta-card {
        background: rgba(31,157,106,0.10);
        border-color: rgba(31,157,106,0.18);
    }
    .team-cta-title { margin: 0 0 6px; font-size: 1.6rem; }
    .team-cta-sub { margin: 0; color: var(--clr-text-muted); }
    @media (max-width: 640px) { .team-cta-card { flex-direction: column; align-items: flex-start; } }
</style>
@endpush

