<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use Igniter\Local\Classes\WorkingRange;
use Igniter\Local\Classes\WorkingTime;
use Igniter\Local\Exceptions\WorkingHourException;

it('creates correctly', function(): void {
    $times = ['08:00', '17:00'];

    $workingRange = WorkingRange::create($times);

    expect($workingRange->start()->format())->toBe('08:00')
        ->and($workingRange->end()->format())->toBe('17:00');
});

it('creates from ranges correctly', function(): void {
    $ranges = [
        WorkingRange::create(['10:00', '12:00']),
        WorkingRange::create(['08:00', '17:00']),
        WorkingRange::create(['13:00', '17:00']),
    ];

    $workingRange = WorkingRange::fromRanges($ranges);

    expect($workingRange->start()->format())->toBe('08:00')
        ->and($workingRange->end()->format())->toBe('17:00');
});

it('throws an exception when ranges are empty', function(): void {
    WorkingRange::fromRanges([]);
})->throws(WorkingHourException::class);

it('throws an exception when ranges are not valid', function(): void {
    WorkingRange::fromRanges([new WorkingTime(8, 00), new WorkingTime(17, 00)]);
})->throws(WorkingHourException::class);

it('checks if ends next day', function(): void {
    $times = ['17:00', '08:00'];

    $workingRange = WorkingRange::create($times);

    expect($workingRange->endsNextDay())->toBeTrue();
});

it('checks if opens all day', function(): void {
    $times = ['00:00', '23:59'];

    $workingRange = WorkingRange::create($times);

    expect($workingRange->opensAllDay())->toBeTrue();
});

it('checks if contains time', function(): void {
    $times = ['08:00', '17:00'];

    $workingRange = WorkingRange::create($times);

    expect($workingRange->containsTime(new WorkingTime(10, 00)))->toBeTrue()
        ->and($workingRange->containsTime(new WorkingTime(18, 00)))->toBeFalse();
});

it('checks if contains time when ends the next day', function(): void {
    $times = ['15:00', '04:00'];

    $workingRange = WorkingRange::create($times);

    expect($workingRange->containsTime(new WorkingTime(18, 00)))->toBeTrue();
});

it('checks if overlaps', function(): void {
    $workingRange1 = WorkingRange::create(['08:00', '12:00']);
    $workingRange2 = WorkingRange::create(['11:00', '13:00']);
    $workingRange3 = WorkingRange::create(['13:00', '17:00']);

    expect($workingRange1->overlaps($workingRange2))->toBeTrue()
        ->and($workingRange1->overlaps($workingRange3))->toBeFalse();
});

it('formats correctly', function(): void {
    $times = ['08:00', '17:00'];

    $workingRange = WorkingRange::create($times);

    expect($workingRange->format())->toBe('08:00-17:00');
});
