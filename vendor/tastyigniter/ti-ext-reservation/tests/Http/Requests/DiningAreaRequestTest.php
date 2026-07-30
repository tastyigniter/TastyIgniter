<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Requests;

use Igniter\Reservation\Http\Requests\DiningAreaRequest;

it('returns correct attribute labels for dining area', function(): void {
    $attributes = (new DiningAreaRequest)->attributes();

    expect($attributes['name'])->toBe(lang('igniter::admin.label_name'));
});

it('validates rules correctly for dining area', function(): void {
    $rules = (new DiningAreaRequest)->rules();

    expect($rules['name'])->toBe(['required', 'between:2,128']);
});
