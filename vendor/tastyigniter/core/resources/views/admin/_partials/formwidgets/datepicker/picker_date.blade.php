<div class="input-group">
    <input
        type="date"
        id="{{ $this->getId('date') }}"
        class="form-control datepicker-input"
        name="{{ $field->getName() }}"
        value="{{ $value ? $value->format('Y-m-d') : null }}"
        data-control="datepicker"
        data-datepicker-value
        @if($startDate) min="{{ $startDate }}" @endif
        @if($endDate) max="{{ $endDate }}" @endif
        autocomplete="off"
        pattern="\d{4}-\d{2}-\d{2}"
        {!! $field->getAttributes() !!}
        {!! $this->previewMode ? 'readonly="readonly"' : '' !!}
    />
</div>
