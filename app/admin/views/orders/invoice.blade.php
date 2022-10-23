<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{!! $model->invoice_number.' - '.lang('admin::lang.orders.text_invoice').' - '.setting('site_name') !!}</title>
    {!! get_style_tags() !!}
    <style>
        body {
            background-color: #FFF;
            color: #000;
        }
    </style>
</head>
<body>
<div class="container-fluid p-5">
    <div class="row">
        <div class="col">
            <div class="invoice-title">
                <h3 class="pull-right">@lang('admin::lang.orders.label_order_id')&nbsp;#{{$model->order_id}}</h3>
                <h2>@lang('admin::lang.orders.text_invoice')</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col py-3">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <strong>@lang('admin::lang.orders.text_restaurant')</strong><br>
            <span>{{ $model->location->getName() }}</span><br>
            <address>{{ format_address($model->location->getAddress(), true) }}</address>
        </div>
        <div class="col-6 text-right">
            <img class="img-responsive" src="{{ uploads_url(setting('invoice_logo') ?: setting('site_logo')) }}" alt="" style="max-height:120px;" />
        </div>
    </div>

    <div class="row">
        <div class="col">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <p>
                <strong>@lang('admin::lang.orders.text_customer')</strong><br>
                {{ $model->first_name.' '.$model->last_name.' ('.$model->email.')' }}
            </p>
            @if($model->isDeliveryType())
                <div>
                    <strong>@lang('admin::lang.orders.text_deliver_to')</strong><br>
                    <address>{{ $model->formatted_address }}</address>
                </div>
            @endif
        </div>
        <div class="col-3 text-left">
            <p>
                <strong>@lang('admin::lang.orders.text_invoice_no')</strong><br>
                {{ $model->invoice_number }}
            </p>
            <p>
                <strong>@lang('admin::lang.orders.text_invoice_date')</strong><br>
                {{ $model->invoice_date->format(lang('system::lang.php.date_format')) }}<br><br>
            </p>
        </div>
        <div class="col-3 text-right">
            <p>
                <strong>@lang('admin::lang.orders.text_payment')</strong><br>
                {{ $model->payment_method ? $model->payment_method->name : '' }}
            </p>
            <p>
                <strong>@lang('admin::lang.orders.text_order_date')</strong><br>
                {{ $model->order_date->setTimeFromTimeString($model->order_time)->format(lang('system::lang.php.date_time_format')) }}
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="2%"></th>
                        <th class="text-left" width="65%">
                            <b>@lang('admin::lang.orders.column_name_option')</b>
                        </th>
                        <th class="text-left"><b>@lang('admin::lang.orders.column_price')</b></th>
                        <th class="text-right"><b>@lang('admin::lang.orders.column_total')</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($model->getOrderMenusWithOptions() as $menuItem)
                        <tr>
                            <td>{{ $menuItem->quantity }}x</td>
                            <td class="text-left"><b>{{ $menuItem->name }}</b><br />
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
                                                                {{ $menuItemOption->quantity }}&nbsp;&times;
                                                            @endif
                                                            {{ $menuItemOption->order_option_name }}&nbsp;
                                                            @if ($menuItemOption->order_option_price > 0)
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
                                    <div>
                                        <small><b>{{ $menuItem->comment }}</b></small>
                                    </div>
                                @endif
                            </td>
                            <td class="text-left">{{ currency_format($menuItem->price) }}</td>
                            <td class="text-right">{{ currency_format($menuItem->subtotal) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    @foreach($model->getOrderTotals() as $total)
                        @continue($model->isCollectionType() && $total->code == 'delivery')
                        @php $thickLine = ($total->code == 'order_total' || $total->code == 'total') @endphp
                        <tr>
                            <td class="{{ ($loop->iteration === 1 || $thickLine) ? 'thick' : 'no' }}-line" width="1"></td>
                            <td class="{{ ($loop->iteration === 1 || $thickLine) ? 'thick' : 'no' }}-line"></td>
                            <td class="{{ ($loop->iteration === 1 || $thickLine) ? 'thick' : 'no' }}-line text-left">{{ $total->title }}</td>
                            <td class="{{ ($loop->iteration === 1 || $thickLine) ? 'thick' : 'no' }}-line text-right">{{ currency_format($total->value) }}</td>
                        </tr>
                    @endforeach
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p class="text-center">@lang('admin::lang.orders.text_invoice_thank_you')</p>
        </div>
    </div>
</div>
</body>
</html>
