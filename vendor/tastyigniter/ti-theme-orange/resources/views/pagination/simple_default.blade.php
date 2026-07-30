@if ($paginator->hasPages())
    <ul class="pagination d-flex justify-content-between">
        @if ($paginator->onFirstPage())
            <li class="disabled"><a href="#"><span>@lang('pagination.previous')</span></a></li>
        @else
            <li>
                <a
                    href="{{ url($paginator->previousPageUrl()) }}"
                    rel="prev"
                >@lang('pagination.previous')</a>
            </li>
        @endif

        @if ($paginator->hasMorePages())
            <li>
                <a
                    href="{{ url($paginator->nextPageUrl()) }}"
                    rel="next"
                >@lang('pagination.next')</a>
            </li>
        @else
            <li class="disabled"><span>@lang('pagination.next')</span></li>
        @endif
    </ul>
@endif
