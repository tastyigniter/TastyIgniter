<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Jobs;

use Igniter\Cart\Models\Order;
use Igniter\User\Jobs\AllocateAssignable;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Mockery;
use stdClass;

it('allocates assignable successfully when assignee is available', function(): void {
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $assignee = Mockery::mock(User::class)->makePartial();
    $assignable = Mockery::mock(Order::class)->makePartial();
    $assignableLog->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);
    $assignableLog->shouldReceive('extendableGet')->with('assignee_id')->andReturn(null);
    $assignableLog->shouldReceive('extendableGet')->with('assignee_group')->andReturn($userGroup);
    $userGroup->shouldReceive('findAvailableAssignee')->andReturn($assignee);
    $assignableLog->assignable->shouldReceive('assignTo')->with($assignee)->once();

    (new AllocateAssignable($assignableLog))->handle();
});

it('does not allocate when assignee_id is already set', function(): void {
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();
    $assignableLog->shouldReceive('extendableGet')->with('assignee_id')->andReturn(1);
    $assignableLog->shouldReceive('extendableGet')->with('assignee_group')->never();

    (new AllocateAssignable($assignableLog))->handle();
});

it('does not allocate when assignable does not use Assignable trait', function(): void {
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();
    $assignableLog->shouldReceive('extendableGet')->with('assignee_id')->andReturnNull();
    $assignableLog->shouldReceive('extendableGet')->with('assignable')->andReturn(new stdClass);
    $assignableLog->shouldReceive('extendableGet')->with('assignee_group')->never();

    (new AllocateAssignable($assignableLog))->handle();
});

it('does not allocate when assignee_group is not an instance of UserGroup', function(): void {
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();
    $assignable = Mockery::mock(Order::class)->makePartial();
    $assignableLog->shouldReceive('extendableGet')->with('assignee_id')->andReturnNull();
    $assignableLog->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);
    $assignableLog->shouldReceive('extendableGet')->with('assignee_group')->andReturnNull()->once();

    (new AllocateAssignable($assignableLog))->handle();
});

it('retries allocation when no assignee is available and not last attempt', function(): void {
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();
    $assignable = Mockery::mock(Order::class)->makePartial();
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $assignableLog->shouldReceive('extendableGet')->with('assignee_id')->andReturnNull();
    $assignableLog->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);
    $assignableLog->shouldReceive('extendableGet')->with('assignee_group')->andReturn($userGroup);
    $userGroup->shouldReceive('findAvailableAssignee')->andReturn(null);

    $job = Mockery::mock(AllocateAssignable::class, [$assignableLog])->makePartial();
    $job->shouldReceive('attempts')->andReturn(1);
    $job->shouldReceive('release')->with(10)->once();

    $job->handle();
});

it('deletes job when no assignee is available and last attempt', function(): void {
    $assignableLog = Mockery::mock(AssignableLog::class)->makePartial();
    $assignable = Mockery::mock(Order::class)->makePartial();
    $userGroup = Mockery::mock(UserGroup::class)->makePartial();
    $assignableLog->shouldReceive('extendableGet')->with('assignee_id')->andReturnNull();
    $assignableLog->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);
    $assignableLog->shouldReceive('extendableGet')->with('assignee_group')->andReturn($userGroup);
    $userGroup->shouldReceive('findAvailableAssignee')->andReturn(null);

    $job = Mockery::mock(AllocateAssignable::class, [$assignableLog])->makePartial();
    $job->shouldReceive('attempts')->andReturn(3);
    $job->shouldReceive('delete')->once();

    $job->handle();
});
