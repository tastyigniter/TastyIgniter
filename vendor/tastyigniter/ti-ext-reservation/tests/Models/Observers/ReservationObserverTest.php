<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models\Observers;

use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\Observers\ReservationObserver;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Models\Customer;
use Mockery;

it('fills customer details when creating reservation with customer_id', function(): void {
    $customer = Mockery::mock(Customer::class)->makePartial();
    $reservation = Mockery::mock(Reservation::class)->makePartial();

    $customer->shouldReceive('extendableGet')->with('first_name')->andReturn('John');
    $customer->shouldReceive('extendableGet')->with('last_name')->andReturn('Doe');
    $customer->shouldReceive('extendableGet')->with('email')->andReturn('john.doe@example.com');
    $customer->shouldReceive('extendableGet')->with('telephone')->andReturn('1234567890');
    $reservation->shouldReceive('extendableGet')->with('customer_id')->andReturn(1);
    $reservation->shouldReceive('extendableGet')->with('customer')->andReturn($customer);
    $reservation->shouldReceive('generateHash')->andReturn('hash');
    $reservation->shouldReceive('forceFill')->with([
        'hash' => 'hash',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0',
    ])->once();

    request()->headers->set('user-agent', 'Mozilla/5.0');
    request()->headers->set('REMOTE_ADDR', '127.0.0.1');

    (new ReservationObserver)->creating($reservation);

    expect($reservation->first_name)->toBe('John')
        ->and($reservation->last_name)->toBe('Doe')
        ->and($reservation->email)->toBe('john.doe@example.com')
        ->and($reservation->telephone)->toBe('1234567890');
});

it('fills default values when creating reservation without customer_id', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->shouldReceive('extendableGet')->with('customer_id')->andReturnNull();
    $reservation->shouldReceive('generateHash')->andReturn('hash');
    $reservation->shouldReceive('forceFill')->with([
        'hash' => 'hash',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0',
    ])->once();

    request()->headers->set('user-agent', 'Mozilla/5.0');
    request()->headers->set('REMOTE_ADDR', '127.0.0.1');

    (new ReservationObserver)->creating($reservation);

    expect($reservation->first_name)->toBeNull()
        ->and($reservation->last_name)->toBeNull()
        ->and($reservation->email)->toBeNull()
        ->and($reservation->telephone)->toBeNull();
});

it('restores purged values and adds reservation tables when saved', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $location = Mockery::mock(Location::class);

    $reservation->shouldReceive('restorePurgedValues')->once();
    $reservation->shouldReceive('getAttributes')->andReturn(['tables' => ['table1', 'table2']]);
    $reservation->shouldReceive('addReservationTables')->with(['table1', 'table2'])->once();
    $reservation->shouldReceive('reloadRelations')->with('location')->once();
    $reservation->shouldReceive('tables->count')->andReturn(0);
    $reservation->shouldReceive('autoAssignTable')->once();
    $reservation->shouldReceive('extendableGet')->with('location')->andReturn($location);
    $location->shouldReceive('shouldAutoAllocateTable')->andReturn(true);

    (new ReservationObserver)->saved($reservation);
});

it('does not assign table if auto allocate is disabled', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $location = Mockery::mock(Location::class);

    $reservation->shouldReceive('restorePurgedValues')->once();
    $reservation->shouldReceive('getAttributes')->andReturn(['tables' => ['table1', 'table2']]);
    $reservation->shouldReceive('addReservationTables')->with(['table1', 'table2'])->once();
    $reservation->shouldReceive('reloadRelations')->with('location')->once();
    $reservation->shouldReceive('tables->count')->andReturn(0);
    $reservation->shouldNotReceive('autoAssignTable');
    $location->shouldReceive('shouldAutoAllocateTable')->andReturn(false);
    $reservation->shouldReceive('extendableGet')->with('location')->andReturn($location);

    (new ReservationObserver)->saved($reservation);
});
