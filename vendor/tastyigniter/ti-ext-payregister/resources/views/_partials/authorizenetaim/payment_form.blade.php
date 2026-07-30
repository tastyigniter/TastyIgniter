<div
    id="authorizeNetAimPaymentForm"
    class="payment-form w-100"
    data-button-selector=".AcceptUI"
    data-error-selector="#authorizenetaim-errors"
    data-accept-js-endpoint="{{ $paymentMethod->getEndPoint() }}"
>
    @foreach ($paymentMethod->getHiddenFields() as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}"/>
    @endforeach

    @if ($paymentProfile = $paymentMethod->findPaymentProfile($order->customer))
        <div class="form-group">
            <input type="hidden" name="pay_from_profile" value="1">
            <div>
                <i class="fab fa-fw fa-cc-{{ $paymentProfile->card_brand }}"></i>&nbsp;&nbsp;
                <b>************&nbsp;{{ $paymentProfile->card_last4 }}</b>
                &nbsp;&nbsp;-&nbsp;&nbsp;
                <a
                    class="text-danger"
                    href="javascript:;"
                    data-checkout-control="delete-payment-profile"
                    data-payment-code="{{ $paymentMethod->code }}"
                >@lang('igniter.payregister::default.button_delete_card')</a>
            </div>
        </div>
    @else
        <button
            type="button"
            class="AcceptUI hide"
            data-billingAddressOptions='{"show":true, "required":false}'
            data-apiLoginID="{{ $paymentMethod->getApiLoginID() }}"
            data-clientKey="{{ $paymentMethod->getClientKey() }}"
            data-paymentOptions='{"showCreditCard": true, "showBankAccount": false}'
            data-acceptUIFormHeaderTxt="Card Information"
            data-responseHandler="authorizeNetAimResponseHandler"
        ></button>
        <div id="authorizenetaim-errors" class="text-danger"></div>
    @endif
</div>