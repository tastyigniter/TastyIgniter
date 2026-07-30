<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\AutomationRules\Events;

use Igniter\Admin\Models\Status;
use Igniter\Cart\AutomationRules\Events\OrderPlaced;
use Igniter\Cart\Models\Order;
use stdClass;

it('has a name and description', function(): void {
    $event = new OrderPlaced;
    expect($event->eventDetails())->toHaveKeys(['name', 'description']);
});

it('returns order data from event', function(): void {
    $order = Order::factory()->create([
        'order_type' => 'delivery',
        'order_total' => 10.0,
    ]);

    $order->status = Status::factory()->create();

    $params = OrderPlaced::makeParamsFromEvent([$order]);
    expect($params)->toHaveKeys(['order', 'status'])
        ->and($params['order']->getKey())->toBe($order->getKey())
        ->and($params['status']->getKey())->toBe($order->status->getKey())
        ->and($params['order_total'])->toBe(10.0);
});

it('returns empty array if order is not provided', function(): void {
    $params = OrderPlaced::makeParamsFromEvent([]);

    expect($params)->toBeArray()->not->toHaveKey('order');

    $params = OrderPlaced::makeParamsFromEvent([new stdClass]);

    expect($params)->toBeArray()->not->toHaveKey('order');
});
