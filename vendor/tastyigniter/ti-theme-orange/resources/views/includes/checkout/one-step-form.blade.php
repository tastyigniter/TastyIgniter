<x-igniter-orange::forms.form id="checkout-form" novalidate>
    <div class="p-3">
        <h5 class="fw-normal">@lang('igniter.orange::default.label_your_details')</h5>
        @include('igniter-orange::includes.checkout.tab-fields', [
            'fields' => $this->formTabFields('details'),
        ])
    </div>

    <div class="px-3 fs-5">
        <div class="p-3 border rounded">
            <x-igniter-orange::fulfillment/>

            @includeWhen($order->isDeliveryType(), 'igniter-orange::includes.checkout.delivery-address')
        </div>
    </div>

    <div class="p-3">
        @include('igniter-orange::includes.checkout.tab-fields', [
            'fields' => $this->formTabFields('comments'),
        ])
    </div>

    @include('igniter-orange::includes.checkout.tab-fields', [
        'fields' => $this->formTabFields('payments'),
    ])

    @include('igniter-orange::includes.checkout.tab-fields', [
        'fields' => $this->formTabFields('terms'),
    ])

    <div class="p-3">
        <button
            wire:loading.class="disabled"
            data-checkout-control="submit"
            type="submit"
            class="checkout-btn btn btn-primary w-100 btn-lg"
        >@lang('igniter.orange::default.button_confirm')</button>
    </div>
</x-igniter-orange::forms.form>
