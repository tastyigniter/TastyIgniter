@php
    $fieldOptions = $field->options();
@endphp
<div class="field-radio">
    @if ($fieldCount = count($fieldOptions))
        <div
            id="{{ $field->getId() }}"
            class="btn-group btn-group-toggle bg-light"
        >
            @foreach ($fieldOptions as $key => $value)
                <input
                    type="radio"
                    id="{{ $field->getId($loop->iteration) }}"
                    class="btn-check"
                    name="{{ $field->getName() }}"
                    value="{{ $key }}"
                    {!! $field->value == $key ? 'checked="checked"' : '' !!}
                    {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                    {!! $field->getAttributes() !!}
                />
                <label
                    for="{{ $field->getId($loop->iteration) }}"
                    class="btn btn-light text-nowrap {{ $this->previewMode ? 'disabled' : '' }}"
                >{{ is_lang_key($value) ? lang($value) : $value }}</label>
            @endforeach
        </div>
    @endif
</div>
