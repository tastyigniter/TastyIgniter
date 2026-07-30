<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources\Requests;

use Igniter\Api\ApiResources\Requests\MenuOptionRequest;

it('returns correct attribute labels', function(): void {
    $request = new MenuOptionRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('option_name', lang('admin::lang.menu_options.label_option_group_name'))
        ->and($attributes)->toHaveKey('display_type', lang('admin::lang.menu_options.label_display_type'))
        ->and($attributes)->toHaveKey('priority', lang('admin::lang.menu_options.label_priority'))
        ->and($attributes)->toHaveKey('locations.*', lang('admin::lang.label_location'))
        ->and($attributes)->toHaveKey('option_values.*.option_value_id', lang('admin::lang.label_option_value_id'))
        ->and($attributes)->toHaveKey('option_values.*.option_id', lang('admin::lang.label_option_id'))
        ->and($attributes)->toHaveKey('option_values.*.value', lang('admin::lang.menu_options.label_option_value'))
        ->and($attributes)->toHaveKey('option_values.*.price', lang('admin::lang.menu_options.label_option_price'))
        ->and($attributes)->toHaveKey('option_values.*.priority', lang('admin::lang.menu_options.label_option_price'))
        ->and($attributes)->toHaveKey('option_values.*.allergens.*', lang('igniter.cart::default.menus.label_allergens'));
});

it('returns correct validation rules', function(): void {
    $request = new MenuOptionRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('option_name')
        ->and($rules)->toHaveKey('display_type')
        ->and($rules)->toHaveKey('priority')
        ->and($rules)->toHaveKey('locations.*')
        ->and($rules)->toHaveKey('option_values.*.option_value_id')
        ->and($rules)->toHaveKey('option_values.*.option_id')
        ->and($rules)->toHaveKey('option_values.*.value')
        ->and($rules)->toHaveKey('option_values.*.price')
        ->and($rules)->toHaveKey('option_values.*.priority')
        ->and($rules)->toHaveKey('option_values.*.allergens.*')
        ->and($rules['option_name'])->toContain('required', 'min:2', 'max:32')
        ->and($rules['display_type'])->toContain('required', 'alpha')
        ->and($rules['priority'])->toContain('integer')
        ->and($rules['locations.*'])->toContain('integer')
        ->and($rules['option_values.*.option_value_id'])->toContain('integer')
        ->and($rules['option_values.*.option_id'])->toContain('integer')
        ->and($rules['option_values.*.value'])->toContain('min:2', 'max:128')
        ->and($rules['option_values.*.price'])->toContain('numeric', 'min:0')
        ->and($rules['option_values.*.priority'])->toContain('integer')
        ->and($rules['option_values.*.allergens.*'])->toContain('integer');
});
