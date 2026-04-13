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
                @for ($i = 0; $i < 3; $i++)
                    @php
                        $piece = $stack->get($i);
                        $imgUrl = null;
                        if ($piece) {
                            if ($isGallery) {
                                $imgUrl = $piece->getFirstMediaUrl('image', 'thumb') ?: $piece->getFirstMediaUrl('image');
                            } else {
                                $imgUrl = $piece->hasMedia('cover')
                                    ? ($piece->getFirstMediaUrl('cover', 'thumb') ?: $piece->getFirstMediaUrl('cover'))
                                    : null;
                            }
                        }
                    @endphp
                    <div class="mag-hero__polaroid mag-hero__polaroid--{{ $i + 1 }}">
                        @if ($imgUrl)
                            <img src="{{ $imgUrl }}" alt="" decoding="async" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                        @else
                            <div class="mag-hero__polaroid-fallback mag-hero__polaroid-fallback--{{ ($i % 3) + 1 }}"></div>
                        @endif
                    </div>
                @endfor
            </div>
            <div class="mag-hero__frame"></div>
        </div>
    </div>
</section>
