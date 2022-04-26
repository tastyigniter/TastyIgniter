@php
    $on = $field->config['on'] ?? 'admin::lang.text_enabled';
    $off = $field->config['off'] ?? 'admin::lang.text_disabled';
    $onColor = $field->config['onColor'] ?? 'success';
    $offColor = $field->config['offColor'] ?? 'danger';
    $labelWith = $field->config['labelWith'] ?? '120';
@endphp
<input
    type="hidden"
    name="{{ $field->getName() }}"
    value="0"
    {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
/>

<div class="field-custom-container">
    <div class="form-check form-switch">
        <input
            type="checkbox"
            name="{{ $field->getName() }}"
            id="{{ $field->getId() }}"
            class="form-check-input"
            value="1"
            role="switch"
            {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
            {!! $field->value == 1 ? 'checked="checked"' : '' !!}
            {!! $field->getAttributes() !!}
        />
        <label
            class="form-check-label"
            for="{{ $field->getId() }}"
        >@lang($off)/@lang($on)</label>
    </div>
</div>
