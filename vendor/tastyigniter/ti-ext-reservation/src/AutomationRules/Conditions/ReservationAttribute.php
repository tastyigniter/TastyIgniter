<?php

declare(strict_types=1);

namespace Igniter\Reservation\AutomationRules\Conditions;

use Igniter\Automation\AutomationException;
use Igniter\Automation\Classes\BaseModelAttributesCondition;
use Igniter\Reservation\Models\Reservation;
use Override;

class ReservationAttribute extends BaseModelAttributesCondition
{
    protected $modelClass = Reservation::class;

    protected $modelAttributes;

    #[Override]
    public function conditionDetails(): array
    {
        return [
            'name' => 'Reservation attribute',
            'description' => 'Reservation attributes',
        ];
    }

    #[Override]
    public function defineModelAttributes(): array
    {
        return [
            'first_name' => [
                'label' => 'First Name',
            ],
            'last_name' => [
                'label' => 'Last Name',
            ],
            'email' => [
                'label' => 'Email address',
            ],
            'location_id' => [
                'label' => 'Location ID',
            ],
            'status_id' => [
                'label' => 'Last reservation status ID',
            ],
            'guest_num' => [
                'label' => 'Number of guests',
            ],
            'hours_since' => [
                'label' => 'Hours since reservation time',
            ],
            'hours_until' => [
                'label' => 'Hours until reservation time',
            ],
            'days_since' => [
                'label' => 'Days since reservation time',
            ],
            'days_until' => [
                'label' => 'Days until reservation time',
            ],
            'history_status_id' => [
                'label' => 'Recent reservation status IDs (eg. 1,2,3)',
            ],
        ];
    }

    public function getHoursSinceAttribute($value, $reservation): float|int
    {
        $currentDateTime = now();

        return $currentDateTime->isAfter($reservation->reservation_datetime)
            ? floor($reservation->reservation_datetime->diffInUTCHours($currentDateTime))
            : 0;
    }

    public function getHoursUntilAttribute($value, $reservation)
    {
        $currentDateTime = now();

        return $currentDateTime->isBefore($reservation->reservation_datetime)
            ? $currentDateTime->diffInUTCHours($reservation->reservation_datetime)
            : 0;
    }

    public function getDaysSinceAttribute($value, $reservation): float|int
    {
        $currentDateTime = now();

        return $currentDateTime->isAfter($reservation->reservation_datetime)
            ? floor($reservation->reservation_datetime->diffInDays($currentDateTime))
            : 0;
    }

    public function getDaysUntilAttribute($value, $reservation): float|int
    {
        $currentDateTime = now();

        return $currentDateTime->isBefore($reservation->reservation_datetime)
            ? floor($currentDateTime->diffInDays($reservation->reservation_datetime))
            : 0;
    }

    public function getHistoryStatusIdAttribute($value, $reservation)
    {
        return $reservation->status_history()->pluck('status_id')->implode(',');
    }

    /**
     * Checks whether the condition is TRUE for specified parameters
     * @param array $params Specifies a list of parameters as an associative array.
     * @return bool
     */
    #[Override]
    public function isTrue(&$params)
    {
        if (!$reservation = array_get($params, 'reservation')) {
            throw new AutomationException('Error evaluating the reservation attribute condition: the reservation object is not found in the condition parameters.');
        }

        return $this->evalIsTrue($reservation);
    }
}
