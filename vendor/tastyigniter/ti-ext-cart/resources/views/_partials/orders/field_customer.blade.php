<div class="card-body">
    <h5 class="card-title">@lang($field->label)</h5>
    <div class="py-2 lead">
        @if($formModel->customer)
            <a href="{{ admin_url('customers/preview/'.$formModel->customer_id) }}">{{ $formModel->customer_name }}</a>
        @else
            {{ $formModel->customer_name }}
        @endif
    </div>
    @unless(array_get($field->config, 'hideEmail', false))
        <div class="py-2">
            <i class="fa fa-envelope fa-fw text-muted"></i>&nbsp;&nbsp;
            {{ $formModel->email }}
        </div>
    @endunless
    @if(!array_get($field->config, 'hideTelephone', false) && $formModel->telephone)
        <div class="py-2">
            <i class="fa fa-phone fa-fw text-muted"></i>&nbsp;&nbsp;
            {{ $formModel->telephone }}
        </div>
    @endif
</div>
@if($formModel->isDeliveryType() && $formModel->address)
    <div class="card-body border-top">
        <h5 class="card-title">@lang('igniter.cart::default.orders.label_delivery_address')</h5>
        <div class="py-2">
            {{ html(format_address($formModel->address->toArray())) }}
        </div>
    </div>
@endif
