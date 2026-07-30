<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Http\Requests;

use Igniter\Local\Http\Requests\WorkingHourRequest;

it('returns correct attribute labels', function(): void {
    $attributes = (new WorkingHourRequest)->attributes();

    expect($attributes)->toHaveKey('type', lang('igniter.local::default.label_schedule_type'))
        ->and($attributes)->toHaveKey('days.*', lang('igniter.local::default.label_schedule_days'))
        ->and($attributes)->toHaveKey('open', lang('igniter.local::default.label_schedule_open'))
        ->and($attributes)->toHaveKey('close', lang('igniter.local::default.label_schedule_close'))
        ->and($attributes)->toHaveKey('timesheet', lang('igniter.local::default.text_timesheet'))
        ->and($attributes)->toHaveKey('flexible.*.day', lang('igniter.local::default.label_schedule_days'))
        ->and($attributes)->toHaveKey('flexible.*.hours', lang('igniter.local::default.label_schedule_hours'))
        ->and($attributes)->toHaveKey('flexible.*.status', lang('igniter::admin.label_status'));
});

it('returns correct validation rules', function(): void {
    $rules = (new WorkingHourRequest)->rules();

    expect($rules)->toHaveKey('type', ['alpha_dash', 'in:24_7,daily,timesheet,flexible'])
        ->and($rules)->toHaveKey('days.*', ['required_if:type,daily', 'integer', 'between:0,7'])
        ->and($rules)->toHaveKey('open', ['required_if:type,daily', 'date_format:H:i'])
        ->and($rules)->toHaveKey('close', ['required_if:type,daily', 'date_format:H:i'])
        ->and($rules)->toHaveKey('timesheet', ['required_if:type,timesheet', 'string'])
        ->and($rules)->toHaveKey('flexible', ['required_if:type,flexible', 'array'])
        ->and($rules)->toHaveKey('flexible.*.day', ['required_if:type,flexible', 'numeric'])
        ->and($rules)->toHaveKey('flexible.*.hours', ['required_if:type,flexible'])
        ->and($rules)->toHaveKey('flexible.*.status', ['sometimes', 'required_if:type,flexible', 'boolean']);
});
