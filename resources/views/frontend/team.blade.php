@extends('layouts.frontend')

@section('title', 'Team - GMAC Coffee')
@section('meta_description', 'Meet the people behind GMAC Coffee — quality, origin, and a direct line to the station.')

@section('content')
@php
    $team = collect($team ?? []);
    $stories = $stories ?? \App\Support\FrontendShowcase::teamStories();
    $contactUrl = LaravelLocalization::localizeUrl(url('/contact'));
@endphp

@include('partials.frontend.page-hero', [
    'title' => 'Our people',
    'subtitle' => 'Founder, managing director, marketing, production, and finance — the people behind every bag.',
    'eyebrow' => 'GMAC Coffee',
    'image' => \App\Support\FrontendShowcase::img('farm'),
])

<section class="tp-page">
    <div class="container">
        <nav class="tp-jump" aria-label="On this page">
            <a href="#team">The team</a>
            <a href="#origin">At origin</a>
            <a href="#reach">Reach us</a>
        </nav>

        <section class="tp-block" id="team" style="margin-top: 0;">
            <div class="tp-head">
                <p class="tp-kicker">The team</p>
                <h3>The people who keep the lots honest</h3>
                <p>From the founder and chairperson to finance — a direct line, not a distant sales desk.</p>
            </div>

            <div class="tp-lead">
                @foreach($team as $member)
                    @php
                        $initials = $member['initials'] ?? \App\Models\TeamMember::makeInitials($member['name'] ?? '');
                        $pose = $member['pose'] ?? 'face';
                    @endphp
                    <article class="tp-person">
                        <div class="tp-person__media {{ empty($member['photo']) ? 'is-avatar' : '' }}">
                            @if(!empty($member['photo']))
                                <button type="button" class="tp-person__zoom js-tp-zoom" data-src="{{ $member['photo'] }}" data-alt="{{ $member['name'] }}" aria-label="View larger portrait of {{ $member['name'] }}">
                                    <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}" class="is-{{ $pose }}">
                                </button>
                            @else
                                <span class="tp-avatar">{{ $initials }}</span>
                            @endif
                        </div>
                        <div class="tp-person__body">
                            <p class="tp-role">{{ $member['role'] }}</p>
                            <h4>{{ $member['name'] }}</h4>
                            @if(!empty($member['focus']))
                                <p class="tp-focus">{{ $member['focus'] }}</p>
                            @endif
                            @if(!empty($member['bio']))
                                <p class="tp-bio">{{ $member['bio'] }}</p>
                            @endif
                            <div class="tp-person__links">
                                @if(!empty($member['email']))
                                    <a href="mailto:{{ $member['email'] }}">{{ $member['email'] }}</a>
                                @endif
                                @if(!empty($member['phone']))
                                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $member['phone']) }}">{{ $member['phone'] }}</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach

                <article class="tp-note">
                    <p class="tp-kicker">Seasonal team</p>
                    <h4>90% women on the beds</h4>
                    <p>Harvest work at Karenge is carried by women who sort cherry, turn parchment, and keep the drying honest. They are the wider team behind every bag.</p>
                    <a href="{{ LaravelLocalization::localizeUrl(url('/history')) }}">Read the origin story</a>
                </article>
            </div>
        </section>

        <section class="tp-block" id="origin">
            <div class="tp-head">
                <p class="tp-kicker">At origin</p>
                <h3>The work you can still taste</h3>
                <p>Click a scene to read who is in it — mill, beds, and the cupping table.</p>
            </div>

            <div class="tp-stories">
                @foreach($stories as $i => $story)
                    <button type="button" class="tp-story {{ $i === 0 ? 'is-active' : '' }}" data-story="{{ $i }}">
                        <img src="{{ $story['image'] }}" alt="{{ $story['title'] }}">
                        <span class="tp-story__veil">
                            <em>{{ $story['kicker'] }}</em>
                            <strong>{{ $story['title'] }}</strong>
                        </span>
                    </button>
                @endforeach
            </div>
            <div class="tp-story-panel" id="tp-story-panel">
                @foreach($stories as $i => $story)
                    <p class="{{ $i === 0 ? 'is-on' : '' }}" data-story-text="{{ $i }}">
                        <strong>{{ $story['title'] }}.</strong>
                        {{ $story['text'] }}
                    </p>
                @endforeach
            </div>
        </section>

        <section class="tp-values">
            <article>
                <strong>01</strong>
                <h3>Quality first</h3>
                <p>Cupping, moisture checks, and lot notes stay attached from the bed to the bag.</p>
            </article>
            <article>
                <strong>02</strong>
                <h3>Farmers at the centre</h3>
                <p>Partner hills and women producers keep the harvest honest — and keep the story true.</p>
            </article>
            <article>
                <strong>03</strong>
                <h3>A direct line</h3>
                <p>Buyers talk to the people who process the coffee. Write to us and the team replies.</p>
            </article>
        </section>

    </div>

    <section class="tp-reach" id="reach">
        <div class="container tp-reach__inner">
            <div>
                <p class="tp-kicker">Reach us</p>
                <h3>Talk to the people who process the coffee</h3>
                <p>Wholesale, samples, export, or a visit to Karenge — the same address reaches the GMAC team.</p>
            </div>
            <div class="tp-reach__actions">
                <a href="mailto:info@gmac.coffee" class="tp-btn">info@gmac.coffee</a>
                <a href="tel:+250783053415" class="tp-btn tp-btn--ghost">+250 783 053 415</a>
                <a href="{{ $contactUrl }}" class="tp-btn tp-btn--ghost">Contact form</a>
            </div>
        </div>
    </section>
</section>

<div class="tp-lightbox" id="tp-lightbox" hidden>
    <button type="button" class="tp-lightbox__close" aria-label="Close portrait">×</button>
    <img src="" alt="">
</div>
@endsection

@push('styles')
<style>
.ph-hero { min-height: 460px !important; }
.ph-hero__bg { object-position: 50% 62% !important; }

.tp-page {
    padding: 1.6rem 0 0;
    background: #f5f3f0;
    word-spacing: normal;
}
.tp-page p,
.tp-page h2,
.tp-page h3,
.tp-page h4,
.tp-page a,
.tp-page button,
.tp-page dd,
.tp-page dt {
    word-spacing: normal;
}

.tp-jump {
    display: flex;
    flex-wrap: wrap;
    gap: 0.45rem;
    margin: 0 0 1.4rem;
}
.tp-jump a {
    display: inline-flex;
    align-items: center;
    min-height: 36px;
    padding: 0 0.9rem;
    border-radius: 999px;
    border: 1px solid #e7e2db;
    background: #fff;
    color: #5c4a3c;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
}
.tp-jump a:hover { border-color: #7a6452; color: #2a1c14; }

.tp-kicker {
    margin: 0 0 0.4rem;
    color: #9a7d4e;
    font-size: 0.74rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.tp-founder,
.tp-block,
.tp-reach { scroll-margin-top: 110px; }
#team { scroll-margin-top: 110px; }

.tp-founder {
    display: grid;
    grid-template-columns: minmax(280px, 0.92fr) minmax(0, 1.08fr);
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(42, 28, 20, 0.07);
}
.tp-founder__media {
    position: relative;
    min-height: 520px;
    padding: 0;
    border: 0;
    background: #efe8df;
    cursor: zoom-in;
}
.tp-founder__media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center 16%;
    display: block;
    border-radius: 0 !important;
}
.tp-founder__media.is-avatar,
.tp-person__media.is-avatar {
    display: grid;
    place-items: center;
    background: linear-gradient(160deg, #8d7560 0%, #3d2e24 100%);
    cursor: default;
}
.tp-avatar {
    width: 96px;
    height: 96px;
    border-radius: 999px;
    display: grid;
    place-items: center;
    background: rgba(245, 243, 240, 0.12);
    border: 1px solid rgba(228, 201, 138, 0.38);
    color: #f5f3f0;
    font-family: Fraunces, serif;
    font-size: 1.85rem;
    font-weight: 500;
    letter-spacing: 0.04em;
}
.tp-avatar--lg {
    width: 140px;
    height: 140px;
    font-size: 2.6rem;
}
.tp-founder__hint {
    position: absolute;
    left: 1rem;
    bottom: 1rem;
    padding: 0.35rem 0.7rem;
    border-radius: 999px;
    background: rgba(42, 28, 20, 0.62);
    color: #fff;
    font-size: 0.72rem;
    font-weight: 500;
}
.tp-founder__content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 2.2rem 2.4rem 2.4rem;
}
.tp-founder__name {
    margin: 0 0 0.55rem;
    font-size: clamp(2.1rem, 4vw, 3rem);
    line-height: 1.08;
    color: #2a1c14;
}
.tp-role {
    display: inline-flex;
    align-self: flex-start;
    margin: 0 0 1rem;
    padding: 0.35rem 0.75rem;
    border-radius: 999px;
    background: #efe8df;
    color: #5c4a3c;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
.tp-quote {
    margin: 0 0 1rem;
    max-width: 36ch;
    color: #3f3731;
    font-family: Fraunces, serif;
    font-size: 1.25rem;
    line-height: 1.4;
    font-style: italic;
}
.tp-bio {
    margin: 0 0 1.15rem;
    max-width: 48ch;
    color: #6b5344;
    line-height: 1.75;
}

.tp-facts {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0.75rem;
    margin: 0 0 1.2rem;
}
.tp-facts div {
    padding: 0.7rem 0.15rem 0.15rem 0;
    border-top: 1px solid #eee6dc;
}
.tp-facts dt {
    font-family: Fraunces, serif;
    font-size: 1.25rem;
    color: #2a1c14;
    font-weight: 500;
}
.tp-facts dd {
    margin: 0.15rem 0 0;
    color: #7d736a;
    font-size: 0.78rem;
}

.tp-chips { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.15rem; }
.tp-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.55rem 0.85rem;
    border-radius: 999px;
    border: 1px solid #e7e2db;
    background: #f5f3f0;
    color: #3f3731;
    font-size: 0.82rem;
    font-weight: 500;
    cursor: pointer;
    font-family: inherit;
}
.tp-chip i { color: #9a7d4e; }
.tp-chip:hover,
.tp-chip.is-copied { border-color: #7a6452; color: #2a1c14; }

.tp-founder__actions,
.tp-reach__actions { display: flex; flex-wrap: wrap; gap: 0.55rem; }
.tp-btn {
    display: inline-flex;
    align-items: center;
    min-height: 42px;
    padding: 0 1.15rem;
    border-radius: 999px;
    background: #7a6452;
    color: #fff;
    font-size: 0.86rem;
    font-weight: 500;
    text-decoration: none;
}
.tp-btn:hover { background: #8d7560; color: #fff; }
.tp-btn--ghost {
    background: #fff;
    color: #5c4a3c;
    border: 1px solid #e7e2db;
}
.tp-btn--ghost:hover { border-color: #7a6452; color: #2a1c14; background: #fff; }

.tp-block { margin-top: 2.6rem; }
.tp-head { max-width: 40rem; margin-bottom: 1.15rem; }
.tp-head h3 { margin: 0 0 0.4rem; font-size: clamp(1.6rem, 3vw, 2.1rem); color: #2a1c14; }
.tp-head p:last-child { margin: 0; color: #6b5344; line-height: 1.65; }

.tp-lead {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
}
.tp-person,
.tp-note {
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 18px;
    overflow: hidden;
}
.tp-person__media {
    position: relative;
    height: 320px;
    background: #f5f3f0;
}
.tp-person__zoom {
    display: block;
    width: 100%;
    height: 100%;
    padding: 0;
    border: 0;
    background: transparent;
    cursor: zoom-in;
}
.tp-person__media img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    display: block;
    background: #f5f3f0;
}
.tp-person__media img.is-face,
.tp-person__media img.is-body {
    object-fit: contain;
    object-position: center top;
    padding: 0.6rem 0.6rem 0;
}
.tp-person__wash { opacity: 0.38; }
.tp-mono {
    position: absolute;
    inset: 0;
    display: grid;
    place-items: center;
    font-family: Fraunces, serif;
    font-size: 2.4rem;
    color: #f5f3f0;
}
.tp-person__body,
.tp-note { padding: 1.2rem 1.25rem 1.35rem; }
.tp-person__body h4,
.tp-note h4 { margin: 0 0 0.4rem; font-size: 1.35rem; color: #2a1c14; }
.tp-focus { margin: 0 0 0.55rem; color: #9a7d4e; font-size: 0.86rem; }
.tp-person__links { display: grid; gap: 0.2rem; }
.tp-person__links a { color: #7a6452; font-size: 0.82rem; font-weight: 600; text-decoration: none; }
.tp-note { display: flex; flex-direction: column; justify-content: center; min-height: 100%; }
.tp-note a { color: #7a6452; font-weight: 600; text-decoration: none; margin-top: 0.6rem; }

.tp-stories {
    display: grid;
    grid-template-columns: 1.3fr 0.85fr 0.85fr;
    gap: 0.75rem;
}
.tp-story {
    position: relative;
    min-height: 260px;
    padding: 0;
    border: 0;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    background: #3d2e24;
}
.tp-story img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .45s ease;
}
.tp-story:hover img,
.tp-story.is-active img { transform: scale(1.04); }
.tp-story__veil {
    position: absolute;
    inset: auto 0 0;
    padding: 2.2rem 1rem 1rem;
    background: linear-gradient(180deg, transparent, rgba(28,18,12,0.82));
    color: #fff;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}
.tp-story__veil em {
    font-style: normal;
    font-size: 0.7rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #e4c98a;
}
.tp-story__veil strong { font-family: Fraunces, serif; font-size: 1.15rem; font-weight: 500; }
.tp-story.is-active { outline: 2px solid #b89a6a; outline-offset: 2px; }

.tp-story-panel {
    margin-top: 0.9rem;
    padding: 1.05rem 1.2rem;
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 16px;
}
.tp-story-panel p { display: none; margin: 0; color: #6b5344; line-height: 1.7; }
.tp-story-panel p.is-on { display: block; }
.tp-story-panel strong { color: #2a1c14; }

.tp-values {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    margin-top: 1.4rem;
}
.tp-values article {
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 18px;
    padding: 1.2rem 1.25rem 1.3rem;
}
.tp-values strong {
    display: block;
    color: #9a7d4e;
    font-family: Fraunces, serif;
    margin-bottom: 0.4rem;
}
.tp-values h3 { margin: 0 0 0.4rem; font-size: 1.1rem; color: #2a1c14; }
.tp-values p { margin: 0; color: #6b5344; line-height: 1.65; font-size: 0.92rem; }

.tp-reach {
    margin: 2rem 0 0;
    padding: 1.8rem 0 2rem;
    background: #efe8df;
    color: #6b5344;
    border-top: 1px solid #e7e2db;
}
.tp-reach,
.tp-reach h3,
.tp-reach p,
.tp-reach a {
    word-spacing: 0.06em;
}
.tp-reach__inner {
    display: flex;
    justify-content: space-between;
    gap: 1.5rem;
    align-items: center;
}
.tp-reach .tp-kicker { color: #9a7d4e; }
.tp-reach h3 {
    margin: 0 0 0.4rem;
    color: #2a1c14;
    font-size: 1.6rem;
    letter-spacing: 0;
}
.tp-reach p { margin: 0; max-width: 42ch; line-height: 1.65; }
.tp-reach .tp-btn { background: #7a6452; color: #fff; }
.tp-reach .tp-btn--ghost { background: #fff; color: #5c4a3c; border-color: #e7e2db; }

.tp-lightbox {
    position: fixed;
    inset: 0;
    z-index: 2400;
    display: grid;
    place-items: center;
    background: rgba(28, 18, 12, 0.84);
    padding: 6.5rem 2rem 2rem;
}
.tp-lightbox[hidden] { display: none; }
.tp-lightbox img {
    max-width: min(920px, 92vw);
    max-height: 86vh;
    width: auto;
    height: auto;
    border-radius: 18px;
    object-fit: contain;
    background: #f5f3f0;
}
.tp-lightbox__close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 42px;
    height: 42px;
    border: 0;
    border-radius: 999px;
    background: #fff;
    color: #2a1c14;
    font-size: 1.6rem;
    cursor: pointer;
}

@media (max-width: 1100px) {
    .tp-lead { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (max-width: 900px) {
    .tp-founder,
    .tp-lead,
    .tp-stories,
    .tp-values,
    .tp-facts { grid-template-columns: 1fr; }
    .tp-founder__media { min-height: 340px; }
    .tp-founder__content { padding: 1.5rem 1.2rem 1.7rem; }
    .tp-reach__inner { flex-direction: column; align-items: flex-start; }
    .tp-story { min-height: 210px; }
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    var lightbox = document.getElementById('tp-lightbox');
    var lightImg = lightbox ? lightbox.querySelector('img') : null;

    document.querySelectorAll('.js-tp-zoom').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!lightbox || !lightImg) return;
            lightImg.src = btn.getAttribute('data-src');
            lightImg.alt = btn.getAttribute('data-alt') || '';
            lightbox.hidden = false;
        });
    });
    if (lightbox) {
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox || e.target.classList.contains('tp-lightbox__close')) {
                lightbox.hidden = true;
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') lightbox.hidden = true;
        });
    }

    document.querySelectorAll('.js-tp-copy').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var value = btn.getAttribute('data-copy') || '';
            var done = function () {
                btn.classList.add('is-copied');
                var label = btn.querySelector('span');
                var prev = label ? label.textContent : '';
                if (label) label.textContent = 'Copied';
                setTimeout(function () {
                    btn.classList.remove('is-copied');
                    if (label) label.textContent = prev;
                }, 1400);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(value).then(done).catch(done);
            } else {
                done();
            }
        });
    });

    var stories = document.querySelectorAll('.tp-story');
    var texts = document.querySelectorAll('[data-story-text]');
    stories.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-story');
            stories.forEach(function (el) { el.classList.toggle('is-active', el === btn); });
            texts.forEach(function (el) {
                el.classList.toggle('is-on', el.getAttribute('data-story-text') === id);
            });
        });
    });
})();
</script>
@endpush
