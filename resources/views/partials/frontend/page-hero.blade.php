@props([
    'title',
    'subtitle' => null,
    'eyebrow'  => 'GMAC Coffee',
])

<section class="ph-hero">
    {{-- Decorative background layers --}}
    <div class="ph-hero__bg" aria-hidden="true">
        <div class="ph-hero__bg-ring ph-hero__bg-ring--1"></div>
        <div class="ph-hero__bg-ring ph-hero__bg-ring--2"></div>
        <div class="ph-hero__bg-grain"></div>
    </div>

    <div class="container ph-hero__container">
        <div class="ph-hero__inner">

            {{-- Left: decorative line --}}
            <div class="ph-hero__rule" aria-hidden="true"></div>

            {{-- Content --}}
            <div class="ph-hero__copy">
                @if($eyebrow)
                <div class="ph-hero__eyebrow">
                    <span class="ph-hero__eyebrow-line"></span>
                    {{ $eyebrow }}
                    <span class="ph-hero__eyebrow-line"></span>
                </div>
                @endif

                <h1 class="ph-hero__title">{{ $title }}</h1>

                @if($subtitle)
                <p class="ph-hero__subtitle">{{ $subtitle }}</p>
                @endif
            </div>

            {{-- Breadcrumb / scroll cue --}}
            <div class="ph-hero__scroll" aria-hidden="true">
                <div class="ph-hero__scroll-line"></div>
                <span>Scroll</span>
            </div>
        </div>
    </div>
</section>
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap');

:root {
    --gh-forest:   #234535;
    --gh-ink:      #21160f;
    --gh-parchment:#efe2cf;
    --gh-cream:    #e7dac4;
    --gh-gold:     var(--clr-gold, #1f9d6a);
    --gh-gold-dk:  #8a6320;
    --gh-gold-lt:  #d8b76b;
    --gh-display:  'Cormorant Garamond', Georgia, serif;
    --gh-body:     'DM Sans', sans-serif;
    --gh-ease:     cubic-bezier(0.16, 1, 0.3, 1);
}

/* ── Hero shell ──────────────────────────────────────────────────── */
.ph-hero {
    position: relative;
    min-height: 280px;
    display: flex;
    align-items: center;
    overflow: hidden;
    background:
        radial-gradient(ellipse 75% 55% at 8% 22%, rgba(31,157,106,0.14), transparent 62%),
        radial-gradient(ellipse 60% 45% at 92% 18%, rgba(138,99,32,0.12), transparent 58%),
        linear-gradient(180deg, #f3e8d8 0%, #efe3d0 58%, #e8dbc6 100%);
    padding: calc(var(--gnav-total-h) + 24px) 0 48px;
    border-bottom: 1px solid rgba(24,49,38,0.06);
}

/* ── Background decorations ─────────────────────────────────────── */
.ph-hero__bg { position: absolute; inset: 0; pointer-events: none; }

.ph-hero__bg-ring {
    position: absolute;
    border-radius: 50%;
    border: 1px solid rgba(31,157,106,0.12);
}
.ph-hero__bg-ring--1 {
    width: 560px; height: 560px;
    top: 50%; left: -200px;
    transform: translateY(-50%);
}
.ph-hero__bg-ring--2 {
    width: 340px; height: 340px;
    top: 50%; left: -100px;
    transform: translateY(-50%);
    border-color: rgba(138,99,32,0.1);
}

/* Subtle grain overlay */
.ph-hero__bg-grain {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
    background-size: 180px 180px;
    opacity: 0.16;
}

/* ── Layout ─────────────────────────────────────────────────────── */
.ph-hero__container { position: relative; z-index: 1; }

.ph-hero__inner {
    display: flex;
    align-items: center;
    gap: 28px;
    position: relative;
    padding: clamp(1.8rem, 3vw, 2.8rem);
    border-radius: 28px;
    background:
        radial-gradient(420px 180px at 100% 0%, rgba(31,157,106,0.12), transparent 60%),
        radial-gradient(360px 180px at 0% 100%, rgba(138,99,32,0.1), transparent 62%),
        linear-gradient(135deg, rgba(250,244,235,0.92) 0%, rgba(244,236,223,0.92) 100%);
    border: 1px solid rgba(24,49,38,0.08);
    box-shadow: 0 20px 50px rgba(18,59,47,0.08);
}

/* Left vertical rule */
.ph-hero__rule {
    flex-shrink: 0;
    width: 1px;
    height: 80px;
    background: linear-gradient(to bottom, transparent, rgba(138,99,32,0.42), transparent);
}

/* ── Copy ───────────────────────────────────────────────────────── */
.ph-hero__copy { flex: 1; }

.ph-hero__eyebrow {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: var(--gh-body);
    font-size: 0.66rem;
    font-weight: 500;
    letter-spacing: 0.28em;
    text-transform: uppercase;
    color: var(--gh-gold-dk);
    margin-bottom: 18px;
    opacity: 0;
    animation: ph-fade-up 0.7s var(--gh-ease) 0.1s both;
}
.ph-hero__eyebrow-line {
    display: block;
    height: 1px;
    width: 22px;
    background: var(--gh-gold);
    opacity: 0.4;
    flex-shrink: 0;
}

.ph-hero__title {
    font-family: var(--gh-display);
    font-size: clamp(2.6rem, 5vw, 4.4rem);
    font-weight: 300;
    line-height: 1.04;
    color: var(--gh-ink);
    margin: 0 0 14px;
    letter-spacing: -0.01em;
    opacity: 0;
    animation: ph-fade-up 0.75s var(--gh-ease) 0.22s both;
}

.ph-hero__subtitle {
    font-family: var(--gh-body);
    font-size: 0.92rem;
    font-weight: 300;
    line-height: 1.75;
    color: rgba(24,49,38,0.76);
    max-width: 52ch;
    margin: 0;
    opacity: 0;
    animation: ph-fade-up 0.75s var(--gh-ease) 0.34s both;
}

/* ── Scroll cue ─────────────────────────────────────────────────── */
.ph-hero__scroll {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0;
    animation: ph-fade-up 0.75s var(--gh-ease) 0.5s both;
}
.ph-hero__scroll span {
    font-family: var(--gh-body);
    font-size: 0.58rem;
    font-weight: 400;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: rgba(24,49,38,0.38);
    writing-mode: vertical-rl;
}
.ph-hero__scroll-line {
    width: 1px;
    height: 38px;
    background: linear-gradient(to bottom, rgba(138,99,32,0.8), transparent);
    animation: ph-scroll-pulse 2.4s ease-in-out infinite;
}

/* ── Animations ─────────────────────────────────────────────────── */
@keyframes ph-fade-up {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes ph-scroll-pulse {
    0%, 100% { opacity: 0.35; }
    50%       { opacity: 1; }
}

/* ── Responsive ─────────────────────────────────────────────────── */
@media (max-width: 768px) {
    .ph-hero { padding: calc(var(--gnav-total-h) + 14px) 0 36px; min-height: 220px; }
    .ph-hero__title { font-size: clamp(2rem, 7vw, 3rem); }
    .ph-hero__scroll { display: none; }
    .ph-hero__rule { height: 60px; }
}
</style>

