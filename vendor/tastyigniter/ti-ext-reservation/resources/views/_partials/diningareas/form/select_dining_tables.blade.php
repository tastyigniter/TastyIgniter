<div class="input-group">
    <div class="flex-grow-1">
        @php
            $fieldOptions = $formModel->dining_table_solos->pluck('name', 'id');
            $checkedValues = (array)$field->value;
            $enableFilter = (count($fieldOptions) > 20);
        @endphp
        <div class="control-selectlist">
            <select
                    data-control="selectlist"
                    id="{{ $field->getId() }}"
                    name="{{ $field->getName() }}[]"
                    {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                    multiple="multiple"
                    data-enable-filtering="{{ $enableFilter }}"
                    data-enable-case-insensitive-filtering="{{ $enableFilter }}"
                    {!! $field->getAttributes() !!}
            >
                @foreach ($fieldOptions as $value => $option)
                    @continue($field->disabled && !in_array($value, $checkedValues))
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
    </div>
    <button
        type="button"
        class="btn btn-light"
        data-request="onCreateCombo"
    ><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('igniter.reservation::default.dining_areas.button_new_combo')</button>
</div>
