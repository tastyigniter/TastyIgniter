<div>
    <div id="cart-box" class="module-box bg-white border shadow-sm rounded-3 p-3">
        <div id="cart-items">
            @if ($cart->count())
                <h5 class="mb-4">@lang('igniter.cart::default.text_basket')</h5>
                @include('igniter-orange::includes.cartbox.items')
            @else
                <div class="p-3 text-center">
                    <i class="fa fa-basket-shopping fa-3x opacity-25 mb-3"></i>
                    <p class="text-center mb-0">@lang('igniter.cart::default.text_no_cart_items')</p>
                </div>
            @endif
        </div>

        @includeWhen($cart->count(), 'igniter-orange::includes.cartbox.coupon-form')

        @includeWhen($cart->count(), 'igniter-orange::includes.cartbox.totals')

        <div id="cart-buttons" class="mt-3">
            @if($minOrderTotal = $location->minimumOrderTotal())
                <p class="text-muted text-center mb-3">
                    @lang('igniter.local::default.text_min_total'): {{ currency_format($minOrderTotal) }}
                </p>
            @endif
            @include('igniter-orange::includes.cartbox.buttons')
            @teleport('body')
                @include('igniter-orange::includes.cartbox.buttons-mobile')
            @endteleport
        </div>
    </div>
</div>
