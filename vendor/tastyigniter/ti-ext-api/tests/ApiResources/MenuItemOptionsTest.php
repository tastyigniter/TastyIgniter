<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Cart\Models\MenuItemOption;
use Igniter\Cart\Models\MenuOption;
use Igniter\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

it('returns all menu item options', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_item_options:*']);
    $menuItemOption = MenuItemOption::first();

    $this
        ->get(route('igniter.api.menu_item_options.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$menuItemOption->getKey())
        ->assertJsonPath('data.0.attributes.option_name', $menuItemOption->option_name);
});

it('shows a menu item option', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_item_options:*']);
    $menuItemOption = MenuItemOption::first();

    $this
        ->get(route('igniter.api.menu_item_options.show', [$menuItemOption->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$menuItemOption->getKey())
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes.option')
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('option_id', $menuItemOption->option->getKey())
                ->etc(),
            )->etc(),
        );
});

it('shows a menu item option with menu_option_values relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_item_options:*']);
    $menuItemOption = MenuItemOption::first();
    $menuItemOption->menu_option_values()->create(['option_value_id' => 1]);

    $this
        ->get(route('igniter.api.menu_item_options.show', [$menuItemOption->getKey()]).'?'.http_build_query([
            'include' => 'menu_option_values',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.menu_option_values.data.0.type', 'menu_option_values');
});

it('creates a menu item option', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_item_options:*']);
    $menuOption = MenuOption::first();

    $this
        ->post(route('igniter.api.menu_item_options.store'), [
            'menu_id' => 1,
            'option_id' => $menuOption->getKey(),
            'menu_option_values' => [
                ['menu_id' => 1, 'option_id' => 1],
            ],
        ])
        ->assertCreated()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('option_id', $menuOption->getKey())
                ->etc(),
            ));
});

it('updates a menu item option', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_item_options:*']);
    $menuItemOption = MenuItemOption::first();

    $this
        ->put(route('igniter.api.menu_item_options.update', [$menuItemOption->getKey()]), [
            'option_id' => $menuItemOption->option->getKey(),
        ])
        ->assertOk()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('option_id', $menuItemOption->option->getKey())
                ->etc(),
            )->etc());
});

it('deletes a menu item option', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_item_options:*']);
    $menuItemOption = MenuItemOption::first();

    $this
        ->delete(route('igniter.api.menu_item_options.destroy', [$menuItemOption->getKey()]))
        ->assertStatus(204);
});
