@php $fieldValue = sprintf('%s (%s)', $formModel->customer_name, $formModel->email) @endphp
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
