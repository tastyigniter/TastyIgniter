<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models;

use Igniter\Admin\Models\Status;
use Igniter\Flame\Database\Traits\NestedTree;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningSection;
use Igniter\Reservation\Models\DiningTable;
use Igniter\Reservation\Models\Reservation;
use Mockery;

it('returns correct dining section id options when dining area exists', function(): void {
    $location = Location::factory()->create();
    $diningArea = DiningArea::factory()->create(['location_id' => $location->getKey()]);
    $diningTable = DiningTable::factory()->create(['dining_area_id' => $diningArea->getKey()]);
    DiningSection::factory()->count(5)->create(['location_id' => $location->getKey()]);

    expect($diningTable->getDiningSectionIdOptions()->count())->toBe(5);
});

it('returns empty dining section id options when dining area does not exist', function(): void {
    $diningTable = Mockery::mock(DiningTable::class)->makePartial();
    $diningTable->shouldReceive('exists')->andReturn(false);

    expect($diningTable->getDiningSectionIdOptions())->toBe([]);
});

it('returns priority options as an array of strings', function(): void {
    $diningTable = new DiningTable;

    $options = $diningTable->getPriorityOptions();

    expect($options)->toBeArray()
        ->and($options)->toHaveCount(10)
        ->and($options[0])->toBeString();
});

it('returns correct section name attribute', function(): void {
    $diningSection = Mockery::mock(DiningSection::class)->makePartial();
    $diningSection->shouldReceive('getAttribute')->with('name')->andReturn('Main Section');

    $diningTable = Mockery::mock(DiningTable::class)->makePartial();
    $diningTable->shouldReceive('extendableGet')->with('dining_section')->andReturn($diningSection);

    expect($diningTable->section_name)->toBe('Main Section');
});

it('returns null section name attribute when dining section is null', function(): void {
    $diningTable = Mockery::mock(DiningTable::class)->makePartial();
    $diningTable->shouldReceive('getAttribute')->with('dining_section')->andReturn(null);

    expect($diningTable->section_name)->toBeNull();
});

it('returns correct floor plan array without reservation', function(): void {
    $diningTable = new DiningTable;
    $diningTable->id = 1;
    $diningTable->name = 'Table1';
    $diningTable->min_capacity = 2;
    $diningTable->max_capacity = 4;
    $diningTable->shape = 'square';
    $diningTable->seat_layout = ['layout'];

    $expectedArray = [
        'id' => 1,
        'name' => 'Table1',
        'description' => '2-4',
        'capacity' => 4,
        'shape' => 'square',
        'seatLayout' => ['layout'],
        'tableColor' => null,
        'seatColor' => null,
        'customerName' => null,
    ];

    expect($diningTable->toFloorPlanArray())->toBe($expectedArray);
});

it('returns correct floor plan array with reservation', function(): void {
    $reservation = new Reservation;
    $reservation->reserve_date = '2023-10-10';
    $reservation->reserve_time = '12:00:00';
    $reservation->duration = 120;
    $reservation->first_name = 'John';
    $reservation->last_name = 'Doe';
    $reservation->setRelation('status', new Status(['status_color' => 'red']));

    $diningTable = new DiningTable;
    $diningTable->id = 1;
    $diningTable->name = 'Table1';
    $diningTable->min_capacity = 2;
    $diningTable->max_capacity = 4;
    $diningTable->shape = 'square';
    $diningTable->seat_layout = ['layout'];

    $expectedArray = [
        'id' => 1,
        'name' => 'Table1',
        'description' => '12:00 pm - 02:00 pm',
        'capacity' => 4,
        'shape' => 'square',
        'seatLayout' => ['layout'],
        'tableColor' => null,
        'seatColor' => 'red',
        'customerName' => 'John Doe',
    ];

    expect($diningTable->toFloorPlanArray($reservation))->toBe($expectedArray);
});

it('configures dining table model correctly', function(): void {
    $diningTable = new DiningTable;

    expect(class_uses_recursive($diningTable))
        ->toContain(Locationable::class)
        ->toContain(NestedTree::class)
        ->toContain(Sortable::class)
        ->and(DiningTable::SORT_ORDER)->toBe('priority')
        ->and($diningTable->getTable())->toBe('dining_tables')
        ->and($diningTable->timestamps)->toBeTrue()
        ->and($diningTable->getMorphClass())->toBe('tables')
        ->and($diningTable->getCasts())->toHaveKeys([
            'min_capacity', 'max_capacity', 'extra_capacity', 'priority', 'is_combo', 'is_enabled', 'seat_layout',
        ])
        ->and($diningTable->relation)->toEqual([
            'belongsTo' => [
                'dining_area' => [DiningArea::class],
                'dining_section' => [DiningSection::class],
            ],
            'belongsToMany' => [
                'reservations' => [Reservation::class, 'table' => 'reservation_tables', 'otherKey' => 'reservation_id'],
            ],
            'hasOneThrough' => [
                'location' => [
                    Location::class,
                    'through' => DiningArea::class,
                    'foreignKey' => 'id',
                    'throughKey' => 'location_id',
                    'otherKey' => 'dining_area_id',
                    'secondOtherKey' => 'location_id',
                ],
            ],
        ]);
});
