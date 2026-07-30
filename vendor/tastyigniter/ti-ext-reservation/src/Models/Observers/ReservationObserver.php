<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models\Observers;

use Igniter\Reservation\Models\Reservation;

class ReservationObserver
{
    public function creating(Reservation $reservation): void
    {
        if ($reservation->customer_id) {
            $reservation->first_name = $reservation->first_name ?: $reservation->customer->first_name;
            $reservation->last_name = $reservation->last_name ?: $reservation->customer->last_name;
            $reservation->email = $reservation->email ?: $reservation->customer->email;
            $reservation->telephone = $reservation->telephone ?: $reservation->customer->telephone;
        }

        $reservation->forceFill([
            'hash' => $reservation->generateHash(),
            'ip_address' => request()->getClientIp(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function saved(Reservation $reservation): void
    {
        $reservation->restorePurgedValues();

        if (array_key_exists('tables', $attributes = $reservation->getAttributes())) {
            $reservation->addReservationTables((array)array_get($attributes, 'tables', []));
        }

        $reservation->reloadRelations('location');

        if ($reservation->location?->shouldAutoAllocateTable() && !$reservation->tables()->count()) {
            $reservation->autoAssignTable();
        }
    }
}
