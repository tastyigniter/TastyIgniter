<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class DeliverySettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'is_enabled' => lang('igniter.local::default.label_is_enabled'),
            'add_lead_time' => lang('igniter.local::default.label_delivery_add_lead_time'),
            'time_interval' => lang('igniter.local::default.label_delivery_time_interval'),
            'lead_time' => lang('igniter.local::default.label_delivery_lead_time'),
            'time_restriction' => lang('igniter.local::default.label_delivery_time_restriction'),
            'cancellation_timeout' => lang('igniter.local::default.label_delivery_cancellation_timeout'),
            'min_order_amount' => lang('igniter.local::default.label_delivery_min_order_amount'),
            'future_orders.is_enabled' => lang('igniter.local::default.label_future_delivery_order'),
            'future_orders.min_days' => lang('igniter.local::default.label_future_min_delivery_days'),
            'future_orders.days' => lang('igniter.local::default.label_future_delivery_days'),
        ];
    }

    public function rules(): array
    {
        return [
            'is_enabled' => ['boolean'],
            'add_lead_time' => ['boolean'],
            'time_interval' => ['integer', 'min:5'],
            'lead_time' => ['integer', 'min:5'],
            'time_restriction' => ['nullable', 'integer', 'max:2'],
            'cancellation_timeout' => ['integer', 'min:0', 'max:999'],
            'min_order_amount' => ['numeric', 'min:0'],
            'future_orders.is_enabled' => ['boolean'],
            'future_orders.min_days' => ['integer', 'min:0'],
            'future_orders.days' => ['integer', 'min:0', 'gt:future_orders.min_days'],
        ];
    }
}
