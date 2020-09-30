@php
    $fieldOptions = $field->options();
    $isCheckboxMode = $field->config['mode'] ?? 'checkbox';
    $selectMultiple = $isCheckboxMode == 'checkbox';
    $checkedValues = (array)$field->value;
    $enableFilter = (count($fieldOptions) > 20);
@endphp
<div class="control-selectlist">
    <select
        data-control="selectlist"
        id="{{ $field->getId() }}"
        name="{!! $field->getName().($selectMultiple ? '[]' : '') !!}"
        @if ($field->placeholder)data-non-selected-text="@lang($field->placeholder)" @endif
        {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
        {!! $selectMultiple ? 'multiple="multiple"' : '' !!}
        data-enable-filtering="{{ $enableFilter }}"
        data-enable-case-insensitive-filtering="{{ $enableFilter }}"
        {!! $field->getAttributes() !!}
    >

        @if ($field->placeholder)
            <option value="">@lang($field->placeholder)</option>
        @endif

        @foreach ($fieldOptions as $value => $option)
            @continue($field->disabled AND !in_array($value, $checkedValues))
            @php
                if (!is_array($option)) $option = [$option];
            @endphp
            <option
                {!! in_array($value, $checkedValues) ? 'selected="selected"' : '' !!}
                value="{{ $value }}">
                {{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}
                @isset($option[1])
                    <span>{{ is_lang_key($option[1]) ? lang($option[1]) : $option[1] }}</span>
                @endisset
            </option>
        @endforeach
    </select>
</div>
