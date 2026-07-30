<div
    class="cart-items mb-3"
    wire:loading.class="opacity-75"
>
    <ul class="list-unstyled user-select-none mb-0">
        @foreach ($cart->content()->reverse() as $cartItem)
            <li @class(['d-flex align-items-start', 'mb-3' => !$loop->last]) wire:key="cart-item-{{ $cartItem->rowId }}">
                @unless($previewMode)
                    <div class="me-3 text-nowrap">
                        <button
                            wire:click="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'minus')"
                            wire:loading.class="disabled"
                            type="button"
                            class="btn btn-outline-secondary btn-sm lh-sm p-0 border-2 rounded-circle me-1"
                        >
                            <i class="fa fa-minus fa-fw"
                               wire:loading.class="fa-spinner fa-spin"
                               wire:loading.class.remove="fa-minus"
                               wire:target="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'minus')"
                            ></i>
                        </button>
                        <button
                            wire:click="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'plus')"
                            wire:loading.class="disabled"
                            type="button"
                            class="btn btn-outline-secondary btn-sm lh-sm p-0 border-2 rounded-circle"
                        >
                            <i class="fa fa-plus fa-fw"
                               wire:loading.class="fa-spinner fa-spin"
                               wire:loading.class.remove="fa-plus"
                               wire:target="onUpdateItemQuantity('{{ $cartItem->rowId }}', 'plus')"
                            ></i>
                        </button>
                    </div>
                    <button
                        class="btn shadow-none flex-grow-1 text-start fw-normal p-0"
                        data-toggle="orange-modal"
                        data-component="igniter-orange::cart-item-modal"
                        data-arguments='{"menuId": {{ $cartItem->id }}, "rowId": "{{ $cartItem->rowId }}"}'
                    >
                        <p class="mb-1">
                            @if ($cartItem->qty > 1)
                                <span class="fw-bolder">{{ $cartItem->qty }} @lang('igniter.cart::default.text_times')</span>
                            @endif
                            {{ $cartItem->name }}
                        </p>
                        @includeWhen($cartItem->hasOptions(), 'igniter-orange::includes.cartbox.list-item-options', ['itemOptions' => $cartItem->options])
                        @if (!empty($cartItem->comment))
                            <p class="bg-light small mt-2 mb-0 px-3 py-1 rounded-pill">
                                {{ $cartItem->comment }}
                            </p>
                        @endif
                    </button>
                @else
                    <div class="flex-grow-1 text-start fw-normal p-0">
                        <p class="mb-1">
                            @if ($cartItem->qty > 1)
                                <span class="fw-bolder">{{ $cartItem->qty }} @lang('igniter.cart::default.text_times')</span>
                            @endif
                            {{ $cartItem->name }}
                        </p>
                        @includeWhen($cartItem->hasOptions(), 'igniter-orange::includes.cartbox.list-item-options', ['itemOptions' => $cartItem->options])
                        @if (!empty($cartItem->comment))
                            <p class="bg-light small mt-2 mb-0 px-3 py-1 rounded-pill">
                                {{ $cartItem->comment }}
                            </p>
                        @endif
                    </div>
                @endunless
                <div class="price ms-3">
                    @if ($cartItem->hasConditions())
                        <s class="text-muted">{{currency_format($cartItem->subtotalWithoutConditions())}}</s>/
                    @endif
                    {{ currency_format($cartItem->subtotal) }}
                </div>
            </li>
        @endforeach
    </ul>
</div>
