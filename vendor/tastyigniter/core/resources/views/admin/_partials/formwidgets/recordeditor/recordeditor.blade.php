<div
    id="{{ $this->getId() }}"
    class="control-recordeditor rounded border py-1"
    data-control="record-editor"
    data-alias="{{ $this->alias }}"
>
    @unless($this->previewMode)
        <div class="list-group list-group-flush vh-50 overflow-auto">
            @foreach ($field->options() as $value => $option)
                @php if (!is_array($option)) $option = [$option] @endphp
                <div class="record-editor-item list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center flex-md-column flex-lg-row">
                        <div class="text-truncate">
                            {{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}
                        </div>
                        <div>
                            @if($showEditButton)
                                <button
                                    type="button"
                                    class="btn btn-link text-reset"
                                    data-control="edit-record"
                                    data-toggle="record-editor"
                                    data-alias="{{$this->alias}}"
                                    data-record-id="{{$value}}"
                                    title="@lang($editLabel)"
                                    {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
                                ><i class="fa fa-pencil"></i></button>
                            @endif
                            @if($showDeleteButton)
                                <button
                                    type="button"
                                    class="btn btn-link text-danger"
                                    title="@lang($deleteLabel)"
                                    data-control="delete-record"
                                    data-request="{{$this->getEventHandler('onDeleteRecord')}}"
                                    data-request-data="'recordId': '{{$value}}'"
                                    data-request-confirm="@lang('igniter::admin.alert_warning_confirm')"
                                    {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
                                ><i class="fa fa-trash"></i></button>
                            @endif
                            @if($showAttachButton)
                                <button
                                    type="button"
                                    class="btn btn-link text-reset"
                                    title="@lang($attachLabel)"
                                    data-control="attach-record"
                                    data-request="{{$this->getEventHandler('onAttachRecord')}}"
                                    data-request-data="'recordId': '{{$value}}'"
                                    {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
                                ><i class="fa fa-plus-square"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="p-3 border-top">
            @if($showCreateButton)
                <button
                    type="button"
                    class="btn btn-light"
                    data-control="create-record"
                    data-toggle="record-editor"
                    data-alias="{{$this->alias}}"
                    {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
                ><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang($addLabel)</button>
            @endif
        </div>
    @endunless
</div>
