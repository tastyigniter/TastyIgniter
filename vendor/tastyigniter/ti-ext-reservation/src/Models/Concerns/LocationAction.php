<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models\Concerns;

use Igniter\Local\Models\Location;
use Igniter\System\Actions\ModelAction;

/**
 * LocationAction Trait
 *
 * @property Location $model
 */
class LocationAction extends ModelAction
{
    public function getReservationInterval(): int
    {
        return (int)$this->model->getSettings('booking.time_interval', 0);
    }

    public function getReservationLeadTime(): int
    {
        return $this->getReservationStayTime();
    }

    public function getReservationStayTime(): int
    {
        return (int)$this->model->getSettings('booking.stay_time', 0);
    }

    public function getMinReservationGuestCount(): int
    {
        return (int)$this->model->getSettings('booking.min_guest_count', 2);
    }

    public function getMaxReservationGuestCount(): int
    {
        return (int)$this->model->getSettings('booking.max_guest_count', 20);
    }

    public function getMinReservationAdvanceTime(): int
    {
        return (int)$this->model->getSettings('booking.min_advance_time', 2);
    }

    public function getMaxReservationAdvanceTime(): int
    {
        return (int)$this->model->getSettings('booking.max_advance_time', 30);
    }

    public function getReservationCancellationTimeout(): int
    {
        return (int)$this->model->getSettings('booking.cancellation_timeout', 0);
    }

    public function shouldAutoAllocateTable(): bool
    {
        return (bool)$this->model->getSettings('booking.auto_allocate_table', 1);
    }
}
