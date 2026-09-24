@extends('layouts.frontend')

@section('title', 'Our Coffee Collection - GMAC Coffee')
@section('meta_description', 'Browse our premium selection of Rwandan green and roasted coffee beans. Sustainably sourced and expertly processed.')

@section('content')
@include('partials.frontend.page-hero', [
    'title' => __('messages.products'),
    'subtitle' => 'Official roasted bags with GS1 barcodes — packed in Kigali, priced in Rwandan francs.',
    'eyebrow' => 'GMAC Coffee',
    'image' => \App\Support\FrontendShowcase::img('pack_green'),
])

<section class="pc-page">
    <div class="container">
        <div class="pc-toolbar">
            <p class="pc-count">{{ $products->count() }} {{ __('messages.products') }}</p>
            <div class="pc-filters" role="group" aria-label="Filter by category">
                <button type="button" class="pc-chip is-active" data-category="all">{{ __('messages.all_products') }}</button>
                @foreach($categories as $category)
                    <button type="button" class="pc-chip" data-category="cat-{{ $category->id }}">{{ $category->name }}</button>
                @endforeach
            </div>
        </div>

        <div class="pc-grid" id="pc-grid">
            @forelse($products as $product)
                <article class="pc-card filter-item cat-{{ $product->product_category_id }}">
                    <a href="{{ route('products.show', $product->slug) }}" class="pc-card__media">
                        <img src="{{ $product->displayImage() }}" alt="{{ $product->name }}" loading="lazy" class="{{ $product->usesPackShot() ? 'is-pack' : '' }}">
                        <span class="pc-card__size">{{ $product->packSize() }}</span>
                    </a>
                    <div class="pc-card__body">
                        <div class="pc-card__meta">
                            <span class="pc-card__swatch is-{{ $product->packColor() }}" aria-hidden="true"></span>
                            <span>{{ $product->packColorLabel() }}</span>
                            @if($product->packRoast())
                                <span class="pc-card__sep" aria-hidden="true"></span>
                                <span>{{ $product->packRoast() }}</span>
                            @endif
                        </div>
                        <h3 class="pc-card__name">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        @if($product->barcode)
                            <p class="g-barcode">{{ $product->barcode }}</p>
                        @endif
                        <div class="pc-card__foot">
                            @if($product->price)
                                <span class="pc-card__price">{{ $product->formattedPrice() }}</span>
                            @else
                                <span class="pc-card__price pc-card__price--soft">{{ __('messages.price_on_request') }}</span>
                            @endif
                            <div class="pc-card__actions">
                                <form action="{{ route('cart.add', $product->slug) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="pc-add">{{ __('messages.add_to_cart') }}</button>
                                </form>
                                <a href="{{ route('products.show', $product->slug) }}" class="pc-more">{{ __('messages.details') }}</a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="pc-empty">
                    <i class="fa-solid fa-mug-hot" aria-hidden="true"></i>
                    <p>No products found at the moment. Please check back later.</p>
                    <a href="{{ LaravelLocalization::localizeUrl(url('/contact')) }}" class="pc-add">{{ __('messages.contact') }}</a>
                </div>
            @endforelse
        </div>

        <p class="pc-none" id="pc-none" hidden>No products in this category.</p>
    </div>
</section>
@endsection

@push('scripts')
<style>
.pc-page { padding: 2.25rem 0 4.5rem; background: #f5f3f0; }
.pc-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1.6rem;
}
.pc-count { margin: 0; color: #7d736a; font-size: 0.88rem; }
.pc-filters { display: flex; flex-wrap: wrap; gap: 0.45rem; }
.pc-chip {
    border: 1px solid #e7e2db;
    background: #fff;
    color: #7d736a;
    border-radius: 999px;
    padding: 0.45rem 0.9rem;
    font: 500 0.8rem/1 Poppins, sans-serif;
    cursor: pointer;
}
.pc-chip:hover { color: #3f3731; border-color: #d8cfc4; }
.pc-chip.is-active { background: #efe8df; color: #5c4a3c; border-color: transparent; }

.pc-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.15rem;
}
.pc-card {
    background: #fff;
    border: 1px solid #e7e2db;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.pc-card__media { display: block; position: relative; background: #f7f4f0; }
.pc-card__media img,
.pc-card__ph { width: 100%; height: 220px; object-fit: cover; display: block; }
.pc-card__ph { display: flex; align-items: center; justify-content: center; color: #b89a6a; font-size: 2rem; }
.pc-card__size {
    position: absolute; top: 12px; left: 12px;
    background: #fff; color: #5c4a3c; border: 1px solid #e7e2db;
    border-radius: 999px; padding: 0.28rem 0.65rem;
    font-size: 0.7rem; font-weight: 600;
}
.pc-card__body { padding: 1.1rem 1.15rem 1.2rem; display: flex; flex-direction: column; flex: 1; }
.pc-card__meta { display: flex; align-items: center; flex-wrap: wrap; gap: 0.4rem; color: #7a6452; font-size: 0.74rem; font-weight: 600; }
.pc-card__swatch { width: 12px; height: 12px; border-radius: 999px; border: 1px solid rgba(63,55,49,.12); }
.pc-card__swatch.is-red { background: #c0392b; }
.pc-card__swatch.is-chocolate { background: #c4a574; }
.pc-card__swatch.is-green { background: #2f7a4a; }
.pc-card__sep { width: 3px; height: 3px; border-radius: 999px; background: #c9bfb4; }
.pc-card__name { margin: 0.45rem 0 0.4rem; font-size: 1.15rem; }
.pc-card__name a { color: #3f3731; text-decoration: none; }
.pc-card__foot { margin-top: auto; display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap; }
.pc-card__price { font-weight: 600; color: #3f3731; }
.pc-card__price--soft { color: #9a7d4e; font-size: 0.85rem; }
.pc-card__actions { display: flex; align-items: center; gap: 0.55rem; }
.pc-add {
    border: 0;
    background: #7a6452;
    color: #fff;
    border-radius: 999px;
    padding: 0.5rem 0.9rem;
    font: 500 0.78rem/1 Poppins, sans-serif;
    cursor: pointer;
    text-decoration: none;
}
.pc-add:hover { background: #8d7560; }
.pc-more { color: #7a6452; font-size: 0.8rem; font-weight: 600; text-decoration: none; }
.pc-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem 1rem;
    color: #7d736a;
}
.pc-empty i { font-size: 1.6rem; color: #b89a6a; display: block; margin-bottom: 0.7rem; }
.pc-none { text-align: center; color: #7d736a; margin: 1.5rem 0 0; }

@media (max-width: 900px) { .pc-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 640px) { .pc-grid { grid-template-columns: 1fr; } }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var chips = document.querySelectorAll('.pc-chip');
    var items = document.querySelectorAll('#pc-grid .filter-item');
    var empty = document.getElementById('pc-none');
    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            chips.forEach(function (c) { c.classList.remove('is-active'); });
            chip.classList.add('is-active');
            var cat = chip.getAttribute('data-category');
            var shown = 0;
            items.forEach(function (item) {
                var on = cat === 'all' || item.classList.contains(cat);
                item.style.display = on ? '' : 'none';
                if (on) shown++;
            });
            if (empty) empty.hidden = items.length === 0 || shown !== 0;
        });
    });
});
</script>
@endpush
