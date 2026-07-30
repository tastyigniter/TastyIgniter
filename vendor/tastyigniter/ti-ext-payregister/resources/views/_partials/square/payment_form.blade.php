<div
    id="squarePaymentForm"
    class="payment-form ms-2 mt-3"
    data-application-id="{{ $paymentMethod->getAppId() }}"
    data-location-id="{{ $paymentMethod->getLocationId() }}"
    data-order-total="{{ Cart::total() }}"
    data-currency-code="{{ currency()->getUserCurrency() }}"
    data-error-selector="#square-card-errors"
>
    @foreach ($paymentMethod->getHiddenFields() as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}"/>
    @endforeach

    <div class="form-group">
        @if ($paymentProfile = $paymentMethod->findPaymentProfile($order->customer))
            <input type="hidden" name="pay_from_profile" value="1">
            <div class="d-flex align-items-center">
                <i class="fab fa-fw fa-2x fa-cc-{{ $paymentProfile->card_brand }}"></i>&nbsp;&nbsp;
                <b>&bull;&bull;&bull;&bull;&nbsp;&bull;&bull;&bull;&bull;&nbsp;&bull;&bull;&bull;&bull;&nbsp;{{ $paymentProfile->card_last4 }}</b>
                &nbsp;&nbsp;-&nbsp;&nbsp;
                <a
                    class="text-danger"
                    href="javascript:;"
                    data-checkout-control="delete-payment-profile"
                    data-payment-code="{{ $paymentMethod->code }}"
                >@lang('igniter.payregister::default.button_delete_card')</a>
            </div>
        @else
            <div class="square-ccbox">
                <div id="square-card-element"></div>
                @if ($paymentMethod->supportsPaymentProfiles() && $order->customer)
                    <div class="form-check mt-2">
                        <input
                            id="save-customer-profile"
                            type="checkbox"
                            class="form-check-input"
                            name="create_payment_profile"
                            value="1"
                        >
                        <label
                            class="form-check-label"
                            for="save-customer-profile"
                        >@lang('igniter.payregister::default.text_save_card_profile')</label>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
