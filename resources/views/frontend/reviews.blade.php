@extends('layouts.frontend')

@section('title', __('messages.reviews_page_title'))
@section('meta_description', __('messages.reviews_page_meta'))

@section('content')

@include('partials.frontend.page-hero', [
    'title' => __('messages.reviews_page_heading'),
    'subtitle' => __('messages.reviews_page_subtitle'),
    'eyebrow' => 'GMAC Coffee',
    'image' => \App\Support\FrontendShowcase::img('cherries'),
])

<section class="reviews-page">
    <div class="container">
        @if(session('feedback_success'))
            <div class="reviews-alert fade-in" role="status">
                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                {{ session('feedback_success') }}
            </div>
        @endif

        <div class="reviews-layout fade-in">
            <div class="reviews-form-card shadow-lg">
                <div class="reviews-form-head">
                    <span class="reviews-kicker">{{ __('messages.reviews_form_kicker') }}</span>
                    <h2 class="reviews-form-title">{{ __('messages.reviews_form_title') }}</h2>
                    <p class="reviews-form-lead">{{ __('messages.reviews_form_lead') }}</p>
                </div>

                <form action="{{ route('reviews.submit') }}" method="POST" class="reviews-form">
                    @csrf
                    <div class="reviews-form-row">
                        <div class="reviews-field">
                            <label for="fb-name">{{ __('messages.name') }} *</label>
                            <input type="text" id="fb-name" name="name" value="{{ old('name') }}" required maxlength="255" class="reviews-input" autocomplete="name">
                            @error('name')<span class="reviews-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="reviews-field">
                            <label for="fb-email">{{ __('messages.email') }}</label>
                            <input type="email" id="fb-email" name="email" value="{{ old('email') }}" maxlength="255" class="reviews-input" autocomplete="email">
                            @error('email')<span class="reviews-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="reviews-field">
                        <label for="fb-rating">{{ __('messages.reviews_rating_label') }} *</label>
                        <select name="rating" id="fb-rating" class="reviews-input" required>
                            @foreach([5, 4, 3, 2, 1] as $r)
                                <option value="{{ $r }}" @selected((int) old('rating', 5) === $r)>{{ __('messages.reviews_stars_option', ['n' => $r]) }}</option>
                            @endforeach
                        </select>
                        @error('rating')<span class="reviews-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="reviews-field">
                        <label for="fb-body">{{ __('messages.reviews_comment_label') }} *</label>
                        <textarea id="fb-body" name="body" rows="5" required minlength="10" maxlength="5000" class="reviews-textarea" placeholder="{{ __('messages.reviews_comment_placeholder') }}">{{ old('body') }}</textarea>
                        @error('body')<span class="reviews-error">{{ $message }}</span>@enderror
                    </div>

                    <p class="reviews-moderation-note">{{ __('messages.reviews_moderation_note') }}</p>

                    <button type="submit" class="reviews-submit gh-btn gh-btn--gold">{{ __('messages.reviews_submit') }}</button>
                </form>
            </div>

            <div class="reviews-list-wrap">
                <h3 class="reviews-list-title">{{ __('messages.reviews_public_title') }}</h3>
                @if($feedbacks->isEmpty())
                    <p class="reviews-empty">{{ __('messages.reviews_empty') }}</p>
                @else
                    <ul class="reviews-list">
                        @foreach($feedbacks as $fb)
                            <li class="reviews-item">
                                <div class="reviews-item__stars" aria-label="{{ $fb->rating }} of 5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $fb->rating ? 'is-on' : 'is-off' }}" aria-hidden="true"></i>
                                    @endfor
                                </div>
                                <p class="reviews-item__body">"{{ $fb->body }}"</p>
                                <div class="reviews-item__meta">— {{ $fb->name }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
.reviews-page { padding: 2.25rem 0 5rem; background: #f5f3f0; }
.reviews-alert {
    margin: 0 0 1.25rem;
    padding: 0.85rem 1rem;
    border-radius: 12px;
    background: #efe8df;
    color: #3d2918;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.reviews-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
    gap: 1.4rem;
    align-items: start;
}
.reviews-form-card {
    background: #fff;
    border-radius: 22px;
    padding: 1.6rem 1.5rem;
    border: 1px solid #e7e2db;
    box-shadow: 0 12px 36px rgba(42,28,20,.05);
}
.reviews-kicker { font-size: 0.78rem; font-weight: 600; color: #9a7d4e; letter-spacing: 0; text-transform: none; }
.reviews-form-title { font-size: 1.5rem; font-weight: 600; margin: 0.35rem 0 0.5rem; color: #2a1c14; }
.reviews-form-lead { font-size: 0.92rem; color: #6b5344; margin: 0 0 1.15rem; line-height: 1.65; }
.reviews-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.reviews-field { margin-bottom: 1rem; }
.reviews-field label { display: block; font-size: 0.82rem; font-weight: 600; margin-bottom: 0.4rem; color: #3f3731; }
.reviews-input, .reviews-textarea {
    width: 100%; min-height: 46px; border: 1px solid #e7e2db; border-radius: 12px;
    padding: 0.7rem 0.9rem; font-size: 0.95rem; background: #fff; color: #3f3731;
}
.reviews-textarea { resize: vertical; min-height: 130px; }
.reviews-error { display: block; color: #9a3b2f; font-size: 0.78rem; margin-top: 0.25rem; }
.reviews-moderation-note { font-size: 0.8rem; color: #7d736a; margin: 0 0 1rem; line-height: 1.5; }
.reviews-submit { width: 100%; justify-content: center; border: none; cursor: pointer; min-height: 46px; }
.reviews-list-wrap { display: grid; gap: 0.85rem; }
.reviews-list-title { font-size: 1.25rem; font-weight: 600; margin: 0 0 0.2rem; color: #2a1c14; }
.reviews-empty { color: #7d736a; font-size: 0.95rem; line-height: 1.6; }
.reviews-list { list-style: none; margin: 0; padding: 0; display: grid; gap: 0.85rem; }
.reviews-item { padding: 1.1rem 1.15rem; background: #fff; border: 1px solid #e7e2db; border-radius: 16px; }
.reviews-item__stars { margin-bottom: 0.5rem; }
.reviews-item__stars .is-on { color: #b89a6a; }
.reviews-item__stars .is-off { color: #e7e2db; }
.reviews-item__body { font-size: 0.95rem; line-height: 1.65; color: #3f3731; margin: 0 0 0.5rem; }
.reviews-item__meta { font-size: 0.82rem; font-weight: 600; color: #7d736a; }
@media (max-width: 900px) {
    .reviews-layout, .reviews-form-row { grid-template-columns: 1fr; }
}
</style>
@endsection
