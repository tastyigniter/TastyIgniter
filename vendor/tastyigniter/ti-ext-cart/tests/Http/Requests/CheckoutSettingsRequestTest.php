<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\CheckoutSettingsRequest;

it('returns correct attribute labels', function(): void {
    $request = new CheckoutSettingsRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('guest_order', lang('igniter.cart::default.label_guest_order'))
        ->and($attributes)->toHaveKey('limit_orders_period.*.day_of_week.*', lang('igniter.local::default.checkout.label_day_of_week'))
        ->and($attributes)->toHaveKey('limit_orders_period.*.start_time', lang('igniter.local::default.checkout.label_start_time'))
        ->and($attributes)->toHaveKey('limit_orders_period.*.end_time', lang('igniter.local::default.checkout.label_end_time'))
        ->and($attributes)->toHaveKey('limit_orders_period.*.max_type', lang('igniter.local::default.checkout.label_max_type'))
        ->and($attributes)->toHaveKey('limit_orders_period.*.max_count', lang('igniter.local::default.checkout.label_max_count'))
        ->and($attributes)->toHaveKey('limit_orders_period.*.order_type.*', lang('igniter.local::default.checkout.label_order_type'))
        ->and($attributes)->toHaveKey('limit_orders_period.*.categories.*', lang('igniter.local::default.checkout.label_categories'))
        ->and($attributes)->toHaveKey('limit_orders_period.*.status', lang('igniter::admin.label_status'))
        ->and($attributes)->toHaveKey('payments.*', lang('igniter.payregister::default.label_payments'));
});

it('returns correct validation rules', function(): void {
    $request = new CheckoutSettingsRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('guest_order')
        ->and($rules)->toHaveKey('limit_orders_period.*.day_of_week.*')
        ->and($rules)->toHaveKey('limit_orders_period.*.start_time')
        ->and($rules)->toHaveKey('limit_orders_period.*.end_time')
        ->and($rules)->toHaveKey('limit_orders_period.*.max_type')
        ->and($rules)->toHaveKey('limit_orders_period.*.max_count')
        ->and($rules)->toHaveKey('limit_orders_period.*.order_type.*')
        ->and($rules)->toHaveKey('limit_orders_period.*.categories.*')
        ->and($rules)->toHaveKey('limit_orders_period.*.status')
        ->and($rules)->toHaveKey('payments.*')
        ->and($rules['guest_order'])->toContain('integer')
        ->and($rules['limit_orders_period.*.day_of_week.*'])->toContain('required', 'integer')
        ->and($rules['limit_orders_period.*.start_time'])->toContain('required', 'date_format:H:i')
        ->and($rules['limit_orders_period.*.end_time'])->toContain('required', 'date_format:H:i')
        ->and($rules['limit_orders_period.*.max_type'])->toContain('required', 'in:order,category')
        ->and($rules['limit_orders_period.*.max_count'])->toContain('required', 'integer')
        ->and($rules['limit_orders_period.*.order_type.*'])->toContain('nullable', 'string')
        ->and($rules['limit_orders_period.*.categories.*'])->toContain('nullable', 'string')
        ->and($rules['limit_orders_period.*.status'])->toContain('nullable', 'boolean')
        ->and($rules['payments'])->toContain('nullable')
        ->and($rules['payments.*'])->toContain('string');
});
