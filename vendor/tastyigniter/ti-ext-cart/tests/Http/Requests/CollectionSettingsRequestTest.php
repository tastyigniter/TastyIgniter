<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\CollectionSettingsRequest;

it('returns correct attribute labels', function(): void {
    $request = new CollectionSettingsRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('is_enabled', lang('igniter.local::default.label_offer_collection'))
        ->and($attributes)->toHaveKey('time_interval', lang('igniter.local::default.label_collection_time_interval'))
        ->and($attributes)->toHaveKey('lead_time', lang('igniter.local::default.label_collection_lead_time'))
        ->and($attributes)->toHaveKey('future_orders.is_enabled', lang('igniter.local::default.label_future_collection_order'))
        ->and($attributes)->toHaveKey('future_orders.min_days', lang('igniter.local::default.label_future_min_collection_days'))
        ->and($attributes)->toHaveKey('future_orders.days', lang('igniter.local::default.label_future_collection_days'))
        ->and($attributes)->toHaveKey('time_restriction', lang('igniter.local::default.label_collection_time_restriction'))
        ->and($attributes)->toHaveKey('cancellation_timeout', lang('igniter.local::default.label_collection_cancellation_timeout'))
        ->and($attributes)->toHaveKey('add_lead_time', lang('igniter.local::default.label_collection_add_lead_time'))
        ->and($attributes)->toHaveKey('min_order_amount', lang('igniter.local::default.label_collection_min_order_amount'));
});

it('returns correct validation rules', function(): void {
    $request = new CollectionSettingsRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('is_enabled')
        ->and($rules)->toHaveKey('time_interval')
        ->and($rules)->toHaveKey('lead_time')
        ->and($rules)->toHaveKey('future_orders.is_enabled')
        ->and($rules)->toHaveKey('future_orders.min_days')
        ->and($rules)->toHaveKey('future_orders.days')
        ->and($rules)->toHaveKey('time_restriction')
        ->and($rules)->toHaveKey('add_lead_time')
        ->and($rules)->toHaveKey('cancellation_timeout')
        ->and($rules)->toHaveKey('min_order_amount')
        ->and($rules['is_enabled'])->toContain('boolean')
        ->and($rules['time_interval'])->toContain('integer', 'min:5')
        ->and($rules['lead_time'])->toContain('integer', 'min:5')
        ->and($rules['future_orders.is_enabled'])->toContain('boolean')
        ->and($rules['future_orders.min_days'])->toContain('integer', 'min:0')
        ->and($rules['future_orders.days'])->toContain('integer', 'min:0', 'gt:future_orders.min_days')
        ->and($rules['time_restriction'])->toContain('nullable', 'integer', 'max:2')
        ->and($rules['add_lead_time'])->toContain('boolean')
        ->and($rules['cancellation_timeout'])->toContain('integer', 'min:0', 'max:999')
        ->and($rules['min_order_amount'])->toContain('numeric', 'min:0');
});
