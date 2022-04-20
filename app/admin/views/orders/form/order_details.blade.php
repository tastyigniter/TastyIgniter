<div class="table-responsive">
    <table class="table table-borderless mb-0">
        <tbody>
        @if($formModel->payment_method)
            <tr>
                <td class="text-muted">@lang('admin::lang.orders.label_payment_method')</td>
                <td class="text-right">{{ $formModel->payment_method->name }}</td>
            </tr>
        @endif
        <tr>
            <td class="text-muted">@lang('admin::lang.orders.label_invoice')</td>
            <td class="text-right">
                @if ($formModel->hasInvoice())
                    <a
                        class="font-weight-bold"
                        href="{{ admin_url('orders/invoice/'.$formModel->order_id) }}"
                        target="_blank"
                    >{{ $formModel->invoice_number }}</a>
                @else
                    {{ $formModel->invoice_number }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-muted">@lang('admin::lang.orders.label_date_added')</td>
            <td class="text-right">{{ $formModel->created_at->isoFormat(lang('system::lang.moment.date_time_format_short')) }}</td>
        </tr>
        <tr>
            <td class="text-muted">@lang('admin::lang.orders.label_date_modified')</td>
            <td class="text-right">{{ $formModel->updated_at->isoFormat(lang('system::lang.moment.date_time_format_short')) }}</td>
        </tr>
        <tr>
            <td class="text-muted">@lang('admin::lang.orders.label_ip_address')</td>
            <td class="text-right">{{ $formModel->ip_address }}</td>
        </tr>
        <tr>
            <td class="text-muted">@lang('admin::lang.orders.label_user_agent')</td>
            <td class="text-right">{{ $formModel->user_agent }}</td>
        </tr>
        </tbody>
    </table>
</div>
