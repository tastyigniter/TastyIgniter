<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models;

use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuOption;
use Igniter\Cart\Models\MenuOptionValue;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location;

it('returns options with locations when locations are assigned', function(): void {
    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([1, 2]);

    $result = MenuOption::getRecordEditorOptions();

    expect($result)->toBeCollection()
        ->and($result)->not()->toBeEmpty();
});

it('checks if menu option display type is select', function(): void {
    $menuOption = MenuOption::factory()->create(['display_type' => 'select']);

    expect($menuOption->isSelectDisplayType())->toBeTrue();
});

it('checks if menu option display type is not select', function(): void {
    $menuOption = MenuOption::factory()->create(['display_type' => 'radio']);

    expect($menuOption->isSelectDisplayType())->toBeFalse();
});

it('returns option values filtered by option_id', function(): void {
    MenuOptionValue::factory()->create(['option_id' => 123]);

    $result = MenuOption::getOptionValues(123);

    expect($result)->toBeCollection()
        ->and($result->count())->toBe(1);
});

it('checks if menu option values are added correctly', function(): void {
    $menuOption = MenuOption::factory()->create();

    expect($menuOption->addOptionValues([
        ['option_value_id' => 1, 'price' => 10.00],
        ['option_value_id' => 2, 'price' => 15.00],
        ['option_value_id' => 3, 'price' => 20.00],
    ]))->toBe(3);
});

it('adds values to menu options on save correctly', function(): void {
    $menuOption = MenuOption::factory()->create();

    $menuOption->values = [
        ['option_value_id' => 1, 'price' => 10.00],
        ['option_value_id' => 2, 'price' => 15.00],
        ['option_value_id' => 3, 'price' => 20.00],
    ];

    $menuOption->save();

    expect($menuOption->option_values()->count())->toBe(3);
});

it('attaches menu option to menu', function(): void {
    $menu = Menu::factory()->create();
    $menuOption = MenuOption::factory()
        ->has(MenuOptionValue::factory()->count(3), 'option_values')
        ->create();

    $menuOption->attachRecordTo($menu);

    $menuItemOption = MenuItemOption::where('menu_id', $menu->menu_id)
        ->where('option_id', $menuOption->option_id)
        ->first();

    expect($menuItemOption)->toBeInstanceOf(MenuItemOption::class)
        ->and($menuItemOption->menu_option_values()->count())->toBe(3);
});

it('detaches location from menu option on delete', function(): void {
    $location = Location::factory()->create();
    $menuOption = MenuOption::factory()
        ->hasAttached($location)
        ->create();

    expect($menuOption->locations()->count())->toBe(1);

    $menuOption->delete();

    expect($menuOption->locations()->count())->toBe(0);
});

it('configures menu option model correctly', function(): void {
    $menuOption = new MenuOption;

    expect($menuOption->getTable())->toBe('menu_options')
        ->and($menuOption->getKeyName())->toBe('option_id')
        ->and($menuOption->getFillable())->toEqual([
            'option_id',
            'option_name',
            'display_type',
        ])
        ->and($menuOption->timestamps)->toBeTrue()
        ->and($menuOption->getMorphClass())->toBe('menu_options')
        ->and($menuOption->getPurgeableAttributes())->toEqual(['values']);
});
