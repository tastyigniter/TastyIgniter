<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Concerns;

use Igniter\Cart\Models\Concerns\LocationAction;
use Igniter\Local\Models\Location;
use Igniter\PayRegister\Models\Payment;
use Igniter\PayRegister\Payments\Cod;
use Illuminate\Support\Collection;

it('allows guest order correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'checkout',
        'data' => ['guest_order' => -1],
    ]);

    expect((new LocationAction($location))->allowGuestOrder())->toBeTrue();
});

it('lists available payments correctly', function(): void {
    Payment::factory()->create([
        'class_name' => Cod::class,
        'status' => 1,
    ]);

    $location = Location::factory()->create();
    $locationAction = new LocationAction($location);

    $payments = $locationAction->listAvailablePayments();

    expect($payments)->toBeInstanceOf(Collection::class)
        ->and($payments->first())->toBeInstanceOf(Payment::class);

    unset($location->settings);
    $location->settings()->create([
        'item' => 'checkout',
        'data' => ['payments' => ['cash']],
    ]);

    expect($locationAction->listAvailablePayments()->count())->toBe(0);
});

it('gets order time interval correctly', function(): void {
    $location = Location::factory()->create();

    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['time_interval' => 60],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->getOrderTimeInterval(Location::DELIVERY))->toBe(60);
});

it('checks if should add lead time correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['add_lead_time' => 1],
    ]);

    expect((new LocationAction($location))
        ->shouldAddLeadTime(Location::DELIVERY))->toBeTrue();
});

it('gets order lead time correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['lead_time' => 60],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->getOrderLeadTime(Location::DELIVERY))->toBe(60);
});

it('gets order time restriction correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['time_restriction' => 60],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->getOrderTimeRestriction(Location::DELIVERY))->toBe(60);
});

it('gets order cancellation timeout correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['cancellation_timeout' => 60],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->getOrderCancellationTimeout(Location::DELIVERY))->toBe(60);
});

it('gets minimum order total correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['min_order_amount' => 60],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->getMinimumOrderTotal(Location::DELIVERY))->toBe(60.0);
});

it('gets delivery minutes correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['lead_time' => 60],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->deliveryMinutes())->toBe(60);
});

it('gets collection minutes correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::COLLECTION,
        'data' => ['lead_time' => 60],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->collectionMinutes())->toBe(60);
});

it('checks if has order type correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['is_enabled' => 1],
    ]);

    expect((new LocationAction($location))->hasDelivery())->toBeTrue();
});

it('checks if has future order correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['future_days' => ['is_enabled' => 1]],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->hasFutureOrder(Location::DELIVERY))->toBeFalse();
});

it('gets future order days correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['future_orders' => ['days' => 60]],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->futureOrderDays(Location::DELIVERY))->toBe(60);
});

it('gets minimum future order days correctly', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => Location::DELIVERY,
        'data' => ['future_orders' => ['min_days' => 6]],
    ]);

    $locationAction = new LocationAction($location);

    expect($locationAction->minimumFutureOrderDays(Location::DELIVERY))->toBe(6);
});
