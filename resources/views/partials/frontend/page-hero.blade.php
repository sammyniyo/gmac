@props([
    'title',
    'subtitle' => null,
    'eyebrow'  => 'GMAC Coffee',
])

<section class="ph-hero">
    <div class="container ph-hero__container">
        <div class="ph-hero__inner">
            <div class="ph-hero__copy">
                @if($eyebrow)
                    <div class="ph-hero__eyebrow">{{ $eyebrow }}</div>
                @endif

                <h1 class="ph-hero__title">{{ $title }}</h1>

                @if($subtitle)
                    <p class="ph-hero__subtitle">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
<style>
.ph-hero {
    position: relative;
    background:
        radial-gradient(900px 320px at 10% 0%, rgba(212, 162, 74, 0.14), transparent 60%),
        radial-gradient(720px 260px at 90% 10%, rgba(20, 61, 50, 0.07), transparent 58%),
        linear-gradient(180deg, #faf6ef 0%, #f0e6d6 55%, #ebe0d0 100%);
    padding: calc(var(--site-header-h, 84px) + 34px) 0 42px;
    border-bottom: 1px solid rgba(13, 9, 7, 0.06);
}

.ph-hero__container {
    position: relative;
    z-index: 1;
}

@keyframes ph-card-in {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.985);
        filter: blur(4px);
    }
    to {
        opacity: 1;
        transform: none;
        filter: none;
    }
}

.ph-hero__inner {
    max-width: 860px;
    margin: 0 auto;
    padding: clamp(2rem, 4vw, 3rem);
    text-align: center;
    background:
        radial-gradient(360px 140px at 50% 0%, rgba(212, 162, 74, 0.14), transparent 70%),
        rgba(255, 252, 247, 0.78);
    border: 1px solid rgba(13, 9, 7, 0.06);
    border-radius: 30px;
    box-shadow:
        0 22px 56px rgba(13, 9, 7, 0.08),
        0 0 0 1px rgba(212, 162, 74, 0.06) inset;
}

@media (prefers-reduced-motion: no-preference) {
    .ph-hero__inner {
        animation: ph-card-in 0.85s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
}

[data-theme='dark'] .ph-hero {
    background:
        radial-gradient(900px 320px at 10% 0%, rgba(201, 150, 63, 0.1), transparent 60%),
        linear-gradient(180deg, #150b06 0%, #100804 55%, #0d0907 100%);
    border-bottom-color: rgba(246, 240, 230, 0.08);
}

[data-theme='dark'] .ph-hero__inner {
    background: rgba(246, 240, 230, 0.04);
    border-color: rgba(246, 240, 230, 0.1);
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.26);
}

.ph-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.55rem 1rem;
    border-radius: 999px;
    background: rgba(201, 150, 63, 0.12);
    border: 1px solid rgba(201, 150, 63, 0.18);
    color: var(--clr-gold-hover);
    font-family: var(--font-body);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.ph-hero__title {
    font-family: var(--font-heading);
    font-size: clamp(2.4rem, 5vw, 4rem);
    font-weight: 300;
    line-height: 1.05;
    color: var(--clr-deep-espresso);
    margin: 0 0 0.8rem;
}

.ph-hero__subtitle {
    max-width: 58ch;
    margin: 0 auto;
    color: rgba(24, 49, 38, 0.74);
    font-size: 1rem;
    line-height: 1.8;
}

[data-theme='dark'] .ph-hero__eyebrow {
    color: var(--clr-gold-light);
    background: rgba(201, 150, 63, 0.1);
    border-color: rgba(201, 150, 63, 0.18);
}

[data-theme='dark'] .ph-hero__title {
    color: var(--clr-text-light);
}

[data-theme='dark'] .ph-hero__subtitle {
    color: rgba(246, 240, 230, 0.66);
}

@media (max-width: 768px) {
    .ph-hero {
        padding: calc(var(--site-header-h, 84px) + 24px) 0 28px;
    }

    .ph-hero__inner {
        padding: 1.6rem 1.25rem;
        border-radius: 24px;
    }

    .ph-hero__title {
        font-size: clamp(2rem, 8vw, 2.9rem);
    }
}
</style>

