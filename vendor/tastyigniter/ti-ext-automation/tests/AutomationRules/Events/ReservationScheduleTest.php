<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\AutomationRules\Events;

use Igniter\Automation\AutomationRules\Events\ReservationSchedule;
use Igniter\Reservation\Models\Reservation;
use stdClass;

it('has a name and description', function(): void {
    $event = new ReservationSchedule;
    expect($event->eventDetails())->toHaveKeys(['name', 'description']);
});

it('returns reservation data from event', function(): void {
    $reservation = Reservation::factory()->create([
        'guest_num' => 10,
    ]);

    $params = ReservationSchedule::makeParamsFromEvent([$reservation]);
    expect($params)->toHaveKeys(['reservation', 'reservation_id', 'guest_num', 'reserve_date'])
        ->and($params['reservation'])->toBeInstanceOf(Reservation::class)
        ->and($params['guest_num'])->toBe(10);
});

it('returns empty array if order is not provided', function(): void {
    $params = ReservationSchedule::makeParamsFromEvent([]);

    expect($params)->toBeArray()
        ->and($params)->toBeEmpty();
});

it('returns empty array if order is not an instance of Order', function(): void {
    $params = ReservationSchedule::makeParamsFromEvent([new stdClass]);

    expect($params)->toBeArray()
        ->and($params)->toBeEmpty();
});
