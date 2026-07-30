<?php

declare(strict_types=1);

use Carbon\Carbon;
use Igniter\Automation\AutomationException;
use Igniter\Automation\Models\RuleCondition;
use Igniter\Cart\AutomationRules\Conditions\OrderAttribute;
use Igniter\Cart\Models\Order;

it('returns correct condition details', function(): void {
    $result = (new OrderAttribute)->conditionDetails();

    expect($result)->toBe([
        'name' => 'Order attribute',
        'description' => 'Order attributes',
    ]);
});

it('defines model attributes correctly', function(): void {
    $orderAttribute = new OrderAttribute;

    $attributes = $orderAttribute->defineModelAttributes();

    expect($attributes)->toHaveKeys([
        'first_name', 'last_name', 'email', 'location_id', 'status_id',
        'total_items', 'order_type', 'payment', 'hours_since', 'hours_until',
        'days_since', 'days_until',
    ]);
});

it('calculates hours since correctly', function(): void {
    $this->travelTo(Carbon::now()->setHour(8)->setMinute(0)->setSecond(0));

    $order = Order::factory()->create([
        'order_date' => Carbon::now()->toDateString(),
        'order_time' => Carbon::now()->subHours(5)->toTimeString(),
    ]);

    $orderAttribute = new OrderAttribute;

    expect($orderAttribute->getHoursSinceAttribute(null, $order))->toBe(5.0);
});

it('calculates hours until correctly', function(): void {
    $this->travelTo(Carbon::now()->setHour(8)->setMinute(0)->setSecond(0));
    $order = Order::factory()->create([
        'order_date' => Carbon::now()->toDateString(),
        'order_time' => Carbon::now()->addHours(5)->toTimeString(),
    ]);

    $orderAttribute = new OrderAttribute;

    expect($orderAttribute->getHoursUntilAttribute(null, $order))->toBe(4.0);
});

it('calculates days since correctly', function(): void {
    $this->travelTo(Carbon::now()->setHour(8)->setMinute(0)->setSecond(0));
    $order = Order::factory()->create([
        'order_date' => Carbon::now()->subDays(3)->toDateString(),
        'order_time' => Carbon::now()->toTimeString(),
    ]);

    $orderAttribute = new OrderAttribute;

    expect($orderAttribute->getDaysSinceAttribute(null, $order))->toBe(3.0);
});

it('calculates days until correctly', function(): void {
    $order = Order::factory()->create([
        'order_date' => Carbon::now()->addDays(4)->toDateString(),
        'order_time' => Carbon::now()->toTimeString(),
    ]);

    $orderAttribute = new OrderAttribute;

    expect($orderAttribute->getDaysUntilAttribute(null, $order))->toBe(3.0);
});

it('gets history status id correctly', function(): void {
    $orderAttribute = new OrderAttribute;
    $order = Mockery::mock(Order::class);
    $order->shouldReceive('status_history->pluck')->andReturn(collect([1, 2, 3]));

    expect($orderAttribute->getHistoryStatusIdAttribute(null, $order))->toBe('1,2,3');
});

it('throws exception when no order in params', function(): void {
    $orderAttribute = new OrderAttribute;

    $this->expectException(AutomationException::class);

    $params = [];
    $orderAttribute->isTrue($params);
});

it('evaluates isTrue correctly', function(): void {
    $order = Order::factory()->create([
        'first_name' => 'John',
    ]);

    $orderAttribute = new OrderAttribute(new RuleCondition([
        'options' => [
            ['attribute' => 'first_name', 'operator' => 'is', 'value' => 'John'],
        ],
    ]));

    $params = ['order' => $order];
    expect($orderAttribute->isTrue($params))->toBeTrue();
});
