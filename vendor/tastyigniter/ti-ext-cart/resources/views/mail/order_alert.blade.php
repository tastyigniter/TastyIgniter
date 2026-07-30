subject = "New order on {{$site_name}}"
==
You received an order!

You just received an order from {{$location_name}}.

The order number is {{$order_number}}
This is a {{$order_type}} order.

Customer name: {{$first_name}} {{$last_name}}
Order date: {{$order_date}}
Requested {{$order_type}} time: {{$order_time}}
Payment Method: {{$order_payment}}

{{$order_address}}
Restaurant: {{$location_name}}

{{$order_comment}}

@if(!empty($order_menus))
    @foreach($order_menus as $order_menu)
        {{ $order_menu['menu_quantity'] }} x {{ $order_menu['menu_name'] }}
        {!! $order_menu['menu_options'] !!}
        - {{ $order_menu['menu_price'] }}
        - {{ $order_menu['menu_subtotal'] }}
        {!! $order_menu['menu_comment'] !!}
    @endforeach
@endif

@if(!empty($order_totals))
    @foreach($order_totals as $order_total)
        {{ $order_total['order_total_title'] }}
        {{ $order_total['order_total_value'] }}
    @endforeach
@endif
==
## You just received a {{$order_type}} order ({{$order_number}}) from {{$location_name}}.

**Customer name:** {{$first_name}} {{$last_name}}<br>
**Order date:** {{$order_date}}<br>
**Requested {{$order_type}} time:** {{$order_time}}<br>
**Payment Method:** {{$order_payment}}<br>
**Restaurant:** {{$location_name}}<br>
**Delivery Address:** {{$order_address}}

{{$order_comment}}

@partial('table')
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th width="50%" align="left">Name/Description</th>
        <th align="right">Unit Price</th>
        <th align="right">Sub Total</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($order_menus))
        @foreach($order_menus as $order_menu)
            <tr>
                <td>{{ $order_menu['menu_quantity'] }} x {{ $order_menu['menu_name'] }}<br>{!! $order_menu['menu_options'] !!}<br>{!! $order_menu['menu_comment'] !!}</td>
                <td align="right">{{ $order_menu['menu_price'] }}</td>
                <td align="right">{{ $order_menu['menu_subtotal'] }}</td>
            </tr>
        @endforeach
    @endif
    <tr>
        <td colspan="3">
            <hr>
        </td>
    </tr>
    @if(!empty($order_totals))
        @foreach($order_totals as $order_total)
            <tr>
                <td><br></td>
                <td align="right">{{ $order_total['order_total_title'] }}</td>
                <td align="right">{{ $order_total['order_total_value'] }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
@endpartial
