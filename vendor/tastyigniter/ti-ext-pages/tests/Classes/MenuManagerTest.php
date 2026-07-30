<?php

declare(strict_types=1);

namespace Igniter\Pages\Tests\Classes;

use Igniter\Main\Models\Theme;
use Igniter\Pages\Classes\MenuManager;
use Igniter\Pages\Classes\Page;
use Igniter\Pages\Models\Menu;
use Igniter\Pages\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Mockery;

beforeEach(function(): void {
    Theme::syncAll();
    Menu::syncAll();
});

it('loads menus from config files across loaded themes', function(): void {
    Theme::factory()->create([
        'name' => 'Theme Name',
        'code' => 'tests-theme',
        'version' => '1.0.0',
        'status' => 1,
        'data' => [],
    ]);

    $menuManager = new MenuManager;
    $menus = $menuManager->getMenusConfig();

    expect($menus)->not->toBeEmpty()
        ->and($menus)->toHaveCount(3);
});

it('generates menu references with active state', function(): void {
    $request = Request::create('/account/address');
    app()->instance('request', $request);

    $page = Mockery::mock(Page::class);
    $page->shouldReceive('getAttribute')->andReturn('view-menu');
    $menu = Menu::create([
        'name' => 'Test menu',
        'code' => 'test-menu',
        'theme_code' => 'igniter-orange',
    ]);
    $parent = $menu->items()->create([
        'title' => 'Test', 'code' => 'test', 'type' => 'url', 'url' => '/',
    ]);
    $menu->items()->create([
        'title' => 'About Us', 'code' => 'about-us', 'type' => 'theme-page', 'theme_code' => 'igniter-orange',
    ]);
    $menu->items()->create([
        'title' => 'Policy', 'code' => 'policy', 'type' => 'theme-page', 'url' => '/policy', 'theme_code' => 'igniter-orange',
    ]);
    $menuItem = $menu->items()->create([
        'title' => 'Account', 'code' => 'account', 'type' => 'url', 'url' => '/account',
    ]);
    $menuItem2 = $menu->items()->create([
        'title' => 'Address', 'code' => 'address', 'type' => 'url', 'url' => '/account/address',
    ]);
    $menuItem3 = $menu->items()->create([
        'title' => 'Address Edit', 'code' => 'address-edit', 'type' => 'url', 'url' => '/account/address',
    ]);
    MenuItem::fixTree();
    $menuItem->parent()->associate($parent)->save();
    $menuItem2->parent()->associate($parent)->save();
    $menuItem3->parent()->associate($menuItem)->save();

    Event::listen('pages.menuitem.resolveItem', fn($item, $currentUrl, $theme): array => [
        'url' => $item->url,
        'isActive' => $item->url == $currentUrl,
        'items' => [
            [
                'title' => 'Address Edit',
                'code' => 'address-edit',
            ],
        ],
    ]);

    Event::listen('pages.menuitem.resolveItem', fn($item, $currentUrl, $theme): array => [
        [
            'isActive' => $item->url == $currentUrl,
            'items' => [
                [
                    'title' => 'Address Preview',
                    'code' => 'address-preview',
                    'url' => '/account/address',
                    'items' => [
                        [
                            'title' => 'Address Edit',
                            'code' => 'address-edit',
                        ],
                    ],
                ],
            ],
        ],
    ]);

    $items = (new MenuManager)->generateReferences($menu, $page);

    expect($items)->not->toBeEmpty()
        ->and($items[0]->code)->toEqual('test')
        ->and($items[0]->isActive)->toBeFalse()
        ->and($items[0]->items[0]->isActive)->toBeFalse()
        ->and($items[0]->items[0]->isChildActive)->toBeTrue()
        ->and($items[0]->items[0]->items[0]->code)->toEqual('address-edit')
        ->and($items[0]->items[0]->items[0]->isActive)->toBeTrue()
        ->and($items[1]->code)->toEqual('about-us')
        ->and($items[1]->items[0]->code)->toEqual('address-preview')
        ->and($items[1]->items[0]->items[0]->code)->toEqual('address-edit');
});
