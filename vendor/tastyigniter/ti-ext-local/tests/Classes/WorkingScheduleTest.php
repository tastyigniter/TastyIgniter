<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use DateInterval;
use DateTime;
use DateTimeZone;
use Igniter\Local\Classes\WorkingPeriod;
use Igniter\Local\Classes\WorkingSchedule;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\WorkingHour;
use Illuminate\Support\Carbon;
use ReflectionClass;

it('creates correctly', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', 5);

    expect($workingSchedule->minDays())->toBe(0)
        ->and($workingSchedule->days())->toBe(5);
});

it('creates with min and max future days correctly', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', [5, 10]);

    expect($workingSchedule->minDays())->toBe(5)
        ->and($workingSchedule->days())->toBe(10);
});

it('fills correctly', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', 5);

    $workingHour = WorkingHour::create([
        'weekday' => 'tuesday',
        'opening_time' => '08:00',
        'closing_time' => '17:00',
        'status' => 0,
    ]);

    $workingSchedule->fill([
        'periods' => [
            'monday' => [
                ['08:00', '12:00'],
                ['13:00', '17:00'],
            ],
            $workingHour,
        ],
        'exceptions' => [
            '2022-12-31' => [
                ['08:00', '12:00'],
            ],
        ],
    ]);

    expect($workingSchedule->getPeriods())->toHaveCount(7)
        ->and($workingSchedule->exceptions())->toHaveCount(1);
});

it('sets the current time to now', function(): void {
    $workingSchedule = new WorkingSchedule;
    $now = new DateTime('2023-01-01 12:00:00');

    $result = $workingSchedule->setNow($now);

    expect($result)->toBe($workingSchedule);
});

it('sets the timezone correctly', function(): void {
    $workingSchedule = new class extends WorkingSchedule
    {
        public function timezone(): ?DateTimeZone
        {
            return $this->timezone;
        }
    };
    $timezone = 'America/New_York';

    $workingSchedule->setTimezone($timezone);

    expect($workingSchedule->timezone()->getName())->toBe($timezone);
});

it('checks next open time', function(): void {
    $this->travelTo(new DateTime('2023-01-01 10:00:00')); // Sunday
    $workingSchedule = new WorkingSchedule('UTC', [0, 15]);
    $workingSchedule->fill([
        'periods' => [
            'monday' => [
                ['08:00', '12:00'],
                ['13:00', '17:00'],
            ],
        ],
    ]);

    $result = $workingSchedule->isOpening();

    expect($result)->toBeTrue();
});

it('checks next open time fails when no periods', function(): void {
    $this->travelTo(new DateTime('2023-01-03 10:00:00')); // Tuesday
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);

    expect($workingSchedule->isOpening())->toBeFalse();
});

it('opens on day with no periods', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);
    $workingSchedule->fill([
        'periods' => [
            'monday' => [],
        ],
    ]);

    $result = $workingSchedule->isOpenOn('monday');

    expect($result)->toBeFalse();
});

it('closed on day with no periods', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);
    $workingSchedule->fill([
        'periods' => [
            'monday' => [],
        ],
    ]);

    $result = $workingSchedule->isClosedOn('sunday');

    expect($result)->toBeTrue();
});

it('returns the working period for a given date', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);
    $workingSchedule->fill([
        'periods' => [
            'monday' => [
                ['08:00', '12:00'],
                ['13:00', '17:00'],
            ],
        ],
    ]);

    $result = $workingSchedule->getPeriod(new DateTime('2023-01-03 10:00:00'));

    expect($result)->toBeInstanceOf(WorkingPeriod::class);
});

it('returns the next open time formatted', function(): void {
    $this->travelTo(new DateTime('2023-01-01 10:00:00')); // Sunday
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);
    $workingSchedule->fill([
        'periods' => [
            'monday' => [
                ['08:00', '12:00'],
                ['13:00', '17:00'],
            ],
        ],
    ]);

    $result = $workingSchedule->getOpenTime('H:i');

    expect($result)->toBe('08:00');
});

it('returns the next close time formatted', function(): void {
    $this->travelTo(new DateTime('2023-01-01 10:00:00')); // Sunday
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);
    $workingSchedule->fill([
        'periods' => [
            'sunday' => [
                ['08:00', '12:00'],
                ['13:00', '17:00'],
            ],
        ],
    ]);

    $result = $workingSchedule->getCloseTime('H:i');

    expect($result)->toBe('12:00');
});

it('checks next close time fails when no periods and exceptions', function(): void {
    $this->travelTo(new DateTime('2023-01-03 10:00:00')); // Tuesday
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);

    $result = $workingSchedule->getCloseTime('H:i');

    expect($result)->toBeNull();
});

it('checks next close time with exceptions', function(): void {
    $this->travelTo(new DateTime('2023-01-03 10:00:00')); // Tuesday
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);
    $workingSchedule->fill([
        'exceptions' => [
            '2024-01-03' => [
                ['08:00', '12:00'],
            ],
        ],
    ]);

    $result = $workingSchedule->getCloseTime('H:i');

    expect($result)->toBe('12:00');
});

it('checks status correctly', function(): void {
    $this->travelTo(new DateTime('2022-12-25 10:00:00'));
    $workingSchedule = new WorkingSchedule('UTC', 0);
    $workingSchedule->fill([
        'periods' => [
            'sunday' => [
                ['08:00', '18:00'],
            ],
            'monday' => [
                ['08:00', '12:00'],
                ['13:00', '17:00'],
            ],
        ],
        'exceptions' => [
            '2022-12-25' => [
                ['08:00', '12:00'],
            ],
            '2022-12-31' => [],
            '2023-01-01' => [],
        ],
    ]);

    expect($workingSchedule->checkStatus())->toBe(WorkingPeriod::OPEN)
        ->and($workingSchedule->checkStatus('2022-12-31 20:00:00'))->toBe(WorkingPeriod::CLOSED)
        ->and($workingSchedule->checkStatus('2023-01-01 15:00:00'))->toBe(WorkingPeriod::CLOSED)
        ->and($workingSchedule->checkStatus(new DateTime('2023-01-02 20:00:00')))->toBe(WorkingPeriod::CLOSED)
        ->and($workingSchedule->checkStatus(new DateTime('2023-01-02 10:00:00')))->toBe(WorkingPeriod::OPEN)
        ->and($workingSchedule->checkStatus(new DateTime('2023-01-02 07:00:00')))->toBe(WorkingPeriod::OPENING);
});

it('gets timeslot correctly', function(): void {
    $this->travelTo(new DateTime('2023-01-02 10:00:00'));
    $workingSchedule = new WorkingSchedule('UTC', 5);
    $workingSchedule->setType(Location::DELIVERY);
    $workingSchedule->fill([
        'periods' => [
            'monday' => [
                ['08:00', '12:00'],
                ['13:00', '17:00'],
            ],
        ],
    ]);

    $timeslot = $workingSchedule->getTimeslot(15, new DateTime('2023-01-02 10:00:00'))->all();

    expect($timeslot)->toBeArray()
        ->and($timeslot['2023-01-02'])->toHaveCount(22);
});

it('gets empty timeslot when no next open time', function(): void {
    $this->travelTo(new DateTime('2023-01-03 10:00:00')); // Tuesday
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);

    $timeslot = $workingSchedule->getTimeslot(15, new DateTime('2023-01-02 10:00:00'))->all();

    expect($timeslot)->toBeEmpty();
});

it('gets timeslot when when closes late', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', [0, 5]);
    $workingSchedule->fill([
        'periods' => [
            'sunday' => [
                ['18:00', '02:00'],
            ],
        ],
    ]);

    $timeslot = $workingSchedule->getTimeslot(15, new DateTime('2023-01-03 20:00:00'))->all();

    expect($timeslot)->toBeEmpty();
});

it('gets timeslot when when next end date is less than current date', function(): void {
    $workingSchedule = new WorkingSchedule('UTC', [1, 1]);
    $workingSchedule->fill([
        'periods' => [
            'tuesday' => [
                ['18:00', '19:00'],
            ],
            'monday' => [
                ['18:00', '23:00'],
            ],
        ],
    ]);

    $timeslot = $workingSchedule->getTimeslot(3, new DateTime('2023-01-03 20:00:00'))->all();

    expect($timeslot)->toBeEmpty();
});

it('generates timeslot correctly', function(): void {
    $this->travelTo(new DateTime('2023-01-02 10:00:00'));
    $workingSchedule = new WorkingSchedule('UTC', 5);
    $workingSchedule->setType(Location::DELIVERY);

    $workingSchedule->fill([
        'periods' => [
            'monday' => [
                ['08:00', '12:00'],
                ['13:00', '17:00'],
            ],
        ],
    ]);

    $timeslot = $workingSchedule->generateTimeslot(
        new DateTime('2023-01-02 10:00:00'),
        new DateInterval('PT15M'),
    )->all();

    expect($timeslot)->toBeArray()
        ->and($timeslot)->toHaveCount(22);
});

it('generates empty timeslot', function(): void {
    $this->travelTo(new DateTime('2023-01-02 07:00:00'));
    $workingSchedule = new WorkingSchedule('UTC', [2, 5]);
    $workingSchedule->fill([
        'exceptions' => [
            '2023-01-02' => [
                ['08:00', '12:00'],
            ],
        ],
    ]);

    $timeslot = $workingSchedule->generateTimeslot(
        new DateTime('2023-01-02 10:00:00'),
        new DateInterval('PT15M'),
    )->all();

    expect($timeslot)->toBeArray()->and($timeslot)->toHaveCount(0);
});

it('adjusts end date when next close date is before current date', function(): void {
    $dateTime = Carbon::now();
    $workingSchedule = mock(WorkingSchedule::class)->makePartial();
    $workingSchedule->shouldReceive('nextOpenAt')->andReturn($dateTime->copy()->subDay());
    $workingSchedule->shouldReceive('nextCloseAt')->andReturn($dateTime->copy()->subDay());
    $workingPeriod = mock(WorkingPeriod::class);
    $workingPeriod->shouldReceive('closesLate')->andReturnFalse();
    $workingSchedule->shouldReceive('forDate')->andReturn($workingPeriod);

    $reflection = new ReflectionClass(WorkingSchedule::class);
    $method = $reflection->getMethod('createPeriodForDays');

    $result = $method->invoke($workingSchedule, $dateTime);

    expect($result->end->toDateString())->toBe($dateTime->copy()->subDay()->addDay()->toDateString());
});
