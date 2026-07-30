<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models\Concerns;

use Carbon\Carbon;
use Igniter\Local\Exceptions\WorkingHourException;
use Igniter\Local\Models\Location;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use InvalidArgumentException;

it('returns the correct working hour type when hourType is provided', function(): void {
    $location = Location::factory()->create();
    $location->settings()->create([
        'item' => 'hours',
        'data' => [
            'opening' => ['type' => '24_7'],
            'delivery' => ['type' => 'daily'],
            'collection' => ['type' => 'flexible'],
        ],
    ]);

    expect($location->workingHourType('opening'))->toBe('24_7')
        ->and($location->workingHourType('delivery'))->toBe('daily')
        ->and($location->workingHourType('collection'))->toBe('flexible');
});

it('returns working hours by day', function(): void {
    $location = Location::factory()->create();
    $workingHour1 = $location->working_hours()->create([
        'weekday' => 1,
        'type' => 'opening',
    ]);
    $workingHour2 = $location->working_hours()->create([
        'weekday' => 1,
        'type' => 'delivery',
    ]);
    $workingHour3 = $location->working_hours()->create([
        'weekday' => 2,
        'type' => 'opening',
    ]);

    $result = $location->getWorkingHoursByDay(1);

    expect($result)->toHaveCount(2)
        ->and($result->pluck('id')->all())->toContain($workingHour1->id, $workingHour2->id);
});

it('returns the correct working hour by day and type', function(): void {
    $location = Location::factory()->create();
    $workingHour = $location->working_hours()->create([
        'weekday' => 1,
        'type' => 'opening',
    ]);

    $result = $location->getWorkingHourByDayAndType(1, 'opening');

    expect($result->getKey())->toBe($workingHour->getKey());
});

it('returns the correct working hour by date and type', function(): void {
    $location = Location::factory()->create();
    $workingHour = $location->working_hours()->create([
        'weekday' => 1,
        'type' => 'opening',
    ]);
    $date = Carbon::createFromDate(2023, 1, 2)->toDateString(); // Monday

    $result = $location->getWorkingHourByDateAndType($date, 'opening');

    expect($result->id)->toBe($workingHour->id);
});

it('throws exception if working_hours relation does not exist', function(): void {
    $location = Location::factory()->make();
    unset($location->relation['hasMany']['working_hours']);

    expect(fn() => $location->getWorkingHours())->toThrow(RelationNotFoundException::class);
});

it('creates default working hours if none exist', function(): void {
    $location = Location::factory()->create();

    $result = $location->getWorkingHours();

    expect($result)->not->toBeEmpty();
});

it('creates a new working schedule with valid type and days', function(): void {
    $location = Location::factory()->create();
    $type = 'opening';
    $days = [2, 7];

    $schedule = $location->newWorkingSchedule($type, $days);

    expect($schedule->getType())->toBe($type)
        ->and($schedule->minDays())->toBe(2)
        ->and($schedule->days())->toBe(7);
});

it('throws exception when creating schedule with invalid type', function(): void {
    $location = Location::factory()->create();
    $invalidType = 'invalid';

    expect(fn() => $location->newWorkingSchedule($invalidType))->toThrow(WorkingHourException::class);
});

it('creates schedule item with valid type and data', function(): void {
    $location = Location::factory()->create();
    $type = 'opening';
    $scheduleData = ['type' => 'daily', 'open' => '09:00', 'close' => '17:00'];

    $scheduleItem = $location->createScheduleItem($type, $scheduleData);

    expect($scheduleItem->name)->toBe($type)
        ->and($scheduleItem->type)->toBe('daily');

    array_map(function(array $data): array {
        expect($data[0]['open'])->toBe('09:00')
            ->and($data[0]['close'])->toBe('17:00');

        return $data;
    }, $scheduleItem->getHours());
});

it('throws exception when creating schedule item with invalid type', function(): void {
    $location = Location::factory()->create();
    $invalidType = 'invalid';

    expect(fn() => $location->createScheduleItem($invalidType))->toThrow(InvalidArgumentException::class);
});

it('adds opening hours for all types when type is null', function(): void {
    $location = Location::factory()->create();
    $data = [
        'opening' => ['type' => 'daily', 'days' => [1], 'open' => '09:00', 'close' => '17:00', 'status' => 1],
        'delivery' => ['type' => 'daily', 'days' => [2], 'open' => '10:00', 'close' => '18:00', 'status' => 1],
        'collection' => ['type' => 'daily', 'days' => [3], 'open' => '11:00', 'close' => '19:00', 'status' => 1],
    ];

    $result = $location->addOpeningHours($data);

    expect($result)->toBeTrue()
        ->and($location->working_hours()->whereIsEnabled()->count())->toBe(3);
});

it('adds opening hours for a specific type', function(): void {
    $location = Location::factory()->create();
    $data = ['type' => 'daily', 'days' => [1], 'open' => '09:00', 'close' => '17:00', 'status' => 1];

    $result = $location->addOpeningHours('opening', $data);

    expect($result)->toBeTrue()
        ->and($location->working_hours()->whereIsEnabled()->where('type', 'opening')->count())->toBe(1);
});

it('does not add opening hours if schedule data is not an array', function(): void {
    $location = Location::factory()->create();
    $data = ['opening' => 'invalid data'];

    $result = $location->addOpeningHours($data);

    expect($result)->toBeTrue()
        ->and($location->working_hours()->count())->toBe(0);
});
