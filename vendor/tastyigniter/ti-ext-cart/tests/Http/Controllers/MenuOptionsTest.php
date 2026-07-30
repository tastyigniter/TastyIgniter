<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Controllers;

use Igniter\Cart\Models\MenuOption;

it('loads menu options page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.cart.menu_options'))
        ->assertOk();
});

it('loads create menu option page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.cart.menu_options', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit menu option page', function(): void {
    $menuOption = MenuOption::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.cart.menu_options', ['slug' => 'edit/'.$menuOption->getKey()]))
        ->assertOk();
});

it('loads menu option preview page', function(): void {
    $menuOption = MenuOption::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.cart.menu_options', ['slug' => 'preview/'.$menuOption->getKey()]))
        ->assertOk();
});

it('updates menu option', function(): void {
    $menuOption = MenuOption::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.cart.menu_options', ['slug' => 'edit/'.$menuOption->getKey()]), [
            'MenuOption' => [
                'option_name' => 'Updated MenuOption',
                'display_type' => 'select',
                'values' => [
                    [
                        'option_id' => 1,
                        'price' => 10.00,
                        'name' => 'Option Value 1',
                        'priority' => 1,
                    ],
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(MenuOption::find($menuOption->getKey()))->option_name->toBe('Updated MenuOption');
});

it('deletes menu option', function(): void {
    $menuOption = MenuOption::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.cart.menu_options', ['slug' => 'edit/'.$menuOption->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(MenuOption::find($menuOption->getKey()))->toBeNull();
});
