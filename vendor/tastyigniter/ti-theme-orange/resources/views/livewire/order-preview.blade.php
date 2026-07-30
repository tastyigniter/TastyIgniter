<div wire:poll.120s>
    @if (!$order)
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center" id="ti-order-status">
                No order found
            </div>
        </div>
    @else
        <div class="card shadow-sm mb-3">
            <div class="card-body text-center" id="ti-order-status">
                @include('igniter-orange::includes.order.status')
            </div>
        </div>

        @auth('igniter-customer')
            <livewire:igniter-orange::leave-review />

            <div class="row g-3">
                <div class="col-sm-7">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            @include('igniter-orange::includes.order.restaurant', ['location' => $order->location])
                        </div>
                    </div>

                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            @include('igniter-orange::includes.order.items')
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    @include('igniter-orange::includes.order.details')
                </div>
            </div>
        @else
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center">
                    <a
                        href="{{ $loginUrl }}"
                    >@lang('igniter.cart::default.orders.text_login_to_view_more')</a>
                </div>
            </div>
        @endauth
    @endif
</div>
