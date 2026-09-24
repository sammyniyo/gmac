@if ($paginator->hasPages())
    <nav class="g-pager" role="navigation" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="g-pager__btn is-disabled" aria-disabled="true">Previous</span>
        @else
            <a class="g-pager__btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="g-pager__btn is-gap" aria-hidden="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="g-pager__btn is-current" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="g-pager__btn" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="g-pager__btn" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        @else
            <span class="g-pager__btn is-disabled" aria-disabled="true">Next</span>
        @endif
    </nav>
@endif
