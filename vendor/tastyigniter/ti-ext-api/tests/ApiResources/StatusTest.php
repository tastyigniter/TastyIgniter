<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Admin\Models\Status;
use Igniter\User\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns all statuses', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['status:*']);
    $status = Status::first();

    $this
        ->get(route('igniter.api.status.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$status->getKey())
        ->assertJsonPath('data.0.attributes.status_name', $status->status_name);
});

it('shows a status', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['status:*']);
    $status = Status::factory()->create();

    $this
        ->get(route('igniter.api.status.show', [$status->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$status->getKey())
        ->assertJsonPath('data.attributes.status_name', $status->status_name)
        ->assertJsonPath('data.attributes.status_for', $status->status_for);
});

it('creates a status', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['status:*']);

    $this
        ->post(route('igniter.api.status.store'), [
            'status_name' => 'Test Status',
            'status_for' => 'order',
            'status_color' => '#FF0000',
            'status_comment' => 'Test comment',
            'notify_customer' => true,
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.status_name', 'Test Status')
        ->assertJsonPath('data.attributes.status_for', 'order');
});

it('creates a status fails on validation', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['status:*']);

    $this
        ->post(route('igniter.api.status.store'), [
            'status_name' => 'T', // Too short, minimum is 2
        ])
        ->assertStatus(422);
});

it('creates a status fails on invalid status_for', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['status:*']);

    $this
        ->post(route('igniter.api.status.store'), [
            'status_name' => 'Test Status',
            'status_for' => 'invalid', // Must be 'order' or 'reservation'
            'notify_customer' => true,
        ])
        ->assertStatus(422);
});

it('updates a status', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['status:*']);
    $status = Status::factory()->create();

    $this
        ->put(route('igniter.api.status.update', [$status->getKey()]), [
            'status_name' => 'Updated Status',
            'status_for' => 'reservation',
            'status_color' => '#00FF00',
            'status_comment' => 'Updated comment',
            'notify_customer' => false,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.status_name', 'Updated Status')
        ->assertJsonPath('data.attributes.status_for', 'reservation');
});

it('deletes a status', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['status:*']);
    $status = Status::factory()->create();

    $this
        ->delete(route('igniter.api.status.destroy', [$status->getKey()]))
        ->assertStatus(204);
});

