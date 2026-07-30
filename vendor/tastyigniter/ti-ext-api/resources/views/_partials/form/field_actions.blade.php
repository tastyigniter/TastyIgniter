<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th width="35%">@lang('igniter.api::default.text_allow_only')</th>
            <th></th>
            <th class="list-action">@lang('admin::lang.text_disabled')/@lang('admin::lang.text_enabled')</th>
        </tr>
        </thead>
        <tbody>
        @php
            $fieldValue = !is_array($field->value) ? [$field->value] : $field->value;
        @endphp
        @foreach ($field->options() as $action => $name)
            <tr>
                <td>
                    <select
                        id="{{ $field->getId($action.'-authorization') }}"
                        name="{{ $field->getName() }}[authorization][{{ $action }}]"
                        class="form-select"
                    >
                        @foreach ($field->getConfig('authOptions') as $key => $label)
                            <option
                                value="{{ $key }}"
                                {!! $key == array_get($fieldValue, 'authorization.'.$action) ? 'selected="selected"' : '' !!}
                            >@lang($label)</option>
                        @endforeach
                    </select>
                </td>
                <td>@lang($name)</td>
                <td class="list-action text-right">
                    <div class="field-custom-container">
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="{{ $field->getId($action.'-actions') }}"
                                name="{{ $field->getName() }}[actions][]"
                                value="{{ $action }}"
                                {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
                                {!! in_array($action, array_get($fieldValue, 'actions', [$action])) ? 'checked="checked"' : '' !!}
                            />
                            <label
                                class="form-check-label"
                                for="{{ $field->getId($action.'-actions') }}"
                            >&nbsp;</label>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
