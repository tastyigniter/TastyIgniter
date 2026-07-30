<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\IngredientRequest;

it('returns correct attribute labels', function(): void {
    $request = new IngredientRequest;

    $attributes = $request->attributes();

    expect($attributes)->toHaveKey('name', lang('igniter::admin.label_name'))
        ->and($attributes)->toHaveKey('description', lang('igniter::admin.label_description'))
        ->and($attributes)->toHaveKey('status', lang('igniter::admin.label_status'))
        ->and($attributes)->toHaveKey('is_allergen', lang('igniter.cart::default.ingredients.label_allergen'));
});

it('returns correct validation rules', function(): void {
    $request = new IngredientRequest;

    $rules = $request->rules();

    expect($rules)->toHaveKey('name')
        ->and($rules)->toHaveKey('description')
        ->and($rules)->toHaveKey('status')
        ->and($rules)->toHaveKey('is_allergen')
        ->and($rules['name'])->toContain('required', 'string', 'between:2,255')
        ->and($rules['description'])->toContain('string', 'min:2')
        ->and($rules['status'])->toContain('boolean')
        ->and($rules['is_allergen'])->toContain('boolean');
});
