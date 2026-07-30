@php $locationIsClosed = (!$cart->count() || $this->locationIsClosed() || $this->hasMinimumOrder()); @endphp
<button
    @class(['checkout-btn btn btn-primary w-100 btn-lg', 'btn-secondary disabled' => $locationIsClosed])
    wire:loading.class="disabled"
    wire:click="onProceedToCheckout({{ $this->getLocationId() }})"
>{{ $this->buttonLabel($checkout ?? null) }}</button>
