<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;

it('returns option name attribute', function(): void {
    $menuItemOptionValue = MenuItemOptionValue::factory()
        ->for(MenuOptionValue::factory(['name' => 'Option Value Name'])->create(), 'option_value')
        ->create();

    expect($menuItemOptionValue->name)->toBe('Option Value Name');
});

it('returns price attribute', function(): void {
    $menuItemOptionValue = MenuItemOptionValue::factory()
        ->for(MenuOptionValue::factory(['price' => 10.00])->create(), 'option_value')
        ->create();

    expect($menuItemOptionValue->price)->toBe(10.00);

    $menuItemOptionValue->override_price = 15.00;

    expect($menuItemOptionValue->price)->toBe(15.00);
});

it('checks if menu item option value is default', function(): void {
    $menuItemOptionValue = MenuItemOptionValue::factory()->create(['is_default' => 1]);

    expect($menuItemOptionValue->isDefault())->toBeTrue();
});

it('checks if menu item option value is not default', function(): void {
    $menuItemOptionValue = MenuItemOptionValue::factory()->create(['is_default' => 0]);

    expect($menuItemOptionValue->isDefault())->toBeFalse();
});

it('exempts free_quantity for select and radio display types regardless of stored value', function(): void {
    foreach (['select', 'radio'] as $displayType) {
        $menuOption = MenuOption::factory()->create(['display_type' => $displayType]);
        $menuItemOption = MenuItemOption::factory()->for($menuOption, 'option')->create();
        $menuItemOptionValue = MenuItemOptionValue::factory()->for($menuItemOption, 'menu_option')->create(['free_quantity' => 5]);

        expect($menuItemOptionValue->free_quantity)->toBe(0)
            ->and($menuItemOptionValue->fresh()->free_quantity)->toBe(0)
            ->and($menuItemOptionValue->validate())->toBeTrue();
    }
});

it('limits free_quantity to a maximum of one for checkbox display type regardless of stored value', function(): void {
    $menuOption = MenuOption::factory()->create(['display_type' => 'checkbox']);
    $menuItemOption = MenuItemOption::factory()->for($menuOption, 'option')->create();
    $menuItemOptionValue = MenuItemOptionValue::factory()->for($menuItemOption, 'menu_option')->create(['free_quantity' => 5]);

    expect($menuItemOptionValue->free_quantity)->toBe(1)
        ->and($menuItemOptionValue->fresh()->free_quantity)->toBe(1)
        ->and($menuItemOptionValue->validate())->toBeTrue();
});

it('does not limit free_quantity for quantity display type', function(): void {
    $menuOption = MenuOption::factory()->create(['display_type' => 'quantity']);
    $menuItemOption = MenuItemOption::factory()->for($menuOption, 'option')->create();
    $menuItemOptionValue = MenuItemOptionValue::factory()->for($menuItemOption, 'menu_option')->create(['free_quantity' => 5]);

    expect($menuItemOptionValue->free_quantity)->toBe(5);
});

it('configures menu item option value model correctly', function(): void {
    $menuItemOptionValue = new MenuItemOptionValue;
    expect($menuItemOptionValue->getTable())->toBe('menu_item_option_values')
        ->and($menuItemOptionValue->getKeyName())->toBe('menu_option_value_id')
        ->and($menuItemOptionValue->getFillable())->toEqual([
            'menu_option_id',
            'option_value_id',
            'override_price',
            'priority',
            'is_default',
            'free_quantity',
        ])
        ->and($menuItemOptionValue->timestamps)->toBeTrue()
        ->and($menuItemOptionValue->relation)->toEqual([
            'belongsTo' => [
                'menu' => [Menu::class],
                'option_value' => [MenuOptionValue::class],
                'menu_option' => [MenuItemOption::class],
            ],
        ])
        ->and($menuItemOptionValue->rules)->toEqual([
            ['menu_option_id', 'igniter.cart::default.menu_options.label_option_value_id', 'required|integer'],
            ['option_value_id', 'igniter.cart::default.menu_options.label_option_value', 'required|integer'],
            ['override_price', 'igniter.cart::default.menu_options.label_option_price', 'nullable|numeric|min:0'],
            ['free_quantity', 'igniter.cart::default.menu_options.label_value_free_quantity', 'integer|min:0'],
        ])
        ->and($menuItemOptionValue->getCasts()['menu_option_value_id'])->toEqual('integer')
        ->and($menuItemOptionValue->getCasts()['menu_option_id'])->toEqual('integer')
        ->and($menuItemOptionValue->getCasts()['option_value_id'])->toEqual('integer')
        ->and($menuItemOptionValue->getCasts()['override_price'])->toEqual('float')
        ->and($menuItemOptionValue->getCasts()['priority'])->toEqual('integer')
        ->and($menuItemOptionValue->getCasts()['is_default'])->toEqual('boolean')
        ->and($menuItemOptionValue->getAppends())->toEqual(['name', 'price'])
        ->and($menuItemOptionValue->getMorphClass())->toBe('menu_item_option_values');
});
