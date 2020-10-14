@php
    $fieldOptions = $field->options();
@endphp
<div class="field-radio">
    @foreach ($fieldOptions as $key => $value)
        <div
            id="{{ $field->getId() }}"
            class="custom-control custom-radio custom-control-inline"
        >
            <input
                type="radio"
                id="{{ $field->getId($loop->iteration) }}"
                class="custom-control-input"
                name="{{ $field->getName() }}"
                value="{{ $key }}"
                {!! $field->value == $key ? 'checked="checked"' : '' !!}
                {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                {!! $field->getAttributes() !!}
            />
            <label
                class="custom-control-label"
                for="{{ $field->getId($loop->iteration) }}"
            >{{ is_lang_key($value) ? lang($value) : $value }}</label>
        </div>
    @endforeach
</div>
