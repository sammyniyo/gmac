@extends('layouts.frontend')

@section('title', $post->title . ' - News - GMAC Coffee')
@section('meta_description', Str::limit(strip_tags($post->content), 160))

@section('content')
@php
    $pub = $post->published_at ?? $post->created_at;
@endphp
<article class="news-article">
    <header class="news-article__hero fade-in">
        <div class="container news-article__hero-inner">
            <nav class="news-article__crumb" aria-label="Breadcrumb">
                <a href="{{ LaravelLocalization::localizeUrl(url('/')) }}">{{ __('messages.home') }}</a>
                <span class="news-article__crumb-sep" aria-hidden="true">/</span>
                <a href="{{ LaravelLocalization::localizeUrl(url('/news')) }}">{{ __('messages.news') }}</a>
                <span class="news-article__crumb-sep" aria-hidden="true">/</span>
                <span class="news-article__crumb-current">{{ Str::limit($post->title, 48) }}</span>
            </nav>
            <time class="news-article__date" datetime="{{ $pub->toIso8601String() }}">
                <i class="fa-regular fa-calendar-days" aria-hidden="true"></i>
                {{ $pub->format('F j, Y') }}
            </time>
            <h1 class="news-article__title">{{ $post->title }}</h1>
            <div class="news-article__rule" aria-hidden="true"></div>
        </div>
    </header>

    <div class="container news-article__shell">
        <div class="news-article__visual fade-in">
            @if($post->hasMedia('cover'))
                <img src="{{ $post->getFirstMediaUrl('cover') }}" alt="{{ $post->title }}" class="news-article__cover">
            @else
                <div class="news-article__cover-placeholder" aria-hidden="true">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
            @endif
        </div>

        <div class="news-article__content rich-text fade-in">
            {!! $post->content !!}
        </div>

        <footer class="news-article__share fade-in">
            <span class="news-article__share-label">{{ __('messages.share_story') }}</span>
            <div class="news-article__share-links">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="news-article__share-btn" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" class="news-article__share-btn" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" class="news-article__share-btn" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </footer>
    </div>
</article>

@php
    $recent = \App\Models\NewsPost::where('id', '!=', $post->id)
        ->where('is_published', true)
        ->latest('published_at')
        ->take(3)
        ->get();
@endphp

@if($recent->count() > 0)
<section class="news-article__recent">
    <div class="container">
        <h2 class="news-article__recent-title">{{ __('messages.latest_news') }}</h2>
        <div class="news-article__recent-grid">
            @foreach($recent as $rec)
                <a href="{{ route('news.show', $rec->slug) }}" class="news-article__recent-card">
                    <span class="news-article__recent-thumb">
                        @if($rec->hasMedia('cover'))
                            <img src="{{ $rec->getFirstMediaUrl('cover', 'thumb') ?? $rec->getFirstMediaUrl('cover') }}" alt="{{ $rec->title }}">
                        @else
                            <span class="news-article__recent-ph" aria-hidden="true"><i class="fa-solid fa-newspaper"></i></span>
                        @endif
                    </span>
                    <span class="news-article__recent-meta">
                        <span class="news-article__recent-card-title">{{ $rec->title }}</span>
                        <time datetime="{{ ($rec->published_at ?? $rec->created_at)->toIso8601String() }}">
                            {{ ($rec->published_at ?? $rec->created_at)->format('M j, Y') }}
                        </time>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
    .news-article__hero {
        padding: 2rem 0 2.5rem;
        background: linear-gradient(180deg, rgba(212, 162, 74, 0.08) 0%, transparent 100%);
        border-bottom: 1px solid rgba(13, 9, 7, 0.06);
    }

    [data-theme="dark"] .news-article__hero {
        background: linear-gradient(180deg, rgba(212, 162, 74, 0.06) 0%, transparent 100%);
        border-bottom-color: rgba(201, 150, 63, 0.1);
    }

    .news-article__hero-inner { max-width: 820px; margin: 0 auto; text-align: center; }

    .news-article__crumb {
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 1rem;
        color: rgba(26, 14, 8, 0.45);
    }

    [data-theme="dark"] .news-article__crumb { color: rgba(246, 240, 230, 0.4); }

    .news-article__crumb a {
        color: var(--clr-gold-dk, #9a7028);
        text-decoration: none;
    }

    .news-article__crumb a:hover { text-decoration: underline; }

    .news-article__crumb-sep { margin: 0 0.35rem; opacity: 0.5; }

    .news-article__crumb-current { color: rgba(26, 14, 8, 0.55); font-weight: 500; }

    [data-theme="dark"] .news-article__crumb-current { color: rgba(246, 240, 230, 0.55); }

    .news-article__date {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--clr-gold-dk, #9a7028);
        margin-bottom: 0.75rem;
    }

    [data-theme="dark"] .news-article__date { color: var(--clr-gold, #e8c97a); }

    .news-article__title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: clamp(2rem, 4.5vw, 3.25rem);
        font-weight: 600;
        line-height: 1.12;
        margin: 0 0 1rem;
        color: var(--clr-deep-espresso, #1a0e08);
    }

    [data-theme="dark"] .news-article__title { color: var(--clr-parchment, #f6f0e6); }

    .news-article__rule {
        width: 72px;
        height: 3px;
        margin: 0 auto;
        border-radius: 2px;
        background: linear-gradient(90deg, transparent, var(--clr-gold, #d4a24a), transparent);
    }

    .news-article__shell {
        max-width: 760px;
        padding-top: 2.25rem;
        padding-bottom: 3rem;
    }

    .news-article__visual { margin-bottom: 2rem; }

    .news-article__cover {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(13, 9, 7, 0.12);
    }

    .news-article__cover-placeholder {
        height: min(380px, 45vh);
        border-radius: 20px;
        background: var(--clr-bg-alt, rgba(26, 14, 8, 0.06));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--clr-gold, #d4a24a);
        opacity: 0.7;
    }

    .news-article__content {
        font-size: 1.08rem;
        line-height: 1.82;
        color: rgba(26, 14, 8, 0.88);
    }

    [data-theme="dark"] .news-article__content {
        color: rgba(246, 240, 230, 0.88);
    }

    .news-article__content p { margin-bottom: 1.5rem; }

    .news-article__content h2,
    .news-article__content h3 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        margin: 2.25rem 0 1rem;
        line-height: 1.2;
    }

    .news-article__share {
        margin-top: 2.5rem;
        padding-top: 1.75rem;
        border-top: 1px solid rgba(13, 9, 7, 0.08);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px 20px;
    }

    [data-theme="dark"] .news-article__share {
        border-top-color: rgba(201, 150, 63, 0.15);
    }

    .news-article__share-label {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(26, 14, 8, 0.5);
    }

    [data-theme="dark"] .news-article__share-label {
        color: rgba(246, 240, 230, 0.45);
    }

    .news-article__share-links { display: flex; gap: 10px; }

    .news-article__share-btn {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(212, 162, 74, 0.12);
        border: 1px solid rgba(201, 150, 63, 0.25);
        color: var(--clr-gold-dk, #8a6220);
        text-decoration: none;
        transition: transform 0.2s, background 0.2s;
    }

    .news-article__share-btn:hover {
        transform: translateY(-2px);
        background: rgba(212, 162, 74, 0.22);
    }

    .news-article__recent {
        padding: 3rem 0 4rem;
        background: var(--clr-bg-alt, rgba(26, 14, 8, 0.03));
        border-top: 1px solid rgba(13, 9, 7, 0.06);
    }

    [data-theme="dark"] .news-article__recent {
        background: rgba(0, 0, 0, 0.2);
        border-top-color: rgba(201, 150, 63, 0.08);
    }

    .news-article__recent-title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.75rem;
        font-weight: 600;
        text-align: center;
        margin: 0 0 1.75rem;
    }

    .news-article__recent-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }

    .news-article__recent-card {
        display: flex;
        gap: 14px;
        align-items: center;
        padding: 12px 14px;
        border-radius: 16px;
        text-decoration: none;
        color: inherit;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(13, 9, 7, 0.07);
        box-shadow: 0 4px 20px rgba(13, 9, 7, 0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    [data-theme="dark"] .news-article__recent-card {
        background: rgba(22, 14, 10, 0.9);
        border-color: rgba(201, 150, 63, 0.12);
    }

    .news-article__recent-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 36px rgba(13, 9, 7, 0.1);
    }

    .news-article__recent-thumb {
        flex-shrink: 0;
        width: 88px;
        height: 72px;
        border-radius: 12px;
        overflow: hidden;
        background: rgba(26, 14, 8, 0.06);
    }

    .news-article__recent-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .news-article__recent-ph {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        color: var(--clr-gold, #d4a24a);
        font-size: 1.35rem;
    }

    .news-article__recent-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .news-article__recent-card-title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.05rem;
        font-weight: 600;
        line-height: 1.25;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-article__recent-meta time {
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: rgba(26, 14, 8, 0.45);
    }

    [data-theme="dark"] .news-article__recent-meta time {
        color: rgba(246, 240, 230, 0.4);
    }

    @media (max-width: 900px) {
        .news-article__recent-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush
