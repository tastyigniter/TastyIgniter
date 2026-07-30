<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Requests;

use Igniter\Reservation\Http\Requests\DiningTableRequest;

it('returns correct attribute labels for dining table', function(): void {
    $attributes = (new DiningTableRequest)->attributes();

    expect($attributes['name'])->toBe(lang('igniter::admin.label_name'))
        ->and($attributes['shape'])->toBe(lang('igniter.reservation::default.dining_tables.label_table_shape'))
        ->and($attributes['min_capacity'])->toBe(lang('igniter.reservation::default.tables.label_min_capacity'))
        ->and($attributes['max_capacity'])->toBe(lang('igniter.reservation::default.tables.label_capacity'))
        ->and($attributes['extra_capacity'])->toBe(lang('igniter.reservation::default.tables.label_extra_capacity'))
        ->and($attributes['priority'])->toBe(lang('igniter.reservation::default.tables.label_priority'))
        ->and($attributes['is_enabled'])->toBe(lang('igniter::admin.label_status'))
        ->and($attributes['dining_area_id'])->toBe(lang('igniter.reservation::default.dining_tables.label_dining_areas'))
        ->and($attributes['dining_section_id'])->toBe(lang('igniter.reservation::default.dining_tables.column_section'));
});

it('validates rules correctly for dining table', function(): void {
    $rules = (new DiningTableRequest)->rules();

    expect($rules['name'])->toBe(['required', 'string', 'between:2,255'])
        ->and($rules['shape'])->toBe(['required', 'in:rectangle,round'])
        ->and($rules['min_capacity'])->toBe(['required', 'integer', 'min:1', 'lte:max_capacity'])
        ->and($rules['max_capacity'])->toBe(['required', 'integer', 'min:1', 'gte:min_capacity'])
        ->and($rules['extra_capacity'])->toBe(['sometimes', 'integer'])
        ->and($rules['priority'])->toBe(['sometimes', 'integer'])
        ->and($rules['is_enabled'])->toBe(['sometimes', 'boolean'])
        ->and($rules['dining_area_id'])->toBe(['required', 'integer'])
        ->and($rules['dining_section_id'])->toBe(['nullable', 'integer']);
});
