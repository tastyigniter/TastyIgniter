<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\AutomationRules\Conditions;

use Igniter\Admin\Models\Status;
use Igniter\Automation\AutomationException;
use Igniter\Reservation\AutomationRules\Conditions\ReservationStatusAttribute;
use Mockery;

it('returns correct condition details', function(): void {
    $result = (new ReservationStatusAttribute)->conditionDetails();

    expect($result)->toBe([
        'name' => 'Reservation status attribute',
        'description' => 'Reservation status attributes',
    ]);
});

it('defines model attributes correctly', function(): void {
    $reservationStatusAttribute = new ReservationStatusAttribute;

    $attributes = $reservationStatusAttribute->defineModelAttributes();

    expect($attributes)->toHaveKeys(['status_id', 'status_name', 'notify_customer']);
});

it('returns true if status attribute condition is met', function(): void {
    $status = Mockery::mock(Status::class);
    $condition = Mockery::mock(ReservationStatusAttribute::class)->makePartial();
    $condition->shouldReceive('evalIsTrue')->with($status)->andReturn(true);
    $params = ['status' => $status];

    $result = $condition->isTrue($params);
    expect($result)->toBeTrue();
});

it('throws exception if status object is not found in parameters', function(): void {
    $params = [];

    $this->expectException(AutomationException::class);
    $this->expectExceptionMessage('Error evaluating the status attribute condition: the status object is not found in the condition parameters.');

    (new ReservationStatusAttribute)->isTrue($params);
});

it('returns false if status attribute condition is not met', function(): void {
    $status = Mockery::mock(Status::class);
    $condition = Mockery::mock(ReservationStatusAttribute::class)->makePartial();
    $condition->shouldReceive('evalIsTrue')->with($status)->andReturn(false);
    $params = ['status' => $status];

    expect((new ReservationStatusAttribute)->isTrue($params))->toBeFalse();
});
