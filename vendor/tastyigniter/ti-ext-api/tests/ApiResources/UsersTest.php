<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\Local\Models\Location;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Igniter\User\Models\UserRole;
use Laravel\Sanctum\Sanctum;

it('returns all users', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $user = User::first();

    $this
        ->get(route('igniter.api.users.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$user->getKey())
        ->assertJsonPath('data.0.attributes.name', $user->name);
});

it('shows a user', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $user = User::factory()->create();

    $this
        ->get(route('igniter.api.users.show', [$user->getKey()]))
        ->assertOk()
        ->assertJsonPath('data.id', (string)$user->getKey())
        ->assertJsonPath('data.attributes.name', $user->name)
        ->assertJsonPath('data.attributes.email', $user->email);
});

it('shows a user with groups relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $user = User::factory()->create();
    $userGroup = UserGroup::factory()->create(['user_group_name' => 'Test Group']);
    $user->groups()->attach($userGroup);

    $this
        ->get(route('igniter.api.users.show', [$user->getKey()]).'?'.http_build_query([
            'include' => 'groups',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.groups.data.0.type', 'groups')
        ->assertJsonPath('included.0.id', (string)$userGroup->getKey())
        ->assertJsonPath('included.0.attributes.user_group_name', 'Test Group');
});

it('shows a user with locations relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $user = User::factory()->create();
    $location = Location::factory()->create(['location_name' => 'Test Location']);
    $user->locations()->attach($location);

    $this
        ->get(route('igniter.api.users.show', [$user->getKey()]).'?'.http_build_query([
            'include' => 'locations',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.locations.data.0.type', 'locations')
        ->assertJsonPath('included.0.id', (string)$location->getKey())
        ->assertJsonPath('included.0.attributes.location_name', 'Test Location');
});

it('shows a user with role relationship', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $role = UserRole::factory()->create(['name' => 'Test Role']);
    $user = User::factory()->create(['user_role_id' => $role->getKey()]);

    $this
        ->get(route('igniter.api.users.show', [$user->getKey()]).'?'.http_build_query([
            'include' => 'role',
        ]))
        ->assertOk()
        ->assertJsonPath('data.relationships.role.data.type', 'role')
        ->assertJsonPath('included.0.id', (string)$role->getKey())
        ->assertJsonPath('included.0.attributes.name', 'Test Role');
});

it('creates a user', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $role = UserRole::factory()->create();

    $this
        ->post(route('igniter.api.users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.tld',
            'username' => 'testuser',
            'password' => 'Test@Password123!',
            'password_confirm' => 'Test@Password123!',
            'user_role_id' => $role->getKey(),
            'status' => true,
            'send_invite' => false,
        ])
        ->assertCreated()
        ->assertJsonPath('data.attributes.name', 'Test User')
        ->assertJsonPath('data.attributes.email', 'test@example.tld');
});

it('creates a user fails on validation', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);

    $this
        ->post(route('igniter.api.users.store'), [
            'name' => 'T', // Too short, minimum is 2
            'email' => 'invalid-email', // Invalid email format
        ])
        ->assertStatus(422);
});

it('creates a user fails on missing required fields', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);

    $this
        ->post(route('igniter.api.users.store'))
        ->assertStatus(422);
});

it('creates a user fails on password mismatch', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $role = UserRole::factory()->create();

    $this
        ->post(route('igniter.api.users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.tld',
            'username' => 'testuser',
            'password' => 'Test@Password123!',
            'password_confirm' => 'DifferentPassword123!',
            'user_role_id' => $role->getKey(),
            'status' => true,
            'send_invite' => false,
        ])
        ->assertStatus(422);
});

it('updates a user', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $user = User::factory()->create();
    $role = UserRole::factory()->create();

    $this
        ->put(route('igniter.api.users.update', [$user->getKey()]), [
            'name' => 'Updated User',
            'email' => 'updated@example.tld',
            'username' => 'updateduser',
            'user_role_id' => $role->getKey(),
            'status' => true,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.name', 'Updated User')
        ->assertJsonPath('data.attributes.email', 'updated@example.tld');
});

it('updates a user password', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $user = User::factory()->create();
    $role = UserRole::factory()->create();

    $this
        ->put(route('igniter.api.users.update', [$user->getKey()]), [
            'name' => 'Updated Name',
            'email' => 'newemail@example.tld',
            'username' => 'newusername',
            'password' => 'New@Password123!',
            'password_confirm' => 'New@Password123!',
            'user_role_id' => $role->getKey(),
            'status' => true,
        ])
        ->assertOk()
        ->assertJsonPath('data.attributes.name', 'Updated Name')
        ->assertJsonPath('data.attributes.email', 'newemail@example.tld');
});

it('deletes a user', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['staff:*']);
    $user = User::factory()->create();

    $this
        ->delete(route('igniter.api.users.destroy', [$user->getKey()]))
        ->assertStatus(204);
});

