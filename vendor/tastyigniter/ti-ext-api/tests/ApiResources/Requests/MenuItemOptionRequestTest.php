<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources\Requests;

use Igniter\Api\ApiResources\Requests\MenuItemOptionRequest;

it('returns correct attribute labels', function(): void {
    $request = new MenuItemOptionRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('menu_id', lang('igniter.cart::default.menus.label_menu_id'))
        ->and($attributes)->toHaveKey('option_id', lang('igniter.cart::default.menus.label_option_id'))
        ->and($attributes)->toHaveKey('priority', lang('igniter.cart::default.menus.label_option'))
        ->and($attributes)->toHaveKey('required', lang('igniter.cart::default.menus.label_option_required'))
        ->and($attributes)->toHaveKey('min_selected', lang('igniter.cart::default.menus.label_min_selected'))
        ->and($attributes)->toHaveKey('max_selected', lang('igniter.cart::default.menus.label_max_selected'))
        ->and($attributes)->toHaveKey('menu_option_values.*', lang('admin::lang.label_option_value_id'));
});

it('returns correct validation rules', function(): void {
    $request = new MenuItemOptionRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('menu_id')
        ->and($rules)->toHaveKey('option_id')
        ->and($rules)->toHaveKey('priority')
        ->and($rules)->toHaveKey('required')
        ->and($rules)->toHaveKey('min_selected')
        ->and($rules)->toHaveKey('max_selected')
        ->and($rules)->toHaveKey('menu_option_values.*')
        ->and($rules['menu_id'])->toContain('nullable', 'integer')
        ->and($rules['option_id'])->toContain('required', 'integer')
        ->and($rules['priority'])->toContain('integer')
        ->and($rules['required'])->toContain('boolean')
        ->and($rules['min_selected'])->toContain('integer', 'lte:max_selected')
        ->and($rules['max_selected'])->toContain('integer', 'gte:min_selected')
        ->and($rules['menu_option_values.*'])->toContain('array');
});
