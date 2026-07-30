<div class="modal-dialog modal-lg">
    {!! form_open(
        [
            'id' => 'record-editor-form',
            'role' => 'form',
            'method' => $formWidget->context == 'create' ? 'POST' : 'PATCH',
            'data-request' => $this->alias.'::onSaveRecord',
            'data-control' => 'area-form',
            'class' => 'w-100',
        ]
    ) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">@lang($formTitle)</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <input type="hidden" name="areaId" value="{{ $formAreaId }}">
        <input type="hidden" data-map-shape {!! $this->getMapShapeAttributes($formWidget->model) !!}>
        <div class="modal-body p-3">
            <div class="form-fields">
                @foreach($formWidget->getFields() as $field)
                    {!! $formWidget->renderField($field) !!}
                @endforeach
            </div>
        </div>
        <div class="modal-footer text-right">
            <button
                type="button"
                class="btn btn-link text-danger fw-bold text-decoration-none"
                data-bs-dismiss="modal"
            >@lang('igniter::admin.button_close')</button>
            <button
                type="submit"
                class="btn btn-primary"
            >@lang('igniter::admin.button_save')</button>
        </div>
    </div>
    {!! form_close() !!}
</div>
