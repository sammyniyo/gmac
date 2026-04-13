@extends('layouts.frontend')

@section('title', 'Our History - GMAC Coffee')
@section('meta_description', 'Learn about the rich history of GMAC Coffee, our mission, vision, and dedication to Rwandan coffee excellence.')

@section('content')
@php
    $founderImage = asset('images/Jeanne.png');
    $historyStats = [
        ['value' => '2012', 'label' => 'Founded'],
        ['value' => '1,200+', 'label' => 'Partner farmers'],
        ['value' => '90%', 'label' => 'Seasonal team women'],
        ['value' => '4', 'label' => 'Processing profiles'],
    ];

    $milestones = [
        ['year' => '2012', 'text' => 'GMAC was founded by Niyonsaba Jeanne with a clear aim to build a traceable, higher-value coffee business.'],
        ['year' => '2017', 'text' => 'The company acquired a washing station in Karenge, Rwamagana, together with 12,000 mature coffee trees.'],
        ['year' => 'Today', 'text' => 'GMAC supports more than 1,200 farmers and produces washed, honey, natural, and anaerobic coffees.'],
    ];

    $values = ['Integrity', 'Quality', 'Sustainability', 'Teamwork', 'Risk Taking', 'Innovation', 'Accountability'];
@endphp

@include('partials.frontend.page-hero', [
    'title' => __('messages.history'),
    'subtitle' => 'The story behind our quality, our people, and our long-term commitment to Rwandan coffee.',
    'eyebrow' => 'GMAC Coffee',
])

<section class="history-page">
    <div class="container">
        <div class="history-intro fade-in">
            <div class="history-kicker">{{ __('messages.our_legacy') }}</div>
            <h2 class="history-title">A founder-led story of ambition, resilience, and <em>better coffee from origin.</em></h2>
            <p class="history-copy">GMAC Coffee did not begin as a polished brand. It began as a determined effort to build something more valuable for farmers, more traceable for buyers, and more meaningful for Rwanda’s coffee future.</p>
        </div>

        <div class="history-stats fade-in">
            @foreach($historyStats as $stat)
                <div class="history-stat">
                    <div class="history-stat__value">{{ $stat['value'] }}</div>
                    <div class="history-stat__label">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="history-grid">
            <article class="history-card history-card--story fade-in">
                <div class="history-card__eyebrow">Our story</div>
                <h3 class="history-card__title">From one vision to a growing coffee platform.</h3>
                <div class="history-founder">
                    <div class="history-founder__media">
                        <img src="{{ $founderImage }}" alt="Founder Jeanne of GMAC Coffee">
                        <div class="history-founder__caption">
                            <strong>Niyonsaba Jeanne</strong>
                            <span>Founder and Chairperson</span>
                        </div>
                    </div>
                    <div class="history-founder__story">
                        <p class="history-founder__lead">In 2012, Jeanne started GMAC with a simple but powerful belief: coffee from Rwanda could create more value when quality, traceability, and producer impact were taken seriously from the beginning.</p>
                        <p>At first, the company exported low-grade coffee. But even then, the goal was never to stay small or ordinary. The deeper ambition was to own processing infrastructure, invest in plantations, and create a business that could grow with farmers rather than around them.</p>
                    </div>
                </div>
                <div class="history-richtext">
                    <p>The turning point came in 2017, when GMAC purchased a washing station in <strong>Karenge Sector, Rwamagana District</strong>, together with <strong>12,000 mature coffee trees</strong>. That step changed the story from trading coffee to truly shaping it, giving the company more control over processing, consistency, and long-term quality.</p>
                    <p>As the company grew, <strong>Rukaka Steven</strong> joined as Managing Director while Jeanne continued as Chairperson of the Board. Their leadership helped GMAC move beyond transactions and into stronger systems, deeper farmer relationships, and a more ambitious specialty coffee future.</p>
                    <p>Today GMAC works with around <strong>1,200 Rainforest Alliance-certified farmers</strong>, including an association of <strong>156 women farmers</strong> and youth-focused producer groups that encourage the next generation to stay engaged in coffee. What started as one founder’s determination is now a broader story of quality, opportunity, and shared progress.</p>
                </div>
            </article>

            <div class="history-stack">
                <article class="history-card fade-in">
                    <div class="history-card__eyebrow">Milestones</div>
                    <h3 class="history-card__title">Key moments in our journey.</h3>
                    <div class="history-timeline">
                        @foreach($milestones as $milestone)
                            <div class="history-timeline__item">
                                <div class="history-timeline__year">{{ $milestone['year'] }}</div>
                                <p>{{ $milestone['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="history-card fade-in">
                    <div class="history-card__eyebrow">Mission &amp; vision</div>
                    <div class="history-pillars">
                        <div class="history-pillar">
                            <span>Vision</span>
                            <p>To produce for the market a traceable, high-quality coffee.</p>
                        </div>
                        <div class="history-pillar">
                            <span>Mission</span>
                            <p>To become efficient across the full coffee value chain, from farm to multinational markets.</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <div class="history-bottom">
            <article class="history-card fade-in">
                <div class="history-card__eyebrow">Impact</div>
                <h3 class="history-card__title">What GMAC looks like today.</h3>
                <p class="history-copy history-copy--left">GMAC now generates about <strong>$800,000 USD</strong> in turnover, with <strong>12 permanent staff</strong> and around <strong>250 seasonal workers</strong>, most of them women. We produce fully washed lots alongside <strong>Honey</strong>, <strong>Natural</strong>, and <strong>Anaerobic</strong> coffees for quality-driven markets.</p>
            </article>

            <article class="history-card fade-in">
                <div class="history-card__eyebrow">Values</div>
                <h3 class="history-card__title">The principles behind our growth.</h3>
                <div class="history-values">
                    @foreach($values as $value)
                        <span class="history-value">{{ $value }}</span>
                    @endforeach
                </div>
            </article>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<style>
    .history-page {
        padding: 3rem 0 5.5rem;
    }

    .history-intro {
        max-width: 860px;
        margin: 0 auto 2rem;
        text-align: center;
    }

    .history-kicker,
    .history-card__eyebrow {
        display: inline-flex;
        align-items: center;
        padding: 0.45rem 0.9rem;
        border-radius: 999px;
        background: rgba(201, 150, 63, 0.1);
        border: 1px solid rgba(201, 150, 63, 0.16);
        color: var(--clr-gold-hover);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
    }

    .history-kicker {
        margin-bottom: 1rem;
    }

    .history-title {
        margin: 0 0 0.9rem;
        font-size: clamp(2.25rem, 4vw, 3.7rem);
        line-height: 1.06;
        color: var(--clr-deep-espresso);
    }

    .history-title em {
        font-style: italic;
        color: var(--clr-gold);
    }

    .history-copy {
        max-width: 62ch;
        margin: 0 auto;
        font-size: 1rem;
        line-height: 1.85;
        color: var(--clr-text-muted);
    }

    .history-copy--left {
        margin: 0;
        max-width: none;
    }

    .history-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin: 0 0 2rem;
    }

    .history-stat,
    .history-card {
        background: rgba(255, 255, 255, 0.84);
        border: 1px solid rgba(13, 9, 7, 0.07);
        border-radius: 26px;
        box-shadow: var(--shadow-sm);
    }

    .history-stat {
        padding: 1.35rem 1.2rem;
        text-align: center;
    }

    .history-stat__value {
        font-family: var(--font-heading);
        font-size: clamp(1.9rem, 3vw, 2.5rem);
        color: var(--clr-deep-espresso);
        line-height: 1;
    }

    .history-stat__label {
        margin-top: 0.45rem;
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--clr-text-muted);
    }

    .history-grid,
    .history-bottom {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(0, 1fr);
        gap: 1.4rem;
    }

    .history-bottom {
        margin-top: 1.4rem;
    }

    .history-stack {
        display: grid;
        gap: 1.4rem;
    }

    .history-card {
        padding: 1.9rem;
    }

    .history-card__eyebrow {
        margin-bottom: 1rem;
    }

    .history-card__title {
        margin: 0 0 1rem;
        font-size: 1.8rem;
        line-height: 1.12;
    }

    .history-richtext p {
        margin: 0 0 1rem;
        color: var(--clr-text-muted);
        line-height: 1.85;
    }

    .history-founder {
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        gap: 1.5rem;
        align-items: start;
        margin: 0 0 1.35rem;
    }

    .history-founder__media {
        background: rgba(201, 150, 63, 0.06);
        border: 1px solid rgba(201, 150, 63, 0.14);
        border-radius: 22px;
        overflow: hidden;
    }

    .history-founder__media img {
        display: block;
        width: 100%;
        aspect-ratio: 4 / 5;
        object-fit: cover;
    }

    .history-founder__caption {
        padding: 0.95rem 1rem 1rem;
        display: grid;
        gap: 0.2rem;
        background: rgba(255, 255, 255, 0.7);
    }

    .history-founder__caption strong {
        color: var(--clr-deep-espresso);
        font-size: 1rem;
    }

    .history-founder__caption span {
        color: var(--clr-text-muted);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-weight: 700;
    }

    .history-founder__story {
        padding-top: 0.2rem;
    }

    .history-founder__lead {
        margin: 0 0 1rem;
        font-family: var(--font-heading);
        font-size: 1.35rem;
        line-height: 1.55;
        color: var(--clr-deep-espresso);
    }

    .history-founder__story p {
        margin: 0 0 1rem;
        color: var(--clr-text-muted);
        line-height: 1.85;
    }

    .history-timeline {
        display: grid;
        gap: 0.85rem;
    }

    .history-timeline__item,
    .history-pillar {
        padding: 1rem 1.05rem;
        border-radius: 16px;
        background: rgba(201, 150, 63, 0.06);
        border: 1px solid rgba(201, 150, 63, 0.14);
    }

    .history-timeline__year,
    .history-pillar span {
        display: inline-block;
        margin-bottom: 0.35rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--clr-gold-hover);
    }

    .history-timeline__item p,
    .history-pillar p {
        margin: 0;
        color: var(--clr-text-muted);
        line-height: 1.7;
    }

    .history-pillars,
    .history-values {
        display: grid;
        gap: 0.85rem;
    }

    .history-values {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .history-value {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 52px;
        padding: 0.9rem 1rem;
        text-align: center;
        border-radius: 16px;
        background: rgba(201, 150, 63, 0.06);
        border: 1px solid rgba(201, 150, 63, 0.14);
        color: var(--clr-text-main);
        font-size: 0.88rem;
        font-weight: 700;
    }

    [data-theme="dark"] .history-stat,
    [data-theme="dark"] .history-card {
        background: rgba(246, 240, 230, 0.05);
        border-color: rgba(246, 240, 230, 0.1);
    }

    [data-theme="dark"] .history-title,
    [data-theme="dark"] .history-card__title,
    [data-theme="dark"] .history-stat__value,
    [data-theme="dark"] .history-value {
        color: var(--clr-text-light);
    }

    [data-theme="dark"] .history-copy,
    [data-theme="dark"] .history-founder__caption span,
    [data-theme="dark"] .history-founder__story p,
    [data-theme="dark"] .history-richtext p,
    [data-theme="dark"] .history-timeline__item p,
    [data-theme="dark"] .history-pillar p,
    [data-theme="dark"] .history-stat__label {
        color: rgba(246, 240, 230, 0.7);
    }

    [data-theme="dark"] .history-founder__caption {
        background: rgba(246, 240, 230, 0.04);
    }

    [data-theme="dark"] .history-founder__media {
        background: rgba(246, 240, 230, 0.04);
        border-color: rgba(246, 240, 230, 0.1);
    }

    [data-theme="dark"] .history-founder__caption strong,
    [data-theme="dark"] .history-founder__lead {
        color: var(--clr-text-light);
    }

    @media (max-width: 1024px) {
        .history-stats,
        .history-grid,
        .history-bottom {
            grid-template-columns: 1fr 1fr;
        }

        .history-grid > .history-card--story {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 900px) {
        .history-stats,
        .history-grid,
        .history-bottom,
        .history-values {
            grid-template-columns: 1fr;
        }

        .history-founder {
            grid-template-columns: 1fr;
        }

        .history-card,
        .history-stat {
            padding: 1.4rem;
        }
    }
</style>
@endpush
