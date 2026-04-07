@extends('layouts.frontend')

@section('title', 'News & Events - GMAC Coffee')
@section('meta_description', 'The latest updates, harvest news, and community events from GMAC Coffee and the Rwandan coffee industry.')

@section('content')
<section class="page-hero fade-in">
    <div class="container">
        <div class="page-hero-card">
            <div class="page-hero-kicker">GMAC Coffee</div>
            <h1 class="page-hero-title">{{ __('messages.news') }}</h1>
            <p class="page-hero-subtitle">Updates, harvest stories, and community events.</p>
        </div>
    </div>
</section>

<div class="container py-6">
    <div class="news-listing fade-in">
        <div class="news-grid">
            @forelse($posts as $post)
                <article class="news-card fade-in">
                    <a href="{{ route('news.show', $post->slug) }}" class="news-image-link">
                        @if($post->hasMedia('cover'))
                            <img src="{{ $post->getFirstMediaUrl('cover', 'thumb') ?? $post->getFirstMediaUrl('cover') }}" alt="{{ $post->title }}" class="news-image">
                        @else
                            <div class="news-image-placeholder">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                        @endif
                        <div class="news-date">
                            <span class="day">{{ $post->published_at ? $post->published_at->format('d') : $post->created_at->format('d') }}</span>
                            <span class="month">{{ $post->published_at ? $post->published_at->format('M') : $post->created_at->format('M') }}</span>
                        </div>
                    </a>
                    <div class="news-body">
                        <h2 class="news-title"><a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a></h2>
                        <p class="news-excerpt">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                        <a href="{{ route('news.show', $post->slug) }}" class="news-link">{{ __('messages.read_more') }} <i class="fa-solid fa-arrow-right-long ml-1"></i></a>
                    </div>
                </article>
            @empty
                <div class="text-center py-6 w-full">
                    <p class="text-xl text-gray-500">No news updates yet. Stay tuned for harvest reports and events.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-wrapper mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 3rem;
    }
    
    .news-card {
        background: rgba(255,255,255,0.88);
        border: 1px solid rgba(13, 9, 7, 0.07);
        border-radius: var(--radius-card);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: transform var(--transition-base), box-shadow var(--transition-base);
        display: flex;
        flex-direction: column;
    }
    
    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }
    
    .news-image-link {
        position: relative;
        height: 240px;
        display: block;
        overflow: hidden;
    }
    
    .news-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform var(--transition-slow);
    }
    
    .news-card:hover .news-image {
        transform: scale(1.1);
    }
    
    .news-image-placeholder {
        width: 100%;
        height: 100%;
        background-color: var(--clr-bg-alt);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--clr-gold);
    }
    
    .news-date {
        position: absolute;
        top: 1.25rem; right: 1.25rem;
        background: #1a0e08;
        color: #f6f0e6;
        padding: 0.5rem 0.85rem;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 4px 14px rgba(13,9,7,0.22);
        z-index: 10;
        min-width: 54px;
        text-align: center;
    }

    .news-date .day {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.35rem;
        font-weight: 600;
        line-height: 1;
        color: #e8c97a;
    }

    .news-date .month {
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: rgba(246, 240, 230, 0.55);
    }
    
    .news-body {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .news-title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    
    .news-title a {
        color: inherit;
        text-decoration: none;
    }
    
    .news-title a:hover {
        color: var(--clr-gold);
    }
    
    .news-excerpt {
        color: var(--clr-text-muted);
        font-size: 1rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
        flex-grow: 1;
    }
    
    .news-link {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        color: var(--clr-gold);
        display: flex;
        align-items: center;
    }
    
    /* Pagination Styles */
    .pagination-wrapper nav {
        display: flex;
        justify-content: center;
    }
    
    @media (max-width: 600px) {
        .news-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush
