<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Controllers;

use Igniter\Cart\Models\Ingredient;

it('loads ingredients page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.cart.ingredients'))
        ->assertOk();
});

it('loads create ingredient page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.cart.ingredients', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit ingredient page', function(): void {
    $ingredient = Ingredient::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.cart.ingredients', ['slug' => 'edit/'.$ingredient->getKey()]))
        ->assertOk();
});

it('loads ingredient preview page', function(): void {
    $ingredient = Ingredient::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.cart.ingredients', ['slug' => 'preview/'.$ingredient->getKey()]))
        ->assertOk();
});

it('updates ingredient', function(): void {
    $ingredient = Ingredient::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.cart.ingredients', ['slug' => 'edit/'.$ingredient->getKey()]), [
            'Ingredient' => [
                'name' => 'Updated Ingredient',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Ingredient::find($ingredient->getKey()))->name->toBe('Updated Ingredient');
});

it('deletes ingredient', function(): void {
    $ingredient = Ingredient::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.cart.ingredients', ['slug' => 'edit/'.$ingredient->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Ingredient::find($ingredient->getKey()))->toBeNull();
});
