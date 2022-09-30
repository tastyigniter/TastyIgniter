@unless ($this->previewMode)
    <div
        id="{{ $this->getId() }}"
        class="control-recordeditor"
        data-control="record-editor"
        data-alias="{{ $this->alias }}"
    >
        <div class="field-radiolist">
            <input type="hidden" name="{{ $field->getName() }}" value="0" />
            @foreach ($this->modelClass::where('dining_area_id', $formModel->id)->dropdown('name') as $value => $option)
                @php
                    $checkboxId = 'radio_'.$field->getId().'_'.$loop->iteration;
                    if (is_string($option)) $option = [$option];
                @endphp
                <div class="form-check mb-2">
                    <input
                        type="radio"
                        id="{{ $checkboxId }}"
                        class="form-check-input"
                        name="{{ $field->getName() }}[]"
                        value="{{ $value }}"
                        data-control="choose-record"
                        {!! $field->getAttributes() !!}>

                    <label class="form-check-label" for="{{ $checkboxId }}">
                        {{ isset($option[0]) ? lang($option[0]) : '&nbsp;' }}
                        @isset($option[1])
                            <p class="help-block font-weight-normal">@lang($option[1])</p>
                        @endisset
                    </label>
                </div>
            @endforeach
        </div>

        <div class="py-2">
            @if ($showEditButton)
                <button
                    type="button"
                    class="btn btn-outline-default"
                    data-control="edit-record"
                    {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
                ><i class="fa fa-pencil"></i>&nbsp;&nbsp;@lang($editLabel)&nbsp;@lang($this->formName)</button>
            @endif
            @if ($showDeleteButton)
                <button
                    type="button"
                    class="btn btn-outline-danger"
                    title="{{ lang($deleteLabel).' '.lang($this->formName) }}"
                    data-control="delete-record"
                    data-confirm-message="@lang('admin::lang.alert_warning_confirm')"
                    {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
                ><i class="fa fa-trash"></i></button>
            @endif
            @if ($showCreateButton)
                <button
                    type="button"
                    class="btn btn-outline-default"
                    data-control="create-record"
                    {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
                ><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang($addLabel)&nbsp;@lang($this->formName)</button>
            @endif
        </div>
    </div>
@endunless
