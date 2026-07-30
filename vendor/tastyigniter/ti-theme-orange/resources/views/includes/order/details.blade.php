@if ($order->isDeliveryType())
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h6 class="text-muted">@lang('igniter.cart::default.checkout.text_delivery_address')</h6>
            <b>{{ $order->customer_name }}</b><br>
            {!! $order->address ? format_address($order->address) : '' !!}
        </div>
    </div>
@endif

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="text-muted">@lang('igniter.cart::default.checkout.text_comment')</h6>
        <p class="mb-0">{{ !empty($order->comment) ? $order->comment : lang('igniter.cart::default.checkout.text_no_comment') }}</p>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h6 class="text-muted">@lang('igniter.cart::default.checkout.label_payment_method')</h6>
        <p class="mb-0">
            {{ $order->payment_method
                ? $order->payment_method->name
                : lang('igniter.cart::default.checkout.text_no_payment') }}
        </p>
    </div>
</div>
