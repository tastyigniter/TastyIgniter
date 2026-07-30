<?php

declare(strict_types=1);

namespace Igniter\Reservation\AutomationRules\Events;

use Igniter\Automation\Classes\BaseEvent;
use Igniter\Reservation\Models\Reservation;
use Override;

class ReservationAssigned extends BaseEvent
{
    #[Override]
    public function eventDetails(): array
    {
        return [
            'name' => 'Reservation Assigned Event',
            'description' => 'When a reservation is assigned to a staff',
            'group' => 'reservation',
        ];
    }

    #[Override]
    public static function makeParamsFromEvent(array $args, $eventName = null)
    {
        $params = [];
        $reservation = array_get($args, 0);
        if ($reservation instanceof Reservation) {
            $params = $reservation->mailGetData();
        }

        $params['status'] = $reservation?->status;
        $params['assignee'] = $reservation?->assignee;

        return $params;
    }
}
