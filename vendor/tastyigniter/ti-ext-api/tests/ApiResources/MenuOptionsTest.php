<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Cart\Models\MenuOption;
use Igniter\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;

it('returns all menu options', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_options:*']);
    $menuOption = MenuOption::first();

    $this
        ->get(route('igniter.api.menu_options.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$menuOption->getKey())
        ->assertJsonPath('data.0.attributes.option_name', $menuOption->option_name);
});

it('shows a menu option', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_options:*']);
    $menuOption = MenuOption::first();

    $this
        ->get(route('igniter.api.menu_options.show', [$menuOption->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$menuOption->getKey())
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('option_name', $menuOption->option_name)
                ->where('display_type', $menuOption->display_type)
                ->etc(),
            )->etc(),
        );
});

it('shows a menu option with option_values relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_options:*']);
    $menuOption = MenuOption::first();
    $menuOptionValue = $menuOption->option_values()->create(['name' => 'Test Value']);

    $this
        ->get(route('igniter.api.menu_options.show', [$menuOption->getKey()]).'?'.http_build_query([
            'include' => 'option_values',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.option_values.data.0.type', 'option_values')
        ->assertJsonPath('included.3.id', (string)$menuOptionValue->getKey())
        ->assertJsonPath('included.3.attributes.name', 'Test Value');
});

it('creates a menu option', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_options:*']);
    $menuOption = MenuOption::first();

    $this
        ->post(route('igniter.api.menu_options.store'), [
            'option_name' => 'Test menu option',
            'display_type' => 'radio',
        ])
        ->assertCreated()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('option_name', 'Test menu option')
                ->where('display_type', 'radio')
                ->etc(),
            ));
});

it('updates a menu option', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_options:*']);
    $menuOption = MenuOption::first();

    $this
        ->put(route('igniter.api.menu_options.update', [$menuOption->getKey()]), [
            'option_name' => 'Test menu option',
            'display_type' => 'radio',
        ])
        ->assertOk()
        ->assertJson(fn(AssertableJson $json): AssertableJson => $json
            ->has('data.attributes', fn(AssertableJson $json): AssertableJson => $json
                ->where('option_name', 'Test menu option')
                ->where('display_type', 'radio')
                ->etc(),
            )->etc());
});

it('deletes a menu option', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['menu_options:*']);
    $menuOption = MenuOption::first();

    $this
        ->delete(route('igniter.api.menu_options.destroy', [$menuOption->getKey()]))
        ->assertStatus(204);
});
