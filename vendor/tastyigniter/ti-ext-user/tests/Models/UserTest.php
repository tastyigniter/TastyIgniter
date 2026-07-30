<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Carbon\Carbon;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Concerns\SendsMailTemplate;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\System\Models\Language;
use Igniter\User\Classes\PermissionManager;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\Concerns\SendsInvite;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Igniter\User\Models\UserRole;
use Mockery;

it('returns correct full name', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->name = 'John Doe';

    expect($user->getStaffNameAttribute())->toBe('John Doe')
        ->and($user->getFullNameAttribute(null))->toBe('John Doe');
});

it('returns correct email', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->email = 'user@example.com';

    $result = $user->getStaffEmailAttribute();

    expect($result)->toBe('user@example.com');
});

it('returns correct avatar URL', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->email = 'user@example.com';

    $result = $user->getAvatarUrlAttribute();

    expect($result)->toBe('//www.gravatar.com/avatar/'.md5('user@example.com').'.png?d=mm');
});

it('returns default sale permission when not set', function(): void {
    $user = Mockery::mock(User::class)->makePartial();

    $result = $user->getSalePermissionAttribute(null);

    expect($result)->toBe(1);
});

it('returns correct sale permission when set', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->sale_permission = 2;

    $result = $user->getSalePermissionAttribute(2);

    expect($result)->toBe(2);
});

it('returns correct dropdown options for enabled users', function(): void {
    $user1 = User::factory()->create(['name' => 'John Doe', 'status' => 1]);
    $user2 = User::factory()->create(['name' => 'Jane Doe', 'status' => 1]);

    $result = User::getDropdownOptions();

    expect($result[$user1->getKey()])->toBe('John Doe')
        ->and($result[$user2->getKey()])->toBe('Jane Doe');
});

it('returns empty array when no enabled users are present', function(): void {
    $result = User::getDropdownOptions();

    expect($result)->toBeEmpty();
});

it('filters out super users', function(): void {
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('where')->with('super_user', '!=', 1)->andReturnSelf();
    $query->shouldReceive('orWhereNull')->with('super_user')->andReturnSelf()->once();

    $user = Mockery::mock(User::class)->makePartial();
    $user->scopeWhereNotSuperUser($query);
});

it('filters only super users', function(): void {
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('where')->with('super_user', 1)->andReturnSelf()->once();

    $user = Mockery::mock(User::class)->makePartial();
    $user->scopeWhereIsSuperUser($query);
});

it('updates last login timestamp after login', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('query')->andReturnSelf();
    $user->shouldReceive('whereKey')->andReturnSelf();
    $user->shouldReceive('update')->with(Mockery::on(fn($callback): bool => $callback['last_login'] instanceof Carbon))->once();

    $user->afterLogin();
});

it('returns true for super user', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->super_user = 1;

    $result = $user->isSuperUser();

    expect($result)->toBeTrue();
});

it('returns false for non-super user', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->super_user = 0;

    $result = $user->isSuperUser();

    expect($result)->toBeFalse();
});

it('returns true if user is super user', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('isSuperUser')->andReturnTrue();

    $result = $user->hasAnyPermission('any_permission');

    expect($result)->toBeTrue();
});

it('returns true if user has any of the given permissions', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('isSuperUser')->andReturnFalse();
    $user->shouldReceive('getPermissions')->andReturn(['permission1', 'permission2']);
    $permissionManager = Mockery::mock(PermissionManager::class);
    $permissionManager->shouldReceive('checkPermission')->with(['permission1', 'permission2'], ['permission1'], false)->andReturnTrue();
    app()->instance(PermissionManager::class, $permissionManager);

    $result = $user->hasAnyPermission('permission1');

    expect($result)->toBeTrue();
});

it('returns false if user does not have any of the given permissions', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('isSuperUser')->andReturnFalse();
    $user->shouldReceive('getPermissions')->andReturn(['permission1', 'permission2']);
    $permissionManager = Mockery::mock(PermissionManager::class);
    $permissionManager->shouldReceive('checkPermission')->with(['permission1', 'permission2'], ['permission3'], false)->andReturnFalse();
    app()->instance(PermissionManager::class, $permissionManager);

    $result = $user->hasAnyPermission('permission3');

    expect($result)->toBeFalse();
});

it('returns true if user has all of the given permissions', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('isSuperUser')->andReturnFalse();
    $user->shouldReceive('getPermissions')->andReturn(['permission1', 'permission2']);
    $permissionManager = Mockery::mock(PermissionManager::class);
    $permissionManager->shouldReceive('checkPermission')->with(['permission1', 'permission2'], ['permission1', 'permission2'], true)->andReturnTrue();
    app()->instance(PermissionManager::class, $permissionManager);

    $result = $user->hasPermission('permission1,permission2', true);

    expect($result)->toBeTrue();
});

it('returns false if user does not have all of the given permissions', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('isSuperUser')->andReturnFalse();
    $user->shouldReceive('getPermissions')->andReturn(['permission1', 'permission2']);
    $permissionManager = Mockery::mock(PermissionManager::class);
    $permissionManager->shouldReceive('checkPermission')->with(['permission1', 'permission2'], ['permission1', 'permission3'], true)->andReturnFalse();
    app()->instance(PermissionManager::class, $permissionManager);

    $result = $user->hasPermission('permission1,permission3', true);

    expect($result)->toBeFalse();
});

it('returns correct permissions for user role', function(): void {
    $role = Mockery::mock(UserRole::class)->makePartial();
    $role->permissions = ['permission1', 'permission2'];

    $user = Mockery::mock(User::class)->makePartial();
    $user->role = $role;

    $result = $user->getPermissions();

    expect($result)->toBe(['permission1', 'permission2']);
});

it('returns empty permissions when user role is not set', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->role = null;

    $result = $user->getPermissions();

    expect($result)->toBe([]);
});

it('returns staff/site email and name when type is staff or admin', function(): void {
    setting()->set(['site_email' => 'admin@example.com', 'site_name' => 'Admin Name']);
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('extendableGet')->with('full_name')->andReturn('Staff Name');
    $user->email = 'staff@example.com';

    $result = $user->mailGetRecipients('staff');

    expect($result)->toBe([['staff@example.com', 'Staff Name']]);

    $result = $user->mailGetRecipients('admin');

    expect($result)->toBe([['admin@example.com', 'Admin Name']]);

    $result = $user->mailGetRecipients('unknown');

    expect($result)->toBe([]);
});

it('returns true if user can be assigned to', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $result = $user->canAssignTo();

    expect($result)->toBeTrue();
});

it('returns true if user has global assignable scope', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->sale_permission = 1;

    $result = $user->hasGlobalAssignableScope();

    expect($result)->toBeTrue();
});

it('returns false if user does not have global assignable scope', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->sale_permission = 2;

    $result = $user->hasGlobalAssignableScope();

    expect($result)->toBeFalse();
});

it('returns true if user has group assignable scope', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->sale_permission = 2;

    $result = $user->hasGroupAssignableScope();

    expect($result)->toBeTrue();
});

it('returns false if user does not have group assignable scope', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->sale_permission = 1;

    $result = $user->hasGroupAssignableScope();

    expect($result)->toBeFalse();
});

it('returns true if user has restricted assignable scope', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->sale_permission = 3;

    $result = $user->hasRestrictedAssignableScope();

    expect($result)->toBeTrue();
});

it('returns false if user does not have restricted assignable scope', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->sale_permission = 1;

    $result = $user->hasRestrictedAssignableScope();

    expect($result)->toBeFalse();
});

it('returns user creation dates', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('pluckDates')->with('created_at')->andReturn(['2023-01-01', '2023-02-01']);

    $result = $user->getUserDates();

    expect($result)->toBe(['2023-01-01', '2023-02-01']);
});

it('syncs locations successfully', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('locations->sync')->with([1, 2, 3])->andReturnTrue();

    $result = $user->addLocations([1, 2, 3]);

    expect($result)->toBeTrue();
});

it('syncs groups successfully', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('groups->sync')->with([1, 2, 3])->andReturnTrue();

    $result = $user->addGroups([1, 2, 3]);

    expect($result)->toBeTrue();
});

it('registers a new user and activates it', function(): void {
    $attributes = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'username' => 'johndoe',
        'password' => 'secret',
        'language_id' => 1,
        'user_role_id' => 1,
        'super_user' => false,
        'status' => true,
        'groups' => [1, 2],
        'locations' => [1, 2],
    ];

    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('save')->andReturnTrue()->once();
    $user->shouldReceive('completeActivation')->andReturnTrue()->never();
    $user->shouldReceive('groups->attach')->with([1, 2])->andReturnTrue();
    $user->shouldReceive('locations->attach')->with([1, 2])->andReturnTrue();
    $user->shouldReceive('reload')->andReturnSelf();

    $user->register($attributes);
});

it('registers a new user without activation', function(): void {
    $attributes = [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'username' => 'janedoe',
        'password' => 'secret',
        'language_id' => 1,
        'user_role_id' => 1,
        'super_user' => false,
        'status' => true,
        'groups' => [1, 2],
        'locations' => [1, 2],
    ];

    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('save')->andReturnTrue()->once();
    $user->shouldReceive('completeActivation')->andReturnTrue()->once();
    $user->shouldReceive('groups->attach')->with([1, 2])->andReturnTrue();
    $user->shouldReceive('locations->attach')->with([1, 2])->andReturnTrue();
    $user->shouldReceive('reload')->andReturnSelf();

    $user->register($attributes, true);
});

it('returns broadcast notification channel', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('getKey')->andReturn(123);

    $result = $user->receivesBroadcastNotificationsOn();

    expect($result)->toBe('admin.users.123');
});

it('configures user model correctly', function(): void {
    $user = new User;

    expect(class_uses_recursive($user))
        ->toContain(Locationable::class)
        ->toContain(Purgeable::class)
        ->toContain(SendsInvite::class)
        ->toContain(SendsMailTemplate::class)
        ->toContain(Switchable::class)
        ->and($user->getTable())->toBe('admin_users')
        ->and($user->getKeyName())->toBe('user_id')
        ->and($user->timestamps)->toBeTrue()
        ->and($user->getGuarded())->toBe(['reset_code', 'activation_code', 'remember_token'])
        ->and($user->getAppends())->toBe(['full_name'])
        ->and($user->getHidden())->toBe(['password', 'remember_token'])
        ->and($user->getCasts()['password'])->toBe('hashed')
        ->and($user->getCasts()['user_role_id'])->toBe('integer')
        ->and($user->getCasts()['sale_permission'])->toBe('integer')
        ->and($user->getCasts()['language_id'])->toBe('integer')
        ->and($user->getCasts()['super_user'])->toBe('boolean')
        ->and($user->getCasts()['is_activated'])->toBe('boolean')
        ->and($user->getCasts()['reset_time'])->toBe('datetime')
        ->and($user->getCasts()['invited_at'])->toBe('datetime')
        ->and($user->getCasts()['activated_at'])->toBe('datetime')
        ->and($user->getCasts()['last_login'])->toBe('datetime')
        ->and($user->relation['hasMany']['assignable_logs'])->toBe([AssignableLog::class, 'foreignKey' => 'assignee_id'])
        ->and($user->relation['belongsTo']['role'])->toBe([UserRole::class, 'foreignKey' => 'user_role_id'])
        ->and($user->relation['belongsTo']['language'])->toBe([Language::class])
        ->and($user->relation['belongsToMany']['groups'])->toBe([UserGroup::class, 'table' => 'admin_users_groups'])
        ->and($user->relation['morphToMany']['locations'])->toBe([Location::class, 'name' => 'locationable'])
        ->and($user->getCasts()['super_user'])->toBe('boolean')
        ->and($user->getCasts()['sale_permission'])->toBe('integer');
});
