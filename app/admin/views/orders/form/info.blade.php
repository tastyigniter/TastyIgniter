<div class="d-flex">
    <div class="mr-3 flex-fill">
        <label class="control-label">
            @lang('admin::lang.orders.label_order_id')
        </label>
        <h3>#{{ $formModel->order_id }}</h3>
    </div>
    <div class="mr-3 flex-fill text-center">
        <label class="control-label">
            @lang('admin::lang.orders.label_total_items')
        </label>
        <h3>{{ $formModel->total_items }}</h3>
    </div>
    <div class="flex-fill text-center">
        <label class="control-label">
            @lang('admin::lang.orders.label_order_total')
        </label>
        <h3>{{ currency_format($formModel->order_total) }}</h3>
    </div>
</div>
