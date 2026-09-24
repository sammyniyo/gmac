@php $current = $current ?? 1; @endphp
<ol class="bag-steps" aria-label="Order request steps">
    <li class="{{ $current === 1 ? 'is-on' : ($current > 1 ? 'is-done' : '') }}">
        @if($current > 1)
            <a href="{{ route('cart.index') }}"><strong>1</strong><span>Bag</span></a>
        @else
            <span><strong>1</strong><span>Bag</span></span>
        @endif
    </li>
    <li class="{{ $current === 2 ? 'is-on' : ($current > 2 ? 'is-done' : '') }}">
        @if($current === 1 && !empty($canCheckout))
            <a href="{{ route('checkout') }}"><strong>2</strong><span>Details</span></a>
        @else
            <span><strong>2</strong><span>Details</span></span>
        @endif
    </li>
    <li class="{{ $current === 3 ? 'is-on' : '' }}">
        <span><strong>3</strong><span>We reply</span></span>
    </li>
</ol>
<style>
.bag-steps {
    display: flex;
    flex-wrap: wrap;
    gap: 0.45rem;
    list-style: none;
    margin: 0 0 1.4rem;
    padding: 0;
}
.bag-steps li > * {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    min-height: 46px;
    padding: 0 0.85rem;
    border-radius: 999px;
    background: #fff;
    border: 1px solid #e7e2db;
    color: #7d736a;
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 500;
}
.bag-steps strong {
    width: 22px;
    height: 22px;
    display: grid;
    place-items: center;
    border-radius: 999px;
    background: #efe8df;
    color: #5c4a3c;
    font-size: 0.72rem;
}
.bag-steps .is-on > * { border-color: #7a6452; color: #2a1c14; background: #fff; }
.bag-steps .is-on strong,
.bag-steps .is-done strong { background: #7a6452; color: #fff; }
.bag-steps .is-done > * { color: #5c4a3c; }
@media (max-width: 640px) {
    .bag-steps li span span { display: none; }
    .bag-steps li > * { justify-content: center; padding: 0 0.5rem; }
}
</style>
