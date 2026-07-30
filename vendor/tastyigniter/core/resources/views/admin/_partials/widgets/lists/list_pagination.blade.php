@if ($showPagination)
    <div class="pagination-bar d-flex flex-column flex-md-row justify-content-end">
        @if ($showPageNumbers)
            <div class="align-self-center order-last order-md-first text-end w-100 p-2">
                {{ sprintf(lang('igniter::admin.list.text_showing'), $records->firstItem() ?? 0, $records->lastItem() ?? 0, $records->total()) }}
            </div>
        @endif
        <div class="pl-3">
            {!! $records->render() !!}
        </div>
    </div>
@endif
