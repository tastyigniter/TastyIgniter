<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Igniter\Flame\Database\Casts\Serialize;
use Igniter\User\Models\User;
use Igniter\User\Models\UserRole;
use InvalidArgumentException;
use Mockery;

it('returns dropdown options for user roles', function(): void {
    $role1 = UserRole::factory()->create(['name' => 'Role 1']);
    $role2 = UserRole::factory()->create(['name' => 'Role 2']);

    $result = UserRole::getDropdownOptions();

    expect($result[$role1->getKey()])->toBe('Role 1')
        ->and($result[$role2->getKey()])->toBe('Role 2');
});

it('returns list of dropdown options with descriptions', function(): void {
    $role1 = UserRole::factory()->create(['name' => 'Role 1', 'description' => 'Role 1 description']);
    $role2 = UserRole::factory()->create(['name' => 'Role 2', 'description' => 'Role 2 description']);

    $result = UserRole::listDropdownOptions();

    expect($result[$role1->getKey()])->toBe(['Role 1', 'Role 1 description'])
        ->and($result[$role2->getKey()])->toBe(['Role 2', 'Role 2 description']);
});

it('returns staff count attribute', function(): void {
    $userRole = Mockery::mock(UserRole::class)->makePartial();
    $userRole->shouldReceive('getAttribute')->with('users')->andReturn(collect([1, 2, 3]));

    $result = $userRole->getStaffCountAttribute(null);

    expect($result)->toBe(3);
});

it('throws exception for invalid permission value', function(): void {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Invalid value "2" for permission "edit" given.');

    $userRole = Mockery::mock(UserRole::class)->makePartial();
    $userRole->setPermissionsAttribute(['edit' => 2]);
});

it('sets permissions attribute correctly', function(): void {
    $userRole = Mockery::mock(UserRole::class)->makePartial();
    $permissions = ['edit' => 1, 'delete' => -1];
    $userRole->setPermissionsAttribute($permissions);

    $result = $userRole->getAttribute('permissions');

    expect($result)->toBe($permissions);
});

it('removes permissions with value 0', function(): void {
    $userRole = Mockery::mock(UserRole::class)->makePartial();
    $permissions = ['edit' => 1, 'delete' => 0];
    $userRole->setPermissionsAttribute($permissions);

    $result = $userRole->getAttribute('permissions');

    expect($result)->toBe(['edit' => 1]);
});

it('configures user role model correctly', function(): void {
    $role = new UserRole;

    expect($role->getTable())->toBe('admin_user_roles')
        ->and($role->getKeyName())->toBe('user_role_id')
        ->and($role->timestamps)->toBeTrue()
        ->and($role->relation['hasMany']['users'])->toBe([
            User::class, 'foreignKey' => 'user_role_id', 'otherKey' => 'user_role_id',
        ])
        ->and($role->getCasts()['permissions'])->toBe(Serialize::class);
});
