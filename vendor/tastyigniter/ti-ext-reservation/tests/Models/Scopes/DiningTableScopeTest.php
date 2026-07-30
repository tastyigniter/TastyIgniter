<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models\Scopes;

use Carbon\Carbon;
use Igniter\Flame\Database\Builder;
use Igniter\Reservation\Models\Reservation;
use Igniter\Reservation\Models\Scopes\DiningTableScope;
use Mockery;

beforeEach(function(): void {
    $this->scope = new DiningTableScope;
    $this->builder = Mockery::mock(Builder::class);
});

it('adds reservable scope with all options', function(): void {
    $options = [
        'dateTime' => '2023-10-10 12:00:00',
        'date' => '2023-10-10',
        'locationId' => 1,
        'guestNum' => 4,
    ];
    $this->builder->shouldReceive('whereIsReservable')->once()->andReturnSelf();
    $this->builder->shouldReceive('whereIsAvailableOn')->with('2023-10-10 12:00:00', 15)->once()->andReturnSelf();
    $this->builder->shouldReceive('whereIsAvailableForDate')->with('2023-10-10')->once()->andReturnSelf();
    $this->builder->shouldReceive('whereIsAvailableAt')->with(1)->once()->andReturnSelf();
    $this->builder->shouldReceive('whereCanAccommodate')->with(4)->once()->andReturnSelf();
    $this->builder->shouldReceive('orderBy')->with('dining_sections.priority', 'desc')->once()->andReturnSelf();
    $this->builder->shouldReceive('orderBy')->with('dining_tables.priority', 'desc')->once()->andReturnSelf();
    $this->builder->shouldReceive('getModel->fireEvent')->with('model.extendDiningTableReservableQuery', [$this->builder, $options])->once();

    $addReservable = $this->scope->addReservable();
    $addReservable($this->builder, $options);
});

it('adds where is reservable scope', function(): void {
    $this->builder->shouldReceive('whereIsRoot')->once()->andReturnSelf();
    $this->builder->shouldReceive('where')->with('dining_tables.is_enabled', 1)->once()->andReturnSelf();
    $this->builder->shouldReceive('leftJoin')->with('dining_sections', Mockery::on(function($callback): true {
        $join = Mockery::mock('alias:JoinClause');
        $join->shouldReceive('on')->with('dining_sections.id', '=', 'dining_tables.dining_section_id')->once()->andReturnSelf();
        $join->shouldReceive('where')->with('dining_sections.is_enabled', 1)->once();
        $callback($join);

        return true;
    }))->once()->andReturnSelf();

    $addWhereIsReservable = $this->scope->addWhereIsReservable();
    $addWhereIsReservable($this->builder);
});

it('adds where is combo scope', function(): void {
    $this->builder->shouldReceive('where')->with('is_combo', 1)->once()->andReturnSelf();
    $this->builder->shouldReceive('with')->andReturnSelf();

    $addWhereIsCombo = $this->scope->addWhereIsCombo();
    $addWhereIsCombo($this->builder);
});

it('adds where is not combo scope', function(): void {
    $this->builder->shouldReceive('where')->with('is_combo', '!=', 1)->once()->andReturnSelf();
    $this->builder->shouldReceive('with')->andReturnSelf();

    $addWhereIsNotCombo = $this->scope->addWhereIsNotCombo();
    $addWhereIsNotCombo($this->builder);
});

it('adds where is available at scope', function(): void {
    $this->builder->shouldReceive('join')->with('dining_areas', Mockery::on(function($callback): true {
        $join = Mockery::mock('alias:JoinClause');
        $join->shouldReceive('on')->with('dining_areas.id', '=', 'dining_tables.dining_area_id')->once()->andReturnSelf();
        $join->shouldReceive('where')->with('dining_areas.location_id', 1)->once();
        $callback($join);

        return true;
    }))->once()->andReturnSelf();

    $addWhereIsAvailableAt = $this->scope->addWhereIsAvailableAt();
    $addWhereIsAvailableAt($this->builder, 1);
});

it('adds where is available for date scope', function(): void {
    $this->builder->shouldReceive('whereDoesntHave')->with('reservations', Mockery::on(function($callback): true {
        $subBuilder = Mockery::mock(Builder::class);
        $subBuilder->shouldReceive('where')->with('reserve_date', '2023-10-10')->once()->andReturnSelf();
        $subBuilder->shouldReceive('whereNotIn')->with('status_id', [0, setting('canceled_reservation_status')])->once();
        $callback($subBuilder);

        return true;
    }))->once()->andReturnSelf();

    $addWhereIsAvailableForDate = $this->scope->addWhereIsAvailableForDate();
    $addWhereIsAvailableForDate($this->builder, '2023-10-10');
});

it('adds where is available on scope', function(): void {
    $duration = 15;
    $dateTime = Carbon::parse('2023-10-10 12:30:00')->toDateTimeString();
    $this->builder->shouldReceive('whereDoesntHave')->with('reservations', Mockery::on(function($callback) use ($dateTime): true {
        $subBuilder = Mockery::mock(Builder::class);
        $subBuilder->shouldReceive('where')->with(Mockery::on(function($callback) use ($dateTime): true {
            $subBuilder = Mockery::mock(Builder::class);
            $subBuilder->shouldReceive('whereBetweenStayTime')->with(Mockery::on(fn($dateTime) => $dateTime->eq('2023-10-10 12:31:00')))->once()->andReturnSelf();
            $callback($subBuilder);

            return true;
        }))->andReturnSelf();
        $subBuilder->shouldReceive('orWhere')->with(Mockery::on(function($callback) use ($dateTime): true {
            $subBuilder = Mockery::mock(Builder::class);
            $subBuilder->shouldReceive('whereBetweenStayTime')->with(Mockery::on(fn($dateTime) => $dateTime->eq('2023-10-10 12:44:00')))->andReturnSelf();
            $callback($subBuilder);

            return true;
        }))->andReturnSelf();
        $subBuilder->shouldReceive('whereNotIn')->with('status_id', [0, setting('canceled_reservation_status')])->once();
        $callback($subBuilder);

        return true;
    }))->once()->andReturnSelf();

    $addWhereIsAvailableOn = $this->scope->addWhereIsAvailableOn();
    $addWhereIsAvailableOn($this->builder, $dateTime, $duration);
});

it('adds where can accommodate scope', function(): void {
    $this->builder->shouldReceive('where')->with('min_capacity', '<=', 4)->once()->andReturnSelf();
    $this->builder->shouldReceive('where')->with('max_capacity', '>=', 4)->once()->andReturnSelf();

    $addWhereCanAccommodate = $this->scope->addWhereCanAccommodate();
    $addWhereCanAccommodate($this->builder, 4);
});

it('adds where has reservation location scope', function(): void {
    $reservation = Mockery::mock(Reservation::class);
    $reservation->shouldReceive('extendableGet')->with('location_id')->andReturn(1);
    $this->builder->shouldReceive('whereHasLocation')->with(1)->once()->andReturnSelf();

    $addWhereHasReservationLocation = $this->scope->addWhereHasReservationLocation();
    $addWhereHasReservationLocation($this->builder, $reservation);
});
