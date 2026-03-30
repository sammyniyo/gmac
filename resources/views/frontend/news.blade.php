@extends('layouts.frontend')

@section('title', 'News & Events - GMAC Coffee')
@section('meta_description', 'The latest updates, harvest news, and community events from GMAC Coffee and the Rwandan coffee industry.')

@section('content')
<!-- Page Header -->
<div class="page-header" style="background-image: linear-gradient(rgba(28, 10, 0, 0.7), rgba(28, 10, 0, 0.7)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2000&auto=format&fit=crop');">
    <div class="container fade-in">
        <h1 class="page-title">{{ __('messages.gallery') }}</h1>
        <p class="page-subtitle">{{ __('messages.slogan') }}</p>
    </div>
</div>

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
    .page-header {
        height: 350px;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-top: -80px;
        padding-top: 80px;
    }
    
    .page-title {
        font-size: 3.5rem;
        color: white !important;
    }
    
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 3rem;
    }
    
    .news-card {
        background: var(--clr-white);
        border-radius: 12px;
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
        top: 1rem; left: 1rem;
        background: var(--clr-gold);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: var(--shadow-md);
        z-index: 10;
    }
    
    .news-date .day {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
    }
    
    .news-date .month {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
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
