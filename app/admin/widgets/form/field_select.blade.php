@php
    $fieldOptions = $field->options();
    $useSearch = $field->getConfig('showSearch', count($fieldOptions) > 10);
    $multiOption = $field->getConfig('multiOption', false);
    $fieldValue = is_null($field->value) ? [] : $field->value;
    $fieldValue = !is_array($fieldValue) ? [$fieldValue] : $fieldValue;
@endphp
@if ($this->previewMode)
    <div
        class="form-control-static"
    >@isset($fieldOptions[$field->value])@lang($fieldOptions[$field->value])@endisset</div>
@else
    <select
        id="{{ $field->getId() }}"
        name="{!! $field->getName().($multiOption ? '[]' : '') !!}"
        data-control="selectlist"
        @if ($field->placeholder)data-placeholder-text="@lang($field->placeholder)" @endif
        data-show-search="{{ $useSearch }}"
        {!! $multiOption ? 'multiple="multiple"' : '' !!}
        {!! $field->getAttributes() !!}>

        @if (!$multiOption && $field->placeholder)
            <option data-placeholder="true"></option>
        @endif
        @foreach ($fieldOptions as $value => $option)
            @php
                if (!is_array($option)) $option = [$option];
            @endphp
            <option
                {!! in_array($value, $fieldValue) ? 'selected="selected"' : '' !!}
                value="{{ $value }}">
                {{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}
                @isset($option[1]) - {{ $option[1] }}@endisset
            </option>
        @endforeach
    </select>
@endif
