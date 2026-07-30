<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models\Scopes;

use Igniter\Flame\Database\Builder;
use Igniter\Reservation\Models\Scopes\ReservationScope;
use Mockery;

beforeEach(function(): void {
    $this->scope = new ReservationScope;
    $this->builder = Mockery::mock(Builder::class);
});

it('applies date time filter with valid range', function(): void {
    $this->builder->shouldReceive('whereBetweenReservationDateTime')
        ->with('2023-10-10 12:00:00', '2023-10-10 14:00:00')
        ->once()
        ->andReturnSelf();

    $applyDateTimeFilter = $this->scope->addApplyDateTimeFilter();
    $applyDateTimeFilter($this->builder, ['startAt' => '2023-10-10 12:00:00', 'endAt' => '2023-10-10 14:00:00']);
});

it('applies date time filter with missing range', function(): void {
    $this->travelTo('2023-10-10 12:00:00');

    $this->builder->shouldReceive('whereBetweenReservationDateTime')
        ->with('2023-10-10 12:00:00', '2023-10-10 12:00:00')
        ->once()
        ->andReturnSelf();

    $applyDateTimeFilter = $this->scope->addApplyDateTimeFilter();
    $applyDateTimeFilter($this->builder, []);
});

it('applies where between reservation date time', function(): void {
    $this->builder->shouldReceive('whereRaw')
        ->with('ADDTIME(reserve_date, reserve_time) between ? and ?', ['2023-10-10 12:00:00', '2023-10-10 14:00:00'])
        ->once()
        ->andReturnSelf();

    $whereBetweenReservationDateTime = $this->scope->addWhereBetweenReservationDateTime();
    $whereBetweenReservationDateTime($this->builder, '2023-10-10 12:00:00', '2023-10-10 14:00:00');
});

it('applies where between date time', function(): void {
    $this->builder->shouldReceive('whereRaw')
        ->with('? between DATE_SUB(ADDTIME(reserve_date, reserve_time), INTERVAL 2 MINUTE) and DATE_ADD(ADDTIME(reserve_date, reserve_time), INTERVAL duration MINUTE)', ['2023-10-10 12:00:00'])
        ->once()
        ->andReturnSelf();

    $whereBetweenStayTime = $this->scope->addWhereBetweenDate();
    $whereBetweenStayTime($this->builder, '2023-10-10 12:00:00');
});

it('applies where between stay time', function(): void {
    $this->builder->shouldReceive('whereRaw')
        ->with('? between DATE_SUB(ADDTIME(reserve_date, reserve_time), INTERVAL 2 MINUTE) and DATE_ADD(ADDTIME(reserve_date, reserve_time), INTERVAL duration MINUTE)', ['2023-10-10 12:00:00'])
        ->once()
        ->andReturnSelf();

    $whereBetweenStayTime = $this->scope->addWhereBetweenStayTime();
    $whereBetweenStayTime($this->builder, '2023-10-10 12:00:00');
});

it('applies where not between stay time', function(): void {
    $this->builder->shouldReceive('whereRaw')
        ->with('? not between DATE_SUB(ADDTIME(reserve_date, reserve_time), INTERVAL (duration - 2) MINUTE) and DATE_ADD(ADDTIME(reserve_date, reserve_time), INTERVAL duration MINUTE)', ['2023-10-10 12:00:00'])
        ->once()
        ->andReturnSelf();

    $whereNotBetweenStayTime = $this->scope->addWhereNotBetweenStayTime();
    $whereNotBetweenStayTime($this->builder, '2023-10-10 12:00:00');
});

it('applies where has dining area', function(): void {
    $this->builder->shouldReceive('whereHas')
        ->with('tables', Mockery::on(function($callback): true {
            $query = Mockery::mock(Builder::class);
            $query->shouldReceive('where')
                ->with('dining_tables.dining_area_id', 1)
                ->once();
            $callback($query);

            return true;
        }))
        ->once()
        ->andReturnSelf();
    $this->builder->shouldReceive('orDoesntHave')
        ->with('tables')
        ->once()
        ->andReturnSelf();

    $whereHasDiningArea = $this->scope->addWhereHasDiningArea();
    $whereHasDiningArea($this->builder, 1);
});
