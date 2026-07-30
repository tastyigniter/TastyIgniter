<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Listeners;

use Igniter\Cart\Listeners\ExtendDashboardCharts;
use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Order;

beforeEach(function(): void {
    $this->listener = new ExtendDashboardCharts;
    $this->startDate = now()->subMonth();
    $this->endDate = now();
    $this->travelTo(now()->subHours(2));
});

afterEach(function(): void {
    $this->travelBack();
});

it('returns correct dataset config for orders by day', function(): void {
    Order::factory()->count(3)->create(['order_date' => now()->subDays(1)]);
    Order::factory()->count(3)->create(['order_date' => now()->subDays(2)]);

    $result = $this->listener->getDatasetConfig('orders_by_day', $this->startDate, $this->endDate);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('labels')
        ->and($result)->toHaveKey('datasets')
        ->and($result['datasets'][0])->toHaveKey('backgroundColor')
        ->and($result['datasets'][0])->toHaveKey('data')
        ->and($result['datasets'][0]['data'][0])->toBe(3)
        ->and($result['datasets'][0]['data'][1])->toBe(3);
});

it('returns correct dataset config for orders by hour', function(): void {
    Order::factory()->count(2)->create([
        'order_date' => now()->format('Y-m-d'),
        'order_time' => now()->format('H:i:s'),
    ]);
    Order::factory()->count(2)->create([
        'order_date' => now()->subHours(2)->format('Y-m-d'),
        'order_time' => now()->subHours(2)->format('H:i:s'),
    ]);

    $result = $this->listener->getDatasetConfig('orders_by_hour', $this->startDate, $this->endDate);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('labels')
        ->and($result)->toHaveKey('datasets')
        ->and($result['labels'])->toHaveCount(2)
        ->and($result['datasets'][0])->toHaveKey('backgroundColor')
        ->and($result['datasets'][0])->toHaveKey('data')
        ->and($result['datasets'][0]['data'][0])->toBe(2)
        ->and($result['datasets'][0]['data'][1])->toBe(2);
});

it('returns correct dataset config for orders by category', function(): void {
    $order = Order::factory()->create([
        'order_date' => now()->format('Y-m-d'),
        'order_time' => now()->format('H:i:s'),
    ]);
    $menu = Menu::factory()->has(Category::factory()->count(3), 'categories')->create();
    $order->menus()->create([
        'menu_id' => $menu->getKey(),
        'quantity' => 2,
    ]);

    $result = $this->listener->getDatasetConfig('orders_by_category', $this->startDate, $this->endDate);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('labels')
        ->and($result)->toHaveKey('datasets')
        ->and($result['labels'])->toHaveCount(3)
        ->and($result['datasets'][0])->toHaveKey('backgroundColor')
        ->and($result['datasets'][0])->toHaveKey('data')
        ->and($result['datasets'][0]['data'][0])->toBe(1)
        ->and($result['datasets'][0]['data'][1])->toBe(1)
        ->and($result['datasets'][0]['data'][2])->toBe(1);
});

it('returns correct dataset config for orders by payment', function(): void {
    Order::factory()->count(4)->create([
        'order_date' => now()->format('Y-m-d'),
        'order_time' => now()->format('H:i:s'),
        'payment' => 'cod',
    ]);
    Order::factory()->count(4)->create([
        'order_date' => now()->format('Y-m-d'),
        'order_time' => now()->format('H:i:s'),
        'payment' => 'stripe',
    ]);
    Order::factory()->count(4)->create([
        'order_date' => now()->format('Y-m-d'),
        'order_time' => now()->format('H:i:s'),
        'payment' => 'mollie',
    ]);

    $result = $this->listener->getDatasetConfig('orders_by_payment', $this->startDate, $this->endDate);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('labels')
        ->and($result)->toHaveKey('datasets')
        ->and($result['datasets'][0])->toHaveKey('backgroundColor')
        ->and($result['datasets'][0])->toHaveKey('data')
        ->and($result['datasets'][0]['data'][0])->toBe(4)
        ->and($result['datasets'][0]['data'][1])->toBe(4)
        ->and($result['datasets'][0]['data'][2])->toBe(4);
});
