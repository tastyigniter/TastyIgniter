@php
    $fieldOptions = $field->options();
    $checkedValues = (array)$field->value;
@endphp
<div class="field-checkbox">
    @forelse($fieldOptions as $value => $option)
        @php
            $checkboxId = 'checkbox_'.$field->getId().'_'.$loop->iteration;
            if (is_string($option)) $option = [$option];
        @endphp
        <div
            id="{{ $field->getId() }}"
            class="custom-control custom-radio custom-control-inline"
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
            <label
                class="form-check-label"
                for="{{ $checkboxId }}"
            >{{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}</label>
        </div>
    @empty

        <input
            type="hidden"
            name="{{ $field->getName() }}"
            value="0"
            {!! $this->previewMode ? 'disabled="disabled"' : '' !!}>

        <div class="form-check" tabindex="0">
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
            <label class="form-check-label" for="{{ $field->getId() }}">
                @if ($field->placeholder) @lang($field->placeholder) @else &nbsp; @endif
            </label>
        </div>
    @endforelse
</div>
