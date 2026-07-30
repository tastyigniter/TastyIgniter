<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models\Concerns;

use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\Concerns\LocationAction;
use Mockery;

it('returns correct reservation interval', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.time_interval', 0)->andReturn(15);

    expect((new LocationAction($location))->getReservationInterval())->toBe(15);
});

it('returns correct reservation lead time', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.stay_time', 0)->andReturn(60);

    expect((new LocationAction($location))->getReservationLeadTime())->toBe(60);
});

it('returns correct reservation stay time', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.stay_time', 0)->andReturn(90);

    expect((new LocationAction($location))->getReservationStayTime())->toBe(90);
});

it('returns correct minimum reservation guest count', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.min_guest_count', 2)->andReturn(4);

    expect((new LocationAction($location))->getMinReservationGuestCount())->toBe(4);
});

it('returns correct maximum reservation guest count', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.max_guest_count', 20)->andReturn(10);

    expect((new LocationAction($location))->getMaxReservationGuestCount())->toBe(10);
});

it('returns correct minimum reservation advance time', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.min_advance_time', 2)->andReturn(3);

    expect((new LocationAction($location))->getMinReservationAdvanceTime())->toBe(3);
});

it('returns correct maximum reservation advance time', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.max_advance_time', 30)->andReturn(45);

    expect((new LocationAction($location))->getMaxReservationAdvanceTime())->toBe(45);
});

it('returns correct reservation cancellation timeout', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.cancellation_timeout', 0)->andReturn(10);

    expect((new LocationAction($location))->getReservationCancellationTimeout())->toBe(10);
});

it('returns true when auto allocate table is enabled', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.auto_allocate_table', 0)->andReturn(true);

    expect((new LocationAction($location))->shouldAutoAllocateTable())->toBeTrue();
});

it('returns false when auto allocate table is disabled', function(): void {
    $location = Mockery::mock(Location::class)->makePartial();
    $location->shouldReceive('getSettings')->with('booking.auto_allocate_table', 1)->andReturn(false);

    expect((new LocationAction($location))->shouldAutoAllocateTable())->toBeFalse();
});
