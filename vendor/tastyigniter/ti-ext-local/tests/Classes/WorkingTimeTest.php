<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use DateTime;
use Igniter\Local\Classes\WorkingTime;
use Igniter\Local\Exceptions\WorkingHourException;

it('creates correctly', function(): void {
    $workingTime = WorkingTime::create('08:00');

    expect($workingTime->hours())->toBe(8)
        ->and($workingTime->minutes())->toBe(0);
});

it('throws exception when creating with invalid date', function(): void {
    expect(fn(): WorkingTime => WorkingTime::create('invalid'))->toThrow(WorkingHourException::class);
});

it('creates from DateTime correctly', function(): void {
    $dateTime = new DateTime('08:00');

    $workingTime = WorkingTime::fromDateTime($dateTime);

    expect($workingTime->hours())->toBe(8)
        ->and($workingTime->minutes())->toBe(0);
});

it('checks time correctly', function(): void {
    $workingTime1 = WorkingTime::create('08:00');
    $workingTime2 = WorkingTime::create('10:00');

    expect($workingTime1->isSame($workingTime1))->toBeTrue()
        ->and($workingTime1->isSame($workingTime2))->toBeFalse()
        ->and($workingTime1->isAfter($workingTime1))->toBeFalse()
        ->and($workingTime1->isAfter($workingTime2))->toBeFalse()
        ->and($workingTime1->isBefore($workingTime2))->toBeTrue()
        ->and($workingTime1->isBefore($workingTime1))->toBeFalse()
        ->and($workingTime1->isSameOrAfter($workingTime1))->toBeTrue()
        ->and($workingTime1->isSameOrAfter($workingTime2))->toBeFalse()
        ->and($workingTime1->isSameOrBefore($workingTime1))->toBeTrue()
        ->and($workingTime1->isSameOrBefore($workingTime2))->toBeTrue()
        ->and($workingTime2->isSameOrBefore($workingTime1))->toBeFalse();
});

it('gets time difference correctly', function(): void {
    $workingTime1 = WorkingTime::create('08:00');
    $workingTime2 = WorkingTime::create('10:00');

    $diff = $workingTime1->diff($workingTime2);

    expect($diff->h)->toBe(2)
        ->and($diff->i)->toBe(0);
});

it('formats correctly', function(): void {
    $workingTime = WorkingTime::create('08:00');

    expect($workingTime->format())->toBe('08:00')
        ->and($workingTime->format('H'))->toBe('08')
        ->and($workingTime->format('i'))->toBe('00');
});
