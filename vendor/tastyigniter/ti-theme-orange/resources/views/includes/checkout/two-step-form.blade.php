<x-igniter-orange::forms.form id="checkout-form" novalidate>
    @if ($checkoutStep !== $this::STEP_PAY)
        <input type="hidden" wire:model.fill="form.checkoutStep" name="checkoutStep" value="{{$this::STEP_PAY}}">
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
    @else
        <div class="py-3">
            @include('igniter-orange::includes.checkout.tab-fields', [
                'fields' => $this->formTabFields('payments'),
            ])
        </div>

        @include('igniter-orange::includes.checkout.tab-fields', [
            'fields' => $this->formTabFields('terms'),
        ])
    @endif

    <div class="p-3">
        <button
            wire:loading.class="disabled"
            data-checkout-control="submit"
            type="submit"
            class="btn btn-primary w-100 btn-lg"
        >@lang($checkoutStep === $this::STEP_PAY ? 'igniter.orange::default.button_confirm' : 'igniter.orange::default.button_payment')</button>
    </div>
</x-igniter-orange::forms.form>
