@if(!$paymentMethod->isOffsiteMode())
    @php($paymentProfile = $order->customer && $paymentMethod->paymentProfileExists($order->customer)
        ? $paymentMethod->findPaymentProfile($order->customer)
        : null
    )
    <div
        id="stripePaymentForm"
        class="payment-form ms-2 mt-3"
        data-publishable-key="{{ $paymentMethod->getPublishableKey() }}"
        data-payment-intent-secret="{{ $paymentProfile ? '' : $paymentMethod->createOrFetchIntent($order) }}"
        data-stripe-options='@json($paymentMethod->getStripeJsOptions($order))'
        data-card-selector="#stripe-card-element"
        data-error-selector="#stripe-card-errors"
    >
        @foreach($paymentMethod->getHiddenFields() as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}"/>
        @endforeach

        <div class="form-group">
            @if($paymentProfile)
                <input type="hidden" name="pay_from_profile" value="1">
                <div class="d-flex align-items-center">
                    <i class="fab fa-2x fa-fw fa-cc-{{ $paymentProfile->card_brand }}"></i>&nbsp;&nbsp;
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
                <div id="stripe-card-element"></div>
                <div id="stripe-card-errors" class="text-danger" role="alert"></div>

                @if($paymentMethod->supportsPaymentProfiles() && $order->customer)
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
            @endif
        </div>
    </div>
@endif
