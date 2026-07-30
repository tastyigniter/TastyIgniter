<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningTable;
use Igniter\User\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns all dining tables', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['tables:*']);

    $diningTable = DiningTable::first();
    $this
        ->get(route('igniter.api.tables.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$diningTable->getKey())
        ->assertJsonPath('data.0.attributes.name', $diningTable->name);
});

it('shows a dining table', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['tables:*']);
    $diningTable = DiningTable::first();

    $this
        ->get(route('igniter.api.tables.show', [$diningTable->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$diningTable->getKey())
        ->assertJsonPath('data.attributes.name', $diningTable->name);
});

it('creates a dining table', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['tables:*']);

    $this
        ->post(route('igniter.api.tables.store'), [
            'name' => 'Test Table',
            'shape' => 'rectangle',
            'min_capacity' => 1,
            'max_capacity' => 10,
            'is_enabled' => 1,
            'dining_area_id' => DiningArea::first()->getKey(),
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.name', 'Test Table');
});

it('updates a dining table', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['tables:*']);
    $diningTable = DiningTable::first();

    $this
        ->put(route('igniter.api.tables.update', [$diningTable->getKey()]), [
            'name' => 'Test Table updated',
            'shape' => 'round',
            'min_capacity' => 3,
            'max_capacity' => 13,
            'dining_area_id' => DiningArea::first()->getKey(),
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.name', 'Test Table updated');
});

it('deletes a dining table', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['tables:*']);
    $diningTable = DiningTable::first();

    $this
        ->delete(route('igniter.api.tables.destroy', [$diningTable->getKey()]))
        ->assertStatus(204);

    expect(DiningTable::find($diningTable->getKey()))->toBeNull();
});
