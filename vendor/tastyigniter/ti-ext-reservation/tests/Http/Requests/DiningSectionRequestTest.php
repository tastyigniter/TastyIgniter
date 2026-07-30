<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Requests;

use Igniter\Reservation\Http\Requests\DiningSectionRequest;

it('returns correct attribute labels for dining section', function(): void {
    $attributes = (new DiningSectionRequest)->attributes();

    expect($attributes['location_id'])->toBe(lang('igniter::admin.label_location'))
        ->and($attributes['name'])->toBe(lang('igniter::admin.label_name'))
        ->and($attributes['priority'])->toBe(lang('igniter.reservation::default.dining_tables.label_priority'))
        ->and($attributes['description'])->toBe(lang('igniter::admin.label_description'))
        ->and($attributes['is_enabled'])->toBe(lang('igniter.reservation::default.dining_tables.label_is_enabled'));
});

it('validates rules correctly for dining section', function(): void {
    $rules = (new DiningSectionRequest)->rules();

    expect($rules['location_id'])->toBe(['required', 'integer'])
        ->and($rules['name'])->toBe(['required', 'string'])
        ->and($rules['priority'])->toBe(['required', 'integer'])
        ->and($rules['description'])->toBe(['string'])
        ->and($rules['is_enabled'])->toBe(['is_enabled', 'boolean'])
        ->and($rules['color'])->toBe(['nullable', 'string']);
});
