<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\AutomationRules\Events;

use Igniter\Admin\Models\Status;
use Igniter\Reservation\AutomationRules\Events\NewReservation;
use Igniter\Reservation\Models\Reservation;
use Mockery;

it('returns event details correctly', function(): void {
    $details = (new NewReservation)->eventDetails();

    expect($details['name'])->toBe('New Reservation Event')
        ->and($details['description'])->toBe('When a new reservation is created')
        ->and($details['group'])->toBe('reservation');
});

it('makes params from event with reservation instance', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->shouldReceive('mailGetData')->andReturn(['customer_name' => 'John Doe']);
    $reservation->status = Mockery::mock(Status::class);

    $params = NewReservation::makeParamsFromEvent([$reservation]);

    expect($params['customer_name'])->toBe('John Doe')
        ->and($params['status'])->toBe($reservation->status);
});

it('makes params from event without reservation instance', function(): void {
    $params = NewReservation::makeParamsFromEvent([null]);

    expect($params)->toHaveKey('status')
        ->and($params['status'])->toBeNull();
});
