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
@if ($this->canManage || $this->canSetDefault)
    <div class="toolbar-action pt-3">
        @if ($this->canManage)
            <div class="btn-group">
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
                    class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown"
                    data-bs-display="static"
                    aria-expanded="false"
                ><span class="visually-hidden">Toggle Dropdown</span></button>
                <ul class="dropdown-menu">
                    <li>
                        <button
                            type="button"
                            class="dropdown-item text-danger"
                            data-request="{{ $this->getEventHandler('onResetWidgets') }}"
                            data-request-confirm="@lang('admin::lang.alert_warning_confirm')"
                            data-attach-loading
                            tabindex="-1"
                        >@lang('admin::lang.dashboard.button_reset_widgets')</button>
                    </li>
                </ul>
            </div>
        @endif
        @if ($this->canSetDefault)
            <button
                type="button"
                class="btn btn-outline-default"
                data-request="{{ $this->getEventHandler('onSetAsDefault') }}"
                data-request-confirm="@lang('admin::lang.dashboard.alert_set_default_confirm')"
                data-attach-loading
                tabindex="-1"
            ><i class="fa fa-save"></i>&nbsp;&nbsp;@lang('admin::lang.dashboard.button_set_default')</button>
        @endif
        <button
            id="{{ $this->alias }}-daterange"
            class="btn btn-outline-default pull-right"
            data-control="daterange"
            data-start-date="{{ $startDate->format('m/d/Y') }}"
            data-end-date="{{ $endDate->format('m/d/Y') }}"
        >
            <i class="fa fa-calendar"></i>&nbsp;&nbsp;
            <span>{{$startDate->isoFormat($dateRangeFormat).' - '.$endDate->isoFormat($dateRangeFormat)}}</span>&nbsp;&nbsp;
            <i class="fa fa-caret-down"></i>
        </button>
    </div>
@endif
