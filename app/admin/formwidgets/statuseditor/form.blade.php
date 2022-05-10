<div
    id="{{ $this->getId('form-modal-content') }}"
    class="modal-dialog"
    role="document"
>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ $formTitle ? lang($formTitle) : '' }}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        {!! form_open(
            [
                'id' => 'status-editor-form',
                'role' => 'form',
                'method' => 'PATCH',
                'data-request' => $this->alias.'::onSaveRecord',
            ]
        ) !!}
        <div
            id="{{ $this->getId('form-modal-fields') }}"
            class="modal-body progress-indicator-container"
        >
            {!! $this->makePartial('statuseditor/fields', ['formWidget' => $formWidget]) !!}
        </div>
        <div class="modal-footer text-right">
            <button
                type="button"
                class="btn btn-link"
                data-bs-dismiss="modal"
            >@lang('admin::lang.button_close')</button>
            <button
                type="submit"
                class="btn btn-primary"
                data-attach-loading
            >@lang('admin::lang.button_save')</button>
        </div>
        {!! form_close() !!}
    </div>
</div>
