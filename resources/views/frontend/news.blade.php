@extends('layouts.frontend')

@section('title', 'News & Events - GMAC Coffee')
@section('meta_description', 'The latest updates, harvest news, and community events from GMAC Coffee and the Rwandan coffee industry.')

@section('content')
@include('partials.frontend.mag-hero', [
    'variant' => 'news',
    'title' => __('messages.news'),
    'subtitle' => __('messages.news_hero_subtitle'),
    'mosaic' => $heroPosts,
])

<div class="container py-6">
    <div class="news-page fade-in">
        <div class="news-mag">
            @forelse($posts as $post)
                @php
                    $isLead = $posts->currentPage() === 1 && $loop->first;
                    $date = $post->published_at ?? $post->created_at;
                @endphp
                <article class="news-mag__card {{ $isLead ? 'news-mag__card--lead' : '' }} fade-in">
                    <a href="{{ route('news.show', $post->slug) }}" class="news-mag__media">
                        @if($post->hasMedia('cover'))
                            <img src="{{ $post->getFirstMediaUrl('cover', 'thumb') ?? $post->getFirstMediaUrl('cover') }}"
                                 alt="{{ $post->title }}"
                                 loading="{{ $loop->iteration < 4 ? 'eager' : 'lazy' }}"
                                 decoding="async">
                        @else
                            <span class="news-mag__placeholder" aria-hidden="true"><i class="fa-solid fa-newspaper"></i></span>
                        @endif
                        <span class="news-mag__media-veil" aria-hidden="true"></span>
                    </a>
                    <div class="news-mag__body">
                        <div class="news-mag__kicker">
                            <time datetime="{{ $date->toIso8601String() }}">{{ $date->format('M j, Y') }}</time>
                            @if($isLead)
                                <span class="news-mag__pill">{{ __('messages.latest_news') }}</span>
                            @endif
                        </div>
                        <h2 class="news-mag__title">
                            <a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="news-mag__excerpt">{{ Str::limit(strip_tags($post->content), $isLead ? 220 : 130) }}</p>
                        <a href="{{ route('news.show', $post->slug) }}" class="news-mag__link">
                            {{ __('messages.read_more') }}
                            <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            @empty
                <p class="news-mag__empty">No news yet. Soon you will see harvest reports and events here.</p>
            @endforelse
        </div>

        <div class="news-pagination">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .news-mag {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 1.5rem;
        grid-auto-flow: dense;
    }

    .news-mag__card {
        grid-column: span 4;
        display: flex;
        flex-direction: column;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(13, 9, 7, 0.07);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 6px 28px rgba(13, 9, 7, 0.06);
        transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.35s ease, border-color 0.25s ease;
    }

    [data-theme="dark"] .news-mag__card {
        background: rgba(22, 14, 10, 0.92);
        border-color: rgba(201, 150, 63, 0.12);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
    }

    .news-mag__card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 48px rgba(13, 9, 7, 0.12);
        border-color: rgba(201, 150, 63, 0.22);
    }

    .news-mag__card--lead {
        grid-column: 1 / -1;
        flex-direction: row;
        align-items: stretch;
        min-height: 280px;
    }

    .news-mag__card--lead .news-mag__media {
        flex: 1.15;
        min-height: 280px;
        aspect-ratio: auto;
    }

    .news-mag__card--lead .news-mag__body {
        flex: 1;
        padding: 2rem 2.25rem;
        justify-content: center;
    }

    .news-mag__card--lead .news-mag__title {
        font-size: clamp(1.65rem, 3vw, 2.35rem);
    }

    .news-mag__media {
        position: relative;
        display: block;
        aspect-ratio: 16 / 11;
        overflow: hidden;
        background: var(--clr-bg-alt, rgba(26, 14, 8, 0.06));
    }

    .news-mag__media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .news-mag__card:hover .news-mag__media img {
        transform: scale(1.05);
    }

    .news-mag__placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-size: 3rem;
        color: var(--clr-gold, #d4a24a);
        opacity: 0.65;
    }

    .news-mag__media-veil {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(13, 9, 7, 0.45), transparent 55%);
        opacity: 0.75;
        pointer-events: none;
    }

    .news-mag__body {
        padding: 1.35rem 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 0.65rem;
    }

    .news-mag__kicker {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(26, 14, 8, 0.45);
    }

    [data-theme="dark"] .news-mag__kicker {
        color: rgba(246, 240, 230, 0.45);
    }

    .news-mag__kicker time {
        color: var(--clr-gold-dk, #9a7028);
    }

    [data-theme="dark"] .news-mag__kicker time {
        color: var(--clr-gold, #e8c97a);
    }

    .news-mag__pill {
        padding: 3px 10px;
        border-radius: 999px;
        background: rgba(212, 162, 74, 0.18);
        color: var(--clr-gold-dk, #7a5218);
        font-size: 0.65rem;
    }

    [data-theme="dark"] .news-mag__pill {
        background: rgba(212, 162, 74, 0.15);
        color: var(--clr-gold-lt, #edd078);
    }

    .news-mag__title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.35rem;
        font-weight: 600;
        line-height: 1.22;
        margin: 0;
    }

    .news-mag__title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }

    .news-mag__title a:hover {
        color: var(--clr-gold, #b8892a);
    }

    .news-mag__excerpt {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.65;
        color: var(--clr-text-muted, rgba(26, 14, 8, 0.58));
        flex: 1;
    }

    [data-theme="dark"] .news-mag__excerpt {
        color: rgba(246, 240, 230, 0.55);
    }

    .news-mag__link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 0.25rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--clr-gold-dk, #9a7028);
        text-decoration: none;
        transition: gap 0.25s ease, color 0.2s;
    }

    .news-mag__link:hover {
        gap: 12px;
        color: var(--clr-gold, #c9942e);
    }

    .news-mag__empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem 1rem;
        color: var(--clr-text-muted, rgba(26, 14, 8, 0.5));
        font-size: 1.05rem;
    }

    .news-pagination {
        margin-top: 2.5rem;
        display: flex;
        justify-content: center;
    }

    .news-pagination nav {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.35rem;
    }

    .news-pagination a,
    .news-pagination span {
        min-width: 2.5rem;
        height: 2.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.65rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid rgba(13, 9, 7, 0.1);
        color: rgba(26, 14, 8, 0.65);
        background: rgba(255, 255, 255, 0.85);
        transition: background 0.2s, border-color 0.2s, color 0.2s;
    }

    [data-theme="dark"] .news-pagination a,
    [data-theme="dark"] .news-pagination span {
        background: rgba(22, 14, 10, 0.85);
        border-color: rgba(201, 150, 63, 0.2);
        color: rgba(246, 240, 230, 0.75);
    }

    .news-pagination a:hover {
        border-color: var(--clr-gold, #d4a24a);
        color: var(--clr-gold-dk, #7a5218);
    }

    .news-pagination span[aria-current="page"] {
        background: linear-gradient(135deg, rgba(212, 162, 74, 0.35), rgba(212, 162, 74, 0.12));
        border-color: rgba(201, 150, 63, 0.45);
        color: var(--clr-ink, #1a0e08);
    }

    @media (max-width: 1100px) {
        .news-mag__card { grid-column: span 6; }
        .news-mag__card--lead { flex-direction: column; min-height: 0; }
        .news-mag__card--lead .news-mag__media { min-height: 240px; }
    }

    @media (max-width: 640px) {
        .news-mag__card { grid-column: 1 / -1; }
    }
</style>
@endpush
