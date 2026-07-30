<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuItemOptionValue;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Validation;

it('returns option name attribute', function(): void {
    $menuItemOption = MenuItemOption::factory()
        ->for(MenuOption::factory()->create([
            'option_name' => 'Option Name',
        ]), 'option')
        ->create();

    expect($menuItemOption)->option_name->toBe('Option Name');
});

it('returns display type attribute', function(): void {
    $menuItemOption = MenuItemOption::factory()
        ->for(MenuOption::factory()->create([
            'display_type' => 'radio',
        ]), 'option')
        ->create();

    expect($menuItemOption)->display_type->toBe('radio');
});

it('returns option values with menu option values when they exist', function(): void {
    $menuOption = MenuOption::factory()->create(['display_type' => 'radio']);
    $menuOptionValue = MenuOptionValue::factory()->for($menuOption, 'option')->create(['price' => 10]);
    $menuItemOption = MenuItemOption::factory()->for($menuOption, 'option')->create();
    $menuItemOptionValue = MenuItemOptionValue::factory()
        ->for($menuItemOption, 'menu_option')
        ->create([
            'option_value_id' => $menuOptionValue->getKey(),
            'override_price' => null,
            'is_default' => true,
        ]);

    $result = $menuItemOption->getOptionValuesAttribute();
    $firstResult = $result->first();

    expect($result)->toBeCollection()
        ->and($firstResult->menu_option_value_id)->toBe($menuItemOptionValue->getKey())
        ->and($firstResult->menu_option_id)->toBe($menuItemOption->getKey())
        ->and($firstResult->option_value_id)->toBe($menuOptionValue->getKey())
        ->and($firstResult->price)->toBe(10.0)
        ->and($firstResult->override_price)->toBeNull()
        ->and($firstResult->is_default)->toBeTrue()
        ->and($firstResult->is_enabled)->toBeTrue();
});

it('returns option values with default values when menu option values do not exist', function(): void {
    $menuOption = MenuOption::factory()->create(['display_type' => 'radio']);
    $menuOptionValue = MenuOptionValue::factory()->for($menuOption, 'option')->create(['price' => 10]);
    $menuItemOption = MenuItemOption::factory()->for($menuOption, 'option')->create();

    $result = $menuItemOption->getOptionValuesAttribute();
    $firstResult = $result->first();

    expect($result)->toBeCollection()
        ->and($firstResult->menu_option_value_id)->toBeNull()
        ->and($firstResult->menu_option_id)->toBe($menuOption->getKey())
        ->and($firstResult->option_value_id)->toBe($menuOptionValue->getKey())
        ->and($result->first()->price)->toBe(10.0)
        ->and($result->first()->override_price)->toBeNull()
        ->and($result->first()->is_default)->toBeNull()
        ->and($result->first()->is_enabled)->toBeFalse();
});

it('checks if menu item option is required', function(): void {
    $menuItemOption = MenuItemOption::factory()->create([
        'is_required' => true,
    ]);

    expect($menuItemOption->isRequired())->toBeTrue();
});

it('checks if menu item option is not required', function(): void {
    $menuItemOption = MenuItemOption::factory()->create([
        'is_required' => false,
    ]);

    expect($menuItemOption->isRequired())->toBeFalse();
});

it('checks if menu item option values are added correctly', function(): void {
    $menuItemOption = MenuItemOption::factory()->create();

    expect($menuItemOption->addMenuOptionValues([
        ['option_value_id' => 1, 'override_price' => 10.00],
        ['option_value_id' => 1, 'override_price' => 15.00],
        ['option_value_id' => 1, 'override_price' => 20.00],
    ]))->toBe(3);
});

it('adds values to menu item options on save correctly', function(): void {
    $menuItemOption = MenuItemOption::factory()->create();

    $menuItemOption->menu_option_values = [
        ['option_value_id' => 1, 'is_enabled' => 1, 'override_price' => 10.00],
        ['option_value_id' => 1, 'is_enabled' => 1, 'override_price' => 15.00],
        ['option_value_id' => 1, 'is_enabled' => 1, 'override_price' => 20.00],
    ];

    $menuItemOption->save();

    expect($menuItemOption->menu_option_values()->count())->toBe(3);
});

it('validates min_selected and max_selected rules for select display type', function(): void {
    $menuItemOption = new MenuItemOption([
        'min_selected' => 0,
        'max_selected' => 0,
    ]);
    $menuItemOption->option = new MenuOption(['display_type' => 'select']);
    $menuItemOption->beforeValidate();

    $rules = collect($menuItemOption->rules);

    expect($rules->firstWhere('0', 'min_selected')[2])->toBe('max:1')
        ->and($rules->firstWhere('0', 'max_selected')[2])->toBe('max:1')
        ->and($menuItemOption->getValidationMessages())->toHaveKeys(['min_selected.max', 'max_selected.max']);
});

it('exempts free_quantity for select and radio display types regardless of stored value', function(): void {
    foreach (['select', 'radio'] as $displayType) {
        $menuOption = MenuOption::factory()->create(['display_type' => $displayType]);
        $menuItemOption = MenuItemOption::factory()->for($menuOption, 'option')->create(['free_quantity' => 5]);

        expect($menuItemOption->free_quantity)->toBe(0)
            ->and($menuItemOption->fresh()->free_quantity)->toBe(0)
            ->and($menuItemOption->validate())->toBeTrue();
    }
});

it('does not exempt free_quantity for checkbox or quantity display types', function(): void {
    foreach (['checkbox', 'quantity'] as $displayType) {
        $menuOption = MenuOption::factory()->create(['display_type' => $displayType]);
        $menuItemOption = MenuItemOption::factory()->for($menuOption, 'option')->create(['free_quantity' => 5]);

        expect($menuItemOption->free_quantity)->toBe(5);
    }
});

it('returns linked option value ids from loaded relation', function(): void {
    $menu = Menu::factory()->create();
    $menuItemOption = MenuItemOption::factory()->for($menu, 'menu')->create();
    $linkedValue = MenuItemOptionValue::factory()
        ->for(MenuItemOption::factory()->for($menu, 'menu'), 'menu_option')
        ->create();

    $menuItemOption->linkedOptionValues()->attach($linkedValue->getKey());
    $menuItemOption->load('linkedOptionValues');

    expect($menuItemOption->linked_option_value_ids)->toBe([$linkedValue->getKey()]);
});

it('returns linked option value ids from database when relation is not loaded', function(): void {
    $menu = Menu::factory()->create();
    $menuItemOption = MenuItemOption::factory()->for($menu, 'menu')->create();
    $linkedValue = MenuItemOptionValue::factory()
        ->for(MenuItemOption::factory()->for($menu, 'menu'), 'menu_option')
        ->create();

    $menuItemOption->linkedOptionValues()->attach($linkedValue->getKey());
    $menuItemOption->unsetRelation('linkedOptionValues');

    expect($menuItemOption->linked_option_value_ids)->toBe([$linkedValue->getKey()]);
});

it('returns linked menu option value options from sibling options on the same menu', function(): void {
    $menu = Menu::factory()->create();
    $siblingOption = MenuOption::factory()->create(['option_name' => 'Size']);
    $siblingMenuItemOption = MenuItemOption::factory()
        ->for($menu, 'menu')
        ->for($siblingOption, 'option')
        ->create();
    $optionValue = MenuOptionValue::factory()->for($siblingOption, 'option')->create(['name' => 'Large']);
    $menuItemOptionValue = MenuItemOptionValue::factory()
        ->for($siblingMenuItemOption, 'menu_option')
        ->for($optionValue, 'option_value')
        ->create();
    $currentMenuItemOption = MenuItemOption::factory()
        ->for($menu, 'menu')
        ->for(MenuOption::factory()->create(['option_name' => 'Topping']), 'option')
        ->create();

    $options = $currentMenuItemOption->getLinkedMenuOptionValueOptions();

    expect($options)->toBe([
        $menuItemOptionValue->getKey() => 'Size: Large',
    ]);
});

it('includes all menu options when getting linked menu option value options for unsaved model', function(): void {
    $menu = Menu::factory()->create();
    $menuOption = MenuOption::factory()->create(['option_name' => 'Size']);
    $menuItemOption = MenuItemOption::factory()
        ->for($menu, 'menu')
        ->for($menuOption, 'option')
        ->create();
    $optionValue = MenuOptionValue::factory()->for($menuOption, 'option')->create(['name' => 'Large']);
    $menuItemOptionValue = MenuItemOptionValue::factory()
        ->for($menuItemOption, 'menu_option')
        ->for($optionValue, 'option_value')
        ->create();

    $options = (new MenuItemOption(['menu_id' => $menu->getKey()]))->getLinkedMenuOptionValueOptions();

    expect($options)->toBe([
        $menuItemOptionValue->getKey() => 'Size: Large',
    ]);
});

it('configures menu item option model correctly', function(): void {
    $menuItemOption = new MenuItemOption;

    expect(class_uses_recursive($menuItemOption))
        ->toHaveKey(Purgeable::class)
        ->toHaveKey(Validation::class)
        ->and($menuItemOption->getTable())->toBe('menu_item_options')
        ->and($menuItemOption->getKeyName())->toBe('menu_option_id')
        ->and($menuItemOption->getFillable())->toEqual([
            'option_id', 'menu_id', 'is_required', 'priority', 'min_selected', 'max_selected', 'free_quantity',
        ])
        ->and($menuItemOption->getAppends())->toEqual(['option_name', 'display_type', 'linked_option_value_ids'])
        ->and($menuItemOption->timestamps)->toBeTrue()
        ->and($menuItemOption->relation)->toEqual([
            'hasMany' => [
                'menu_option_values' => [
                    MenuItemOptionValue::class,
                    'foreignKey' => 'menu_option_id',
                    'delete' => true,
                ],
            ],
            'belongsTo' => [
                'menu' => [Menu::class],
                'option' => [MenuOption::class],
            ],
            'belongsToMany' => [
                'linkedOptionValues' => [
                    MenuItemOptionValue::class,
                    'table' => 'menu_item_option_linked_values',
                    'foreignKey' => 'menu_option_id',
                    'otherKey' => 'menu_item_option_value_id',
                ],
            ],
        ])
        ->and($menuItemOption->rules)->toEqual([
            ['menu_id', 'igniter.cart::default.menus.label_menu_id', 'required|integer'],
            ['option_id', 'igniter.cart::default.menus.label_option_id', 'required|integer'],
            ['priority', 'igniter.cart::default.menu_options.label_option', 'integer'],
            ['is_required', 'igniter.cart::default.menu_options.label_option_required', 'boolean'],
            ['min_selected', 'igniter.cart::default.menu_options.label_min_selected', 'integer|lte:max_selected'],
            ['max_selected', 'igniter.cart::default.menu_options.label_max_selected', 'integer|gte:min_selected'],
            ['free_quantity', 'igniter.cart::default.menu_options.label_free_quantity', 'nullable|integer|min:0'],
        ]);
});
