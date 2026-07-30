<?php

declare(strict_types=1);

namespace Igniter\Cart\Models\Scopes;

use Carbon\Carbon;
use Igniter\Flame\Database\Scope;
use Illuminate\Database\Eloquent\Builder;

class OrderScope extends Scope
{
    public function addApplyDateTimeFilter()
    {
        return fn(Builder $builder, $range) => $builder->whereBetweenOrderDateTime(
            Carbon::parse(array_get($range, 'startAt'))->format('Y-m-d H:i:s'),
            Carbon::parse(array_get($range, 'endAt'))->format('Y-m-d H:i:s'),
        );
    }

    public function addWhereBetweenOrderDateTime()
    {
        return fn(Builder $builder, $start, $end) => $builder->whereRaw('ADDTIME(order_date, order_time) between ? and ?', [$start, $end]);
    }

    public function addWhereBetweenDate()
    {
        return fn(Builder $builder, $dateTime) => $builder->whereRaw(
            '? between DATE_SUB(ADDTIME(order_date, order_time), INTERVAL (duration - 2) MINUTE)'.
            ' and DATE_ADD(ADDTIME(order_date, order_time), INTERVAL duration MINUTE)',
            [$dateTime],
        );
    }
}
