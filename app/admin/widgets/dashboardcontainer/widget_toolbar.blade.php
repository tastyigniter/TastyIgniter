<x-modal.loading
    id="newWidgetModal"
    aria-labelledby="newWidgetModalTitle"
    :modalContentId="$this->getId('new-widget-modal-content')"
/>
<div class="toolbar-action card-body">
    @if ($this->canManage)
        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#newWidgetModal"
            data-request="{{ $this->getEventHandler('onLoadAddPopup') }}"
            tabindex="-1"
        ><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('admin::lang.dashboard.button_add_widget')</button>
        <button
            type="button"
            class="btn btn-danger pull-right"
            data-request="{{ $this->getEventHandler('onResetWidgets') }}"
            data-request-confirm="@lang('admin::lang.alert_warning_confirm')"
            data-attach-loading
            tabindex="-1"
        ><i class="fa fa-refresh"></i>&nbsp;&nbsp;@lang('admin::lang.dashboard.button_reset_widgets')</button>
    @endif
    @if ($this->canSetDefault)
        <button
            type="button"
            class="btn btn-default pull-right"
            data-request="{{ $this->getEventHandler('onSetAsDefault') }}"
            data-request-confirm="@lang('admin::lang.dashboard.alert_set_default_confirm')"
            data-attach-loading
            tabindex="-1"
        ><i class="fa fa-save"></i>&nbsp;&nbsp;@lang('admin::lang.dashboard.button_set_default')</button>
    @endif
</div>
