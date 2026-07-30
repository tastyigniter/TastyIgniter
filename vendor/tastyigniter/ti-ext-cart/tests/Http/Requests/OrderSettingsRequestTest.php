<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\OrderSettingsRequest;

it('returns correct attribute labels', function(): void {
    $request = new OrderSettingsRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveCount(25)
        ->and($attributes)->toHaveKey('order_email.*', lang('igniter.cart::default.label_order_email'))
        ->and($attributes)->toHaveKey('processing_order_status', lang('igniter.cart::default.label_processing_order_status'))
        ->and($attributes)->toHaveKey('completed_order_status', lang('igniter.cart::default.label_completed_order_status'))
        ->and($attributes)->toHaveKey('canceled_order_status', lang('igniter.cart::default.label_canceled_order_status'))
        ->and($attributes)->toHaveKey('guest_order', lang('igniter.cart::default.label_guest_order'))
        ->and($attributes)->toHaveKey('location_order', lang('igniter.cart::default.label_location_order'))
        ->and($attributes)->toHaveKey('orders_auto_refresh', lang('igniter.cart::default.label_orders_auto_refresh'))
        ->and($attributes)->toHaveKey('orders_auto_refresh_interval', lang('igniter.cart::default.label_orders_auto_refresh_interval'))
        ->and($attributes)->toHaveKey('accepted_order_status', lang('igniter.cart::default.orders.label_accepted_order_status'))
        ->and($attributes)->toHaveKey('rejected_reasons', lang('igniter.cart::default.orders.label_rejected_reasons'))
        ->and($attributes)->toHaveKey('rejected_reasons.*.code', lang('igniter.cart::default.orders.label_reject_reason_code'))
        ->and($attributes)->toHaveKey('rejected_reasons.*.comment', lang('igniter.cart::default.orders.label_reject_reason_comment'))
        ->and($attributes)->toHaveKey('rejected_reasons.*.status_id', lang('igniter.cart::default.orders.label_reject_reason_status'))
        ->and($attributes)->toHaveKey('delay_times', lang('igniter.cart::default.orders.label_delay_times'))
        ->and($attributes)->toHaveKey('delay_times.*.comment', lang('igniter.cart::default.orders.label_delay_time_comment'))
        ->and($attributes)->toHaveKey('delay_times.*.time', lang('igniter.cart::default.orders.label_delay_time'))
        ->and($attributes)->toHaveKey('limit_users', lang('igniter.cart::default.orders.label_limit_users'))
        ->and($attributes)->toHaveKey('limit_users.*', lang('igniter.cart::default.orders.label_limit_user'))
        ->and($attributes)->toHaveKey('invoice_prefix', lang('igniter.cart::default.label_invoice_prefix'))
        ->and($attributes)->toHaveKey('invoice_logo', lang('igniter.cart::default.label_invoice_logo'))
        ->and($attributes)->toHaveKey('tax_mode', lang('igniter.cart::default.label_tax_mode'))
        ->and($attributes)->toHaveKey('tax_title', lang('igniter.cart::default.label_tax_title'))
        ->and($attributes)->toHaveKey('tax_percentage', lang('igniter.cart::default.label_tax_percentage'))
        ->and($attributes)->toHaveKey('tax_menu_price', lang('igniter.cart::default.label_tax_menu_price'))
        ->and($attributes)->toHaveKey('tax_delivery_charge', lang('igniter.cart::default.label_tax_delivery_charge'));
});

it('returns correct validation rules', function(): void {
    $request = new OrderSettingsRequest;

    $rules = $request->rules();

    expect($rules)->toHaveCount(27)
        ->and($rules)->toHaveKey('order_email.*')
        ->and($rules)->toHaveKey('processing_order_status')
        ->and($rules)->toHaveKey('completed_order_status')
        ->and($rules)->toHaveKey('processing_order_status.*')
        ->and($rules)->toHaveKey('completed_order_status.*')
        ->and($rules)->toHaveKey('canceled_order_status')
        ->and($rules)->toHaveKey('guest_order')
        ->and($rules)->toHaveKey('location_order')
        ->and($rules)->toHaveKey('orders_auto_refresh')
        ->and($rules)->toHaveKey('orders_auto_refresh_interval')
        ->and($rules)->toHaveKey('accepted_order_status')
        ->and($rules)->toHaveKey('rejected_reasons')
        ->and($rules)->toHaveKey('rejected_reasons.*.code')
        ->and($rules)->toHaveKey('rejected_reasons.*.comment')
        ->and($rules)->toHaveKey('rejected_reasons.*.status_id')
        ->and($rules)->toHaveKey('delay_times')
        ->and($rules)->toHaveKey('delay_times.*.comment')
        ->and($rules)->toHaveKey('delay_times.*.time')
        ->and($rules)->toHaveKey('limit_users')
        ->and($rules)->toHaveKey('limit_users.*')
        ->and($rules)->toHaveKey('invoice_prefix')
        ->and($rules)->toHaveKey('invoice_logo')
        ->and($rules)->toHaveKey('tax_mode')
        ->and($rules)->toHaveKey('tax_title')
        ->and($rules)->toHaveKey('tax_percentage')
        ->and($rules)->toHaveKey('tax_menu_price')
        ->and($rules)->toHaveKey('tax_delivery_charge')
        ->and($rules['order_email.*'])->toContain('required', 'alpha')
        ->and($rules['processing_order_status'])->toContain('required', 'array')
        ->and($rules['completed_order_status'])->toContain('required', 'array')
        ->and($rules['processing_order_status.*'])->toContain('required', 'integer')
        ->and($rules['completed_order_status.*'])->toContain('required', 'integer')
        ->and($rules['canceled_order_status'])->toContain('required', 'integer')
        ->and($rules['guest_order'])->toContain('required', 'integer')
        ->and($rules['location_order'])->toContain('required', 'integer')
        ->and($rules['orders_auto_refresh'])->toContain('nullable', 'integer')
        ->and($rules['orders_auto_refresh_interval'])->toContain('nullable', 'integer', 'min:5', 'max:3600')
        ->and($rules['accepted_order_status'])->toContain('nullable', 'integer')
        ->and($rules['rejected_reasons'])->toContain('nullable', 'array')
        ->and($rules['rejected_reasons.*.code'])->toContain('string', 'max:32')
        ->and($rules['rejected_reasons.*.comment'])->toContain('string', 'max:255')
        ->and($rules['rejected_reasons.*.status_id'])->toContain('integer')
        ->and($rules['delay_times'])->toContain('nullable', 'array')
        ->and($rules['delay_times.*.comment'])->toContain('string', 'max:255')
        ->and($rules['delay_times.*.time'])->toContain('integer', 'min:1', 'max:9999')
        ->and($rules['limit_users'])->toContain('nullable', 'array')
        ->and($rules['limit_users.*'])->toContain('nullable', 'integer')
        ->and($rules['invoice_prefix'])->toContain('nullable', 'regex:/^[a-zA-Z0-9-_\{\}]+$/')
        ->and($rules['invoice_logo'])->toContain('nullable', 'string')
        ->and($rules['tax_mode'])->toContain('required', 'integer')
        ->and($rules['tax_title'])->toContain('string', 'max:32')
        ->and($rules['tax_percentage'])->toContain('required_if:tax_mode,1', 'numeric')
        ->and($rules['tax_menu_price'])->toContain('nullable', 'numeric')
        ->and($rules['tax_delivery_charge'])->toContain('numeric');
});
