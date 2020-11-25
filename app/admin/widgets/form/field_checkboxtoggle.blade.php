@php
    $fieldOptions = $field->options();
    $checkedValues = (array)$field->value;
@endphp

<div class="field-checkbox">
    @if ($this->previewMode AND $field->value)
        <div
            id="{{ $field->getId() }}"
            class="btn-group btn-group-toggle bg-light"
            data-toggle="buttons">
            @foreach ($fieldOptions as $value => $option)
                @php
                    $checkboxId = 'checkbox_'.$field->getId().'_'.$loop->iteration;
                    if (is_string($option)) $option = [$option];
                @endphp
                <label
                    class="btn btn-light text-nowrap {{ in_array($value, $checkedValues) ? 'active' : ($this->previewMode ? 'disabled' : '') }}">
                    <input
                        type="checkbox"
                        id="{{ $checkboxId }}"
                        name="{{ $field->getName() }}[]"
                        value="{{ $value }}"
                        {!! in_array($value, $checkedValues) ? 'checked="checked"' : '' !!}
                        disabled="disabled"
                    />
                    {{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}
                </label>
            @endforeach
        </div>
    @elseif (!$this->previewMode AND count($fieldOptions))
        <div
            id="{{ $field->getId() }}"
            class="btn-group btn-group-toggle bg-light"
            data-toggle="buttons">
            @foreach ($fieldOptions as $value => $option)
                @php
                    $checkboxId = 'checkbox_'.$field->getId().'_'.$loop->iteration;
                    if (is_string($option)) $option = [$option];
                @endphp
                <label class="btn btn-light {{ in_array($value, $checkedValues) ? 'active' : '' }}">
                    <input
                        type="checkbox"
                        id="{{ $checkboxId }}"
                        name="{{ $field->getName() }}[]"
                        value="{{ $value }}"
                        {!! $field->getAttributes() !!}
                        {!! in_array($value, $checkedValues) ? 'checked="checked"' : '' !!}
                    />
                    {{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}
                </label>
            @endforeach
        </div>
    @else

        <input
            type="hidden"
            name="{{ $field->getName() }}"
            value="0"
            {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
        />

        <div class="custom-control custom-checkbox" tabindex="0">
            <input
                type="checkbox"
                class="custom-control-input"
                id="{{ $field->getId() }}"
                name="{{ $field->getName() }}"
                value="1"
                {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                {!! $field->value == 1 ? 'checked="checked"' : '' !!}
                {!! $field->getAttributes() !!}
            />
            <label class="custom-control-label" for="{{ $field->getId() }}">
                @if ($field->placeholder) @lang($field->placeholder) @else &nbsp; @endif
            </label>
        </div>
    @endif
</div>
