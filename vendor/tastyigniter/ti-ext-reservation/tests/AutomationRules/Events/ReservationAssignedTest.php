<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\AutomationRules\Events;

use Igniter\Admin\Models\Status;
use Igniter\Reservation\AutomationRules\Events\ReservationAssigned;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Models\User;
use Mockery;

it('returns event details correctly', function(): void {
    $details = (new ReservationAssigned)->eventDetails();

    expect($details['name'])->toBe('Reservation Assigned Event')
        ->and($details['description'])->toBe('When a reservation is assigned to a staff')
        ->and($details['group'])->toBe('reservation');
});

it('makes params from event with reservation, status & assignee instance', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->shouldReceive('mailGetData')->andReturn(['customer_name' => 'John Doe']);
    $reservation->status = Mockery::mock(Status::class);
    $reservation->assignee = Mockery::mock(User::class);

    $params = ReservationAssigned::makeParamsFromEvent([$reservation]);

    expect($params['customer_name'])->toBe('John Doe')
        ->and($params['status'])->toBe($reservation->status)
        ->and($params['assignee'])->toBe($reservation->assignee);
});

it('makes params from event without reservation, status & assignee instance', function(): void {
    $params = ReservationAssigned::makeParamsFromEvent([null]);

    expect($params)->toHaveKey('status')
        ->and($params['status'])->toBeNull()
        ->and($params)->toHaveKey('assignee')
        ->and($params['assignee'])->toBeNull();
});
