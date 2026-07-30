<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Igniter\Admin\Models\Status;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Model;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Illuminate\Database\Eloquent\Prunable;
use Mockery;

it('creates log and updates assignee_updated_at', function(): void {
    $assignable = Mockery::mock(Order::class)->makePartial();
    $assignable->shouldReceive('getMorphClass')->andReturn('order');
    $assignable->shouldReceive('getKey')->andReturn(1);
    $assignable->assignee_group_id = 1;
    $assignable->assignee_id = 2;
    $assignable->status_id = 3;
    $assignable->shouldReceive('newQuery->where->update')->with(Mockery::on(fn($data): bool => isset($data['assignee_updated_at'])))->once();

    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('getKey')->andReturn(1);

    $result = AssignableLog::createLog($assignable, $user);

    expect($result)->toBeInstanceOf(AssignableLog::class)
        ->and($result->user_id)->toBe(1)
        ->and($result->status_id)->toBe(3);
});

it('creates log without user and updates assignee_updated_at', function(): void {
    $assignable = Mockery::mock(Order::class)->makePartial();
    $assignable->shouldReceive('getMorphClass')->andReturn('order');
    $assignable->shouldReceive('getKey')->andReturn(1);
    $assignable->assignee_group_id = 1;
    $assignable->assignee_id = 2;
    $assignable->status_id = 3;
    $assignable->shouldReceive('newQuery->where->update')->with(Mockery::on(fn($data): bool => isset($data['assignee_updated_at'])))->once();

    $result = AssignableLog::createLog($assignable);

    expect($result)->toBeInstanceOf(AssignableLog::class)
        ->and($result->user_id)->toBeNull()
        ->and($result->status_id)->toBe(3);
});

it('returns true when assignable type is order', function(): void {
    $log = Mockery::mock(AssignableLog::class)->makePartial();
    $log->assignable_type = Order::make()->getMorphClass();

    $result = $log->isForOrder();

    expect($result)->toBeTrue();
});

it('returns false when assignable type is not order', function(): void {
    $log = Mockery::mock(AssignableLog::class)->makePartial();
    $log->assignable_type = 'some_other_type';

    $result = $log->isForOrder();

    expect($result)->toBeFalse();
});

it('applies assignable scope with correct type and id', function(): void {
    $assignable = Mockery::mock(Model::class);
    $assignable->shouldReceive('getMorphClass')->andReturn('order');
    $assignable->shouldReceive('getKey')->andReturn(1);
    $log = new AssignableLog;
    $result = $log->applyAssignable($assignable);

    expect($result->toSql())->toContain('where `assignable_type` = ? and `assignable_id` = ?');
});

it('applies round robin scope with correct order', function(): void {
    $log = new AssignableLog;
    $result = $log->applyRoundRobinScope();

    expect($result->toSql())
        ->toContain('`assignee_id`, MAX(created_at) as assign_value')
        ->toContain('from `assignable_logs` where `status_id` in (?, ?, ?) and `assignee_id` is not null')
        ->toContain('group by `assignee_id` order by `assign_value` asc');
});

it('applies load balanced scope with correct limit', function(): void {
    $limit = '10';
    $log = new AssignableLog;
    $result = $log->applyLoadBalancedScope($limit);

    expect($result->toSql())
        ->toContain("`assignee_id`, COUNT(assignee_id)/'10' as assign_value")
        ->toContain('from `assignable_logs` where `status_id` in (?, ?, ?) and `assignee_id` is not null')
        ->toContain('group by `assignee_id` having assign_value < 1 order by `assign_value` desc');
});

it('applies scope with correct assignee id', function(): void {
    $assigneeId = 1;
    $log = new AssignableLog;
    $result = $log->whereAssignTo($assigneeId);

    expect($result->toSql())->toContain('`assignable_logs` where `assignee_id` = ?');
});

it('applies scope with correct assignee group id', function(): void {
    $assigneeGroupId = 1;
    $log = new AssignableLog;
    $result = $log->whereAssignToGroup($assigneeGroupId);

    expect($result->toSql())->toContain('from `assignable_logs` where `assignee_group_id` = ?');
});

it('applies scope with correct assignee group ids', function(): void {
    $assigneeGroupIds = [1, 2, 3];
    $log = new AssignableLog;
    $result = $log->whereInAssignToGroup($assigneeGroupIds);

    expect($result->toSql())->toContain('from `assignable_logs` where `assignee_group_id` in (?, ?, ?)');
});

it('returns prunable records older than activity log timeout', function(): void {
    $this->travelTo($date = now()->startOfDay());

    $result = (new AssignableLog)->prunable()->toRawSql();
    expect($result)->toContain("`created_at` <= '".$date->subDays(60)->toDateTimeString()."'");
});

it('configures assignable log model correctly', function(): void {
    $log = new AssignableLog;

    expect(class_uses_recursive($log))
        ->toContain(Prunable::class)
        ->and($log->getTable())->toBe('assignable_logs')
        ->and($log->getKeyName())->toBe('id')
        ->and($log->getGuarded())->toBe([])
        ->and($log->timestamps)->toBeTrue()
        ->and($log->getCasts()['assignable_id'])->toBe('integer')
        ->and($log->getCasts()['assignee_group_id'])->toBe('integer')
        ->and($log->getCasts()['assignee_id'])->toBe('integer')
        ->and($log->getCasts()['user_id'])->toBe('integer')
        ->and($log->getCasts()['status_id'])->toBe('integer')
        ->and($log->getMorphClass())->toBe('assignable_logs')
        ->and($log->relation['belongsTo']['user'])->toBe(User::class)
        ->and($log->relation['belongsTo']['assignee'])->toBe(User::class)
        ->and($log->relation['belongsTo']['assignee_group'])->toBe(UserGroup::class)
        ->and($log->relation['belongsTo']['status'])->toBe(Status::class)
        ->and($log->relation['morphTo']['assignable'])->toBe([]);
});
