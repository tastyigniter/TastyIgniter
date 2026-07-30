@if (count($orders))
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
            <tr>
                <th>@lang('igniter.cart::default.orders.column_id')</th>
                <th>@lang('igniter.cart::default.orders.column_location')</th>
                <th>@lang('igniter.cart::default.orders.column_status')</th>
                <th>@lang('igniter.cart::default.orders.column_date')</th>
                <th>@lang('igniter.cart::default.orders.column_total')</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr @class(['align-middle', 'border-top' => !$loop->first])>
                    <td>
                        <a
                            class="btn btn-light"
                            href="{{ page_url($orderPage, ['orderId' => $order->order_id, 'hash' => $order->hash]) }}"
                        >#{{ $order->order_id }}</a>
                    </td>
                    <td>{{ $order->location ? $order->location->location_name : '' }}</td>
                    <td><b>{{ $order->status ? $order->status->status_name : '' }}</b></td>
                    <td>{{ $order->order_date->setTimeFromTimeString($order->order_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}</td>
                    <td>{{ currency_format($order->order_total) }}
                        ({!! $order->total_items.' '.lang('igniter.cart::default.orders.column_items') !!})
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-bar text-right">
        <div class="links">{!! $orders->links() !!}</div>
    </div>
@else
    <p>@lang('igniter.cart::default.orders.text_empty')</p>
@endif
