<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Models\Scopes;

use Igniter\Cart\Models\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Builder;
use Mockery;

beforeEach(function(): void {
    $this->scope = new OrderScope;
    $this->builder = Mockery::mock(Builder::class);
});

it('applies date time filter correctly', function(): void {
    $range = ['startAt' => '2023-01-01 00:00:00', 'endAt' => '2023-01-01 23:59:59'];
    $this->builder->shouldReceive('whereBetweenOrderDateTime')
        ->with('2023-01-01 00:00:00', '2023-01-01 23:59:59')
        ->andReturnSelf();

    $applyDateTimeFilter = $this->scope->addApplyDateTimeFilter();
    $applyDateTimeFilter($this->builder, $range);

    $this->builder->shouldHaveReceived('whereBetweenOrderDateTime')
        ->with('2023-01-01 00:00:00', '2023-01-01 23:59:59')
        ->once();
});

it('applies where between order date time correctly', function(): void {
    $start = '2023-01-01 00:00:00';
    $end = '2023-01-01 23:59:59';
    $this->builder->shouldReceive('whereRaw')
        ->with('ADDTIME(order_date, order_time) between ? and ?', [$start, $end])
        ->andReturnSelf();

    $applyWhereBetweenOrderDateTime = $this->scope->addWhereBetweenOrderDateTime();
    $applyWhereBetweenOrderDateTime($this->builder, $start, $end);

    $this->builder->shouldHaveReceived('whereRaw')
        ->with('ADDTIME(order_date, order_time) between ? and ?', [$start, $end])
        ->once();
});

it('applies where between date correctly', function(): void {
    $dateTime = '2023-01-01 12:00:00';
    $this->builder->shouldReceive('whereRaw')
        ->with('? between DATE_SUB(ADDTIME(order_date, order_time), INTERVAL (duration - 2) MINUTE) and DATE_ADD(ADDTIME(order_date, order_time), INTERVAL duration MINUTE)', [$dateTime])
        ->andReturnSelf();

    $applyWhereBetweenDate = $this->scope->addWhereBetweenDate();
    $applyWhereBetweenDate($this->builder, $dateTime);

    $this->builder->shouldHaveReceived('whereRaw')
        ->with('? between DATE_SUB(ADDTIME(order_date, order_time), INTERVAL (duration - 2) MINUTE) and DATE_ADD(ADDTIME(order_date, order_time), INTERVAL duration MINUTE)', [$dateTime])
        ->once();
});
