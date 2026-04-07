@extends('layouts.frontend')

@section('title', 'Our History - GMAC Coffee')
@section('meta_description', 'Learn about the rich history of GMAC Coffee, our mission, vision, and dedication to Rwandan coffee excellence.')

@section('content')
<section class="page-hero fade-in">
    <div class="container">
        <div class="page-hero-card">
            <div class="page-hero-kicker">GMAC Coffee</div>
            <h1 class="page-hero-title">{{ __('messages.history') }}</h1>
            <p class="page-hero-subtitle">{{ __('messages.slogan') }}</p>
        </div>
    </div>
</section>

<div class="container py-6">
    <div class="history-content fade-in">
        <div class="history-text">
            <h2 class="section-title text-center mb-2">{{ __('messages.our_legacy') }}</h2>
            <div class="title-separator mb-4"></div>
            
            <p class="lead-text text-center mx-auto mb-4" style="max-width: 800px; font-size: 1.2rem; color: var(--clr-text-muted);">
                Green Mountain Arabica Coffee Ltd (GMAC) was founded in 2012 with a clear ambition: to build a traceable, high‑quality coffee business that creates value for farmers—especially women—across Rwanda.
            </p>
            
            <div class="history-split mt-4">
                <div class="history-story card">
                    <h3 class="history-h3"><i class="fa-solid fa-seedling text-gold mr-2" aria-hidden="true"></i> Our story</h3>
                    <div class="history-story__body">
                        <p>
                            GMAC was incorporated in 2012 by a young entrepreneur, <strong>Niyonsaba Jeanne</strong>. At the time, the company exported low‑grade coffee—an honest starting point, but not Jeanne’s end goal.
                        </p>
                        <p>
                            Her inspiration was to work toward owning a washing station and building a coffee plantation, while helping women farmers—who often do the hardest work on the farms—share more fairly in the benefits.
                        </p>
                        <p>
                            In 2017, Jeanne reached a major milestone: with accumulated profits, she purchased a <strong>coffee washing station</strong> in Rwanda’s Eastern Province, <strong>Rwamagana District, Karenge Sector</strong>.
                            The station was surrounded by <strong>12,000 mature coffee trees</strong>, acquired together with the washing station.
                        </p>
                        <p>
                            As the business grew, Jeanne strengthened the management team by bringing in her husband. <strong>Rukaka Steven</strong> became the Managing Director, while Jeanne continued as Chairperson of the Board of Directors.
                        </p>
                        <p>
                            Together, they expanded farmer partnerships to around <strong>1,200 Rainforest Alliance‑certified farmers</strong>, including:
                        </p>
                        <ul class="history-list">
                            <li>An association of <strong>156 women coffee farmers</strong>, funded to support women farmers</li>
                            <li>An association of <strong>young farmers</strong>, supported to inspire the next generation in coffee farming</li>
                        </ul>
                        <p>
                            Today, GMAC generates a turnover of approximately <strong>$800,000 USD</strong>, with a team of <strong>12 permanent staff</strong> and around <strong>250 seasonal workers</strong>—about <strong>90% women</strong>.
                            We produce fully washed coffees and specialty processes including <strong>Honey</strong>, <strong>Natural</strong>, and <strong>Anaerobic</strong> coffees.
                        </p>
                    </div>
                </div>

                <div class="history-side">
                    <div class="history-timeline card">
                        <h3 class="history-h3"><i class="fa-solid fa-clock text-gold mr-2" aria-hidden="true"></i> Key milestones</h3>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-year">2012</div>
                                <div class="timeline-body">GMAC incorporated by Niyonsaba Jeanne; exporting coffee begins.</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-year">2017</div>
                                <div class="timeline-body">Purchase of Karenge coffee washing station and 12,000 mature coffee trees.</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-year">Today</div>
                                <div class="timeline-body">1,200+ farmer partners, women/youth associations supported, specialty processing expanded.</div>
                            </div>
                        </div>
                    </div>

                    <div class="history-pillars card">
                        <h3 class="history-h3"><i class="fa-solid fa-bullseye text-gold mr-2" aria-hidden="true"></i> Vision & Mission</h3>
                        <div class="pillars">
                            <div class="pillar">
                                <div class="pillar-kicker">Vision</div>
                                <div class="pillar-text">To produce for the market a traceable, high‑quality coffee.</div>
                            </div>
                            <div class="pillar">
                                <div class="pillar-kicker">Mission</div>
                                <div class="pillar-text">Becoming efficient across the full coffee value chain—from farm to multinational markets.</div>
                            </div>
                        </div>
                    </div>

                    <div class="history-values card">
                        <h3 class="history-h3"><i class="fa-solid fa-certificate text-gold mr-2" aria-hidden="true"></i> Values</h3>
                        <ul class="values-list">
                            <li>Integrity</li>
                            <li>Quality</li>
                            <li>Sustainability</li>
                            <li>Teamwork</li>
                            <li>Risk Taking</li>
                            <li>Innovation</li>
                            <li>Accountability</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .text-gold {
        color: var(--clr-gold);
    }
    
    .mr-2 {
        margin-right: 0.5rem;
    }

    .history-split {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(0, 1fr);
        gap: 2rem;
        align-items: start;
    }

    .history-story.card,
    .history-timeline.card,
    .history-pillars.card,
    .history-values.card {
        padding: 2.25rem;
        border-top: 3px solid var(--clr-gold);
    }

    [data-theme="dark"] .history-story.card,
    [data-theme="dark"] .history-timeline.card,
    [data-theme="dark"] .history-pillars.card,
    [data-theme="dark"] .history-values.card {
        border-top-color: var(--clr-gold-light);
    }

    .history-h3 {
        margin: 0 0 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .history-story__body p {
        margin: 0 0 1rem;
        color: var(--clr-text-muted);
    }

    [data-theme="dark"] .history-story__body p {
        color: rgba(220, 200, 180, 0.85);
    }

    .history-list {
        margin: 0.25rem 0 1rem;
        padding-left: 1.1rem;
        color: var(--clr-text-muted);
        display: grid;
        gap: 0.5rem;
    }

    [data-theme="dark"] .history-list {
        color: rgba(220, 200, 180, 0.85);
    }

    .history-side {
        display: grid;
        gap: 1.5rem;
    }

    .timeline {
        display: grid;
        gap: 0.95rem;
        position: relative;
        padding-left: 0.5rem;
    }

    .timeline-item {
        display: grid;
        grid-template-columns: 72px 1fr;
        gap: 0.9rem;
        align-items: start;
        padding: 0.85rem 0.85rem;
        border-radius: 16px;
        background: rgba(201, 150, 63, 0.06);
        border: 1px solid rgba(201, 150, 63, 0.14);
    }

    [data-theme="dark"] .timeline-item {
        background: rgba(246, 240, 230, 0.06);
        border-color: rgba(246, 240, 230, 0.10);
    }

    .timeline-year {
        font-weight: 900;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        font-size: 0.78rem;
        color: var(--clr-gold-hover);
    }

    .timeline-body {
        color: var(--clr-text-muted);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    [data-theme="dark"] .timeline-body {
        color: rgba(220, 200, 180, 0.85);
    }

    .pillars {
        display: grid;
        gap: 0.85rem;
    }

    .pillar {
        padding: 1rem 1.1rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.65);
        border: 1px solid rgba(13, 9, 7, 0.07);
    }

    [data-theme="dark"] .pillar {
        background: rgba(246, 240, 230, 0.05);
        border-color: rgba(246, 240, 230, 0.10);
    }

    .pillar-kicker {
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        font-size: 0.72rem;
        color: var(--clr-gold);
        margin-bottom: 0.35rem;
    }

    [data-theme="dark"] .pillar-kicker {
        color: var(--clr-gold-light);
    }

    .pillar-text {
        color: var(--clr-text-main);
        font-weight: 600;
        line-height: 1.55;
    }

    [data-theme="dark"] .pillar-text {
        color: rgba(246, 251, 248, 0.92);
    }

    .values-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 0.6rem;
        color: var(--clr-text-muted);
        font-weight: 600;
    }

    .values-list li {
        padding: 0.75rem 0.9rem;
        border-radius: 14px;
        background: rgba(201, 150, 63, 0.06);
        border: 1px solid rgba(201, 150, 63, 0.14);
    }

    [data-theme="dark"] .values-list { color: rgba(220, 200, 180, 0.85); }
    [data-theme="dark"] .values-list li {
        background: rgba(246, 240, 230, 0.06);
        border-color: rgba(246, 240, 230, 0.10);
    }

    @media (max-width: 900px) {
        .history-split {
            grid-template-columns: 1fr;
        }
        .history-story.card,
        .history-timeline.card,
        .history-pillars.card,
        .history-values.card {
            padding: 1.6rem;
        }
        .timeline-item {
            grid-template-columns: 64px 1fr;
        }
    }
</style>
@endpush
