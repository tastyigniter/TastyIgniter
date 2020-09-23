@unless ($this->previewMode)
    <div
        id="{{ $this->getId() }}"
        class="control-template-editor progress-indicator-container"
        data-control="template-editor"
        data-alias="{{ $this->alias }}"
    >
        @php
            $fieldValue = $field->value;
            $fieldPlaceholder = $this->placeholder;
            $selectedType = array_get($fieldValue, 'type') ?? '_pages';
            $selectedFile = array_get($fieldValue, 'file');
            $selectedTypeLabel = str_singular(lang($templateTypes[$selectedType]));
        @endphp
        <div class="form-row">
            <div class="col-sm-2">
                <select
                    id="{{ $field->getId('type') }}"
                    name="{{ $field->getName() }}[type]"
                    class="form-control"
                    data-template-control="choose-type"
                    data-request="onChooseFile"
                    data-progress-indicator="@lang('admin::lang.text_loading')"
                >
                    @foreach ($templateTypes as $value => $label)
                        <option
                            value="{{ $value }}"
                            {!! $value == $selectedType ? 'selected="selected"' : '' !!}
                        >@lang($label)</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-10">
                <div
                    class="input-group" data-toggle="modal"
                    data-target="#{{ $this->getId('form-modal') }}"
                >
                    <select
                        id="{{ $field->getId('file') }}"
                        name="{{ $field->getName() }}[file]"
                        class="form-control"
                        data-template-control="choose-file"
                        data-request="onChooseFile"
                        data-progress-indicator="@lang('admin::lang.text_loading')"
                    >
                        @if ($fieldPlaceholder)
                            <option
                                value=""
                            >{{ sprintf(lang($fieldPlaceholder), strtolower($selectedTypeLabel)) }}</option>
                        @endif
                        @foreach ($fieldOptions as $value => $option)
                            @php if (!is_array($option)) $option = [$option]; @endphp
                            <option
                                {!! $value == $selectedFile ? 'selected="selected"' : '' !!}
                                @isset($option[1]) data-{{ strpos($option[1], '.') ? 'image' : 'icon' }}="{{ $option[1] }}" @endisset
                                value="{{ $value }}"
                            >{{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append ml-1">
                        <button
                            type="button"
                            class="btn btn-outline-default"
                            data-toggle="modal"
                            data-target="#{{ $this->getId('modal') }}"
                            data-modal-title="{{ sprintf(lang($this->addLabel), $selectedTypeLabel) }}"
                            data-modal-source-action="new"
                            data-modal-source-name=""
                        ><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ sprintf(lang($this->addLabel), $selectedTypeLabel) }}
                        </button>
                        @if (!empty($selectedFile))
                            <button
                                type="button"
                                class="btn btn-outline-default"
                                data-toggle="modal"
                                data-target="#{{ $this->getId('modal') }}"
                                data-modal-title="{{ sprintf(lang($this->editLabel), $selectedTypeLabel) }}"
                                data-modal-source-action="rename"
                                data-modal-source-name="{{ $selectedFile }}"
                            ><i class="fa fa-pencil"></i>&nbsp;&nbsp;{{ sprintf(lang($this->editLabel), $selectedTypeLabel) }}
                            </button>
                            <button
                                type="button"
                                class="btn btn-outline-danger"
                                title="{{ sprintf(lang($this->deleteLabel), $selectedTypeLabel) }}"
                                data-request="onManageSource"
                                data-request-data="action: 'delete'"
                                data-request-confirm="@lang('admin::lang.alert_warning_confirm')"
                                data-progress-indicator="@lang('admin::lang.text_deleting')"
                            ><i class="fa fa-trash"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {!! $this->makePartial('templateeditor/modal') !!}
    </div>
@endunless
