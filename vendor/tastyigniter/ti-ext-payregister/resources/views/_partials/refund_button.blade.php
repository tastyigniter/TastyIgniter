@if ($record['is_refundable'] && is_null($record['refunded_at']))
    <a
        role="button"
        class="text-primary font-weight-bold"
        data-control="refund"
        data-log-id="{{ $record['payment_log_id'] }}"
    >@lang('igniter.payregister::default.button_refund')</a>
@else
    -
@endif
