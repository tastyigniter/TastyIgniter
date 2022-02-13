<input
    type="hidden"
    name="{{ $field->getName() }}"
    id="{{ $field->getId() }}"
    value="{{ $field->value }}"
    placeholder="{{ $field->placeholder }}"
    autocomplete="off"
    {!! $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' !!}
    {!! $field->getAttributes() !!}
/>
