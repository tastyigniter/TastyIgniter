{!! form_open(current_url()) !!}
<div class="modal-header">
    <h4 class="modal-title">@lang('igniter::admin.dashboard.text_add_widget')</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label class="form-label">@lang('igniter::admin.dashboard.label_widget')</label>
        <select class="form-select" data-control="selectlist" name="widget" data-request="onSelectWidget">
            <option value="">@lang('igniter::admin.dashboard.text_select_widget')</option>
            @foreach ($widgets as $className => $config)
                <option
                    value="{{ $config['code'] }}"
                    @selected(isset($widgetAlias) ? $widgetAlias == $config['code'] : false)
                >@lang($config['label'])</option>
            @endforeach
        </select>
    </div>

    <div class="progress-indicator-container">
        @isset($widgetAlias)
            @foreach($widgetForm->getFields() as $field)
                {!! $widgetForm->renderField($field) !!}
            @endforeach
        @endisset
    </div>
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
        data-request="{{ $this->getEventHandler('onAddWidget') }}"
        data-bs-dismiss="modal"
    >@lang('igniter::admin.button_add')</button>
</div>
{!! form_close() !!}
