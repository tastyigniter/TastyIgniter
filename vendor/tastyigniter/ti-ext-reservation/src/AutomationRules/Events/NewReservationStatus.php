<?php

declare(strict_types=1);

namespace Igniter\Reservation\AutomationRules\Events;

use Igniter\Automation\Classes\BaseEvent;
use Igniter\Reservation\Models\Reservation;
use Override;

class NewReservationStatus extends BaseEvent
{
    #[Override]
    public function eventDetails(): array
    {
        return [
            'name' => 'Reservation Status Update Event',
            'description' => 'When a reservation status is updated',
            'group' => 'reservation',
        ];
    }

    #[Override]
    public static function makeParamsFromEvent(array $args, $eventName = null)
    {
        $params = [];
        $reservation = array_get($args, 0);
        $status = array_get($args, 1);
        if ($reservation instanceof Reservation) {
            $params = $reservation->mailGetData();
        }

        $params['status'] = $status;

        return $params;
    }
}
