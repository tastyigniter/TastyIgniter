@php
    $fieldOptions = $field->options();
    $checkedValues = (array)$field->value;
    $isScrollable = count($fieldOptions) > 10;
    $inlineMode = (bool)$field->getConfig('inlineMode');
@endphp
@if ($this->previewMode && $field->value)

    <div class="field-radiolist">
        @foreach ($fieldOptions as $value => $option)
            @continue(!in_array($value, $checkedValues))
            @php
                $radioId = 'radio_'.$field->getId().'_'.$loop->iteration;
                if (!is_array($option)) $option = [$option];
            @endphp
            <div class="form-check{{ $inlineMode ? ' form-check-inline' : '' }} mb-2">
                <input
                    type="radio"
                    id="{{ $radioId }}"
                    class="form-check-input"
                    name="{{ $field->getName() }}"
                    value="{{ $value }}"
                    disabled="disabled"
                    checked="checked"
                >
                <label class="form-check-label" for="{{ $radioId }}">
                    {{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}
                    @isset($option[1])
                        <p class="help-block font-weight-normal">{{ is_lang_key($option[1]) ? lang($option[1]) : $option[1] }}</p>
                    @endisset
                </label>
            </div>
        @endforeach
    </div>

@elseif (!$this->previewMode && count($fieldOptions))

    <div class="field-radiolist {{ $isScrollable ? 'is-scrollable' : '' }}">
        @if ($isScrollable)
            <div class="field-radiolist-scrollable">
                <div class="scrollbar">
                    @endif

                    <input
                        type="hidden"
                        name="{{ $field->getName() }}"
                        value="0"
                    />

                    @foreach ($fieldOptions as $value => $option)
                        @php
                            $radioId = 'radio_'.$field->getId().'_'.$loop->iteration;
                            if (is_string($option)) $option = [$option];
                        @endphp
                        <div class="form-check{{ $inlineMode ? ' form-check-inline' : '' }} mb-2">
                            <input
                                type="radio"
                                id="{{ $radioId }}"
                                class="form-check-input"
                                name="{{ $field->getName() }}"
                                value="{{ $value }}"
                                {!! in_array($value, $checkedValues) ? 'checked="checked"' : '' !!}
                            />

                            <label class="form-check-label" for="{{ $radioId }}">
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
