<div
    class="modal slideInDown fade"
    id="newWidgetModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="newWidgetModalTitle"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div id="{{ $this->getId('new-widget-modal-content') }}" class="modal-content">
            <div class="modal-body">
                <div class="progress-indicator">
                    <span class="spinner"><span class="ti-loading fa-3x fa-fw"></span></span>
                    @lang('admin::lang.text_loading')
                </div>
            </div>
        </div>
    </div>
</div>
<div class="toolbar-action pt-3">
    @if ($this->canManage)
        <button
            type="button"
            class="btn btn-outline-primary"
            data-bs-toggle="modal"
            data-bs-target="#newWidgetModal"
            data-request="{{ $this->getEventHandler('onLoadAddPopup') }}"
            tabindex="-1"
        ><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('admin::lang.dashboard.button_add_widget')</button>
        <button
            type="button"
            class="btn btn-outline-danger"
            data-request="{{ $this->getEventHandler('onResetWidgets') }}"
            data-request-confirm="@lang('admin::lang.alert_warning_confirm')"
            data-attach-loading
            title="@lang('admin::lang.dashboard.button_reset_widgets')"
            tabindex="-1"
        ><i class="fa fa-refresh"></i></button>
    @endif
    @if ($this->canSetDefault)
        <button
            type="button"
            class="btn btn-outline-default pull-right"
            data-request="{{ $this->getEventHandler('onSetAsDefault') }}"
            data-request-confirm="@lang('admin::lang.dashboard.alert_set_default_confirm')"
            data-attach-loading
            tabindex="-1"
        ><i class="fa fa-save"></i>&nbsp;&nbsp;@lang('admin::lang.dashboard.button_set_default')</button>
    @endif
</div>
