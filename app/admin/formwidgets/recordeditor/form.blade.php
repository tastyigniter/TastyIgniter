<div class="modal-dialog modal-dialog-scrollable {{ $this->popupSize }}">
    {!! form_open([
        'id' => 'record-editor-form',
        'role' => 'form',
        'method' => $formWidget->context == 'create' ? 'POST' : 'PATCH',
        'data-request' => $this->alias.'::onSaveRecord',
        'class' => 'w-100',
    ]) !!}
    <x-modal.content>
        <x-slot name="title">@lang($formTitle)</x-slot>

        <input type="hidden" name="recordId" value="{{ $formRecordId }}">
        <div class="form-fields p-0">
            @foreach ($formWidget->getFields() as $field)
                {!! $formWidget->renderField($field) !!}
            @endforeach
        </div>

        <x-slot name="footer">
            <button
                type="button"
                class="btn btn-link"
                data-bs-dismiss="modal"
            >@lang('admin::lang.button_close')</button>
            <button
                type="submit"
                class="btn btn-primary"
            >@lang('admin::lang.button_save')</button>
        </x-slot>
    </x-modal.content>
    {!! form_close() !!}
</div>
