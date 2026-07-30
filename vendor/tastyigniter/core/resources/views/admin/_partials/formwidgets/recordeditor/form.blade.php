<div class="modal-dialog modal-dialog-scrollable {{ $this->popupSize }}">
    {!! form_open([
        'id' => $this->getId('record-editor-form'),
        'role' => 'form',
        'method' => $formWidget->context == 'create' ? 'POST' : 'PATCH',
        'data-request' => $this->alias.'::onSaveRecord',
        'class' => 'w-100',
    ]) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">@lang($formTitle)</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <input type="hidden" name="recordId" value="{{ $formRecordId }}">
        <div class="modal-body p-3">
            <div
                class="form-fields"
                data-control="formwidget"
                data-alias="{{$this->alias}}"
                data-refresh-handler="{{$this->getEventHandler('onRefresh')}}"
            >
                @foreach($formWidget->getFields() as $field)
                    {!! $formWidget->renderField($field) !!}
                @endforeach
            </div>
        </div>
        <div class="modal-footer text-right">
            @if(!empty($showDeleteButton))
                <button
                    type="button"
                    class="btn btn-link text-danger fw-bold text-decoration-none me-auto"
                    data-request="{{ $this->getEventHandler('onDeleteRecord') }}"
                >@lang('igniter::admin.button_delete')</button>
            @endif
            <button
                type="button"
                class="btn btn-link text-danger fw-bold text-decoration-none"
                data-bs-dismiss="modal"
            >@lang('igniter::admin.button_close')</button>
            @unless($formWidget->previewMode)
                <button
                    type="submit"
                    class="btn btn-primary"
                >@lang('igniter::admin.button_save')</button>
            @endunless
        </div>
    </div>
    {!! form_close() !!}
</div>
