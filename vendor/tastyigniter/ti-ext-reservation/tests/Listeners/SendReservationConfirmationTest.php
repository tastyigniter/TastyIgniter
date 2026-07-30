<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Listeners;

use Igniter\Reservation\Listeners\SendReservationConfirmation;
use Igniter\Reservation\Models\Reservation;
use Igniter\Reservation\Notifications\ReservationCreatedNotification;
use Mockery;

it('sends reservation confirmation emails to customer, location, and admin', function(): void {
    $model = Mockery::mock(Reservation::class)->makePartial();
    $model->shouldReceive('mailSend')->with('igniter.reservation::mail.reservation', 'customer')->once();
    $model->shouldReceive('mailSend')->with('igniter.reservation::mail.reservation_alert', 'location')->once();
    $model->shouldReceive('mailSend')->with('igniter.reservation::mail.reservation_alert', 'admin')->once();

    $notification = Mockery::mock(ReservationCreatedNotification::class);
    $notification->shouldReceive('make')->andReturnSelf();
    $notification->shouldReceive('subject')->with($model)->andReturnSelf();
    $notification->shouldReceive('broadcast')->once();
    app()->instance(ReservationCreatedNotification::class, $notification);

    (new SendReservationConfirmation)->handle($model);
});
