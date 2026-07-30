<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Igniter\Flame\Database\Builder;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Mockery;

it('returns dropdown options for user groups', function(): void {
    $group1 = UserGroup::factory()->create(['user_group_name' => 'Group 1']);
    $group2 = UserGroup::factory()->create(['user_group_name' => 'Group 2']);

    $result = UserGroup::getDropdownOptions();

    expect($result[$group1->getKey()])->toBe('Group 1')
        ->and($result[$group2->getKey()])->toBe('Group 2');
});

it('returns list of dropdown options with descriptions', function(): void {
    $group1 = UserGroup::factory()->create(['user_group_name' => 'Group 1', 'description' => 'Group 1 description']);
    $group2 = UserGroup::factory()->create(['user_group_name' => 'Group 2', 'description' => 'Group 2 description']);

    $result = UserGroup::listDropdownOptions();

    expect($result[$group1->getKey()])->toBe(['Group 1', 'Group 1 description'])
        ->and($result[$group2->getKey()])->toBe(['Group 2', 'Group 2 description']);
});

it('returns staff count attribute', function(): void {
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $userGroup->shouldReceive('getAttribute')->with('users')->andReturn(collect([1, 2, 3]));

    $result = $userGroup->getStaffCountAttribute(null);

    expect($result)->toBe(3);
});

it('syncs auto assign status', function(): void {
    UserGroup::factory()->create(['auto_assign' => 1]);

    UserGroup::syncAutoAssignStatus();

    expect(setting()->getPref('allocator_is_enabled'))->toBe('1');
});

it('returns default auto assign limit', function(): void {
    $userGroup = new UserGroup(['auto_assign_limit' => null]);

    $result = $userGroup->getAutoAssignLimitAttribute(null);

    expect($result)->toBe(20);
});

it('returns custom auto assign limit', function(): void {
    $userGroup = new UserGroup(['auto_assign_limit' => 10]);

    $result = $userGroup->getAutoAssignLimitAttribute(null);

    expect($result)->toBe(10);
});

it('returns true if auto assign is enabled', function(): void {
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $userGroup->auto_assign = true;

    $result = $userGroup->autoAssignEnabled();

    expect($result)->toBeTrue();
});

it('returns false if auto assign is disabled', function(): void {
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $userGroup->auto_assign = false;

    $result = $userGroup->autoAssignEnabled();

    expect($result)->toBeFalse();
});

it('returns list of assignees', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('isEnabled')->andReturnTrue()->once();
    $user->shouldReceive('canAssignTo')->andReturnTrue()->once();
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $userGroup->shouldReceive('getAttribute')->with('users')->andReturn(collect([$user]));

    $userGroup->listAssignees();
});

it('returns available assignee using round robin', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $query = Mockery::mock(Builder::class)->makePartial();
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $userGroup->auto_assign_mode = UserGroup::AUTO_ASSIGN_ROUND_ROBIN;
    $userGroup->shouldReceive('assignable_logs')->andReturn($query);
    $query->shouldReceive('applyRoundRobinScope')->andReturnSelf()->once();
    $query->shouldReceive('pluck')->andReturn(collect([1 => 0]))->once();
    $userGroup->shouldReceive('listAssignees')->andReturn(collect([$user]))->once();

    $result = $userGroup->findAvailableAssignee();

    expect($result)->toBe($user);
});

it('returns available assignee using load balanced', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $query = Mockery::mock(Builder::class)->makePartial();
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $userGroup->auto_assign_mode = UserGroup::AUTO_ASSIGN_LOAD_BALANCED;
    $userGroup->shouldReceive('assignable_logs')->andReturn($query);
    $query->shouldReceive('applyLoadBalancedScope')->andReturnSelf()->once();
    $query->shouldReceive('pluck')->andReturn(collect([1 => 0]))->once();
    $userGroup->shouldReceive('listAssignees')->andReturn(collect([$user]))->once();

    $result = $userGroup->findAvailableAssignee();

    expect($result)->toBe($user);
});

it('configures user group model correctly', function(): void {
    $userGroup = new UserGroup;

    expect($userGroup->getTable())->toBe('admin_user_groups')
        ->and($userGroup->getKeyName())->toBe('user_group_id')
        ->and($userGroup->timestamps)->toBeTrue()
        ->and($userGroup->relation['hasMany']['assignable_logs'])->toBe([AssignableLog::class, 'foreignKey' => 'assignee_group_id'])
        ->and($userGroup->relation['belongsToMany']['users'])->toBe([User::class, 'table' => 'admin_users_groups'])
        ->and($userGroup->getCasts()['auto_assign'])->toBe('boolean')
        ->and($userGroup->getCasts()['auto_assign_mode'])->toBe('integer')
        ->and($userGroup->getCasts()['auto_assign_limit'])->toBe('integer')
        ->and($userGroup->getCasts()['auto_assign_availability'])->toBe('boolean');
});
