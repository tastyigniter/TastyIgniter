<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models\Scopes;

use Carbon\Carbon;
use Igniter\Flame\Database\Scope;
use Igniter\Reservation\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;

class ReservationScope extends Scope
{
    public function addApplyDateTimeFilter()
    {
        return fn(Builder|Reservation $builder, $range) => $builder->whereBetweenReservationDateTime(
            Carbon::parse(array_get($range, 'startAt'))->format('Y-m-d H:i:s'),
            Carbon::parse(array_get($range, 'endAt'))->format('Y-m-d H:i:s'),
        );
    }

    public function addWhereBetweenReservationDateTime()
    {
        return fn(Builder|Reservation $builder, $start, $end) => $builder->whereRaw('ADDTIME(reserve_date, reserve_time) between ? and ?', [$start, $end]);
    }

    public function addWhereBetweenDate()
    {
        return $this->addWhereBetweenStayTime();
    }

    public function addWhereBetweenStayTime()
    {
        return fn(Builder|Reservation $builder, $dateTime) => $builder
            ->whereRaw(
                '? between DATE_SUB(ADDTIME(reserve_date, reserve_time), INTERVAL 2 MINUTE)'.
                ' and DATE_ADD(ADDTIME(reserve_date, reserve_time), INTERVAL duration MINUTE)',
                [$dateTime],
            );
    }

    public function addWhereNotBetweenStayTime()
    {
        return fn(Builder|Reservation $builder, $dateTime) => $builder->whereRaw(
            '? not between DATE_SUB(ADDTIME(reserve_date, reserve_time), INTERVAL (duration - 2) MINUTE)'.
            ' and DATE_ADD(ADDTIME(reserve_date, reserve_time), INTERVAL duration MINUTE)',
            [$dateTime],
        );
    }

    public function addWhereHasDiningArea()
    {
        return fn(Builder|Reservation $builder, $diningAreaId) => $builder->whereHas('tables', function($q) use ($diningAreaId): void {
            $q->where('dining_tables.dining_area_id', $diningAreaId);
        })->orDoesntHave('tables');
    }
}
