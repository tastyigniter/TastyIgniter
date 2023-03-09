<div class="form-row">
    <div class="col-md-2 pb-3 pb-md-0">
        <select
            id="{{ $field->getId('type') }}"
            name="{{ $field->getName() }}[type]"
            data-control="selectlist"
            data-template-control="choose-type"
            data-request="{{ $this->getEventHandler('onChooseFile') }}"
            data-progress-indicator="@lang('admin::lang.text_loading')"
        >
            @foreach ($templateTypes as $value => $label)
                <option
                    value="{{ $value }}"
                    {!! $value == $selectedTemplateType ? 'selected="selected"' : '' !!}
                >@lang($label)</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-10">
        <div class="input-group">
            <div class="control-selectlist flex-grow-1">
                <select
                    data-control="selectlist"
                    id="{{ $field->getId('file') }}"
                    name="{{ $field->getName() }}[file]"
                    data-template-control="choose-file"
                    data-request="{{ $this->getEventHandler('onChooseFile') }}"
                    data-progress-indicator="@lang('admin::lang.text_loading')"
                    data-placeholder-text="{{ sprintf(lang($this->placeholder), strtolower($selectedTypeLabel)) }}"
                    data-show-search="true"
                >
                    @if ($this->placeholder)
                        <option data-placeholder="true"></option>
                    @endif
                    @foreach ($fieldOptions as $value => $option)
                        @php if (!is_array($option)) $option = [$option]; @endphp
                        <option
                            {!! $value == $selectedTemplateFile ? 'selected="selected"' : '' !!}
                            @isset($option[1]) data-{{ strpos($option[1], '.') ? 'image' : 'icon' }}="{{ $option[1] }}" @endisset
                            value="{{ $value }}"
                        >{{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}</option>
                    @endforeach
                </select>
            </div>
            <button
                type="button"
                class="btn btn-outline-default"
                data-bs-toggle="modal"
                data-bs-target="#{{ $this->getId('modal') }}"
                data-modal-title="{{ sprintf(lang($this->addLabel), $selectedTypeLabel) }}"
                data-modal-source-action="new"
                data-modal-source-name=""
            ><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ sprintf(lang($this->addLabel), $selectedTypeLabel) }}
            </button>
            @if (!empty($selectedTemplateFile))
                <button
                    type="button"
                    class="btn btn-outline-default"
                    data-bs-toggle="modal"
                    data-bs-target="#{{ $this->getId('modal') }}"
                    data-modal-title="{{ sprintf(lang($this->editLabel), $selectedTypeLabel) }}"
                    data-modal-source-action="rename"
                    data-modal-source-name="{{ $selectedTemplateFile }}"
                ><i class="fa fa-pencil"></i>&nbsp;&nbsp;{{ sprintf(lang($this->editLabel), $selectedTypeLabel) }}
                </button>
                <button
                    type="button"
                    class="btn btn-outline-danger"
                    title="{{ sprintf(lang($this->deleteLabel), $selectedTypeLabel) }}"
                    data-request="{{ $this->getEventHandler('onManageSource') }}"
                    data-request-data="action: 'delete'"
                    data-request-confirm="@lang('admin::lang.alert_warning_confirm')"
                    data-progress-indicator="@lang('admin::lang.text_deleting')"
                ><i class="fa fa-trash"></i></button>
            @endif
        </div>
    </div>
</div>
