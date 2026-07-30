<div class="card">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <h4 class="mb-0">@lang('igniter.user::default.text_address')</h4>
        <button
            class="btn btn-secondary"
            wire:click="$set('showModal', true)"
            wire:loading.class="disabled"
        >@lang('igniter.user::default.account.button_add')</button>
    </div>
    <div class="card-body pb-2">
        @if(count($addresses))
            <div class="list-group list-group-flush">
                @foreach ($addresses as $address)
                    <div
                        wire:click="$set('addressId', {{ $address->address_id }})"
                        wire:loading.class="disabled"
                        role="button"
                        @class([
                            'list-group-item list-group-item-action py-3',
                            'list-group-item-primary' => $defaultAddressId == $address->address_id,
                        ])
                    >
                        <div class="d-flex align-items-center">
                            <i class="fa fa-location-dot opacity-75 me-2"></i>
                            <address class="flex-grow-1 mb-0">{{ format_address($address, false) }}</address>
                            <i class="fa fa-pencil-alt ms-2"></i>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between">
                <div class="links">{{$addresses->links()}}</div>
            </div>
        @else
            <p>@lang('igniter.user::default.account.text_no_address')</p>
        @endif
        @if($showModal)
            @include('igniter-orange::includes.account.address-book-form')
        @endif
    </div>
</div>
