<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Ingredient;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\System\Models\Concerns\Switchable;

it('returns description attribute', function(): void {
    $ingredient = Ingredient::factory()->create(['description' => '<p>Description</p>']);

    expect($ingredient->description)->toBe('Description');
});

it('counts menus', function(): void {
    $ingredient = Ingredient::factory()->create();
    $ingredient->menus()->saveMany(Menu::factory()->count(3)->make());

    expect($ingredient->count_menus)->toBe(3);
});

it('morphs to many menus', function(): void {
    $ingredient = new Ingredient;
    $relation = $ingredient->menus();

    expect($relation->getRelated())->toBeInstanceOf(Menu::class)
        ->and($relation->getTable())->toBe('ingredientables');
});

it('morphs to many menu option values', function(): void {
    $ingredient = new Ingredient;
    $relation = $ingredient->menu_option_values();

    expect($relation->getRelated())->toBeInstanceOf(MenuOptionValue::class)
        ->and($relation->getTable())->toBe('ingredientables');
});

it('scopes to ingredients with menus', function(): void {
    $menu = Menu::factory()->create();
    $menu->ingredients()->saveMany(Ingredient::factory()->count(3)->make(['status' => 1]));

    expect(Ingredient::query()->whereHasMenus()->count())->toBe(3);
});

it('scopes to allergen ingredients', function(): void {
    Ingredient::factory()->count(3)->create(['is_allergen' => 0]);
    Ingredient::factory()->count(3)->create(['is_allergen' => 1]);

    expect(Ingredient::isAllergen()->count())->toBe(3);
});

it('configures ingredient model correctly', function(): void {
    $ingredient = new Ingredient;

    expect(class_uses_recursive($ingredient))
        ->toContain(HasMedia::class)
        ->toContain(Switchable::class)
        ->and($ingredient->getTable())->toBe('ingredients')
        ->and($ingredient->getKeyName())->toBe('ingredient_id')
        ->and($ingredient->getGuarded())->toBe([])
        ->and($ingredient->getMorphClass())->toBe('ingredients')
        ->and($ingredient->mediable())->toHaveKey('thumb')
        ->and($ingredient->timestamps)->toBeTrue()
        ->and($ingredient->relation)->toEqual([
            'morphedByMany' => [
                'menus' => [Menu::class, 'name' => 'ingredientable'],
                'menu_option_values' => [MenuOptionValue::class, 'name' => 'ingredientable'],
            ],
        ]);
});
