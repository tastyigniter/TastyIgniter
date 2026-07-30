<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\AutomationRules\Conditions;

use Carbon\Carbon;
use Igniter\Automation\AutomationException;
use Igniter\Reservation\AutomationRules\Conditions\ReservationAttribute;
use Igniter\Reservation\Models\Reservation;
use Mockery;

it('returns correct condition details', function(): void {
    $result = (new ReservationAttribute)->conditionDetails();

    expect($result)->toBe([
        'name' => 'Reservation attribute',
        'description' => 'Reservation attributes',
    ]);
});

it('defines model attributes correctly', function(): void {
    $reservationAttribute = new ReservationAttribute;

    $attributes = $reservationAttribute->defineModelAttributes();

    expect($attributes)->toHaveKeys([
        'first_name', 'last_name', 'email', 'location_id', 'status_id',
        'guest_num', 'hours_since', 'hours_until', 'days_since', 'days_until', 'history_status_id',
    ]);
});

it('returns model attribute correctly', function($carbonMethod, $carbonValue, $conditionMethod, $expected): void {
    $this->travelTo(Carbon::now()->setHour(8)->setMinute(0)->setSecond(0));

    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->shouldReceive('extendableGet')
        ->with('reservation_datetime')
        ->andReturn(now()->$carbonMethod($carbonValue));

    expect((new ReservationAttribute)->$conditionMethod(null, $reservation))->toBe($expected);
})->with([
    ['subHours', 5, 'getHoursSinceAttribute', 5.0],
    ['addHours', 5, 'getHoursSinceAttribute', 0],
    ['addHours', 5, 'getHoursUntilAttribute', 5.0],
    ['subHours', 5, 'getHoursUntilAttribute', 0],
    ['subDays', 3, 'getDaysSinceAttribute', 3.0],
    ['addDays', 3, 'getDaysSinceAttribute', 0],
    ['addDays', 3, 'getDaysUntilAttribute', 3.0],
    ['subDays', 3, 'getDaysUntilAttribute', 0],
]);

it('returns correct history status ids', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $reservation->shouldReceive('status_history->pluck')->with('status_id')->andReturn(collect([1, 2, 3]));

    expect((new ReservationAttribute)->getHistoryStatusIdAttribute(null, $reservation))->toBe('1,2,3');
});

it('throws exception if reservation object is not found in parameters', function(): void {
    $params = [];

    $this->expectException(AutomationException::class);
    $this->expectExceptionMessage('Error evaluating the reservation attribute condition: the reservation object is not found in the condition parameters.');

    (new ReservationAttribute)->isTrue($params);
});

it('evaluates condition as true if reservation attribute condition is met', function(): void {
    $reservation = Mockery::mock(Reservation::class)->makePartial();
    $condition = Mockery::mock(ReservationAttribute::class)->makePartial();
    $condition->shouldReceive('evalIsTrue')->with($reservation)->andReturn(true);
    $params = ['reservation' => $reservation];

    expect($condition->isTrue($params))->toBeTrue();
});
