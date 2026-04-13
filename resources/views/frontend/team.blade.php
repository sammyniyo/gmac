@extends('layouts.frontend')

@section('title', 'Team - GMAC Coffee')
@section('meta_description', 'Meet the team behind GMAC Coffee.')

@section('content')
@php
    $founder = collect($team)->first();
    $otherMembers = collect($team)->slice(1);
@endphp

@include('partials.frontend.page-hero', [
    'title' => 'Our Team',
    'subtitle' => 'The people who shape our quality, farmer relationships, processing standards, and long-term vision.',
    'eyebrow' => 'GMAC Coffee',
])

<section class="team-page">
    <div class="container">
        <div class="team-intro fade-in">
            <div class="team-kicker">People &amp; Leadership</div>
            <h2 class="team-title">Our people in a <em>clearer, simpler view.</em></h2>
            <p class="team-copy">Meet the founder first. More staff can be added over time with direct contact details.</p>
        </div>

        @if($founder)
            <section class="team-founder fade-in">
                <div class="team-founder__media">
                    @if(!empty($founder['photo']))
                        <img src="{{ $founder['photo'] }}" alt="{{ $founder['name'] }}">
                    @else
                        <div class="team-photo-ph">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    @endif
                </div>
                <div class="team-founder__content">
                    <div class="team-kicker">Founder Spotlight</div>
                    <h2 class="team-founder__name">{{ $founder['name'] }}</h2>
                    <div class="team-role">{{ $founder['role'] }}</div>
                    <div class="team-founder__contact">
                        @if(!empty($founder['email']))
                            <a href="mailto:{{ $founder['email'] }}" class="team-contact-chip">
                                <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                                <span>{{ $founder['email'] }}</span>
                            </a>
                        @endif
                        @if(!empty($founder['phone']))
                            <a href="tel:{{ preg_replace('/[^\d+]/', '', $founder['phone']) }}" class="team-contact-chip">
                                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                <span>{{ $founder['phone'] }}</span>
                            </a>
                        @endif
                    </div>
                    <p class="team-bio">{{ $founder['bio'] }}</p>
                </div>
            </section>
        @endif

        @if($otherMembers->isNotEmpty())
            <div class="team-section-head fade-in">
                <div class="team-kicker team-kicker--small">Growing Team</div>
                <h3 class="team-section-title">More team members</h3>
            </div>

            <div class="team-grid fade-in">
                @foreach($otherMembers as $member)
                    <article class="team-card">
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
                        <div class="team-card__contact">
                            @if(!empty($member['email']))
                                <a href="mailto:{{ $member['email'] }}">{{ $member['email'] }}</a>
                            @endif
                            @if(!empty($member['phone']))
                                <a href="tel:{{ preg_replace('/[^\d+]/', '', $member['phone']) }}">{{ $member['phone'] }}</a>
                            @endif
                        </div>
                        @if(!empty($member['bio']))
                            <p class="team-bio">{{ $member['bio'] }}</p>
                        @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="team-coming fade-in">
                <div class="team-kicker team-kicker--small">Coming Soon</div>
                <p>More team members will be added here as GMAC continues to grow.</p>
            </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
<style>
    .team-page {
        padding: 3rem 0 5.5rem;
    }

    .team-intro {
        max-width: 820px;
        margin: 0 auto 2rem;
        text-align: center;
    }

    .team-kicker {
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

    .team-kicker--small {
        margin-bottom: 0.85rem;
    }

    .team-title {
        margin: 0 0 0.8rem;
        font-size: clamp(2.2rem, 4vw, 3.6rem);
        line-height: 1.06;
        color: var(--clr-deep-espresso);
    }

    .team-title em {
        font-style: italic;
        color: var(--clr-gold);
    }

    .team-copy {
        max-width: 60ch;
        margin: 0 auto;
        color: var(--clr-text-muted);
        line-height: 1.85;
        font-size: 1rem;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.2rem;
        margin-top: 0;
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

    .team-founder {
        display: grid;
        grid-template-columns: 360px minmax(0, 1fr);
        gap: 1.5rem;
        align-items: stretch;
        margin-bottom: 1.35rem;
        padding: 1.35rem;
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid rgba(13, 9, 7, 0.07);
        border-radius: 28px;
        box-shadow: var(--shadow-md);
    }

    .team-founder__media {
        overflow: hidden;
        border-radius: 22px;
        background: linear-gradient(135deg, var(--clr-bg-alt) 0%, var(--clr-bg-warm) 100%);
        min-height: 420px;
    }

    .team-founder__media img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .team-founder__content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 0.4rem 0.2rem;
    }

    .team-founder__name {
        margin: 0 0 0.45rem;
        font-size: clamp(2.2rem, 4vw, 3.2rem);
        line-height: 1.06;
        color: var(--clr-deep-espresso);
    }

    .team-founder__contact {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin: 0.4rem 0 0.9rem;
    }

    .team-contact-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 0.9rem;
        border-radius: 999px;
        background: rgba(201, 150, 63, 0.08);
        border: 1px solid rgba(201, 150, 63, 0.16);
        color: var(--clr-text-main);
        font-size: 0.82rem;
        font-weight: 600;
    }

    .team-contact-chip:hover {
        color: var(--clr-gold-hover);
        border-color: rgba(201, 150, 63, 0.3);
    }

    .team-section-head {
        margin: 0 0 1rem;
    }

    .team-section-title {
        margin: 0;
        font-size: 1.6rem;
        color: var(--clr-deep-espresso);
    }

    .team-coming {
        margin-top: 0.2rem;
        padding: 1.25rem 1.35rem;
        background: rgba(201, 150, 63, 0.08);
        border: 1px solid rgba(201, 150, 63, 0.16);
        border-radius: 22px;
    }

    .team-coming p {
        margin: 0;
        color: var(--clr-text-muted);
        line-height: 1.75;
    }

    .team-photo {
        height: 280px;
        background: linear-gradient(135deg, var(--clr-bg-alt) 0%, var(--clr-bg-warm) 100%);
        display: flex; align-items: center; justify-content: center;
    }
    .team-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .team-photo-ph { font-size: 2.5rem; color: rgba(201, 150, 63, 0.40); }

    .team-body { padding: 1.3rem 1.3rem 1.45rem; }
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
    .team-bio { color: var(--clr-text-subtle); margin: 0; font-size: 0.9rem; line-height: 1.75; }

    .team-card__contact {
        display: grid;
        gap: 0.35rem;
        margin-bottom: 0.75rem;
    }

    .team-card__contact a {
        color: var(--clr-gold-hover);
        font-size: 0.82rem;
        font-weight: 600;
        word-break: break-word;
    }

    [data-theme='dark'] .team-title,
    [data-theme='dark'] .team-founder__name,
    [data-theme='dark'] .team-section-title {
        color: var(--clr-text-light);
    }

    [data-theme='dark'] .team-copy,
    [data-theme='dark'] .team-bio,
    [data-theme='dark'] .team-coming p {
        color: rgba(246, 240, 230, 0.7);
    }

    [data-theme='dark'] .team-founder,
    [data-theme='dark'] .team-coming {
        background: rgba(246, 240, 230, 0.05);
        border-color: rgba(246, 240, 230, 0.1);
    }

    [data-theme='dark'] .team-contact-chip {
        color: var(--clr-text-light);
        background: rgba(201, 150, 63, 0.08);
        border-color: rgba(201, 150, 63, 0.18);
    }

    @media (max-width: 900px) {
        .team-founder {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .team-photo { height: 240px; }
    }
</style>
@endpush

