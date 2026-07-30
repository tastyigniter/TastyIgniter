@php
    $recordId = $record->getKey();
    $hasOverride = $record->hasOutOfStockOverride();
    $isOutOfStock = $record->outOfStock();
@endphp

@if($hasOverride)
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-danger bg-opacity-10 text-danger py-1 px-2">
            <i class="fa fa-pause-circle me-1"></i>{{ $record->getOutOfStockLabel() }}
        </span>
        <button
            type="button"
            class="btn btn-sm btn-outline-secondary border-0 p-0 px-1"
            data-request="onClearOutOfStock"
            data-request-data="recordId: '{{ $recordId }}'"
            data-request-confirm="@lang('igniter.cart::default.stocks.alert_confirm_clear_oos')"
            title="@lang('igniter.cart::default.stocks.button_reset_stock')"
        ><i class="fa fa-times"></i></button>
    </div>
@elseif($isOutOfStock)
    <span class="badge bg-danger bg-opacity-10 text-danger py-1 px-2">
        <i class="fa fa-times-circle me-1"></i>@lang('igniter.cart::default.stocks.text_out_of_stock')
    </span>
@else
    <div class="dropdown">
        <button
            type="button"
            class="btn btn-sm btn-outline-danger dropdown-toggle"
            data-bs-toggle="dropdown"
            data-bs-display="static"
            aria-haspopup="true"
            aria-expanded="false"
        >@lang('igniter.cart::default.stocks.button_mark_out_of_stock')</button>
        <div class="dropdown-menu">
            <h6 class="dropdown-header">@lang('igniter.cart::default.stocks.text_oos_quick_options')</h6>
            <a class="dropdown-item"
                role="button"
                data-request="onMarkOutOfStock"
                data-request-data="recordId: '{{ $recordId }}', outOfStockType: 'duration', outOfStockDuration: '30'"
            >@lang('igniter.cart::default.stocks.text_oos_option_30m')</a>
            <a class="dropdown-item"
                role="button"
                data-request="onMarkOutOfStock"
                data-request-data="recordId: '{{ $recordId }}', outOfStockType: 'duration', outOfStockDuration: '60'"
            >@lang('igniter.cart::default.stocks.text_oos_option_1h')</a>
            <a class="dropdown-item"
                role="button"
                data-request="onMarkOutOfStock"
                data-request-data="recordId: '{{ $recordId }}', outOfStockType: 'duration', outOfStockDuration: '120'"
            >@lang('igniter.cart::default.stocks.text_oos_option_2h')</a>
            <a class="dropdown-item"
                role="button"
                data-request="onMarkOutOfStock"
                data-request-data="recordId: '{{ $recordId }}', outOfStockType: 'duration', outOfStockDuration: '240'"
            >@lang('igniter.cart::default.stocks.text_oos_option_4h')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item"
                role="button"
                data-request="onMarkOutOfStock"
                data-request-data="recordId: '{{ $recordId }}', outOfStockType: 'closing'"
                data-request-confirm="@lang('igniter.cart::default.stocks.alert_confirm_oos_closing')"
            >@lang('igniter.cart::default.stocks.text_oos_option_closing')</a>
            <a class="dropdown-item"
                role="button"
                data-request="onMarkOutOfStock"
                data-request-data="recordId: '{{ $recordId }}', outOfStockType: 'indefinitely'"
                data-request-confirm="@lang('igniter.cart::default.stocks.alert_confirm_oos_indefinitely')"
            >@lang('igniter.cart::default.stocks.text_oos_option_indefinitely')</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item js-stock-oos-custom"
                role="button"
                data-record-id="{{ $recordId }}"
            >@lang('igniter.cart::default.stocks.text_oos_option_custom')</a>
        </div>
    </div>
@endif

@once
    <div class="modal fade" id="stockOosModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('igniter.cart::default.stocks.text_oos_option_custom')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <input type="hidden" id="oosRecordId" name="recordId" value="">
                    <div class="modal-body">
                        <label class="form-label" for="oosUntil">@lang('igniter.cart::default.stocks.label_oos_until_datetime')</label>
                        <input
                            type="datetime-local"
                            id="oosUntil"
                            name="outOfStockUntil"
                            class="form-control"
                            required
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            value="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                        >
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-danger"
                            data-bs-dismiss="modal"
                            data-request="onMarkOutOfStock"
                            data-request-data="outOfStockType: 'custom'"
                        >@lang('igniter.cart::default.button_confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('.js-stock-oos-custom');
            if (!trigger) return;
            e.preventDefault();
            document.getElementById('oosRecordId').value = trigger.dataset.recordId;
            var modalEl = document.getElementById('stockOosModal');
            var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.show();
        });
    </script>
@endonce
