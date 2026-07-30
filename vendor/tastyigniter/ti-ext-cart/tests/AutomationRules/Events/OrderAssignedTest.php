<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\AutomationRules\Events;

use Igniter\Admin\Models\Status;
use Igniter\Cart\AutomationRules\Events\OrderAssigned;
use Igniter\Cart\Models\Order;
use Igniter\User\Models\User;
use stdClass;

it('has a name and description', function(): void {
    $event = new OrderAssigned;
    expect($event->eventDetails())->toHaveKeys(['name', 'description']);
});

it('returns order data from event', function(): void {
    $order = Order::factory()->create([
        'order_type' => 'delivery',
        'order_total' => 10.0,
    ]);

    $order->status = Status::factory()->create();
    $order->assignee = User::factory()->create();

    $params = OrderAssigned::makeParamsFromEvent([$order]);
    expect($params)->toHaveKeys(['order', 'status', 'assignee'])
        ->and($params['order']->getKey())->toBe($order->getKey())
        ->and($params['status']->getKey())->toBe($order->status->getKey())
        ->and($params['assignee']->getKey())->toBe($order->assignee->getKey())
        ->and($params['order_total'])->toBe(10.0);
});

it('returns array with missing order', function(): void {
    $params = OrderAssigned::makeParamsFromEvent([]);

    expect($params)->toBeArray()->not->toHaveKey('order');

    $params = OrderAssigned::makeParamsFromEvent([new stdClass]);

    expect($params)->toBeArray()->not->toHaveKey('order');
});
