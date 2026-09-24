{{--
  Editorial hero for Gallery & News — split layout, polaroid stack, motion (respects reduced-motion).
  @param string $variant  gallery | news
  @param string $title
  @param string $subtitle
  @param \Illuminate\Support\Collection $mosaic  GalleryItem or NewsPost models (first 3 used for stack)
  @param string|null $eyebrow  optional override
--}}
@php
    $eyebrowText = $eyebrow ?? (\App\Models\Setting::where('key', 'company_name')->value('value') ?? 'GMAC Coffee');
    $mosaic = $mosaic ?? collect();
    $stack = $mosaic->take(3);
    $isGallery = $variant === 'gallery';
@endphp

<section class="mag-hero mag-hero--{{ $variant }} fade-in" aria-labelledby="mag-hero-heading-{{ $variant }}">
    <div class="mag-hero__ambient" aria-hidden="true">
        <span class="mag-hero__blob mag-hero__blob--1"></span>
        <span class="mag-hero__blob mag-hero__blob--2"></span>
        <span class="mag-hero__blob mag-hero__blob--3"></span>
    </div>

    <div class="container mag-hero__layout">
        <div class="mag-hero__intro">
            <p class="mag-hero__eyebrow">{{ $eyebrowText }}</p>
            <h1 id="mag-hero-heading-{{ $variant }}" class="mag-hero__title">{{ $title }}</h1>
            <p class="mag-hero__lead">{{ $subtitle }}</p>
            <div class="mag-hero__rule" aria-hidden="true"></div>
        </div>

        <div class="mag-hero__visual" aria-hidden="true">
            <div class="mag-hero__stack">
                @php
                    $fallbackStack = $isGallery
                        ? [\App\Support\FrontendShowcase::img('cherries'), \App\Support\FrontendShowcase::img('green'), \App\Support\FrontendShowcase::img('bowl')]
                        : [\App\Support\FrontendShowcase::img('station'), \App\Support\FrontendShowcase::img('cherries'), \App\Support\FrontendShowcase::img('beans')];
                @endphp
                @for ($i = 0; $i < 3; $i++)
                    @php
                        $piece = $stack->get($i);
                        $imgUrl = $piece && method_exists($piece, 'displayImage')
                            ? $piece->displayImage()
                            : $fallbackStack[$i];
                    @endphp
                    <div class="mag-hero__polaroid mag-hero__polaroid--{{ $i + 1 }}">
                        <img src="{{ $imgUrl }}" alt="" decoding="async" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                    </div>
                @endfor
            </div>
            <div class="mag-hero__frame"></div>
        </div>
    </div>
</section>
