<div
    id="{{ $tableId }}"
    data-control="table"
    class="control-table"
    data-columns='@json($columns)'
    data-data="{{$data}}"
    data-data-field="{{$recordsKeyFrom}}"
    data-alias="{{$tableAlias}}"
    data-field-name="{{$tableAlias}}"
    data-height="{{$height}}"
    data-dynamic-height="{{$dynamicHeight}}"
    data-page-size="{{$pageLimit}}"
    data-pagination="{{$showPagination}}"
></div>
