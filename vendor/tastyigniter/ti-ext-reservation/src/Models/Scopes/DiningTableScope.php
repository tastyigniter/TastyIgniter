<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models\Scopes;

use Igniter\Flame\Database\Scope;
use Igniter\Reservation\Models\DiningTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class DiningTableScope extends Scope
{
    public function addReservable()
    {
        return function(Builder|DiningTable $builder, $options): Builder|DiningTable {
            $builder->whereIsReservable();

            if ($dateTime = array_get($options, 'dateTime')) {
                // @phpstan-ignore-next-line arguments.count
                $builder->whereIsAvailableOn($dateTime, array_get($options, 'duration', 15));
            }

            if ($date = array_get($options, 'date')) {
                $builder->whereIsAvailableForDate($date);
            }

            if ($locationId = array_get($options, 'locationId')) {
                $builder->whereIsAvailableAt($locationId);
            }

            if ($guestNum = array_get($options, 'guestNum')) {
                $builder->whereCanAccommodate($guestNum);
            }

            $builder
                ->orderBy('dining_sections.priority', 'desc')
                ->orderBy('dining_tables.priority', 'desc');

            $builder->getModel()->fireEvent('model.extendDiningTableReservableQuery', [$builder, $options]);

            return $builder;
        };
    }

    public function addWhereIsReservable()
    {
        return fn(Builder|DiningTable $builder) => $builder
            ->whereIsRoot()
            ->where('dining_tables.is_enabled', 1)
            ->leftJoin('dining_sections', function($join): void {
                $join->on('dining_sections.id', '=', 'dining_tables.dining_section_id')
                    ->where('dining_sections.is_enabled', 1);
            });
    }

    public function addWhereIsCombo()
    {
        return fn(Builder|DiningTable $builder) => $builder->with('dining_section')->where('is_combo', 1);
    }

    public function addWhereIsNotCombo()
    {
        return fn(Builder|DiningTable $builder) => $builder->with('dining_section')->where('is_combo', '!=', 1);
    }

    public function addWhereIsAvailableAt()
    {
        return fn(Builder|DiningTable $builder, $locationId) => $builder->join('dining_areas', function($join) use ($locationId): void {
            $join->on('dining_areas.id', '=', 'dining_tables.dining_area_id')
                ->where('dining_areas.location_id', $locationId);
        });
    }

    public function addWhereIsAvailableForDate()
    {
        return fn(Builder|DiningTable $builder, $date) => $builder->whereDoesntHave('reservations', function($builder) use ($date): void {
            $builder->where('reserve_date', $date)
                ->whereNotIn('status_id', [0, setting('canceled_reservation_status')]);
        });
    }

    public function addWhereIsAvailableOn()
    {
        return function(Builder|DiningTable $builder, $dateTime, $duration = 15) {
            if (is_string($dateTime)) {
                $dateTime = make_carbon($dateTime);
            }

            return $builder->whereDoesntHave('reservations', function($builder) use ($dateTime, $duration): void {
                $builder
                    ->where(function($builder) use ($dateTime): void {
                        $builder->whereBetweenStayTime($dateTime->clone()->addMinute());
                    })
                    ->orWhere(function($builder) use ($dateTime, $duration): void {
                        $builder->whereBetweenStayTime($dateTime->clone()->addMinutes($duration - 1));
                    })
                    ->whereNotIn('status_id', [0, setting('canceled_reservation_status')]);
            });
        };
    }

    public function addWhereCanAccommodate()
    {
        return fn(Builder|DiningTable $builder, $guestNumber) => $builder
            ->where('min_capacity', '<=', $guestNumber)
            ->where('max_capacity', '>=', $guestNumber);
    }

    public function addWhereHasReservationLocation()
    {
        return fn(Builder|DiningTable $builder, $model) => $builder->whereHasLocation($model->location_id);
    }
}
