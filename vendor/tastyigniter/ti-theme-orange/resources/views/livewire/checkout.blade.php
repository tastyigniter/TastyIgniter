<div>
    <div class="row pt-4">
        <h1 class="px-0">@lang('igniter.orange::default.text_title_checkout') {{ $locationCurrent->getName() }}</h1>

        <div class="px-0 my-3">
            {!! $customer
                ? sprintf(lang('igniter.orange::default.text_logged_out'), e($customer->first_name), url('logout'))
                : sprintf(lang('igniter.orange::default.text_logged_in'), page_url('account.login'))
            !!}
        </div>
    </div>
    <div class="row py-4">
        <div class="col col-lg-8 bg-white border rounded p-0">
            <div
                data-control="checkout"
                data-partial="checkoutForm"
                data-payment-input-name="fields.payment"
                data-validate-event="checkout::validate"
                data-confirm-event="checkout::confirm"
                data-choose-payment-event="checkout::choose-payment"
                data-delete-payment-profile-event="checkout::delete-payment-profile"
            >
                @includeWhen($isTwoPageCheckout, 'igniter-orange::includes.checkout.two-step-form')
                @includeUnless($isTwoPageCheckout, 'igniter-orange::includes.checkout.one-step-form')
            </div>
        </div>

        <div class="col-lg-4">
            <x-igniter-orange::cart-preview />
        </div>
    </div>
</div>
