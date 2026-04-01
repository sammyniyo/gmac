@extends('layouts.frontend')

@section('title', $post->title . ' - News - GMAC Coffee')
@section('meta_description', Str::limit(strip_tags($post->content), 160))

@section('content')
<article class="news-detail py-4">
    <div class="container">
        <nav class="breadcrumb mb-2 fade-in">
            <a href="{{ url('/') }}">{{ __('messages.home') }}</a> / 
            <a href="{{ url('/news') }}">{{ __('messages.news') }}</a> / 
            <span class="active">{{ Str::limit($post->title, 40) }}</span>
        </nav>

        <header class="detail-header text-center mb-4 fade-in">
            <div class="news-meta mb-1">
                <span class="post-date text-gold">
                    <i class="fa-regular fa-calendar-days mr-1"></i>
                    {{ $post->published_at ? $post->published_at->format('F d, Y') : $post->created_at->format('F d, Y') }}
                </span>
            </div>
            <h1 class="detail-h1">{{ $post->title }}</h1>
            <div class="title-separator mx-auto mt-2"></div>
        </header>

        <div class="detail-content-wrapper">
            <div class="news-main-visual fade-in mb-4">
                @if($post->hasMedia('cover'))
                    <img src="{{ $post->getFirstMediaUrl('cover') }}" alt="{{ $post->title }}" class="post-full-image">
                @else
                    <div class="post-image-placeholder">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                @endif
            </div>

            <div class="news-text-body fade-in">
                <div class="rich-text">
                    {!! $post->content !!}
                </div>
            </div>

            <footer class="post-footer mt-6 pt-4 border-t fade-in">
                <div class="share-links flex items-center gap-2">
                    <span class="font-bold">Share this story:</span>
                    <a href="https://facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="social-link" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" class="social-link" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" class="social-link" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </footer>
        </div>
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
<section class="recent-news py-6 bg-alt mt-4">
    <div class="container">
        <h2 class="section-title text-center">Recent Stories</h2>
        <div class="title-separator mb-4"></div>
        
        <div class="news-mini-grid">
            @foreach($recent as $rec)
                <div class="news-card mini-card">
                    <a href="{{ route('news.show', $rec->slug) }}" class="mini-card-image">
                        @if($rec->hasMedia('cover'))
                            <img src="{{ $rec->getFirstMediaUrl('cover', 'thumb') ?? $rec->getFirstMediaUrl('cover') }}" alt="{{ $rec->title }}">
                        @endif
                    </a>
                    <div class="p-1">
                        <h4 class="mb-0"><a href="{{ route('news.show', $rec->slug) }}">{{ $rec->title }}</a></h4>
                        <span class="text-xs text-muted">{{ $rec->published_at ? $rec->published_at->format('M d, Y') : $rec->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<style>
    .detail-h1 {
        font-size: 3.1rem;
        line-height: 1.1;
        margin-top: 1rem;
        color: var(--clr-deep-espresso) !important;
    }
    
    [data-theme='dark'] .detail-h1 {
        color: var(--clr-gold) !important;
    }
    
    .news-detail {
        background-color: transparent;
    }
    
    .detail-content-wrapper {
        max-width: 900px;
        margin: 0 auto;
    }
    
    .post-full-image {
        width: 100%;
        height: auto;
        border-radius: var(--radius-card);
        box-shadow: var(--shadow-md);
    }
    
    .post-image-placeholder {
        height: 400px;
        background: var(--clr-bg-alt);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: var(--clr-gold);
        border-radius: var(--radius-card);
    }
    
    .news-text-body {
        font-size: 1.15rem;
        line-height: 1.8;
    }
    
    .rich-text p {
        margin-bottom: 2rem;
    }
    
    .rich-text h2, .rich-text h3 {
        margin: 3rem 0 1.5rem;
    }
    
    .post-footer {
        border-top: 1px solid var(--clr-bg-alt);
    }
    
    .news-mini-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }
    
    .mini-card-image {
        height: 150px;
        display: block;
        overflow: hidden;
    }
    
    .mini-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .text-xs { font-size: 0.75rem; }
    .text-muted { color: var(--clr-text-muted); }
    .mt-6 { margin-top: 6rem; }
    .pt-4 { padding-top: 4rem; }
    .border-t { border-top: 1px solid var(--clr-bg-alt); }
</style>
@endpush
