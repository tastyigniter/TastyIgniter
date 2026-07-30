<input
    type="time"
    data-control="clockpicker"
    name="{{ $field->getName() }}"
    id="{{ $this->getId('time') }}"
    class="form-control"
    autocomplete="off"
    value="{{ $value ? $value->format('H:i') : null }}"
    pattern="[0-9]{2}:[0-9]{2}"
    {!! $field->getAttributes() !!}
    @if($this->previewMode) readonly="readonly" @endif
/>
