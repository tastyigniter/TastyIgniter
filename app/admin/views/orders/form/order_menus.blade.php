<div class="table-responsive">
    <table class="table mb-0">
        <thead>
        <tr>
            <th width="65%" class="border-top-0">@lang('admin::lang.orders.column_name_option')</th>
            <th class="text-center border-top-0">@lang('admin::lang.orders.column_quantity')</th>
            <th class="text-left border-top-0">@lang('admin::lang.orders.column_price')</th>
            <th class="text-right border-top-0">@lang('admin::lang.orders.column_total')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($model->getOrderMenusWithOptions() as $menuItem)
            <tr>
                <td><b>{{ $menuItem->name }}</b>
                    @php $menuItemOptionGroup = $menuItem->menu_options->groupBy('order_option_category') @endphp
                    @if($menuItemOptionGroup->isNotEmpty())
                        <ul class="list-unstyled mb-0 mt-2">
                            @foreach($menuItemOptionGroup as $menuItemOptionGroupName => $menuItemOptions)
                                <li>
                                    <u class="text-muted">{{ $menuItemOptionGroupName }}:</u>
                                    <ul class="list-unstyled">
                                        @foreach($menuItemOptions as $menuItemOption)
                                            <li>
                                                @if ($menuItemOption->quantity > 1)
                                                    {{ $menuItemOption->quantity }}x
                                                @endif
                                                {{ $menuItemOption->order_option_name }}&nbsp;
                                                @if($menuItemOption->order_option_price > 0)
                                                    ({{ currency_format($menuItemOption->quantity * $menuItemOption->order_option_price) }})
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if(!empty($menuItem->comment))
                        <p class="font-weight-bold">{{ $menuItem->comment }}</p>
                    @endif
                </td>
                <td class="text-center">{{ $menuItem->quantity }}</td>
                <td class="text-left">{{ currency_format($menuItem->price) }}</td>
                <td class="text-right"><b>{{ currency_format($menuItem->subtotal) }}</b></td>
            </tr>
        @endforeach
        <tr>
            <td class="border-top p-0" colspan="99999"></td>
        </tr>
        @foreach($model->getOrderTotals() as $total)
            @continue($model->isCollectionType() && $total->code == 'delivery')
            @php $thickLine = ($total->code == 'order_total' || $total->code == 'total') @endphp
            <tr>
                <td
                    class="{{ ($loop->iteration !== 1) ? 'border-top-0' : '' }} text-muted text-left"
                >
                    {{ $total->title }}
                    @if ($total->code == 'subtotal')
                        <span class="text-muted">({{ $formModel->total_items }} @lang('admin::lang.orders.label_total_items'))</span>
                    @endif
                </td>
                <td class="{{ ($loop->iteration !== 1) ? 'border-top-0' : '' }}"></td>
                <td class="{{ ($loop->iteration !== 1) ? 'border-top-0' : '' }}"></td>
                <td
                    class="{{ ($loop->iteration !== 1) ? 'border-top-0' : '' }} font-weight-bold text-right"
                >{{ currency_format($total->value) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
