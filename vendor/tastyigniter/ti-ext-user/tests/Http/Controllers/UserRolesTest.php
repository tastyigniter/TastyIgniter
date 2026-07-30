<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Controllers;

use Igniter\User\Models\UserRole;

it('loads user roles page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.user_roles'))
        ->assertOk();
});

it('loads create user role page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.user_roles', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit user role page', function(): void {
    $userRole = UserRole::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.user.user_roles', ['slug' => 'edit/'.$userRole->getKey()]))
        ->assertOk();
});

it('loads user role preview page', function(): void {
    $userRole = UserRole::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.user.user_roles', ['slug' => 'preview/'.$userRole->getKey()]))
        ->assertOk();
});

it('creates user role', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.user.user_roles', ['slug' => 'create']), [
            'UserRole' => [
                'name' => 'Created User Role',
                'permissions' => [
                    'Admin.Dashboard' => 1,
                    'Admin.Users' => 1,
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(UserRole::where('name', 'Created User Role')->exists())->toBeTrue();
});

it('updates user role', function(): void {
    $userRole = UserRole::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.user.user_roles', ['slug' => 'edit/'.$userRole->getKey()]), [
            'UserRole' => [
                'name' => 'Updated User Role',
                'permissions' => [
                    'Admin.Dashboard' => 1,
                    'Admin.Users' => 1,
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(UserRole::where('name', 'Updated User Role')->exists())->toBeTrue();
});

it('deletes user role', function(): void {
    $userRole = UserRole::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.user.user_roles', ['slug' => 'edit/'.$userRole->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(UserRole::find($userRole->getKey()))->toBeNull();
});

it('bulk deletes user roles', function(): void {
    $userRole = UserRole::factory()->count(5)->create();
    $userRoleIds = $userRole->pluck('user_role_id')->all();

    actingAsSuperUser()
        ->post(route('igniter.user.user_roles'), [
            'checked' => $userRoleIds,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(UserRole::whereIn('user_role_id',
        $userRoleIds,
    )->exists())->toBeFalse();
});
