<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\AutomationRules\Events;

use Igniter\Admin\Models\Status;
use Igniter\Cart\AutomationRules\Events\NewOrderStatus;
use Igniter\Cart\Models\Order;
use stdClass;

it('has a name and description', function(): void {
    $event = new NewOrderStatus;
    expect($event->eventDetails())->toHaveKeys(['name', 'description']);
});

it('returns order data from event', function(): void {
    $order = Order::factory()->create([
        'order_type' => 'delivery',
        'order_total' => 10.0,
    ]);

    $status = Status::factory()->create();

    $params = NewOrderStatus::makeParamsFromEvent([$order, $status]);
    expect($params)->toHaveKeys(['order', 'status', 'order_id', 'order_type', 'order_total'])
        ->and($params['order']->getKey())->toBe($order->getKey())
        ->and($params['status']->getKey())->toBe($status->getKey())
        ->and($params['order_total'])->toBe(10.0);
});

it('returns array with missing order', function(): void {
    $params = NewOrderStatus::makeParamsFromEvent([]);

    expect($params)->toBeArray()->not->toHaveKey('order');

    $params = NewOrderStatus::makeParamsFromEvent([new stdClass]);

    expect($params)->toBeArray()->not->toHaveKey('order');
});
