<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\MenuOptionRequest;

it('returns correct attribute labels', function(): void {
    $request = new MenuOptionRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveCount(7)
        ->and($attributes)->toHaveKey('option_name', lang('igniter.cart::default.menu_options.label_option_group_name'))
        ->and($attributes)->toHaveKey('display_type', lang('igniter.cart::default.menu_options.label_display_type'))
        ->and($attributes)->toHaveKey('is_required', lang('igniter.cart::default.menu_options.label_option_required'))
        ->and($attributes)->toHaveKey('min_selected', lang('igniter.cart::default.menu_options.label_min_selected'))
        ->and($attributes)->toHaveKey('max_selected', lang('igniter.cart::default.menu_options.label_max_selected'))
        ->and($attributes)->toHaveKey('locations.*', lang('igniter::admin.label_location'))
        ->and($attributes)->toHaveKey('values', lang('igniter.cart::default.menu_options.label_option_values'));
});

it('returns correct validation rules', function(): void {
    $request = new MenuOptionRequest;

    $rules = $request->rules();

    expect($rules)->toHaveCount(8)
        ->and($rules)->toHaveKey('option_name')
        ->and($rules)->toHaveKey('display_type')
        ->and($rules)->toHaveKey('is_required')
        ->and($rules)->toHaveKey('min_selected')
        ->and($rules)->toHaveKey('max_selected')
        ->and($rules)->toHaveKey('locations')
        ->and($rules)->toHaveKey('locations.*')
        ->and($rules)->toHaveKey('values')
        ->and($rules['option_name'])->toContain('required', 'string', 'min:2', 'max:32')
        ->and($rules['display_type'])->toContain('required', 'alpha')
        ->and($rules['is_required'])->toContain('boolean')
        ->and($rules['min_selected'])->toContain('integer', 'lte:max_selected')
        ->and($rules['max_selected'])->toContain('integer', 'gte:min_selected')
        ->and($rules['locations'])->toContain('nullable', 'array')
        ->and($rules['locations.*'])->toContain('integer')
        ->and($rules['values'])->toContain('required', 'array');
});
