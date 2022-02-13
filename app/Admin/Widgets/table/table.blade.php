<div
    id="{{ $tableId }}"
    data-control="table"
    class="control-table"
    data-columns='@json($columns)'
    data-alias="{{$tableAlias}}"
    data-data="{{$data}}"
    data-data-field="{{$recordsKeyFrom}}"
    data-dynamic-height="{{$dynamicHeight}}"
    data-field-name="{{$tableAlias}}"
    data-height="{{$height}}"
    data-page-size="{{$pageLimit}}"
    data-pagination="{{$showPagination ? 'true' : 'false'}}"
    data-use-ajax="{{$useAjax ? 'true' : 'false'}}"
    {!! $this->getAttributes() !!}
></div>
