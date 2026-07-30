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
                <div class="text-center">
                    <div class="ti-loading spinner-border fa-3x fa-fw" role="status"></div>
                    <div class="fw-bold mt-2">
                        @lang('igniter::admin.text_loading')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="toolbar-action d-flex justify-content-between p-3">
    <div class="btn-group">
        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#newWidgetModal"
            data-request="{{ $this->getEventHandler('onLoadAddPopup') }}"
            tabindex="-1"
        ><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('igniter::admin.dashboard.button_add_widget')</button>
        <button
            type="button"
            class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
            data-bs-toggle="dropdown"
            data-bs-display="static"
            aria-expanded="false"
        ><span class="visually-hidden">Toggle Dropdown</span></button>
        <ul class="dropdown-menu">
            <li>
                @if($this->canSetDefault)
                    <button
                        type="button"
                        class="dropdown-item"
                        data-request="{{ $this->getEventHandler('onSetAsDefault') }}"
                        data-request-confirm="@lang('igniter::admin.dashboard.alert_set_default_confirm')"
                        data-attach-loading
                        tabindex="-1"
                    >@lang('igniter::admin.dashboard.button_set_default')</button>
                @endif
                <button
                    type="button"
                    class="dropdown-item text-danger"
                    data-request="{{ $this->getEventHandler('onResetWidgets') }}"
                    data-request-confirm="@lang('igniter::admin.alert_warning_confirm')"
                    data-attach-loading
                    title="@lang('igniter::admin.dashboard.button_reset_widgets')"
                    tabindex="-1"
                >@lang('admin::lang.dashboard.button_reset_widgets')</button>
            </li>
        </ul>
    </div>
    <button
        id="{{ $this->alias }}-daterange"
        class="btn btn-light text-reset pull-right"
        data-control="daterange"
        data-start-date="{{ $startDate }}"
        data-end-date="{{ $endDate }}"
    >
        <i class="fa fa-calendar"></i>&nbsp;&nbsp;
        <span
            class="d-none d-md-inline">{{$startDate->isoFormat($dateRangeFormat).' - '.$endDate->isoFormat($dateRangeFormat)}}</span>&nbsp;&nbsp;
        <i class="fa fa-caret-down"></i>
    </button>
</div>
