<div class="d-inline-block border rounded py-1 px-2">
    @if($value)
        <b>{{ $value }}</b>
    @else
        {{ lang('admin::lang.reservations.text_no_table') }}
    @endif
</div>
