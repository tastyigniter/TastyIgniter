<div class="bg-white border shadow-sm rounded-3 p-3">
    <h5 class="mb-4">@lang('igniter.cart::default.text_basket')</h5>
    @includeWhen($cart->count(), 'igniter-orange::includes.cartbox.items')

    @includeWhen($cart->count(), 'igniter-orange::includes.cartbox.totals')
</div>