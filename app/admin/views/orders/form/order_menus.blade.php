<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th width="65%">@lang('admin::lang.orders.column_name_option')</th>
            <th class="text-left">@lang('admin::lang.orders.column_price')</th>
            <th class="text-right">@lang('admin::lang.orders.column_total')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($model->getOrderMenusWithOptions() as $menuItem)
            <tr>
                <td class="align-top">{{ $menuItem->quantity }}x</td>
                <td><b>{{ $menuItem->name }}</b>
                    @php $menuItemOptionGroup = $menuItem->menu_options->groupBy('order_option_category') @endphp
                    @if($menuItemOptionGroup->isNotEmpty())
                        <ul class="list-unstyled">
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
                <td class="text-left">{{ currency_format($menuItem->price) }}</td>
                <td class="text-right">{{ currency_format($menuItem->subtotal) }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="border-top p-0" colspan="99999"></td>
        </tr>
        @foreach($model->getOrderTotals() as $total)
            @continue($model->isCollectionType() AND $total->code == 'delivery')
            @php $thickLine = ($total->code == 'order_total' OR $total->code == 'total') @endphp
            <tr>
                <td
                    class="{{ ($loop->iteration === 1 OR $thickLine) ? 'lead font-weight-bold' : 'text-muted' }}" width="1"
                ></td>
                <td
                    class="{{ ($loop->iteration === 1 OR $thickLine) ? 'lead font-weight-bold' : 'text-muted' }}"
                ></td>
                <td
                    class="{{ ($loop->iteration === 1 OR $thickLine) ? 'lead font-weight-bold' : 'text-muted' }} text-left"
                >{{ $total->title }}</td>
                <td
                    class="{{ ($loop->iteration === 1 OR $thickLine) ? 'lead font-weight-bold' : '' }} text-right"
                >{{ currency_format($total->value) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
