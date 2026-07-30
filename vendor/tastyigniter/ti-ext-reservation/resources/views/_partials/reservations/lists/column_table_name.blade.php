<div class="d-inline-block border rounded py-1 px-2 text-wrap">
        @if($value)
                <b>{{ $value }}</b>
        @else
                {{ lang('igniter.reservation::default.text_no_table') }}
        @endif
</div>
