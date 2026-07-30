<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Notifications;

use Igniter\Cart\Models\Order;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Igniter\User\Notifications\AssigneeUpdatedNotification;
use Mockery;

beforeEach(function(): void {
    $this->subject = Mockery::mock(AssignableLog::class)->makePartial();
    $this->notification = AssigneeUpdatedNotification::make()->subject($this->subject);
});

it('returns recipients when assignee is null and assignee group is set', function(): void {
    $user1 = Mockery::mock(User::class)->makePartial();
    $user2 = Mockery::mock(User::class)->makePartial();
    $assignable = Mockery::mock(Order::class)->makePartial();
    $this->subject->shouldReceive('extendableGet')->with('assignee')->andReturnNull();
    $this->subject->shouldReceive('extendableGet')->with('assignee_group')->andReturn(Mockery::mock());
    $this->subject->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);
    $assignable->shouldReceive('listGroupAssignees')->andReturn(collect([$user1, $user2]));
    $user1->shouldReceive('getKey')->andReturn(1);
    $user2->shouldReceive('getKey')->andReturn(2);
    AdminAuth::shouldReceive('user')->andReturnSelf();
    AdminAuth::shouldReceive('getKey')->andReturn(2);

    $result = $this->notification->getRecipients();

    expect($result)->toHaveCount(1);
});

it('returns recipients when assignee is set', function(): void {
    $this->subject->shouldReceive('extendableGet')->with('assignee')->andReturn(Mockery::mock());

    $result = $this->notification->getRecipients();

    expect($result)->toHaveCount(1)
        ->and($result[0])->toBe($this->subject->assignee);
});

it('returns title for order', function(): void {
    $assignable = Mockery::mock(Order::class)->makePartial();
    $this->subject->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);

    $result = $this->notification->getTitle();

    expect($result)->toBe(lang('igniter.cart::default.orders.notify_assigned_title'));
});

it('returns title for reservation', function(): void {
    $assignable = Mockery::mock(Reservation::class)->makePartial();
    $this->subject->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);

    $result = $this->notification->getTitle();

    expect($result)->toBe(lang('igniter.reservation::default.notify_assigned_title'));
});

it('returns URL for order', function(): void {
    $assignable = Mockery::mock(Order::class)->makePartial();
    $assignable->shouldReceive('getKey')->andReturn(1);
    $this->subject->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);

    $result = $this->notification->getUrl();

    expect($result)->toBe(admin_url('orders/edit/1'));
});

it('returns URL for reservation', function(): void {
    $assignable = Mockery::mock(Reservation::class)->makePartial();
    $assignable->shouldReceive('getKey')->andReturn(1);
    $this->subject->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);

    $result = $this->notification->getUrl();

    expect($result)->toBe(admin_url('reservations/edit/1'));
});

it('returns message for order', function(): void {
    $user = Mockery::mock(User::class)->makePartial();
    $assignable = Mockery::mock(Order::class)->makePartial();
    $assignable->shouldReceive('getKey')->andReturn(1);
    $user->shouldReceive('extendableGet')->with('full_name')->andReturn('John Doe');
    $this->subject->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);
    $this->subject->shouldReceive('extendableGet')->with('assignee')->andReturn(Mockery::mock());
    $this->subject->shouldReceive('extendableGet')->with('user')->andReturn($user);

    $result = $this->notification->getMessage();

    expect($result)->toBe(sprintf(
        lang('igniter.cart::default.orders.notify_assigned'),
        'John Doe',
        1,
        lang('igniter::admin.text_you'),
    ));
});

it('returns message for reservation', function(): void {
    $assignable = Mockery::mock(Reservation::class)->makePartial();
    $userGroup = Mockery::mock(UserGroup::class);
    $user = Mockery::mock(User::class)->makePartial();
    $assignable->shouldReceive('getKey')->andReturn(1);
    $userGroup->shouldReceive('extendableGet')->with('user_group_name')->andReturn('Group A');
    $this->subject->shouldReceive('extendableGet')->with('assignable')->andReturn($assignable);
    $this->subject->shouldReceive('extendableGet')->with('assignee_group')->andReturn($userGroup);
    $user->shouldReceive('extendableGet')->with('full_name')->andReturn('John Doe');
    $this->subject->shouldReceive('extendableGet')->with('user')->andReturn($user);

    $result = $this->notification->getMessage();

    expect($result)->toBe(sprintf(lang('igniter.reservation::default.notify_assigned'), 'John Doe', 1, 'Group A'));
});

it('returns icon', function(): void {
    $notification = Mockery::mock(AssigneeUpdatedNotification::class)->makePartial();

    $result = $notification->getIcon();

    expect($result)->toBe('fa-clipboard-user');
});

it('returns alias', function(): void {
    $notification = Mockery::mock(AssigneeUpdatedNotification::class)->makePartial();

    $result = $notification->getAlias();

    expect($result)->toBe('assignee-updated');
});
