<?php

declare(strict_types=1);

namespace Igniter\Pages\Tests\Http\Controllers;

use Igniter\Main\Models\Theme;
use Igniter\Pages\Models\Menu;

beforeEach(function(): void {
    Theme::syncAll();
    Menu::syncAll();
});

it('loads static menus page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.pages.menus'))
        ->assertOk();
});

it('loads create static menu page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.pages.menus', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit static menu page', function(): void {
    $menu = Menu::firstWhere('code', 'main-menu');

    actingAsSuperUser()
        ->get(route('igniter.pages.menus', ['slug' => 'edit/'.$menu->id]))
        ->assertOk();
});

it('loads static menu preview page', function(): void {
    $menu = Menu::firstWhere('code', 'main-menu');

    actingAsSuperUser()
        ->get(route('igniter.pages.menus', 'preview/'.$menu->id))
        ->assertOk();
});

it('creates new menu item', function(): void {
    $menu = Menu::firstWhere('code', 'main-menu');

    actingAsSuperUser()
        ->post(route('igniter.pages.menus', ['slug' => 'edit/'.$menu->getKey()]), [
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onNewItem',
        ]);

    expect($menu->items()->where('title', 'New Item')->exists())->toBeTrue();
});

it('gets menu item info', function(): void {
    $menu = Menu::firstWhere('code', 'main-menu');
    $menuItem = $menu->items()->first();

    actingAsSuperUser()
        ->post(route('igniter.pages.menus', ['slug' => 'edit/'.$menu->getKey()]), [
            'type' => $menuItem->type,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onGetMenuItemTypeInfo',
        ])
        ->assertOk();
});

it('creates static menu', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.pages.menus', ['slug' => 'create']), [
            'Menu' => [
                'name' => 'Created Menu',
                'code' => 'created-menu',
                'theme_code' => 'tests-theme',
                'description' => 'Created menu description',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Menu::where('name', 'Created Menu')->exists())->toBeTrue();
});

it('updates static menu', function(): void {
    $menu = Menu::firstWhere('code', 'main-menu');

    actingAsSuperUser()
        ->post(route('igniter.pages.menus', ['slug' => 'edit/'.$menu->id]), [
            'Menu' => [
                'name' => 'Updated Menu',
                'code' => 'updated-menu',
                'theme_code' => 'tests-theme',
                'items' => [
                    [
                        'id' => 1,
                        'priority' => 1,
                        'title' => 'Menu Item',
                        'code' => 'menu-item',
                        'type' => 'menu',
                        'item_id' => 1,
                        'children' => [],
                    ],
                ],
            ],
            '___dragged_items' => [1],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Menu::find($menu->id)->name)->toBe('Updated Menu');
});

it('deletes static menu', function(): void {
    $menu = Menu::firstWhere('code', 'main-menu');

    actingAsSuperUser()
        ->post(route('igniter.pages.menus', ['slug' => 'edit/'.$menu->id]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Menu::find($menu->id))->toBeNull();
});
