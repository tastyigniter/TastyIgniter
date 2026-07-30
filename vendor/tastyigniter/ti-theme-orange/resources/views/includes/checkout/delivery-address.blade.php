<div class="mt-2 pt-2 border-top fs-6">
    @php($deliveryAddress = array_filter(array_only($fields, ['address_1', 'city', 'state', 'postcode'])))
    <i class="fas fa-location-dot me-2"></i>
    @if($deliveryAddress)
        {{ html(format_address($deliveryAddress, false)) }}
    @else
        @lang('igniter.orange::default.text_no_delivery_address')
    @endif
</div>
<x-igniter-orange::forms.error
    field="delivery_address"
    id="delivery-address-feedback"
    class="text-danger fs-6"
/>
