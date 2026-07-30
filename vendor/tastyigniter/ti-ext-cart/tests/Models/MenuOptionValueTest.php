<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Ingredient;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Local\Models\Location;

it('returns dropdown options for menu option values', function(): void {
    $result = MenuOptionValue::getDropDownOptions();

    expect($result)->toBeCollection()
        ->and($result)->not()->toBeEmpty();
});

it('returns allergens options from ingredients', function(): void {
    Ingredient::factory()->count(3)->create();

    (new MenuOptionValue)->getAllergensOptions();
    // Test cache
    $result = (new MenuOptionValue)->getAllergensOptions();

    expect($result)->toBeArray()
        ->and($result)->not()->toBeEmpty();
});

it('returns stockable name as value', function(): void {
    $menuOptionValue = MenuOptionValue::factory()->make([
        'name' => 'Stockable Value',
    ]);

    $result = $menuOptionValue->getStockableName();

    expect($result)->toBe('Stockable Value');
});

it('returns stockable locations from option', function(): void {
    $locations = Location::factory()->count(3)->create();
    $menuOption = MenuOption::factory()->hasAttached($locations, [], 'locations')->create();
    $menuOptionValue = MenuOptionValue::factory()->for($menuOption, 'option')->create([
        'name' => 'Stockable Value',
    ]);

    $result = $menuOptionValue->getStockableLocations();

    expect($result)->toBeCollection()
        ->and($result->count())->toBe(3);
});

it('adds menu allergens successfully when allergen ids are provided', function(): void {
    $ingredients = Ingredient::factory()->count(3)->create();
    $menuOptionValue = MenuOptionValue::factory()->create();
    $allergenIds = $ingredients->pluck('ingredient_id')->all();

    $menuOptionValue->addMenuAllergens($allergenIds);

    expect($menuOptionValue->ingredients->pluck('ingredient_id')->all())->toBe($allergenIds);
});

it('has validation rules defined', function(): void {
    $menuOptionValue = new MenuOptionValue;

    expect($menuOptionValue->rules)->toBeArray()
        ->and($menuOptionValue->rules)->toHaveCount(4);
});

it('configures menu option value model correctly', function(): void {
    $menuOptionValue = new MenuOptionValue;

    expect($menuOptionValue->getTable())->toBe('menu_option_values')
        ->and($menuOptionValue->getKeyName())->toBe('option_value_id')
        ->and($menuOptionValue->getFillable())->toEqual([
            'option_id',
            'name',
            'price',
            'ingredients',
            'priority',
        ])
        ->and($menuOptionValue->sortable)->toEqual([
            'sortOrderColumn' => 'priority',
            'sortWhenCreating' => true,
        ])
        ->and($menuOptionValue->timestamps)->toBeFalse()
        ->and($menuOptionValue->getMorphClass())->toBe('menu_option_values');
});
