<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Listeners;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\DashboardWidgets\Statistics;
use Igniter\Cart\Listeners\ExtendDashboardCards;
use Igniter\Cart\Models\Order;

beforeEach(function(): void {
    $this->listener = new ExtendDashboardCards;
    $this->startDate = now()->subMonth();
    $this->endDate = now();
    $this->callback = function($query): void {};
    $this->travelTo(now()->subHours(2));
});

afterEach(function(): void {
    $this->travelBack();
});

it('registers dashboard cards', function(): void {
    $this->listener->registerCards();
    $controller = $this->createMock(AdminController::class);
    $statistics = new Statistics($controller, ['card' => 'sale']);
    $properties = $statistics->defineProperties();
    $cards = array_get($properties, 'card.options', []);

    expect($cards)->toHaveKey('sale', 'lang:igniter.cart::default.dashboard.text_total_sale')
        ->and($cards)->toHaveKey('lost_sale', 'lang:igniter.cart::default.dashboard.text_total_lost_sale')
        ->and($cards)->toHaveKey('cash_payment', 'lang:igniter.cart::default.dashboard.text_total_cash_payment')
        ->and($cards)->toHaveKey('order', 'lang:igniter.cart::default.dashboard.text_total_order')
        ->and($cards)->toHaveKey('order_menu_items_count', 'lang:igniter.cart::default.dashboard.text_order_menu_items_count')
        ->and($cards)->toHaveKey('delivery_order', 'lang:igniter.cart::default.dashboard.text_total_delivery_order')
        ->and($cards)->toHaveKey('delivery_order_count', 'lang:igniter.cart::default.dashboard.text_delivery_order_count')
        ->and($cards)->toHaveKey('collection_order', 'lang:igniter.cart::default.dashboard.text_total_collection_order')
        ->and($cards)->toHaveKey('collection_order_count', 'lang:igniter.cart::default.dashboard.text_collection_order_count')
        ->and($cards)->toHaveKey('completed_order', 'lang:igniter.cart::default.dashboard.text_total_completed_order')
        ->and($cards)->toHaveKey('completed_order_count', 'lang:igniter.cart::default.dashboard.text_completed_order_count')
        ->and($cards)->toHaveKey('canceled_order_total', 'lang:igniter.cart::default.dashboard.text_canceled_order_total')
        ->and($cards)->toHaveKey('canceled_order_count', 'lang:igniter.cart::default.dashboard.text_canceled_order_count');
});

it('calculates total sale amount correctly', function(): void {
    setting()->set(['canceled_order_status' => 2]);
    Order::factory()->create(['order_total' => 100, 'status_id' => 1]);
    Order::factory()->create(['order_total' => 100, 'status_id' => 2]);

    $result = $this->listener->getValue('sale', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(currency_format(100));
});

it('calculates total lost sale amount correctly', function(): void {
    setting()->set(['canceled_order_status' => 2]);
    Order::factory()->create(['order_total' => 50, 'status_id' => 2]);
    Order::factory()->create(['order_total' => 150, 'status_id' => 1]);

    $result = $this->listener->getValue('lost_sale', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(currency_format(50));
});

it('calculates total cash payment amount correctly', function(): void {
    setting()->set(['canceled_order_status' => 2]);
    Order::factory()->create(['order_total' => 75, 'status_id' => 1, 'payment' => 'cod']);
    Order::factory()->create(['order_total' => 150, 'status_id' => 1, 'payment' => 'stripe']);

    $result = $this->listener->getValue('cash_payment', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(currency_format(75));
});

it('calculates number of orders correctly', function(): void {
    setting()->set(['canceled_order_status' => 2]);
    Order::factory()->create(['order_total' => 10, 'status_id' => 1, 'payment' => 'cod']);
    Order::factory()->create(['order_total' => 150, 'status_id' => 2, 'payment' => 'stripe']);

    $result = $this->listener->getValue('order', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(2);
});

it('calculates number of order menu items correctly', function(): void {
    setting()->set(['canceled_order_status' => 5]);
    $order1 = Order::factory()->create(['order_total' => 10, 'status_id' => 1, 'payment' => 'cod']);
    $order2 = Order::factory()->create(['order_total' => 150, 'status_id' => 2, 'payment' => 'stripe']);
    $order1->menus()->create(['menu_id' => 1, 'quantity' => 2]);
    $order2->menus()->create(['menu_id' => 2, 'quantity' => 3]);

    $result = $this->listener->getValue('order_menu_items_count', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(5);
});

it('calculates total amount of completed orders correctly', function(): void {
    setting()->set(['completed_order_status' => [5]]);
    Order::factory()->count(5)->create(['order_total' => 5, 'status_id' => 5, 'payment' => 'cod']);
    Order::factory()->create(['order_total' => 10, 'status_id' => 2, 'payment' => 'stripe']);

    $result = $this->listener->getValue('completed_order', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(currency_format(5 * 5));
});

it('calculates number of completed orders correctly', function(): void {
    setting()->set(['completed_order_status' => [5]]);
    Order::factory()->count(5)->create(['order_total' => 5, 'status_id' => 5, 'payment' => 'cod']);
    Order::factory()->create(['order_total' => 10, 'status_id' => 2, 'payment' => 'stripe']);

    $result = $this->listener->getValue('completed_order_count', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(5);
});

it('calculates total delivery order amount correctly', function(): void {
    setting()->set(['completed_order_status' => [5]]);
    Order::factory()->create(['order_total' => 200, 'status_id' => 5, 'order_type' => 'delivery']);
    Order::factory()->create(['order_total' => 100, 'status_id' => 2, 'order_type' => 'collection']);

    $result = $this->listener->getValue('delivery_order', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(currency_format(200));
});

it('calculates number of delivery orders correctly', function(): void {
    setting()->set(['completed_order_status' => [5]]);
    Order::factory()->count(5)->create(['order_total' => 50, 'status_id' => 5, 'order_type' => 'delivery']);
    Order::factory()->create(['order_total' => 100, 'status_id' => 2, 'order_type' => 'collection']);

    $result = $this->listener->getValue('delivery_order_count', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(5);
});

it('calculates total collection order amount correctly', function(): void {
    setting()->set(['completed_order_status' => [5]]);
    Order::factory()->create(['order_total' => 100, 'status_id' => 2, 'order_type' => 'delivery']);
    Order::factory()->create(['order_total' => 150, 'status_id' => 5, 'order_type' => 'collection']);

    $result = $this->listener->getValue('collection_order', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(currency_format(150));
});

it('calculates number of collection orders correctly', function(): void {
    setting()->set(['completed_order_status' => [5]]);
    Order::factory()->create(['order_total' => 100, 'status_id' => 2, 'order_type' => 'delivery']);
    Order::factory()->count(5)->create(['order_total' => 150, 'status_id' => 5, 'order_type' => 'collection']);

    $result = $this->listener->getValue('collection_order_count', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(5);
});

it('calculates total cancelled order amount correctly', function(): void {
    setting()->set(['canceled_order_status' => [5]]);
    Order::factory()->create(['order_total' => 100, 'status_id' => 2, 'order_type' => 'delivery']);
    Order::factory()->count(5)->create(['order_total' => 150, 'status_id' => 5, 'order_type' => 'collection']);

    $result = $this->listener->getValue('canceled_order_total', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(currency_format(150 * 5));
});

it('calculates number of cancelled orders correctly', function(): void {
    setting()->set(['canceled_order_status' => [5]]);
    Order::factory()->create(['order_total' => 100, 'status_id' => 2, 'order_type' => 'delivery']);
    Order::factory()->count(5)->create(['order_total' => 150, 'status_id' => 5, 'order_type' => 'collection']);

    $result = $this->listener->getValue('canceled_order_count', $this->startDate, $this->endDate, $this->callback);

    expect($result)->toBe(5);
});
