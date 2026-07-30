@php
    $fieldOptions = $field->options();
    $checkedValues = (array)$field->value;
@endphp
<div class="field-checkbox">
    @forelse($fieldOptions as $value => $option)
        @php
            $checkboxId = 'checkbox_'.$field->getId().'_'.$loop->iteration;
            if (is_string($option)) $option = [$option];
            $checkboxLabel = is_lang_key($option[0]) ? lang($option[0]) : $option[0];
        @endphp
        <div
            id="{{ $field->getId() }}"
            @class(['form-check form-check-inline' => $checkboxLabel])
        >
            <input
                type="checkbox"
                id="{{ $checkboxId }}"
                class="form-check-input"
                name="{{ $field->getName() }}[]"
                value="{{ $value }}"
                {!! in_array($value, $checkedValues) ? 'checked="checked"' : '' !!}
                {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                {!! $field->getAttributes() !!}
            />
            @if($checkboxLabel)
                <label
                    class="form-check-label"
                    for="{{ $checkboxId }}"
                >{{ $checkboxLabel }}</label>
            @endif
        </div>
    @empty

        <input
            type="hidden"
            name="{{ $field->getName() }}"
            value="0"
            {!! $this->previewMode ? 'disabled="disabled"' : '' !!}>

        <div
            @class(['form-check form-check-inline' => $field->placeholder])
            class="form-check"
        >
            <input
                type="checkbox"
                class="form-check-input"
                id="{{ $field->getId() }}"
                name="{{ $field->getName() }}"
                value="1"
                {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                {!! $field->value == 1 ? 'checked="checked"' : '' !!}
                {!! $field->getAttributes() !!}
            />
            @if($field->placeholder)
                <label class="form-check-label" for="{{ $field->getId() }}">@lang($field->placeholder)</label>
            @endif
        </div>
    @endforelse
</div>
