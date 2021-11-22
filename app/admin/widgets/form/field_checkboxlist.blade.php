@php
    $fieldOptions = $field->options();
    $checkedValues = (array)$field->value;
    $isScrollable = count($fieldOptions) > 10;
    $inlineMode = (bool)$field->getConfig('inlineMode');
@endphp
@if ($this->previewMode && $field->value)

    <div class="field-checkboxlist">
        @foreach ($fieldOptions as $value => $option)
            @continue(!in_array($value, $checkedValues))
            @php
                $checkboxId = 'checkbox_'.$field->getId().'_'.$loop->iteration;
                if (!is_array($option)) $option = [$option];
            @endphp
            <div class="form-check{{ $inlineMode ? ' custom-control-inline' : '' }} mb-2">
                <input
                    type="checkbox"
                    id="{{ $checkboxId }}"
                    class="form-check-input"
                    name="{{ $field->getName() }}[]"
                    value="{{ $value }}"
                    disabled="disabled"
                    checked="checked"
                >
                <label class="form-check-label" for="{{ $checkboxId }}">
                    {{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}
                    @isset($option[1])
                        <p class="help-block font-weight-normal">{{ is_lang_key($option[1]) ? lang($option[1]) : $option[1] }}</p>
                    @endisset
                </label>
            </div>
        @endforeach
    </div>

@elseif (!$this->previewMode && count($fieldOptions))

    <div class="field-checkboxlist {{ $isScrollable ? 'is-scrollable' : '' }}">
        @if ($isScrollable)
            <small>
                @lang('admin::lang.text_select'):
                <a href="javascript:;" data-field-checkboxlist-all>@lang('admin::lang.text_select_all')</a>,
                <a href="javascript:;" data-field-checkboxlist-none>@lang('admin::lang.text_select_none')</a>
            </small>

            <div class="field-checkboxlist-scrollable">
                <div class="scrollbar">
                    @endif

                    <input
                        type="hidden"
                        name="{{ $field->getName() }}"
                        value="0"/>

                    @foreach ($fieldOptions as $value => $option)
                        @php
                            $checkboxId = 'checkbox_'.$field->getId().'_'.$loop->iteration;
                            if (is_string($option)) $option = [$option];
                        @endphp
                        <div class="form-check{{ $inlineMode ? ' custom-control-inline' : '' }} mb-2">
                            <input
                                type="checkbox"
                                id="{{ $checkboxId }}"
                                class="form-check-input"
                                name="{{ $field->getName() }}[]"
                                value="{{ $value }}"
                                {!! in_array($value, $checkedValues) ? 'checked="checked"' : '' !!}>

                            <label class="form-check-label" for="{{ $checkboxId }}">
                                {{ isset($option[0]) ? lang($option[0]) : '&nbsp;' }}
                                @isset($option[1])
                                    <p class="help-block font-weight-normal">@lang($option[1])</p>
                                @endisset
                            </label>
                        </div>
                    @endforeach

                    @if ($isScrollable)
                </div>
            </div>
        @endif

    </div>

@else

    @if ($field->placeholder)
        <p>@lang($field->placeholder)</p>
    @endif
@endif
