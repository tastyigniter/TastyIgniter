@php
    $fieldOptions = $field->options();
    $checkedValues = (array)$field->value;
@endphp

<div class="field-checkbox">
    @if($this->previewMode && $field->value)
        <div
            id="{{ $field->getId() }}"
            class="btn-group btn-group-toggle"
        >
            @foreach($fieldOptions as $value => $option)
                @php
                    $checkboxId = 'checkbox_'.$field->getId().'_'.$loop->iteration;
                    if (is_string($option)) $option = [$option];
                @endphp
                <input
                    type="checkbox"
                    id="{{ $checkboxId }}"
                    class="btn-check"
                    name="{{ $field->getName() }}[]"
                    value="{{ $value }}"
                    {!! in_array($value, $checkedValues) ? 'checked="checked"' : '' !!}
                    disabled="disabled"
                />
                <label
                    for="{{ $checkboxId }}"
                    class="btn btn-white text-nowrap"
                >{{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}</label>
            @endforeach
        </div>
    @elseif (!$this->previewMode && count($fieldOptions))
        <div
            id="{{ $field->getId() }}"
            class="btn-group btn-group-toggle"
        >
            @foreach($fieldOptions as $value => $option)
                @php
                    $checkboxId = 'checkbox_'.$field->getId().'_'.$loop->iteration;
                    if (is_string($option)) $option = [$option];
                @endphp
                <input
                    type="checkbox"
                    id="{{ $checkboxId }}"
                    class="btn-check"
                    name="{{ $field->getName() }}[]"
                    value="{{ $value }}"
                    {!! in_array($value, $checkedValues) ? 'checked="checked"' : '' !!}
                    {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                    {!! $field->getAttributes() !!}
                />
                <label
                    for="{{ $checkboxId }}"
                    class="btn btn-white text-nowrap"
                >{{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}</label>
            @endforeach
        </div>
    @endif
</div>
