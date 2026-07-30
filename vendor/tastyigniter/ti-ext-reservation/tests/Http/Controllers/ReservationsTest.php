<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Controllers;

use Igniter\Admin\Models\Status;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\Reservation;

it('loads reservations page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.reservation.reservations'))
        ->assertOk();
});

it('loads reservation floor plan page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.reservation.reservations', ['slug' => 'floor_plan']))
        ->assertOk();
});

it('loads reservation calender page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.reservation.reservations', ['slug' => 'calendar']))
        ->assertOk();
});

it('generates events on reservation calender page', function(): void {
    $location = Location::factory()->create();
    $status = Status::factory()->create();
    LocationFacade::shouldReceive('current')->andReturn($location);
    LocationFacade::shouldReceive('getId')->andReturn($location->getKey());
    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([$location->getKey()]);
    $this->travelTo('2021-04-01');

    Reservation::factory()->for($location, 'location')->for($status, 'status')->count(5)->create([
        'reserve_date' => '2021-04-01',
    ]);
    Reservation::factory()->for($location, 'location')->for($status, 'status')->count(3)->create([
        'reserve_date' => '2021-04-10',
    ]);

    actingAsSuperUser()
        ->post(route('igniter.reservation.reservations', ['slug' => 'calendar']), [
            'start' => '2021-03-29T00:00:00.000Z',
            'end' => '2021-04-09T00:00:00.000Z',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'calender::onGenerateEvents',
        ])
        ->assertJsonCount(5, 'generatedEvents');
});

it('updates events on reservation calender page', function(): void {
    $this->travelTo('2021-04-01');

    $reservation = Reservation::factory()->create(['reserve_date' => '2021-04-01']);

    actingAsSuperUser()
        ->post(route('igniter.reservation.reservations', ['slug' => 'calendar']), [
            'eventId' => $reservation->getKey(),
            'start' => '2021-04-09T00:00:00.000Z',
            'end' => '2021-04-09T00:30:00.000Z',
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'calender::onUpdateEvent',
        ])
        ->assertOk();

    $reservation = Reservation::find($reservation->getKey());
    expect($reservation->duration)->toBe(30)
        ->and($reservation->reserve_date->toDateString())->toBe('2021-04-09');
});

it('loads create reservation page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.reservation.reservations', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit reservation page', function(): void {
    $reservation = Reservation::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.reservation.reservations', ['slug' => 'edit/'.$reservation->getKey()]))
        ->assertOk();
});

it('loads reservation preview page', function(): void {
    $reservation = Reservation::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.reservation.reservations', ['slug' => 'preview/'.$reservation->getKey()]))
        ->assertOk();
});

it('creates reservation', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.reservation.reservations', ['slug' => 'create']), [
            'Reservation' => [
                'location_id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'telephone' => '1234567890',
                'reserve_date' => '2021-01-01',
                'reserve_time' => '12:00',
                'guest_num' => 2,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    $this->assertDatabaseHas('reservations', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'telephone' => '1234567890',
        'reserve_date' => '2021-01-01',
        'reserve_time' => '12:00',
        'guest_num' => 2,
    ]);
});

it('updates reservation', function(): void {
    $reservation = Reservation::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.reservations', ['slug' => 'edit/'.$reservation->getKey()]), [
            'Reservation' => [
                'location_id' => 1,
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'telephone' => '1234567890',
                'reserve_date' => '2025-05-05',
                'reserve_time' => '16:00',
                'guest_num' => 2,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    $this->assertDatabaseHas('reservations', [
        'first_name' => 'Jane',
        'reserve_date' => '2025-05-05',
        'reserve_time' => '16:00',
        'guest_num' => 2,
    ]);
});

it('updates reservation status', function(): void {
    $reservation = Reservation::factory()->create();
    $status = Status::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.reservations'), [
            'recordId' => $reservation->getKey(),
            'statusId' => $status->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onUpdateStatus',
        ]);

    $this->assertDatabaseHas('reservations', [
        'reservation_id' => $reservation->getKey(),
        'status_id' => $status->getKey(),
    ]);
});

it('does not update reservation status when missing status id', function(): void {
    $reservation = Reservation::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.reservations'), [
            'recordId' => $reservation->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onUpdateStatus',
        ]);

    $this->assertDatabaseHas('reservations', [
        'reservation_id' => $reservation->getKey(),
        'status_id' => 0,
    ]);
});

it('deletes reservation from list page', function(): void {
    $reservation = Reservation::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.reservations'), ['checked' => [$reservation->getKey()]], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Reservation::find($reservation->getKey()))->toBeNull();
});

it('deletes reservation from edit page', function(): void {
    $reservation = Reservation::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.reservations', ['slug' => 'edit/'.$reservation->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Reservation::find($reservation->getKey()))->toBeNull();
});
