<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\MenuRequest;

it('returns correct attribute labels', function(): void {
    $request = new MenuRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('menu_name', lang('igniter::admin.label_name'))
        ->and($attributes)->toHaveKey('menu_description', lang('igniter::admin.label_description'))
        ->and($attributes)->toHaveKey('menu_price', lang('igniter.cart::default.menus.label_price'))
        ->and($attributes)->toHaveKey('categories.*', lang('igniter.cart::default.menus.label_category'))
        ->and($attributes)->toHaveKey('ingredients.*', lang('igniter.cart::default.menus.label_ingredients'))
        ->and($attributes)->toHaveKey('mealtimes.*', lang('igniter.cart::default.menus.label_mealtime'))
        ->and($attributes)->toHaveKey('locations.*', lang('igniter::admin.label_location'))
        ->and($attributes)->toHaveKey('minimum_qty', lang('igniter.cart::default.menus.label_minimum_qty'))
        ->and($attributes)->toHaveKey('order_restriction.*', lang('igniter.cart::default.menus.label_order_restriction'))
        ->and($attributes)->toHaveKey('menu_status', lang('igniter::admin.label_status'))
        ->and($attributes)->toHaveKey('mealtime_id', lang('igniter.cart::default.menus.label_mealtime'))
        ->and($attributes)->toHaveKey('menu_priority', lang('igniter.cart::default.menus.label_menu_priority'))
        ->and($attributes)->toHaveKey('menu_option_values', lang('igniter.cart::default.menu_options.label_option_value_id'));
});

it('returns correct validation rules', function(): void {
    $request = new MenuRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('menu_name')
        ->and($rules)->toHaveKey('menu_description')
        ->and($rules)->toHaveKey('menu_price')
        ->and($rules)->toHaveKey('categories')
        ->and($rules)->toHaveKey('categories.*')
        ->and($rules)->toHaveKey('ingredients')
        ->and($rules)->toHaveKey('ingredients.*')
        ->and($rules)->toHaveKey('mealtimes')
        ->and($rules)->toHaveKey('mealtimes.*')
        ->and($rules)->toHaveKey('locations')
        ->and($rules)->toHaveKey('locations.*')
        ->and($rules)->toHaveKey('minimum_qty')
        ->and($rules)->toHaveKey('order_restriction.*')
        ->and($rules)->toHaveKey('menu_status')
        ->and($rules)->toHaveKey('mealtime_id')
        ->and($rules)->toHaveKey('menu_priority')
        ->and($rules)->toHaveKey('menu_options.*.menu_option_id')
        ->and($rules)->toHaveKey('menu_options.*.priority')
        ->and($rules)->toHaveKey('special.special_id')
        ->and($rules)->toHaveKey('special.type')
        ->and($rules)->toHaveKey('special.special_price')
        ->and($rules)->toHaveKey('special.validity')
        ->and($rules)->toHaveKey('special.start_date')
        ->and($rules)->toHaveKey('special.end_date')
        ->and($rules)->toHaveKey('special.recurring_every')
        ->and($rules)->toHaveKey('special.recurring_every.*')
        ->and($rules)->toHaveKey('special.recurring_from')
        ->and($rules)->toHaveKey('special.recurring_to')
        ->and($rules)->toHaveKey('special.special_status')
        ->and($rules['menu_name'])->toContain('required', 'string', 'between:2,255')
        ->and($rules['menu_description'])->toContain('nullable', 'string', 'between:2,1028')
        ->and($rules['menu_price'])->toContain('required', 'numeric', 'min:0')
        ->and($rules['categories'])->toContain('nullable', 'array')
        ->and($rules['categories.*'])->toContain('sometimes', 'required', 'integer')
        ->and($rules['ingredients'])->toContain('nullable', 'array')
        ->and($rules['ingredients.*'])->toContain('sometimes', 'required', 'integer')
        ->and($rules['mealtimes'])->toContain('nullable', 'array')
        ->and($rules['mealtimes.*'])->toContain('sometimes', 'required', 'integer')
        ->and($rules['locations'])->toContain('nullable', 'array')
        ->and($rules['locations.*'])->toContain('integer')
        ->and($rules['minimum_qty'])->toContain('sometimes', 'required', 'integer', 'min:1')
        ->and($rules['order_restriction.*'])->toContain('nullable', 'string')
        ->and($rules['menu_status'])->toContain('boolean')
        ->and($rules['mealtime_id'])->toContain('nullable', 'integer')
        ->and($rules['menu_priority'])->toContain('min:0', 'integer')
        ->and($rules['menu_options'])->toContain('nullable', 'array')
        ->and($rules['menu_options.*.menu_option_id'])->toContain('required', 'integer')
        ->and($rules['menu_options.*.priority'])->toContain('integer')
        ->and($rules['special.special_id'])->toContain('nullable', 'integer')
        ->and($rules['special.type'])->toContain('string', 'in:F,P')
        ->and($rules['special.special_price'])->toContain('nullable', 'numeric', 'min:0')
        ->and($rules['special.validity'])->toContain('string', 'in:forever,period,recurring')
        ->and($rules['special.start_date'])->toContain('required_if:special.validity,period', 'nullable', 'date')
        ->and($rules['special.end_date'])->toContain('required_if:special.validity,period', 'nullable', 'date')
        ->and($rules['special.recurring_every'])->toContain('required_if:special.validity,recurring', 'nullable', 'array')
        ->and($rules['special.recurring_every.*'])->toContain('required_if:special.validity,recurring', 'integer')
        ->and($rules['special.recurring_from'])->toContain('required_if:special.validity,recurring', 'nullable', 'date_format:H:i')
        ->and($rules['special.recurring_to'])->toContain('required_if:special.validity,recurring', 'nullable', 'date_format:H:i')
        ->and($rules['special.special_status'])->toContain('boolean');
});
