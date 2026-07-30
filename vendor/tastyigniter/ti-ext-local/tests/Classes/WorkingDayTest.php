<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use DateTime;
use Igniter\Local\Classes\WorkingDay;
use Igniter\Local\Exceptions\WorkingHourException;

it('lists days correctly', function(): void {
    $days = WorkingDay::days();

    expect($days)->toBeArray()->and($days)->toHaveCount(7);
});

it('maps days correctly', function(): void {
    $mappedDays = WorkingDay::mapDays(fn($day): string => strtoupper((string)$day));

    expect($mappedDays)->toBeArray()
        ->and($mappedDays)->toHaveCount(7)
        ->and($mappedDays['monday'])->toBe('MONDAY');
});

it('validates day correctly', function(): void {
    expect(WorkingDay::isValid('monday'))->toBeTrue()
        ->and(WorkingDay::isValid('invalid'))->toBeFalse();
});

it('gets day on date correctly', function(): void {
    $date = new DateTime('2022-12-31'); // Saturday

    expect(WorkingDay::onDateTime($date))->toBe('saturday');
});

it('converts day to ISO correctly', function(): void {
    expect(WorkingDay::toISO('monday'))->toBe(1)
        ->and(WorkingDay::toISO('sunday'))->toBe(7);
});

it('normalizes day name correctly', function(): void {
    expect(WorkingDay::normalizeName('MONDAY'))->toBe('monday');
});

it('throws exception for invalid day name', function(): void {
    WorkingDay::normalizeName('invalid');
})->throws(WorkingHourException::class);
