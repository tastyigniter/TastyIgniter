<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Cart\Models\Menu;
use Igniter\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

it('returns all menu items', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();

    $this
        ->get(route('igniter.api.menus.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$menu->getKey())
        ->assertJsonPath('data.0.attributes.menu_name', $menu->menu_name);
});

it('shows a menu item', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();

    $this
        ->get(route('igniter.api.menus.show', [$menu->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$menu->getKey())
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('menu_name', $menu->menu_name)
                ->where('menu_price', $menu->menu_price)
                ->etc(),
            )->etc(),
        );
});

it('shows a menu item with media relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();
    $menuMedia = $menu->media()->create(['file_name' => 'test.jpg', 'tag' => 'thumb']);

    $this
        ->get(route('igniter.api.menus.show', [$menu->getKey()]).'?'.
            http_build_query(['include' => 'media']))
        ->assertOk()
        ->assertJsonPath('data.relationships.media.data.type', 'media')
        ->assertJsonPath('included.0.id', (string)$menuMedia->getKey())
        ->assertJsonPath('included.0.attributes.file_name', 'test.jpg');
});

it('shows a menu item with categories relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();
    $menuCategory = $menu->categories()->create(['name' => 'Test Category']);

    $this
        ->get(route('igniter.api.menus.show', [$menu->getKey()]).'?'.
            http_build_query(['include' => 'categories']))
        ->assertOk()
        ->assertJsonPath('data.relationships.categories.data.0.type', 'categories')
        ->assertJsonPath('included.0.id', (string)$menuCategory->getKey())
        ->assertJsonPath('included.0.attributes.name', 'Test Category');
});

it('shows a menu item with menu_options relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();
    $menuOption = $menu->menu_options()->create(['min_selected' => 2, 'max_selected' => 4, 'option_id' => 1]);

    $this
        ->get(route('igniter.api.menus.show', [$menu->getKey()]).'?'.
            http_build_query(['include' => 'menu_options']))
        ->assertOk()
        ->assertJsonPath('data.relationships.menu_options.data.0.type', 'menu_options')
        ->assertJsonPath('included.3.id', (string)$menuOption->getKey())
        ->assertJsonPath('included.3.attributes.min_selected', 2)
        ->assertJsonPath('included.3.attributes.max_selected', 4);
});

it('shows a menu item with ingredients relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();
    $menuIngredient = $menu->ingredients()->create(['name' => 'Test Ingredient']);

    $this
        ->get(route('igniter.api.menus.show', [$menu->getKey()]).'?'.
            http_build_query(['include' => 'ingredients']))
        ->assertOk()
        ->assertJsonPath('data.relationships.ingredients.data.0.type', 'ingredients')
        ->assertJsonPath('included.0.id', (string)$menuIngredient->getKey())
        ->assertJsonPath('included.0.attributes.name', 'Test Ingredient');
});

it('shows a menu item with mealtimes relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();
    $menuMealtime = $menu->mealtimes()->create(['start_time' => '09:00', 'end_time' => '17:00']);

    $this
        ->get(route('igniter.api.menus.show', [$menu->getKey()]).'?'.
            http_build_query(['include' => 'mealtimes']))
        ->assertOk()
        ->assertJsonPath('data.relationships.mealtimes.data.0.type', 'mealtimes')
        ->assertJsonPath('included.0.id', (string)$menuMealtime->getKey())
        ->assertJsonPath('included.0.attributes.start_time', '09:00:00')
        ->assertJsonPath('included.0.attributes.end_time', '17:00:00');
});

it('shows a menu item with stocks relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();
    $menu->stocks()->create(['quantity' => 10]);

    $this
        ->get(route('igniter.api.menus.show', [$menu->getKey()]).'?'.
            http_build_query(['include' => 'stocks']))
        ->assertOk()
        ->assertJsonPath('data.relationships.stocks.data.0.type', 'stocks');
});

it('creates a menu item', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();

    $this
        ->post(route('igniter.api.menus.store'), [
            'menu_name' => 'Test menu item',
            'menu_price' => 99.999,
        ])
        ->assertCreated()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('menu_name', 'Test menu item')
                ->where('menu_price', 99.999)
                ->etc(),
            ));
});

it('updates a menu item', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();

    $this
        ->put(route('igniter.api.menus.update', [$menu->getKey()]), [
            'menu_name' => 'Test menu item',
            'menu_price' => 99.999,
        ])
        ->assertOk()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('menu_name', 'Test menu item')
                ->where('menu_price', 99.999)
                ->etc(),
            )->etc());
});

it('deletes a menu item', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menus:*']);
    $menu = Menu::first();

    $this
        ->delete(route('igniter.api.menus.destroy', [$menu->getKey()]))
        ->assertStatus(204);
});
