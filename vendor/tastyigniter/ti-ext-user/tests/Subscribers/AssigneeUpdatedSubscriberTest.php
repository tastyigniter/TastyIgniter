<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Subscribers;

use Igniter\Cart\Models\Order;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Subscribers\AssigneeUpdatedSubscriber;
use Illuminate\Contracts\Events\Dispatcher;
use Mockery;

it('subscribes to the correct events', function(): void {
    $subscriber = new AssigneeUpdatedSubscriber;
    $events = Mockery::mock(Dispatcher::class);

    $result = $subscriber->subscribe($events);

    expect($result)->toBe(['admin.assignable.assigned' => 'handleAssigned']);
});

it('handles assigned event', function(): void {
    $order = Mockery::mock(Order::class)->makePartial();
    $log = Mockery::mock(AssignableLog::class)->makePartial();

    $subscriber = new AssigneeUpdatedSubscriber;
    expect($subscriber->handleAssigned($order, $log))->toBeNull();
});
