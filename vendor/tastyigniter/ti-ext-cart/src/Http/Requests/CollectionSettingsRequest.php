<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class CollectionSettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'is_enabled' => lang('igniter.local::default.label_offer_collection'),
            'time_interval' => lang('igniter.local::default.label_collection_time_interval'),
            'lead_time' => lang('igniter.local::default.label_collection_lead_time'),
            'future_orders.is_enabled' => lang('igniter.local::default.label_future_collection_order'),
            'future_orders.min_days' => lang('igniter.local::default.label_future_min_collection_days'),
            'future_orders.days' => lang('igniter.local::default.label_future_collection_days'),
            'time_restriction' => lang('igniter.local::default.label_collection_time_restriction'),
            'cancellation_timeout' => lang('igniter.local::default.label_collection_cancellation_timeout'),
            'add_lead_time' => lang('igniter.local::default.label_collection_add_lead_time'),
            'min_order_amount' => lang('igniter.local::default.label_collection_min_order_amount'),
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
