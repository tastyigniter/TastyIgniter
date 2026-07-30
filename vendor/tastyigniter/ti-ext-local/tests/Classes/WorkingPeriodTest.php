<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use DateInterval;
use DateTime;
use Igniter\Local\Classes\WorkingPeriod;
use Igniter\Local\Classes\WorkingRange;
use Igniter\Local\Classes\WorkingTime;
use Igniter\Local\Exceptions\WorkingHourException;

it('creates correctly', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->count())->toBe(2);
});

it('throws an exception when time overlaps', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['11:00', '17:00'],
    ];

    WorkingPeriod::create($times);
})->throws(WorkingHourException::class);

it('checks if open at a specific time', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->isOpenAt(new WorkingTime(10, 00)))->toBeTrue()
        ->and($workingPeriod->isOpenAt(new WorkingTime(12, 30)))->toBeFalse();
});

it('gets open time at a specific time', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->openTimeAt(new WorkingTime(10, 00))->format())->toBe('08:00')
        ->and($workingPeriod->openTimeAt(new WorkingTime(14, 00))->format())->toBe('13:00')
        ->and($workingPeriod->openTimeAt(new WorkingTime(06, 00))->format())->toBe('08:00');
});

it('gets close time at a specific time', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->closeTimeAt(new WorkingTime(10, 00))->format())->toBe('12:00')
        ->and($workingPeriod->closeTimeAt(new WorkingTime(14, 00))->format())->toBe('17:00')
        ->and($workingPeriod->closeTimeAt(new WorkingTime(18, 00))->format())->toBe('17:00');
});

it('gets next open time when time is within a range', function(): void {
    $times = [
        ['08:00', '12:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->nextOpenAt(new WorkingTime(10, 00))->format())->toBe('08:00');
});

it('gets next open time when time is within a range and has multiple ranges', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
        ['18:00', '22:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->nextOpenAt(new WorkingTime(10, 00))->format())->toBe('13:00')
        ->and($workingPeriod->nextOpenAt(new WorkingTime(15, 00))->format())->toBe('18:00');
});

it('gets next open time when time is not within a range but in free time', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->nextOpenAt(new WorkingTime(6, 00))->format())->toBe('08:00');
});

it('returns false when no next open time is found', function(): void {
    $times = [
        ['13:00', '17:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->nextOpenAt(new WorkingTime(18, 00)))->toBeFalse();
});

it('gets next close time at a specific time', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->nextCloseAt(new WorkingTime(10, 00))->format())->toBe('12:00')
        ->and($workingPeriod->nextCloseAt(new WorkingTime(14, 00))->format())->toBe('17:00');
});

it('checks if opens all day', function(): void {
    $times = [
        ['00:00', '23:59'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->opensAllDay())->toBeTrue();
});

it('checks if closes late', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '01:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->closesLate())->toBeTrue();
});

it('checks if opens late at a specific time', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '01:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    expect($workingPeriod->opensLateAt(new WorkingTime(00, 30)))->toBeTrue()
        ->and($workingPeriod->opensLateAt(new WorkingTime(10, 00)))->toBeFalse();
});

it('generates timeslot', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];

    $workingPeriod = WorkingPeriod::create($times);

    $timeslot = $workingPeriod->timeslot(
        new DateTime('2022-12-31 10:00:00'),
        new DateInterval('PT15M'),
    )->all();

    expect($timeslot)->toBeArray()
        ->and($timeslot[0]->format('H:i'))->toBe('08:00')
        ->and($timeslot[1]->format('H:i'))->toBe('08:15');
});

it('returns an iterator for the ranges', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];
    $workingPeriod = WorkingPeriod::create($times);
    $iterator = $workingPeriod->getIterator();

    expect(iterator_to_array($iterator))->toHaveCount(2);
});

it('checks if an offset exists in ranges', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];
    $workingPeriod = WorkingPeriod::create($times);

    $exists = $workingPeriod->offsetExists(0);

    expect($exists)->toBeTrue();
});

it('retrieves a range by offset', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];
    $workingPeriod = WorkingPeriod::create($times);

    $retrievedRange = $workingPeriod->offsetGet(0);

    expect($retrievedRange)->toBeInstanceOf(WorkingRange::class);
});

it('throws an exception when setting a range by offset', function(): void {
    $times = [];
    $workingPeriod = WorkingPeriod::create($times);

    expect(fn() => $workingPeriod->offsetSet(0, WorkingRange::create(['08:00', '12:00'])))
        ->toThrow(WorkingHourException::class);
});

it('unsets a range by offset', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];
    $workingPeriod = WorkingPeriod::create($times);

    $workingPeriod->offsetUnset(0);

    expect(count($workingPeriod))->toBe(1);
});

it('returns a string representation of the ranges', function(): void {
    $times = [
        ['08:00', '12:00'],
        ['13:00', '17:00'],
    ];
    $workingPeriod = WorkingPeriod::create($times);

    $stringRepresentation = (string)$workingPeriod;

    expect($stringRepresentation)->toBe('08:00-12:00,13:00-17:00');
});
