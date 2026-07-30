<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\AutomationRules\Events;

use Igniter\Admin\Models\Status;
use Igniter\Reservation\AutomationRules\Events\NewReservationStatus;
use Igniter\Reservation\Models\Reservation;
use Mockery;

it('returns event details correctly', function(): void {
    $details = (new NewReservationStatus)->eventDetails();

    expect($details['name'])->toBe('Reservation Status Update Event')
        ->and($details['description'])->toBe('When a reservation status is updated')
        ->and($details['group'])->toBe('reservation');
});

it('makes params from event with reservation & status instance', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->shouldReceive('mailGetData')->andReturn(['customer_name' => 'John Doe']);
    $status = Mockery::mock(Status::class);

    $params = NewReservationStatus::makeParamsFromEvent([$reservation, $status]);

    expect($params['customer_name'])->toBe('John Doe')
        ->and($params['status'])->toBe($status);
});

it('makes params from event without reservation & status instance', function(): void {
    $params = NewReservationStatus::makeParamsFromEvent([]);

    expect($params)->toHaveKey('status')
        ->and($params['status'])->toBeNull();
});
