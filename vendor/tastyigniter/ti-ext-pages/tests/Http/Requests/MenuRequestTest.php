<?php

declare(strict_types=1);

namespace Igniter\Pages\Tests\Http\Requests;

use Igniter\Pages\Http\Requests\MenuRequest;

it('returns correct attribute labels', function(): void {
    $request = new MenuRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('theme_code', lang('igniter.pages::default.menu.label_theme'))
        ->and($attributes)->toHaveKey('name', lang('admin::lang.label_name'))
        ->and($attributes)->toHaveKey('code', lang('igniter.pages::default.menu.label_code'))
        ->and($attributes)->toHaveKey('items', lang('igniter.pages::default.menu.text_menu_items'));
});

it('returns correct validation rules', function(): void {
    $request = new MenuRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('theme_code', ['sometimes', 'required', 'alpha_dash'])
        ->and($rules)->toHaveKey('name', ['required', 'string'])
        ->and($rules)->toHaveKey('code', ['required', 'alpha_dash'])
        ->and($rules)->toHaveKey('items', ['sometimes', 'required', 'array']);
});
