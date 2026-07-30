<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Controllers;

use Igniter\User\Models\UserGroup;

it('loads user groups page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.user_groups'))
        ->assertOk();
});

it('loads create user group page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.user_groups', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit user group page', function(): void {
    $userGroup = UserGroup::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.user.user_groups', ['slug' => 'edit/'.$userGroup->getKey()]))
        ->assertOk();
});

it('loads user group preview page', function(): void {
    $userGroup = UserGroup::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.user.user_groups', ['slug' => 'preview/'.$userGroup->getKey()]))
        ->assertOk();
});

it('creates user group', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.user.user_groups', ['slug' => 'create']), [
            'UserGroup' => [
                'user_group_name' => 'Created User Group',
                'auto_assign' => 0,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(UserGroup::where('user_group_name', 'Created User Group')->exists())->toBeTrue();
});

it('updates user group', function(): void {
    $userGroup = UserGroup::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.user.user_groups', ['slug' => 'edit/'.$userGroup->getKey()]), [
            'UserGroup' => [
                'user_group_name' => 'Updated User Group',
                'auto_assign' => 0,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(UserGroup::where('user_group_name', 'Updated User Group')->exists())->toBeTrue();
});

it('deletes user group', function(): void {
    $userGroup = UserGroup::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.user.user_groups', ['slug' => 'edit/'.$userGroup->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(UserGroup::find($userGroup->getKey()))->toBeNull();
});

it('bulk deletes user groups', function(): void {
    $userGroup = UserGroup::factory()->count(5)->create();
    $userGroupIds = $userGroup->pluck('user_group_id')->all();

    actingAsSuperUser()
        ->post(route('igniter.user.user_groups'), [
            'checked' => $userGroupIds,
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(UserGroup::whereIn('user_group_id',
        $userGroupIds,
    )->exists())->toBeFalse();
});
