<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class CheckoutSettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'guest_order' => lang('igniter.cart::default.label_guest_order'),
            'limit_orders' => lang('igniter.cart::default.checkout.label_limit_orders'),
            'limit_orders_count' => lang('igniter.cart::default.checkout.label_limit_orders_count'),
            'limit_orders_period.*.day_of_week.*' => lang('igniter.local::default.checkout.label_day_of_week'),
            'limit_orders_period.*.start_time' => lang('igniter.local::default.checkout.label_start_time'),
            'limit_orders_period.*.end_time' => lang('igniter.local::default.checkout.label_end_time'),
            'limit_orders_period.*.max_type' => lang('igniter.local::default.checkout.label_max_type'),
            'limit_orders_period.*.max_count' => lang('igniter.local::default.checkout.label_max_count'),
            'limit_orders_period.*.order_type.*' => lang('igniter.local::default.checkout.label_order_type'),
            'limit_orders_period.*.categories.*' => lang('igniter.local::default.checkout.label_categories'),
            'limit_orders_period.*.status' => lang('igniter::admin.label_status'),
            'payments.*' => lang('igniter.payregister::default.label_payments'),
        ];
    }

    public function rules(): array
    {
        return [
            'guest_order' => ['integer'],
            'limit_orders' => ['integer'],
            'limit_orders_count' => ['integer'],
            'limit_orders_period.*.day_of_week.*' => ['required', 'integer'],
            'limit_orders_period.*.start_time' => ['required', 'date_format:H:i'],
            'limit_orders_period.*.end_time' => ['required', 'date_format:H:i'],
            'limit_orders_period.*.max_type' => ['required', 'in:order,category'],
            'limit_orders_period.*.max_count' => ['required', 'integer'],
            'limit_orders_period.*.order_type.*' => ['nullable', 'string'],
            'limit_orders_period.*.categories.*' => ['nullable', 'string'],
            'limit_orders_period.*.status' => ['nullable', 'boolean'],
            'payments' => ['nullable'],
            'payments.*' => ['string'],
        ];
    }
}
