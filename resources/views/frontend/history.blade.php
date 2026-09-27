@extends('layouts.frontend')

@section('title', 'Our History - GMAC Coffee')
@section('meta_description', 'Learn about the rich history of GMAC Coffee, our mission, vision, and dedication to Rwandan coffee excellence.')

@section('content')
@php
    $founderImage = \App\Support\FrontendShowcase::img('team_jeanne');
    $historyStats = [
        ['value' => '2012', 'label' => 'Incorporated'],
        ['value' => '1,200', 'label' => 'Partner farmers'],
        ['value' => '$800k', 'label' => 'Annual turnover'],
        ['value' => '90%', 'label' => 'Seasonal team women'],
    ];

    $milestones = [
        ['year' => '2012', 'text' => 'Niyonsaba Jeanne incorporates Green Mountain Arabica Coffee Ltd and begins by buying and exporting lower coffee grades.'],
        ['year' => '2017', 'text' => 'With accumulated profit she buys the washing station in Karenge Sector, Rwamagana District, together with 12,000 mature coffee trees. Rukaka Steven becomes Managing Director; Jeanne remains Chairperson of the Board.'],
        ['year' => 'Today', 'text' => 'About 1,200 Rainforest Alliance-certified farmers — including 156 women Jeanne funded as an association, plus a youth group — and a second station at Gasange in Gatsibo.'],
    ];

    $values = ['Integrity', 'Quality', 'Sustainability', 'Team Work', 'Risk Taking', 'Innovation', 'Accountability'];
@endphp

@include('partials.frontend.page-hero', [
    'title' => __('messages.history'),
    'subtitle' => 'Green Mountain Arabica Coffee Ltd — founded in 2012 by Niyonsaba Jeanne, from low-grade exports to origin stations.',
    'eyebrow' => 'GMAC Coffee',
    'image' => \App\Support\FrontendShowcase::img('farm'),
])

<section class="history-page">
    <div class="container">
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
                <h3 class="history-card__title">From low-grade exports to a station of our own.</h3>
                <div class="history-founder">
                    <div class="history-founder__media">
                        <img src="{{ $founderImage }}" alt="Niyonsaba Jeanne, founder of GMAC Coffee">
                        <div class="history-founder__caption">
                            <strong>Niyonsaba Jeanne</strong>
                            <span>Founder and Chairperson of the Board</span>
                        </div>
                    </div>
                    <div class="history-founder__story">
                        <p class="history-founder__lead">Green Mountain Arabica Coffee Ltd was incorporated in 2012 by Niyonsaba Jeanne. At the start the company bought and exported lower grades of coffee.</p>
                        <p>Jeanne’s aim was to build her own washing station and plantation — and to grow a company that could support women farmers. She had seen women work the hardest on the farms while the profit went to their husbands.</p>
                    </div>
                </div>
                <div class="history-richtext">
                    <p>That first achievement came in <strong>2017</strong>. With accumulated profit she bought the washing station in <strong>Karenge Sector, Rwamagana District</strong>, Eastern Province, together with the <strong>12,000 mature coffee trees</strong> around it. GMAC stopped only trading coffee and started processing it.</p>
                    <p>To strengthen management she brought her husband, <strong>Rukaka Steven</strong>, in as Managing Director. Jeanne stayed Chairperson of the Board. Together they grew the partner base to about <strong>1,200 Rainforest Alliance-certified farmers</strong>.</p>
                    <p>Those farmers include an association of <strong>156 women</strong> that Jeanne funded, and a <strong>youth association</strong> funded so a younger generation would stay in coffee — because many young people do not see farming the way their parents did. GMAC now also works from <strong>Gasange</strong> in Gatsibo District, alongside Karenge.</p>
                    <p class="history-md">Rukaka Steven — Managing Director. Jeanne remains Chairperson of the Board of Directors.</p>
                </div>
            </article>

            <div class="history-stack">
                <article class="history-card fade-in">
                    <div class="history-card__eyebrow">Milestones</div>
                    <h3 class="history-card__title">The years that changed the company.</h3>
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
                            <p>To produce for the market a traceable high-quality coffee.</p>
                        </div>
                        <div class="history-pillar">
                            <span>Mission</span>
                            <p>Becoming efficient in the full coffee value chain up to the multinational.</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <div class="history-bottom">
            <article class="history-card fade-in">
                <div class="history-card__eyebrow">Impact</div>
                <h3 class="history-card__title">What GMAC looks like today.</h3>
                <p class="history-copy history-copy--left">The company turns over about <strong>800,000 USD</strong>, with <strong>12 permanent staff</strong> and <strong>250 casual workers</strong>, of whom <strong>90% are women</strong>. We produce fully washed coffee and specialty lots — <strong>honey</strong>, <strong>natural</strong>, and <strong>anaerobic</strong>.</p>
            </article>

            <article class="history-card fade-in">
                <div class="history-card__eyebrow">Values</div>
                <h3 class="history-card__title">How the company works.</h3>
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
        max-width: 720px;
        margin: 0 0 2rem;
        text-align: left;
    }

    .history-kicker,
    .history-card__eyebrow {
        display: block;
        padding: 0;
        border: 0;
        background: none;
        color: #9a7d4e;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.04em;
        text-transform: none;
    }

    .history-kicker {
        margin-bottom: 1rem;
    }

    .history-title {
        margin: 0 0 0.7rem;
        font-size: clamp(1.7rem, 3vw, 2.2rem);
        line-height: 1.2;
        color: #2a1c14;
    }

    .history-title em {
        font-style: normal;
        color: #7a6452;
    }

    .history-copy {
        max-width: 58ch;
        margin: 0;
        font-size: 0.98rem;
        line-height: 1.75;
        color: #6b5344;
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
    .history-md {
        padding-top: 0.35rem;
        font-size: 0.92rem;
        color: #5c4a3c !important;
        font-weight: 600;
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
        object-fit: contain;
        object-position: center;
        background: #f5f3f0;
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
