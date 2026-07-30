<?php

declare(strict_types=1);

namespace Igniter\Reservation\Events;

use Igniter\Flame\Traits\EventDispatchable;
use Igniter\Reservation\Models\Reservation;

class ReservationCanceledEvent
{
    use EventDispatchable;

    public function __construct(public Reservation $reservation) {}

    public static function eventName(): string
    {
        return 'admin.reservation.canceled';
    }
}
