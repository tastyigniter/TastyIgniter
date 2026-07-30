<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class OrderSettingsRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'order_email.*' => lang('igniter.cart::default.label_order_email'),
            'processing_order_status' => lang('igniter.cart::default.label_processing_order_status'),
            'completed_order_status' => lang('igniter.cart::default.label_completed_order_status'),
            'canceled_order_status' => lang('igniter.cart::default.label_canceled_order_status'),
            'guest_order' => lang('igniter.cart::default.label_guest_order'),
            'location_order' => lang('igniter.cart::default.label_location_order'),
            'orders_auto_refresh' => lang('igniter.cart::default.label_orders_auto_refresh'),
            'orders_auto_refresh_interval' => lang('igniter.cart::default.label_orders_auto_refresh_interval'),

            'accepted_order_status' => lang('igniter.cart::default.orders.label_accepted_order_status'),
            'rejected_reasons' => lang('igniter.cart::default.orders.label_rejected_reasons'),
            'rejected_reasons.*.code' => lang('igniter.cart::default.orders.label_reject_reason_code'),
            'rejected_reasons.*.comment' => lang('igniter.cart::default.orders.label_reject_reason_comment'),
            'rejected_reasons.*.status_id' => lang('igniter.cart::default.orders.label_reject_reason_status'),
            'delay_times' => lang('igniter.cart::default.orders.label_delay_times'),
            'delay_times.*.comment' => lang('igniter.cart::default.orders.label_delay_time_comment'),
            'delay_times.*.time' => lang('igniter.cart::default.orders.label_delay_time'),
            'limit_users' => lang('igniter.cart::default.orders.label_limit_users'),
            'limit_users.*' => lang('igniter.cart::default.orders.label_limit_user'),

            'invoice_prefix' => lang('igniter.cart::default.label_invoice_prefix'),
            'invoice_logo' => lang('igniter.cart::default.label_invoice_logo'),

            'tax_mode' => lang('igniter.cart::default.label_tax_mode'),
            'tax_title' => lang('igniter.cart::default.label_tax_title'),
            'tax_percentage' => lang('igniter.cart::default.label_tax_percentage'),
            'tax_menu_price' => lang('igniter.cart::default.label_tax_menu_price'),
            'tax_delivery_charge' => lang('igniter.cart::default.label_tax_delivery_charge'),
        ];
    }

    public function rules(): array
    {
        return [
            'order_email.*' => ['required', 'alpha'],
            'processing_order_status' => ['required', 'array'],
            'completed_order_status' => ['required', 'array'],
            'processing_order_status.*' => ['required', 'integer'],
            'completed_order_status.*' => ['required', 'integer'],
            'canceled_order_status' => ['required', 'integer'],
            'guest_order' => ['required', 'integer'],
            'location_order' => ['required', 'integer'],
            'orders_auto_refresh' => ['nullable', 'integer'],
            'orders_auto_refresh_interval' => ['nullable', 'integer', 'min:5', 'max:3600'],

            'accepted_order_status' => ['nullable', 'integer'],
            'rejected_reasons' => ['nullable', 'array'],
            'rejected_reasons.*.code' => ['string', 'max:32'],
            'rejected_reasons.*.comment' => ['string', 'max:255'],
            'rejected_reasons.*.status_id' => ['integer'],
            'delay_times' => ['nullable', 'array'],
            'delay_times.*.comment' => ['string', 'max:255'],
            'delay_times.*.time' => ['integer', 'min:1', 'max:9999'],
            'limit_users' => ['nullable', 'array'],
            'limit_users.*' => ['nullable', 'integer'],

            'invoice_prefix' => ['nullable', 'regex:/^[a-zA-Z0-9-_\{\}]+$/'],
            'invoice_logo' => ['nullable', 'string'],

            'tax_mode' => ['required', 'integer'],
            'tax_title' => ['string', 'max:32'],
            'tax_percentage' => ['required_if:tax_mode,1', 'numeric'],
            'tax_menu_price' => ['nullable', 'numeric'],
            'tax_delivery_charge' => ['numeric'],
        ];
    }
}
