<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\CategoryRequest;

it('returns correct attribute labels', function(): void {
    $request = new CategoryRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('name', lang('igniter::admin.label_name'))
        ->and($attributes)->toHaveKey('description', lang('igniter::admin.label_description'))
        ->and($attributes)->toHaveKey('permalink_slug', lang('igniter.cart::default.categories.label_permalink_slug'))
        ->and($attributes)->toHaveKey('parent_id', lang('igniter.cart::default.categories.label_parent'))
        ->and($attributes)->toHaveKey('priority', lang('igniter.cart::default.categories.label_priority'))
        ->and($attributes)->toHaveKey('status', lang('igniter::admin.label_status'))
        ->and($attributes)->toHaveKey('locations.*', lang('igniter::admin.column_location'));
});

it('returns correct validation rules', function(): void {
    $request = new CategoryRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('name')
        ->and($rules)->toHaveKey('description')
        ->and($rules)->toHaveKey('permalink_slug')
        ->and($rules)->toHaveKey('parent_id')
        ->and($rules)->toHaveKey('priority')
        ->and($rules)->toHaveKey('status')
        ->and($rules)->toHaveKey('locations')
        ->and($rules)->toHaveKey('locations.*')
        ->and($rules['name'])->toContain('required', 'string', 'between:2,255')
        ->and($rules['description'])->toContain('string', 'min:2')
        ->and($rules['permalink_slug'])->toContain('alpha_dash', 'max:255')
        ->and($rules['parent_id'])->toContain('nullable', 'integer')
        ->and($rules['priority'])->toContain('nullable', 'integer')
        ->and($rules['status'])->toContain('boolean')
        ->and($rules['locations'])->toContain('nullable', 'array')
        ->and($rules['locations.*'])->toContain('integer');
});
