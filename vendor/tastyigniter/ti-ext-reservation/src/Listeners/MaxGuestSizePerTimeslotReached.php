<?php

declare(strict_types=1);

namespace Igniter\Reservation\Listeners;

use Carbon\Carbon;
use DateTimeInterface;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\Reservation;

class MaxGuestSizePerTimeslotReached
{
    protected static $reservationsCache = [];

    public function handle(DateTimeInterface $timeslot, int|string $guestNum): ?bool
    {
        /** @var Location $locationModel */
        $locationModel = LocationFacade::current();
        if (!(bool)$locationModel->getSettings('booking.limit_guests')) {
            return null;
        }

        if (($limitCount = (int)$locationModel->getSettings('booking.limit_guests_count', 20)) === 0) {
            return null;
        }

        $totalGuestNumOnThisDay = $this->getGuestNum($timeslot);
        if (!$totalGuestNumOnThisDay) {
            return null;
        }

        return ($totalGuestNumOnThisDay + $guestNum) > $limitCount || $totalGuestNumOnThisDay >= $limitCount;
    }

    protected function getGuestNum(DateTimeInterface $timeslot)
    {
        $dateTime = Carbon::parse($timeslot)->toDateTimeString();

        if (array_has(self::$reservationsCache, $dateTime)) {
            return self::$reservationsCache[$dateTime];
        }

        $startTime = Carbon::parse($timeslot)->subMinutes(2);
        $endTime = Carbon::parse($timeslot)->addMinutes(2);

        $guestNum = Reservation::query()
            ->where('location_id', LocationFacade::getId())
            ->where('status_id', '!=', setting('canceled_reservation_status'))
            ->whereBetweenReservationDateTime($startTime->toDateTimeString(), $endTime->toDateTimeString())
            ->sum('guest_num');

        return self::$reservationsCache[$dateTime] = (int)$guestNum;
    }

    public function clearInternalCache(): void
    {
        self::$reservationsCache = [];
    }
}
