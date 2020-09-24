@php
$location = $formModel->location;
$fieldValue = sprintf('%s (%s)', $location->location_name, format_address($location->getAddress(), false));
@endphp
@if($this->previewMode)
    <p class="form-control-static">{{ $fieldValue ?: '&nbsp;' }}</p>
@else
    <input
        type="text"
        name="{{ $field->getName() }}"
        id="{{ $field->getId() }}"
        value="{{ $fieldValue }}"
        placeholder="{{ $field->placeholder }}"
        class="form-control"
        autocomplete="off"
        {!! $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' !!}
        {!! $field->getAttributes() !!}
    />
@endif
