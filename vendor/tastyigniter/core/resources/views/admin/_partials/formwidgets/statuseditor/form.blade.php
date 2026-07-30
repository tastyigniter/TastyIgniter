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
            class="modal-body p-3 progress-indicator-container"
        >
            {!! $this->makePartial('statuseditor/fields', ['formWidget' => $formWidget]) !!}
        </div>
        <div class="modal-footer text-right">
            <button
                type="button"
                class="btn btn-link fw-bold text-decoration-none"
                data-bs-dismiss="modal"
            >@lang('igniter::admin.button_close')</button>
            <button
                type="submit"
                class="btn btn-primary"
                data-attach-loading
            >@lang('igniter::admin.button_save')</button>
        </div>
        {!! form_close() !!}
    </div>
</div>
