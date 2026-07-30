<h6 class="mb-0 text-muted">@lang('igniter.cart::default.checkout.text_order_details')</h6>

<div class="cart-items pt-2">
    <ul class="list-unstyled">
        @foreach ($order->getOrderMenusWithOptions() as $orderItem)
            <li>
                <span class="price pull-right">{{ currency_format($orderItem->subtotal) }}</span>
                <span class="name fw-bold">
                    @if ($orderItem->quantity > 1)
                        <span class="quantity">
                            {{ $orderItem->quantity }} @lang('igniter.cart::default.text_times')
                        </span>
                    @endif
                    {{ $orderItem->name }}
                </span>
                @if ($orderItem->menu_options->isNotEmpty())
                    <ul class="list-unstyled small">
                        @foreach ($orderItem->menu_options as $itemOptionGroupName => $itemOptions)
                            <li>
                                <u class="text-muted">{{ $itemOptionGroupName }}:</u>
                                <ul class="list-unstyled">
                                    @foreach ($itemOptions as $itemOption)
                                        <li>
                                            @if ($itemOption->quantity > 1)
                                                {{ $itemOption->quantity }} @lang('igniter.cart::default.text_times')
                                            @endif
                                            {{ $itemOption->order_option_name }}&nbsp;
                                            @if ($itemOption->order_option_price > 0)
                                                ({{ currency_format($itemOption->quantity * $itemOption->order_option_price) }})
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if (!empty($orderItem->comment))
                    <p class="comment text-muted small">
                        {!! $orderItem->comment !!}
                    </p>
                @endif
            </li>
        @endforeach
    </ul>
</div>

<div class="cart-totals">
    <div class="table-responsive">
        <table class="table table-sm table-borderless mb-0">
            <tbody>
            <tr>
                <td class="border-top p-0" colspan="99999"></td>
            </tr>
            @foreach ($order->getOrderTotals() as $orderTotal)
                @continue($order->isCollectionType() && $orderTotal->code == 'delivery')
                @php($thickLine = in_array($orderTotal->code, ['order_total', 'total']))
                @continue(!$thickLine && (!$orderTotal->is_summable && $orderTotal->code !== 'subtotal'))
                <tr>
                    <td class="px-0 {{ $thickLine ? 'border-top lead fw-bold' : 'text-muted border-0' }}">
                        {{ $orderTotal->title }}
                    </td>
                    <td class="text-right px-0 {{ $thickLine ? 'border-top lead fw-bold' : 'border-0' }}">
                        {{ currency_format($orderTotal->value) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
