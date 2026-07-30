<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models;

use Igniter\Local\Models\Location;
use Igniter\Local\Models\WorkingHour;
use Igniter\System\Models\Concerns\Switchable;

it('returns timesheet options with provided value', function(): void {
    $workingHour = new WorkingHour;
    $value = ['some' => 'value'];

    $result = $workingHour->getTimesheetOptions($value, []);

    expect($result)->toBeObject()
        ->and($result->timesheet)->toBe($value)
        ->and(array_column($result->daysOfWeek, 'name'))->toEqual([
            'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun',
        ]);
});

it('returns correct day attribute', function(): void {
    $workingHour = WorkingHour::create(['weekday' => 1]);

    $result = $workingHour->day;

    expect($result->format('l'))->toBe('Tuesday');
});

it('returns correct open attribute', function(): void {
    $workingHour = WorkingHour::create(['weekday' => 1, 'opening_time' => '08:00']);

    $result = $workingHour->open;

    expect($result->format('H:i'))->toBe('08:00');
});

it('returns correct close attribute', function(): void {
    $workingHour = WorkingHour::create(['weekday' => 1, 'opening_time' => '22:00', 'closing_time' => '02:00']);

    $result = $workingHour->close;

    expect($result->format('H:i'))->toBe('02:00')
        ->and($result->format('l'))->toBe('Wednesday');
});

it('returns true when open all day', function(): void {
    $workingHour = WorkingHour::create(['opening_time' => '00:00', 'closing_time' => '23:59']);

    $result = $workingHour->isOpenAllDay();

    expect($result)->toBeTrue();
});

it('returns false when not open all day', function(): void {
    $workingHour = WorkingHour::create(['opening_time' => '08:00', 'closing_time' => '17:00']);

    $result = $workingHour->isOpenAllDay();

    expect($result)->toBeFalse();
});

it('returns true when past midnight', function(): void {
    $workingHour = WorkingHour::create(['opening_time' => '22:00', 'closing_time' => '02:00']);

    $result = $workingHour->isPastMidnight();

    expect($result)->toBeTrue();
});

it('returns false when not past midnight', function(): void {
    $workingHour = WorkingHour::create(['opening_time' => '08:00', 'closing_time' => '17:00']);

    $result = $workingHour->isPastMidnight();

    expect($result)->toBeFalse();
});

it('configures working hour model correctly', function(): void {
    $workingHour = new WorkingHour;

    expect(class_uses_recursive($workingHour))->toContain(Switchable::class)
        ->and($workingHour->getTable())->toBe('working_hours')
        ->and($workingHour->getKeyName())->toBe('id')
        ->and($workingHour->relation)->toEqual([
            'belongsTo' => [
                'location' => [Location::class],
            ],
        ])
        ->and($workingHour->getAppends())->toEqual(['day', 'open', 'close'])
        ->and($workingHour->attributes)->toEqual([
            'opening_time' => '00:00',
            'closing_time' => '23:59',
        ])
        ->and($workingHour->getCasts())->toEqual([
            'id' => 'int',
            'weekday' => 'integer',
            'opening_time' => 'time',
            'closing_time' => 'time',
        ])
        ->and(WorkingHour::$weekDays)->toEqual(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);
});
