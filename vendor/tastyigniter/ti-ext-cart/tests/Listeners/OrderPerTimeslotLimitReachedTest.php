<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Listeners;

use DateTime;
use DateTimeImmutable;
use Igniter\Cart\CartItem;
use Igniter\Cart\Listeners\OrderPerTimeslotLimitReached;
use Igniter\Cart\Models\Category;
use Igniter\Cart\Models\Menu;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\ApplicationException;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function(): void {
    OrderPerTimeslotLimitReached::clearInternalCache();
});

it('bails when working schedule type is opening', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->setType(Location::OPENING);

    $listener = new OrderPerTimeslotLimitReached;
    $timeslot = new DateTime('2023-01-01 12:00:00');

    $result = $listener->validateTimeslot($workingSchedule, $timeslot);

    expect($result)->toBeNull();
});

it('skips when no current location', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->setType(Location::DELIVERY);

    $listener = new OrderPerTimeslotLimitReached;
    $timeslot = new DateTime('2023-01-01 12:00:00');

    $result = $listener->validateTimeslot($workingSchedule, $timeslot);

    expect($result)->toBeNull();
});

it('skips when no limits per period', function(): void {
    $location = Location::factory()->create();
    LocationFacade::setCurrent($location);

    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->setType(Location::DELIVERY);

    $listener = new OrderPerTimeslotLimitReached;
    $timeslot = new DateTime('2023-01-01 12:00:00');

    $result = $listener->validateTimeslot($workingSchedule, $timeslot);

    expect($result)->toBeNull();
});

it('exceeds timeslot order limits', function(): void {
    $location = Location::factory()->create();
    LocationFacade::setCurrent($location);
    $location->settings()->create([
        'item' => 'checkout',
        'data' => ['limit_orders' => 1, 'limit_orders_count' => 3],
    ]);

    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->setType(Location::DELIVERY);

    $listener = new OrderPerTimeslotLimitReached;
    $timeslot = new DateTime('2023-01-01 12:00:00');

    $result = $listener->validateTimeslot($workingSchedule, $timeslot);

    expect($result)->toBeNull();
});

it('throws exception when exceeds timeslot order limits ', function(): void {
    $this->travelTo('2023-01-01 12:00:00');
    $location = Location::factory()->create();
    LocationFacade::setCurrent($location);
    LocationFacade::updateScheduleTimeSlot('2023-01-01 12:00:00');
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['time_interval' => '15'],
    ]);
    $location->settings()->create([
        'item' => 'checkout',
        'data' => ['limit_orders' => '1', 'limit_orders_count' => '1'],
    ]);
    $orders = Order::factory()
        ->count(3)
        ->state(new Sequence(
            ['order_time' => '12:00:00'],
            ['order_time' => '12:15:00'],
            ['order_time' => '12:30:00'],
        ))
        ->create([
            'location_id' => $location->getKey(),
            'status_id' => setting('default_order_status'),
            'order_date' => '2023-01-01',
            'order_type' => Location::DELIVERY,
        ]);

    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->setType(Location::DELIVERY);

    $listener = new OrderPerTimeslotLimitReached;

    expect(fn() => $listener->enforceMaxOrderLimits($orders->last(), []))
        ->toThrow(new ApplicationException(lang('igniter.cart::default.checkout.alert_maximum_order_reached')));
});

it('exceeds period order limits for order type', function(string $orderType): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => $orderType,
        'data' => ['time_interval' => '90'],
    ]);
    $location->settings()->create([
        'item' => 'checkout',
        'data' => [
            'limit_orders' => 2,
            'limit_orders_period' => [
                [
                    'day_of_week' => ['0', '1'],
                    'start_time' => '12:00',
                    'end_time' => '13:00',
                    'max_type' => 'order',
                    'max_count' => '3',
                    'order_type' => [Location::DELIVERY, Location::COLLECTION],
                    'status' => '1',
                ],
            ]],
    ]);
    LocationFacade::setCurrent($location);
    Order::factory()->count(3)
        ->state(new Sequence(
            ['order_time' => '12:00:00'],
            ['order_time' => '12:30:00'],
            ['order_time' => '13:00:00'],
        ))->create([
            'location_id' => $location->getKey(),
            'status_id' => setting('default_order_status'),
            'order_date' => '2023-01-01',
            'order_type' => $orderType,
        ]);

    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->setType($orderType);

    $timeslot = new DateTime('2023-01-01 12:00:00');
    $result = (new OrderPerTimeslotLimitReached)->validateTimeslot($workingSchedule, $timeslot);

    expect($result)->toBeFalse();
})->with([
    Location::DELIVERY,
    Location::COLLECTION,
]);

it('exceeds period order limits for category type', function(): void {
    $location = Location::factory()->create();
    LocationFacade::setCurrent($location);
    $menu = Menu::factory()->has(Category::factory(), 'categories')->create();
    $orders = Order::factory()
        ->count(3)
        ->state(new Sequence(
            ['order_time' => '12:00:00'],
            ['order_time' => '12:30:00'],
            ['order_time' => '13:00:00'],
        ))
        ->create([
            'location_id' => $location->getKey(),
            'status_id' => setting('default_order_status'),
            'order_date' => '2023-01-01',
            'order_type' => Location::DELIVERY,
        ]);
    $cartItem = new CartItem($menu->getKey(), $menu->menu_name, $menu->menu_price, []);
    $cartItem->setQuantity(1);
    $orders->each(fn($order) => $order->addOrderMenus([$cartItem]));
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['time_interval' => '90'],
    ]);
    $location->settings()->create([
        'item' => 'checkout',
        'data' => [
            'limit_orders' => 2,
            'limit_orders_period' => [
                [
                    'day_of_week' => ['0', '1'],
                    'start_time' => '12:00',
                    'end_time' => '13:00',
                    'max_type' => 'category',
                    'max_count' => '3',
                    'order_type' => [Location::DELIVERY, Location::COLLECTION],
                    'categories' => $menu->categories->pluck('category_id')->toArray(),
                    'status' => '1',
                ],
            ],
        ],
    ]);

    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->setType(Location::DELIVERY);

    $timeslot = new DateTimeImmutable('2023-01-01 12:00:00');
    $listener = new OrderPerTimeslotLimitReached;
    $result = $listener->validateTimeslot($workingSchedule, $timeslot);

    expect($result)->toBeFalse();
});

it('does not exceed max period order limits when no matching limit is found', function(): void {
    $location = Location::factory()->create();
    LocationFacade::setCurrent($location);
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['time_interval' => '15'],
    ]);
    $location->settings()->create([
        'item' => 'checkout',
        'data' => [
            'limit_orders' => 2,
            'limit_orders_period' => [
                [
                    'day_of_week' => ['0', '1'],
                    'start_time' => '12:00',
                    'end_time' => '13:00',
                    'max_type' => 'order',
                    'max_count' => '3',
                    'order_type' => [Location::COLLECTION],
                    'status' => '1',
                ],
                [
                    'day_of_week' => [],
                    'start_time' => '12:00',
                    'end_time' => '13:00',
                    'max_type' => 'order',
                    'max_count' => '3',
                    'order_type' => [Location::DELIVERY],
                    'status' => '1',
                ],
            ],
        ],
    ]);

    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->setType(Location::DELIVERY);

    $listener = new OrderPerTimeslotLimitReached;
    $timeslot = new DateTime('2023-01-01 12:00:00');

    $result = $listener->validateTimeslot($workingSchedule, $timeslot);

    expect($result)->toBeNull();
});
