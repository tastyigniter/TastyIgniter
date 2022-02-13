@php
    $fieldOptions = $field->options();
@endphp
<div class="field-radio">
    @if ($fieldCount = count($fieldOptions))
        <div
            id="{{ $field->getId() }}"
            class="btn-group btn-group-toggle bg-light"
            data-toggle="buttons">
            @foreach ($fieldOptions as $key => $value)
                <label
                    class="btn btn-light text-nowrap {{ ($field->value == $key ? 'active' : '').($this->previewMode ? 'disabled' : '') }}">
                    <input
                        type="radio"
                        id="{{ $field->getId($loop->iteration) }}"
                        name="{{ $field->getName() }}"
                        value="{{ $key }}"
                        {!! $field->value == $key ? 'checked="checked"' : '' !!}
                        {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                        {!! $field->getAttributes() !!}
                    />
                    {{ is_lang_key($value) ? lang($value) : $value }}
                </label>
            @endforeach
        </div>
    @endif
</div>
