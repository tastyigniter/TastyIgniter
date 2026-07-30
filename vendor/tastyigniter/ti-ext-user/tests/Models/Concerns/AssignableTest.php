<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models\Concerns;

use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Exception\FlashException;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\Concerns\Assignable;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Illuminate\Support\Facades\Event;
use Mockery;

it('assigns to user successfully', function(): void {
    Event::fake();
    $assignable = Mockery::mock(Order::class)->makePartial();
    $assignee = Mockery::mock(User::class)->makePartial();
    $user = Mockery::mock(User::class)->makePartial();
    $group = Mockery::mock(UserGroup::class)->makePartial();
    $assignable->assignee = null;
    $assignable->assignee_group = $group;
    $assignable->assignee_group_id = 1;
    $assignable->assignee_id = 1;
    $assignable->status_id = 1;
    $assignee->shouldReceive('groups->first')->andReturnNull();
    $assignable->shouldReceive('assignee_group->associate')->with($group)->once();
    $assignable->shouldReceive('assignee->associate')->with($assignee)->once();
    $assignable->shouldReceive('fireSystemEvent')->with('admin.assignable.beforeAssignTo', [$group, $assignee, null, $group])->once();
    $assignable->shouldReceive('save')->andReturnTrue();
    $assignable->shouldReceive('fireSystemEvent')->with('admin.assignable.assigned', Mockery::any())->once();
    $assignable->shouldReceive('getMorphClass')->andReturn('assignable');
    $assignable->shouldReceive('getKey')->andReturn(1);
    $assignable->shouldReceive('getKeyName')->andReturn('id');
    $assignable->shouldReceive('newQuery->where->update')->once();

    $result = $assignable->assignTo($assignee, $user);

    expect($result)->toBeInstanceOf(AssignableLog::class);
});

it('updates assign to successfully', function(): void {
    Event::fake();
    $assignable = Mockery::mock(Order::class)->makePartial();
    $assignee = Mockery::mock(User::class)->makePartial();
    $user = Mockery::mock(User::class)->makePartial();
    $assignable->assignee = null;
    $assignable->assignee_group = null;
    $assignable->assignee_group_id = 1;
    $assignable->assignee_id = 1;
    $assignable->status_id = 1;
    $assignee->shouldReceive('groups->first')->andReturnNull();
    $assignable->shouldReceive('assignee_group->dissociate')->once();
    $assignable->shouldReceive('assignee->associate')->with($assignee)->once();
    $assignable->shouldReceive('fireSystemEvent')->with('admin.assignable.beforeAssignTo', [null, $assignee, null, null])->once();
    $assignable->shouldReceive('save')->andReturnTrue();
    $assignable->shouldReceive('fireSystemEvent')->with('admin.assignable.assigned', Mockery::any())->once();
    $assignable->shouldReceive('getMorphClass')->andReturn('assignable');
    $assignable->shouldReceive('getKey')->andReturn(1);
    $assignable->shouldReceive('getKeyName')->andReturn('id');
    $assignable->shouldReceive('newQuery->where->update')->once();

    $result = $assignable->updateAssignTo(null, $assignee, $user);

    expect($result)->toBeInstanceOf(AssignableLog::class);
});

it('throws exception when assignee group is not set', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $assignee = Mockery::mock(User::class);

    $assignable->assignee_group = null;

    $this->expectException(FlashException::class);
    $this->expectExceptionMessage('Assignee group is not set');

    $assignable->assignTo($assignee);
});

it('assigns to group successfully', function(): void {
    $assignable = Mockery::mock(Order::class)->makePartial();
    $group = Mockery::mock(UserGroup::class)->makePartial();
    $user = Mockery::mock(User::class)->makePartial();
    $assignable->assignee = null;
    $assignable->assignee_group = null;
    $assignable->assignee_group_id = 1;
    $assignable->assignee_id = 1;
    $assignable->status_id = 1;
    $assignable->shouldReceive('assignee_group->associate')->with($group)->once();
    $assignable->shouldReceive('assignee->dissociate')->once();
    $assignable->shouldReceive('fireSystemEvent')->with('admin.assignable.beforeAssignTo', [$group, null, null, null])->once();
    $assignable->shouldReceive('save')->andReturnTrue();
    $assignable->shouldReceive('fireSystemEvent')->with('admin.assignable.assigned', Mockery::any())->once();
    $assignable->shouldReceive('getMorphClass')->andReturn('assignable');
    $assignable->shouldReceive('getKey')->andReturn(1);
    $assignable->shouldReceive('getKeyName')->andReturn('id');
    $assignable->shouldReceive('newQuery->where->update')->once();

    $result = $assignable->assignToGroup($group, $user);

    expect($result)->toBeInstanceOf(AssignableLog::class);
});

it('returns true when assigned to user', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $assignable->assignee = Mockery::mock(User::class);

    $result = $assignable->hasAssignTo();

    expect($result)->toBeTrue();
});

it('returns false when not assigned to user', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $assignable->assignee = null;

    $result = $assignable->hasAssignTo();

    expect($result)->toBeFalse();
});

it('returns true when assigned to group', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $assignable->assignee_group = Mockery::mock(UserGroup::class);

    $result = $assignable->hasAssignToGroup();

    expect($result)->toBeTrue();
});

it('returns false when not assigned to group', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $assignable->assignee_group = null;

    $result = $assignable->hasAssignToGroup();

    expect($result)->toBeFalse();
});

it('lists group assignees when group is set', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $group = Mockery::mock(UserGroup::class);
    $assignable->assignee_group = $group;

    $group->shouldReceive('listAssignees')->andReturn(['assignee1', 'assignee2']);

    $result = $assignable->listGroupAssignees();

    expect($result)->toBe(['assignee1', 'assignee2']);
});

it('returns empty list when group is not set', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $assignable->assignee_group = null;

    $result = $assignable->listGroupAssignees();

    expect($result)->toBe([]);
});

it('returns true when user cannot be assigned to staff', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $user = Mockery::mock(User::class)->makePartial();
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();
    $assignable->assignee_group_id = 1;
    $user->shouldReceive('getKey')->andReturn(1);
    $assignable->shouldReceive('assignable_logs')->andReturn($assignableLog);
    $assignableLog->shouldReceive('where')->with('user_id', 1)->andReturnSelf();
    $assignableLog->shouldReceive('where')->with('assignee_group_id', $assignable->assignee_group_id)->andReturnSelf();
    $assignableLog->shouldReceive('exists')->andReturn(true);

    $result = $assignable->cannotAssignToStaff($user);

    expect($result)->toBeTrue();
});

it('returns false when user can be assigned to staff', function(): void {
    $assignable = Mockery::mock(Assignable::class)->makePartial();
    $user = Mockery::mock(User::class)->makePartial();
    $assignable->assignee_group_id = 1;
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();

    $user->shouldReceive('getKey')->andReturn(1);
    $assignable->shouldReceive('assignable_logs')->andReturn($assignableLog);
    $assignableLog->shouldReceive('where')->with('user_id', 1)->andReturnSelf();
    $assignableLog->shouldReceive('where')->with('assignee_group_id', $assignable->assignee_group_id)->andReturnSelf();
    $assignableLog->shouldReceive('exists')->andReturn(false);

    $result = $assignable->cannotAssignToStaff($user);

    expect($result)->toBeFalse();
});

it('filters assigned to null when assignedTo is 1', function(): void {
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('whereNull')->with('assignee_id')->andReturnSelf();

    $model = Mockery::mock(Assignable::class)->makePartial();
    $result = $model->scopeFilterAssignedTo($query, 1);

    expect($result)->toBe($query);
});

it('filters assigned to current staff when assignedTo is 2', function(): void {
    $query = Mockery::mock(Builder::class);
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('getKey')->andReturn(1);
    AdminAuth::shouldReceive('staff')->andReturn($user);
    $query->shouldReceive('where')->with('assignee_id', 1)->andReturnSelf();

    $model = Mockery::mock(Assignable::class)->makePartial();
    $result = $model->scopeFilterAssignedTo($query, 2);

    expect($result)->toBe($query);
});

it('filters assigned to not current staff when assignedTo is not 1 or 2', function(): void {
    $query = Mockery::mock(Builder::class);
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('getKey')->andReturn(1);
    AdminAuth::shouldReceive('staff')->andReturn($user);
    $query->shouldReceive('where')->with('assignee_id', '!=', 1)->andReturnSelf();

    $model = Mockery::mock(Assignable::class)->makePartial();
    $result = $model->scopeFilterAssignedTo($query, 3);

    expect($result)->toBe($query);
});

it('filters where unassigned', function(): void {
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('whereNotNull')->with('assignee_group_id')->andReturnSelf();
    $query->shouldReceive('whereNull')->with('assignee_id')->andReturnSelf();

    $model = Mockery::mock(Assignable::class)->makePartial();
    $result = $model->scopeWhereUnAssigned($query);

    expect($result)->toBe($query);
});

it('filters where assigned to specific user', function(): void {
    $query = Mockery::mock(Builder::class);
    $assigneeId = 1;
    $query->shouldReceive('where')->with('assignee_id', $assigneeId)->andReturnSelf();

    $model = Mockery::mock(Assignable::class)->makePartial();
    $result = $model->scopeWhereAssignTo($query, $assigneeId);

    expect($result)->toBe($query);
});

it('filters where assigned to specific group', function(): void {
    $query = Mockery::mock(Builder::class);
    $assigneeGroupId = 1;
    $query->shouldReceive('where')->with('assignee_group_id', $assigneeGroupId)->andReturnSelf();

    $model = Mockery::mock(Assignable::class)->makePartial();
    $result = $model->scopeWhereAssignToGroup($query, $assigneeGroupId);

    expect($result)->toBe($query);
});

it('filters where assigned to specific group ids', function(): void {
    $query = Mockery::mock(Builder::class);
    $assigneeGroupIds = [1, 2, 3];
    $query->shouldReceive('whereIn')->with('assignee_group_id', $assigneeGroupIds)->andReturnSelf();

    $model = Mockery::mock(Assignable::class)->makePartial();
    $result = $model->scopeWhereInAssignToGroup($query, $assigneeGroupIds);

    expect($result)->toBe($query);
});

it('filters where has auto assign group', function(): void {
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('whereHas')->with('assignee_group', Mockery::on(function($callback): true {
        $subQuery = Mockery::mock(Builder::class);
        $subQuery->shouldReceive('where')->with('auto_assign', 1)->andReturnSelf();
        $callback($subQuery);

        return true;
    }))->andReturnSelf();

    $model = Mockery::mock(Assignable::class)->makePartial();
    $result = $model->scopeWhereHasAutoAssignGroup($query);

    expect($result)->toBe($query);
});
