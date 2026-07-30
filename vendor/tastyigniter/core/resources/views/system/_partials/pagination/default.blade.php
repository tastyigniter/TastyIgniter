@if ($paginator->hasPages())
    <ul class="pagination">
        <li class="page-item{{ $paginator->onFirstPage() ? ' disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
        </li>

        @foreach($elements as $element)
            @if(is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
@endif
