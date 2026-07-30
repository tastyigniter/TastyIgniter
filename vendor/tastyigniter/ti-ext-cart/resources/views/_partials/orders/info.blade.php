<div class="d-flex">
    <div class="mr-3 flex-fill">
        <label class="form-label">
            @lang('igniter.cart::default.orders.label_order_id')
        </label>
        <h3>#{{ $formModel->order_id }}</h3>
    </div>
    <div class="mr-3 flex-fill text-center">
        <label class="form-label">
            @lang('igniter.cart::default.checkout.label_order_type')
        </label>
        <h3>{{ $formModel->order_type_name }}</h3>
    </div>
    <div class="mr-3 flex-fill text-center">
        <label class="form-label">
            @lang('igniter.cart::default.orders.label_order_date_time')
        </label>
        <h3>
            {{ $formModel->order_date_time->isoFormat(lang('igniter::system.moment.date_time_format_short')) }}
            @if($formModel->order_time_is_asap)
                <span class="small text-muted">(@lang('igniter.cart::default.orders.text_asap'))</span>
            @endif
        </h3>
    </div>
</div>
