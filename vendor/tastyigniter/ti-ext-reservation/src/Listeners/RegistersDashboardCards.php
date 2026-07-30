<?php

declare(strict_types=1);

namespace Igniter\Reservation\Listeners;

use Igniter\Reservation\Models\Reservation;
use Igniter\System\Models\Settings;

class RegistersDashboardCards
{
    public function __invoke(): array
    {
        return [
            'reserved_table' => [
                'label' => 'lang:igniter.reservation::default.text_total_reserved_table',
                'icon' => ' text-primary fa fa-4x fa-table',
                'valueFrom' => $this->getValue(...),
            ],
            'reserved_guest' => [
                'label' => 'lang:igniter.reservation::default.text_total_reserved_guest',
                'icon' => ' text-primary fa fa-4x fa-table',
                'valueFrom' => $this->getValue(...),
            ],
            'reservation' => [
                'label' => 'lang:igniter.reservation::default.text_total_reservation',
                'icon' => ' text-success fa fa-4x fa-table',
                'valueFrom' => $this->getValue(...),
            ],
            'completed_reservation' => [
                'label' => 'lang:igniter.reservation::default.text_total_completed_reservation',
                'icon' => ' text-success fa fa-4x fa-table',
                'valueFrom' => $this->getValue(...),
            ],
        ];
    }

    public function getValue($code, $start, $end, callable $callback): int
    {
        return match ($code) {
            'reserved_table' => $this->getTotalReservedTableSum($callback),
            'reserved_guest' => $this->getTotalReservedGuestSum($callback),
            'reservation' => $this->getTotalReservationSum($callback),
            'completed_reservation' => $this->getTotalCompletedReservationSum($callback),
            default => 0,
        };
    }

    /**
     * Return the total number of reserved tables
     */
    protected function getTotalReservedTableSum(callable $callback): int
    {
        $query = Reservation::query()
            ->with('tables')
            ->where('status_id', Settings::get('confirmed_reservation_status'));

        $callback($query);

        $result = $query->get();

        $result->pluck('tables')->flatten();

        return $result->count();
    }

    /**
     * Return the total number of reserved table guests
     */
    protected function getTotalReservedGuestSum(callable $callback): int
    {
        $query = Reservation::query();
        $query->where('status_id', Settings::get('confirmed_reservation_status'));

        $callback($query);

        return (int)$query->sum('guest_num');
    }

    /**
     * Return the total number of reservations
     */
    protected function getTotalReservationSum(callable $callback): int
    {
        $query = Reservation::query();
        $query->where('status_id', '!=', Settings::get('canceled_reservation_status'));

        $callback($query);

        return $query->count();
    }

    /**
     * Return the total number of completed reservations
     */
    protected function getTotalCompletedReservationSum(callable $callback): int
    {
        $query = Reservation::query();
        $query->where('status_id', Settings::get('confirmed_reservation_status'));

        $callback($query);

        return $query->count();
    }
}
