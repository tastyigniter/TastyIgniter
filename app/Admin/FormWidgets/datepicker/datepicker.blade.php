@if ($this->previewMode)
    <div class="form-control-static">{{ $value ? $value->format($formatAlias) : null }}</div>
@else

    <div
        id="{{ $this->getId() }}"
        class="control-datepicker"
    >
        {!! $this->makePartial('datepicker/picker_'.$mode) !!}
    </div>

@endif
