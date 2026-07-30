<div class="card mb-3">
    <div class="card-body">
        <h5 class="mb-0">{{ sprintf(lang('igniter.user::default.text_welcome'), $customerName) }}</h5>
    </div>
</div>

<div class="card-group mb-3">
    <div class="card mr-sm-3">
        <div class="card-body">
            @if ($hasDefaultAddress)
                <h5 class="font-weight-normal">
                    @lang('igniter.user::default.text_default_address')
                    <a
                        wire:navigate
                        class="btn btn-outline-secondary edit-address pull-right"
                        href="{{ page_url('account.address') }}"
                    >@lang('igniter.user::default.text_edit')</a>
                </h5>
                <address class="text-left text-overflow">{!! $formattedAddress !!}</address>
            @else
                <p>@lang('igniter.user::default.text_no_default_address')</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <p><i class="fa fa-shopping-basket fa-3x text-muted"></i></p>
            @if ($count = $cartCount())
                <p>{{sprintf(lang('igniter.user::default.text_cart_summary'), $count, currency_format($cartTotal))}}</p>
            @else
                <p>@lang('igniter.user::default.text_no_cart_items')</p>
            @endif
            <a
                wire:navigate
                class="btn btn-secondary" href="{{ page_url('local.menus') }}">
                @lang('igniter.user::default.text_order')
            </a>
        </div>
    </div>
</div>
