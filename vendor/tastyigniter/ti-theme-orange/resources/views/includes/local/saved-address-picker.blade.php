@auth('igniter-customer')
    <p class="mt-3 mb-2">
        @lang('igniter.orange::default.text_select_saved_addresses')
    </p>

    <div class="list-group list-group-flush bg-white border rounded p-3">
        @forelse ($this->savedAddresses as $address)
            <div
                wire:key="address-{{ $address->address_id }}"
                wire:click="onSelectAddress({{ $address->address_id }})"
                class="list-group-item list-group-item-action px-2 cursor-pointer"
                data-address-picker-control="select"
            >
                <div class="d-flex justify-content-between align-items-center py-1">
                    <i class="fa fa-location-dot text-muted me-2"></i>
                    <span class="flex-grow-1">{{ $address->formatted_address }}</span>
                    <i class="fa fa-angle-right text-muted"></i>
                </div>
            </div>
        @empty
            <div class="list-group-item list-group-item-action px-2">
                <p class="mb-0">
                    @lang('igniter.orange::default.text_no_saved_addresses')
                </p>
            </div>
        @endforelse
    </div>

    <x-igniter-orange::forms.error field="savedAddress" id="savedAddressFeedback" class="p-2 text-danger" />
@else
    <p class="mt-2 mb-0">
        <a
            href="{{ page_url('account.login') }}"
        >@lang('igniter.orange::default.text_login')</a> @lang('igniter.orange::default.text_for_saved_addresses')
    </p>
@endauth
