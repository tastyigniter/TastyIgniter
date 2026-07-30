{!! form_open(current_url()) !!}
<input type="hidden" name="alias" value="{{ $widgetAlias }}">
<div class="modal-header">
    <h4 class="modal-title" id="{{ $widgetAlias }}-title">
        @lang('igniter::admin.dashboard.text_edit_widget')
    </h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div
    class="modal-body"
>
    @foreach($widgetForm->getFields() as $field)
        {!! $widgetForm->renderField($field) !!}
    @endforeach
</div>
<div class="modal-footer">
    <button
        type="button"
        class="btn btn-default"
        data-bs-dismiss="modal"
    >@lang('igniter::admin.button_close')</button>
    <button
        type="button"
        class="btn btn-primary"
        data-bs-dismiss="modal"
        data-request="{{ $this->getEventHandler('onUpdateWidget') }}"
    >@lang('igniter::admin.text_save')</button>
</div>
{!! form_close() !!}
