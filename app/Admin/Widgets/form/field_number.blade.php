@if ($this->previewMode)
    <p class="form-control-static">{{ $field->value ? e($field->value) : '0' }}</p>
@else
    <input
        type="number"
        name="{{ $field->getName() }}"
        id="{{ $field->getId() }}"
        value="{{ $field->value }}"
        placeholder="{{ $field->placeholder }}"
        class="form-control"
        autocomplete="off"
        {!! $field->hasAttribute('pattern') ? '' : 'pattern="-?\d+(\.\d+)?"' !!}
        {!! $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' !!}
        {!! $field->getAttributes() !!}
    />
@endif
