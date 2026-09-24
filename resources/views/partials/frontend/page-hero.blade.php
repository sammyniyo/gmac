@props([
    'title',
    'subtitle' => null,
    'eyebrow'  => 'GMAC Coffee',
    'image'    => null,
])

<section class="ph-hero {{ $image ? 'ph-hero--photo' : 'ph-hero--plain' }}">
    @if($image)
        <img class="ph-hero__bg" src="{{ $image }}" alt="" fetchpriority="high" decoding="async">
    @endif
    <div class="ph-hero__veil" aria-hidden="true"></div>
    <div class="container ph-hero__inner">
        @if($eyebrow)
            <p class="ph-hero__eyebrow">{{ $eyebrow }}</p>
        @endif
        <h1 class="ph-hero__title">{{ $title }}</h1>
        @if($subtitle)
            <p class="ph-hero__subtitle">{{ $subtitle }}</p>
        @endif
    </div>
</section>
<style>
.ph-hero {
    position: relative;
    min-height: 380px;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
    background: #3d2e24;
}
.ph-hero--plain { min-height: 220px; }
.ph-hero__bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 42%;
    display: block;
    transform: none;
    image-rendering: auto;
}
.ph-hero__veil {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(28, 18, 12, 0.15) 0%, rgba(28, 18, 12, 0.55) 48%, rgba(28, 18, 12, 0.86) 100%);
}
.ph-hero__inner {
    position: relative;
    z-index: 1;
    max-width: 42rem;
    padding: 5.5rem 0 2.75rem;
}
.ph-hero__eyebrow {
    margin: 0 0 0.7rem;
    color: #e4c98a;
    font-size: 0.72rem;
    font-weight: 500;
    letter-spacing: 0.16em;
    text-transform: uppercase;
}
.ph-hero__title {
    margin: 0 0 0.7rem;
    color: #fff;
    font-family: 'Fraunces', 'Times New Roman', serif;
    font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 500;
    line-height: 1.08;
    letter-spacing: -0.02em;
    word-spacing: 0.06em;
}
.ph-hero__subtitle {
    margin: 0;
    max-width: 40rem;
    color: rgba(255,255,255,0.78);
    font-size: 1.02rem;
    line-height: 1.65;
    word-spacing: 0.06em;
}
@media (max-width: 768px) {
    .ph-hero { min-height: 260px; }
    .ph-hero__inner { padding: 4.2rem 0 2rem; }
}
</style>
