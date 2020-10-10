@if ($showPagination)
    <nav class="pagination-bar d-flex justify-content-end">
        @if ($showPageNumbers)
            <div class="align-self-center">
                {{ sprintf(lang('admin::lang.list.text_showing'), $records->firstItem() ?? 0, $records->lastItem() ?? 0, $records->total()) }}
            </div>
        @endif
        <div class="pl-3">
            {!! $records->render() !!}
        </div>
    </nav>
@endif
