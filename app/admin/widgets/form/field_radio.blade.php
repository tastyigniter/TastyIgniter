@php
    $fieldOptions = $field->options();
@endphp
<div class="field-radio">
    @foreach ($fieldOptions as $key => $value)
        @php
            $radioLabel = is_lang_key($value) ? lang($value) : $value;
        @endphp
        <div
            id="{{ $field->getId() }}"
            @class(['form-check form-check-inline' => $radioLabel])
        >
            <input
                type="radio"
                id="{{ $field->getId($loop->iteration) }}"
                class="form-check-input"
                name="{{ $field->getName() }}"
                value="{{ $key }}"
                {!! $field->value == $key ? 'checked="checked"' : '' !!}
                {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                {!! $field->getAttributes() !!}
            />
            @if($radioLabel)
                <label
                    class="form-check-label"
                    for="{{ $field->getId($loop->iteration) }}"
                >{{ $radioLabel }}</label>
            @endif
        </div>
    @endforeach
</div>
