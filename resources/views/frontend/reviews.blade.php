@extends('layouts.frontend')

@section('title', __('messages.reviews_page_title'))
@section('meta_description', __('messages.reviews_page_meta'))

@section('content')

@include('partials.frontend.page-hero', [
    'title' => __('messages.reviews_page_heading'),
    'subtitle' => __('messages.reviews_page_subtitle'),
    'eyebrow' => 'GMAC Coffee',
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
.reviews-page { padding-bottom: 4rem; }
.reviews-alert {
    max-width: 720px;
    margin: 0 auto 1.5rem;
    padding: 0.85rem 1rem;
    border-radius: 12px;
    background: rgba(45, 31, 21, 0.06);
    border: 1px solid rgba(212, 162, 74, 0.35);
    color: #2d1f15;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.reviews-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2.5rem;
    align-items: start;
    margin-top: 0.5rem;
}
@media (max-width: 980px) {
    .reviews-layout { grid-template-columns: 1fr; }
}
.reviews-form-card {
    background: #fffdf9;
    border-radius: 20px;
    padding: 1.75rem 1.5rem;
    border: 1px solid rgba(33, 22, 15, 0.08);
}
.reviews-kicker {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #9a7028;
}
.reviews-form-title {
    font-family: var(--font-display, 'Cormorant Garamond', Georgia, serif);
    font-size: 1.75rem;
    font-weight: 500;
    margin: 0.35rem 0 0.5rem;
    color: #21160f;
}
.reviews-form-lead {
    font-size: 0.95rem;
    color: rgba(33, 22, 15, 0.65);
    margin: 0 0 1.25rem;
    line-height: 1.6;
}
.reviews-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
@media (max-width: 560px) {
    .reviews-form-row { grid-template-columns: 1fr; }
}
.reviews-field { margin-bottom: 1rem; }
.reviews-field label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.35rem;
    color: #2d1f15;
}
.reviews-input, .reviews-textarea {
    width: 100%;
    border: 1px solid rgba(33, 22, 15, 0.15);
    border-radius: 10px;
    padding: 0.65rem 0.85rem;
    font-size: 0.95rem;
    background: #fff;
}
.reviews-textarea { resize: vertical; min-height: 120px; }
.reviews-error { display: block; color: #b91c1c; font-size: 0.8rem; margin-top: 0.25rem; }

.reviews-moderation-note {
    font-size: 0.8rem;
    color: rgba(33, 22, 15, 0.55);
    margin: 0 0 1rem;
    line-height: 1.5;
}
.reviews-submit {
    width: 100%;
    justify-content: center;
    border: none;
    cursor: pointer;
}

.reviews-list-wrap {
    padding: 0.5rem 0;
}
.reviews-list-title {
    font-family: var(--font-display, 'Cormorant Garamond', Georgia, serif);
    font-size: 1.35rem;
    font-weight: 500;
    margin: 0 0 1.25rem;
    color: #21160f;
}
.reviews-empty {
    color: rgba(33, 22, 15, 0.55);
    font-size: 0.95rem;
    line-height: 1.6;
}
.reviews-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.reviews-item {
    padding: 1.1rem 1.15rem;
    background: rgba(255, 253, 249, 0.9);
    border: 1px solid rgba(33, 22, 15, 0.08);
    border-radius: 14px;
}
.reviews-item__stars { margin-bottom: 0.5rem; letter-spacing: 0.1em; }
.reviews-item__stars .is-on { color: #d4a24a; }
.reviews-item__stars .is-off { color: rgba(33, 22, 15, 0.15); }
.reviews-item__body {
    font-size: 0.95rem;
    line-height: 1.65;
    color: rgba(33, 22, 15, 0.85);
    margin: 0 0 0.5rem;
}
.reviews-item__meta {
    font-size: 0.82rem;
    font-weight: 600;
    color: rgba(33, 22, 15, 0.55);
}
[data-theme="dark"] .reviews-form-card {
    background: #1b140f;
    border-color: rgba(247, 241, 231, 0.1);
}
[data-theme="dark"] .reviews-form-title,
[data-theme="dark"] .reviews-list-title { color: #f7f1e7; }
[data-theme="dark"] .reviews-input,
[data-theme="dark"] .reviews-textarea {
    background: #100c09;
    border-color: rgba(247, 241, 231, 0.12);
    color: #f7f1e7;
}
[data-theme="dark"] .reviews-item {
    background: rgba(27, 20, 15, 0.95);
    border-color: rgba(247, 241, 231, 0.08);
}
</style>
@endsection
