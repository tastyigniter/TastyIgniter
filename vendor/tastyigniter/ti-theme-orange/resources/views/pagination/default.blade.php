@if ($paginator->hasPages())
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">«</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ url($paginator->previousPageUrl()) }}" rel="prev">«</a></li>
        @endif

        @for ($page = 1; $page <= $paginator->lastPage(); $page++)
            @if (is_string($page))
                <li class="page-item disabled"><span class="page-link">{!! $page !!}</span></li>
            @endif

            @if ($page == $paginator->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ current_url().'?page='.$page }}">{{ $page }}</a>
                </li>
            @endif
        @endfor

        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ url($paginator->nextPageUrl()) }}" rel="next">»</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">»</span></li>
        @endif
    </ul>
@endif