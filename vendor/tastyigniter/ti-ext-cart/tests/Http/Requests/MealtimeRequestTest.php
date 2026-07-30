<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\MealtimeRequest;

it('returns correct attribute labels', function(): void {
    $request = new MealtimeRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('mealtime_name', lang('igniter.cart::default.mealtimes.label_mealtime_name'))
        ->and($attributes)->toHaveKey('validity', lang('igniter.cart::default.mealtimes.label_validity'))
        ->and($attributes)->toHaveKey('start_time', lang('igniter.cart::default.mealtimes.label_start_time'))
        ->and($attributes)->toHaveKey('end_time', lang('igniter.cart::default.mealtimes.label_end_time'))
        ->and($attributes)->toHaveKey('start_at', lang('igniter.cart::default.mealtimes.label_start_at'))
        ->and($attributes)->toHaveKey('end_at', lang('igniter.cart::default.mealtimes.label_end_at'))
        ->and($attributes)->toHaveKey('recurring_every', lang('igniter.cart::default.mealtimes.label_recurring_every'))
        ->and($attributes)->toHaveKey('recurring_from', lang('igniter.cart::default.mealtimes.label_recurring_from'))
        ->and($attributes)->toHaveKey('recurring_to', lang('igniter.cart::default.mealtimes.label_recurring_to'))
        ->and($attributes)->toHaveKey('mealtime_status', lang('igniter::admin.label_status'))
        ->and($attributes)->toHaveKey('locations.*', lang('igniter::admin.label_location'));
});

it('returns correct validation rules', function(): void {
    $request = new MealtimeRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('mealtime_name')
        ->and($rules)->toHaveKey('validity')
        ->and($rules)->toHaveKey('start_time')
        ->and($rules)->toHaveKey('end_time')
        ->and($rules)->toHaveKey('start_at')
        ->and($rules)->toHaveKey('end_at')
        ->and($rules)->toHaveKey('recurring_every')
        ->and($rules)->toHaveKey('recurring_every.*')
        ->and($rules)->toHaveKey('recurring_from')
        ->and($rules)->toHaveKey('recurring_to')
        ->and($rules)->toHaveKey('mealtime_status')
        ->and($rules)->toHaveKey('locations')
        ->and($rules)->toHaveKey('locations.*')
        ->and($rules['mealtime_name'])->toContain('required', 'string', 'between:2,255')
        ->and($rules['validity'])->toContain('required', 'in:daily,period,recurring')
        ->and($rules['start_time'])->toContain('nullable', 'required_if:validity,daily', 'date_format:H:i')
        ->and($rules['end_time'])->toContain('nullable', 'required_if:validity,daily', 'date_format:H:i')
        ->and($rules['start_at'])->toContain('nullable', 'required_if:validity,period', 'date')
        ->and($rules['end_at'])->toContain('nullable', 'required_if:validity,period', 'date', 'after:start_date')
        ->and($rules['recurring_every'])->toContain('nullable', 'required_if:validity,recurring', 'array')
        ->and($rules['recurring_every.*'])->toContain('nullable', 'required_if:validity,recurring', 'integer')
        ->and($rules['recurring_from'])->toContain('nullable', 'required_if:validity,recurring', 'date_format:H:i')
        ->and($rules['recurring_to'])->toContain('nullable', 'required_if:validity,recurring', 'date_format:H:i')
        ->and($rules['mealtime_status'])->toContain('required', 'boolean')
        ->and($rules['locations'])->toContain('nullable', 'array')
        ->and($rules['locations.*'])->toContain('integer');
});
