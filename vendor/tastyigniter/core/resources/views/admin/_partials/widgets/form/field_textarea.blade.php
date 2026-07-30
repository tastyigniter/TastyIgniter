<textarea
    name="{{ $field->getName() }}"
    id="{{ $field->getId() }}"
    autocomplete="off"
    class="form-control field-textarea"
    placeholder="{{ $field->placeholder }}"
    {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
    {!! $field->getAttributes() !!}
>{{ $field->value }}</textarea>
