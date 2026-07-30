<?php

declare(strict_types=1);

namespace Igniter\Pages\Tests\Http\Requests;

use Igniter\Pages\Http\Requests\MenuItemRequest;

it('returns correct attribute labels', function(): void {
    $request = new MenuItemRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('title', lang('igniter.pages::default.menu.label_title'))
        ->and($attributes)->toHaveKey('type', lang('igniter.pages::default.menu.label_type'))
        ->and($attributes)->toHaveKey('url', lang('igniter.pages::default.menu.label_url'))
        ->and($attributes)->toHaveKey('reference', lang('igniter.pages::default.menu.label_reference'))
        ->and($attributes)->toHaveKey('parent_id', lang('igniter.pages::default.menu.label_parent_id'))
        ->and($attributes)->toHaveKey('description', lang('admin::lang.label_description'))
        ->and($attributes)->toHaveKey('code', lang('igniter.pages::default.menu.label_code'))
        ->and($attributes)->toHaveKey('config.extraAttributes', lang('igniter.pages::default.menu.label_attributes'));
});

it('returns correct validation rules', function(): void {
    $request = new MenuItemRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('title', ['required', 'string'])
        ->and($rules)->toHaveKey('type', ['required', 'string'])
        ->and($rules)->toHaveKey('url', ['required_if:type,url', 'nullable', 'string'])
        ->and($rules)->toHaveKey('reference', ['nullable', 'regex:/^[\w.\-]+$/'])
        ->and($rules)->toHaveKey('parent_id', ['nullable', 'integer'])
        ->and($rules)->toHaveKey('description', ['nullable', 'string', 'max:500'])
        ->and($rules)->toHaveKey('code', ['nullable', 'alpha_dash'])
        ->and($rules)->toHaveKey('config.extraAttributes', ['string']);
});
