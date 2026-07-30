<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use Igniter\Local\Classes\ScheduleItem;

it('creates 24/7 hours correctly', function(): void {
    $data = [
        'type' => '24_7',
    ];

    $scheduleItem = ScheduleItem::create('Test', $data);
    $hours = $scheduleItem->getHours();

    expect($scheduleItem->type)->toBe('24_7')
        ->and($hours)->toHaveCount(7)
        ->and($hours[0][0]['open'])->toBe('00:00')
        ->and($hours[0][0]['close'])->toBe('23:59')
        ->and($hours[0][0]['status'])->toBeTrue();
});

it('creates daily hours correctly', function(): void {
    $data = [
        'type' => 'daily',
        'days' => [1, 2, 3],
        'open' => '08:00',
        'close' => '17:00',
        'timesheet' => [],
        'flexible' => [],
    ];

    $scheduleItem = ScheduleItem::create('Test', $data);
    $hours = $scheduleItem->getHours();

    expect($scheduleItem->type)->toBe('daily')
        ->and($hours)->toHaveCount(7)
        ->and($hours[0][0]['open'])->toBe('08:00')
        ->and($hours[0][0]['close'])->toBe('17:00')
        ->and($hours[0][0]['status'])->toBeFalse()
        ->and($hours[1][0]['open'])->toBe('08:00')
        ->and($hours[1][0]['close'])->toBe('17:00')
        ->and($hours[1][0]['status'])->toBeTrue();
});

it('creates empty hours when no matching type', function(): void {
    $data = [
        'type' => 'invalid',
        'days' => [1, 2, 3],
        'open' => '08:00',
        'close' => '17:00',
        'timesheet' => [],
        'flexible' => [],
    ];

    $scheduleItem = ScheduleItem::create('Test', $data);
    $hours = $scheduleItem->getHours();

    expect(array_filter($hours))->toBeEmpty();
});

it('creates timesheet hours correctly', function(): void {
    $data = [
        'type' => 'timesheet',
        'days' => [],
        'open' => '08:00',
        'close' => '17:00',
        'timesheet' => [
            [
                'hours' => [
                    ['09:00', '12:00'],
                    ['13:00', '17:00'],
                ],
                'status' => 1,
            ],
        ],
        'flexible' => [],
    ];

    $scheduleItem = ScheduleItem::create('Test', $data);
    $hours = $scheduleItem->getHours();

    expect($scheduleItem->type)->toBe('timesheet')
        ->and($hours)->toHaveCount(7)
        ->and($hours[0][0]['open'])->toBe('09:00')
        ->and($hours[0][0]['close'])->toBe('12:00')
        ->and($hours[0][0]['status'])->toBeTrue()
        ->and($hours[0][1]['open'])->toBe('13:00')
        ->and($hours[0][1]['close'])->toBe('17:00')
        ->and($hours[0][1]['status'])->toBeTrue();
});

it('creates timesheet hours from json encoded string', function(): void {
    $data = [
        'type' => 'timesheet',
        'days' => [],
        'open' => '08:00',
        'close' => '17:00',
        'timesheet' => json_encode([
            [
                'hours' => '09:00-12:00,13:00-17:00',
                'status' => 1,
            ],
        ]),
        'flexible' => [],
    ];

    $scheduleItem = ScheduleItem::create('Test', $data);
    $hours = $scheduleItem->getHours();

    expect($scheduleItem->type)->toBe('timesheet')
        ->and($hours)->toHaveCount(7);
});

it('creates flexible hours correctly', function(): void {
    $data = [
        'type' => 'flexible',
        'days' => [],
        'open' => '08:00',
        'close' => '17:00',
        'timesheet' => [],
        'flexible' => [
            ['hours' => '09:00-12:00,13:00-17:00'],
            ['open' => '09:00', 'close' => '12:00'], // backward compatibility
        ],
    ];

    $scheduleItem = ScheduleItem::create('Test', $data);
    $hours = $scheduleItem->getHours();

    expect($scheduleItem->type)->toBe('flexible')
        ->and($hours)->toHaveCount(7)
        ->and($hours[0][0]['open'])->toBe('09:00')
        ->and($hours[0][0]['close'])->toBe('12:00')
        ->and($hours[0][0]['status'])->toBeTrue()
        ->and($hours[0][1]['open'])->toBe('13:00')
        ->and($hours[0][1]['close'])->toBe('17:00')
        ->and($hours[0][1]['status'])->toBeTrue();
});

it('gets formatted hours correctly', function(): void {
    $data = [
        'type' => 'daily',
        'days' => [1, 2, 3],
        'open' => '08:00',
        'close' => '17:00',
        'timesheet' => [],
        'flexible' => [],
    ];

    $scheduleItem = ScheduleItem::create('Test', $data);

    $formatted = $scheduleItem->getFormatted();

    expect($formatted)->toBeArray()
        ->and($formatted[1]->hours)->toBe('08:00-17:00');
});
