<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Http\Controllers;

use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningSection;
use Igniter\Reservation\Models\DiningTable;

it('loads dining areas page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.reservation.dining_areas'))
        ->assertOk();
});

it('loads create dining area page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.reservation.dining_areas', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit dining area page', function(): void {
    $diningArea = DiningArea::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]))
        ->assertOk();
});

it('loads dining area preview page', function(): void {
    $diningArea = DiningArea::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.reservation.dining_areas', ['slug' => 'preview/'.$diningArea->getKey()]))
        ->assertOk();
});

it('duplicates dining area', function(): void {
    $diningArea = DiningArea::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas'), [
            'id' => (string)$diningArea->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDuplicate',
        ])
        ->assertOk();

    expect(DiningArea::where('name', $diningArea->name.' (copy)')->exists())->toBeTrue();
});

it('creates dining area', function(): void {
    $location = Location::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'create']), [
            'DiningArea' => [
                'name' => 'Created Dining Area',
                'location_id' => $location->getKey(),
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(DiningArea::where('name', 'Created Dining Area')->exists())->toBeTrue();
});

it('creates a dining table combo', function(): void {
    $diningArea = DiningArea::factory()->create();
    $tables = $diningArea->dining_tables()->saveMany(DiningTable::factory(3)->make());

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'DiningArea' => [
                '_select_dining_tables' => $tables->pluck('id')->all(),
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onCreateCombo',
        ]);

    $this->assertDatabaseHas('dining_tables', [
        'name' => $tables->pluck('name')->join('/'),
        'is_combo' => 1,
    ]);
});

it('updates dining area', function(): void {
    $diningArea = DiningArea::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'DiningArea' => [
                'name' => 'Updated Dining Area',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(DiningArea::find($diningArea->getKey()))->name->toBe('Updated Dining Area');
});

it('updates dining area fixes broken tree', function(): void {
    $diningArea = DiningArea::factory()->create();
    $diningTableMock = mock(DiningTable::class)->makePartial();
    $diningTableMock->shouldReceive('isBroken')->andReturnTrue();
    $diningTableMock->shouldReceive('fixBrokenTreeQuietly')->once();
    app()->instance(DiningTable::class, $diningTableMock);

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'DiningArea' => [
                'name' => 'Updated Dining Area',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ])
        ->assertOk();

    expect(DiningArea::find($diningArea->getKey()))->name->toBe('Updated Dining Area');
});

it('deletes dining area', function(): void {
    $diningArea = DiningArea::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(DiningArea::find($diningArea->getKey()))->toBeNull();
});

it('attaches new dining table', function(): void {
    $diningArea = DiningArea::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningTableSolos::onLoadRecord',
        ])
        ->assertSee('New Record');

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'recordId' => '',
            'DiningArea' => [
                'connectorData' => [
                    'id' => '',
                    'dining_area_id' => $diningArea->getKey(),
                    'name' => 'New Dining Table',
                    'priority' => '9',
                    'min_capacity' => '2',
                    'max_capacity' => '4',
                    'extra_capacity' => '0',
                    'shape' => 'square',
                    'is_enabled' => '0',
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningTableSolos::onSaveRecord',
        ]);

    expect(DiningTable::where([
        'name' => 'New Dining Table',
        'dining_area_id' => $diningArea->getKey(),
        'priority' => 9,
        'min_capacity' => 2,
        'max_capacity' => 4,
        'extra_capacity' => 0,
        'shape' => 'square',
        'is_enabled' => 0,
    ])->exists())->toBeTrue();
});

it('updates dining table', function(): void {
    $diningArea = DiningArea::factory()->create();
    $diningTable = DiningTable::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'recordId' => $diningTable->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningTableSolos::onLoadRecord',
        ])
        ->assertSee('Edit Record');

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'recordId' => $diningTable->getKey(),
            'DiningArea' => [
                'connectorData' => [
                    'id' => $diningTable->getKey(),
                    'dining_area_id' => $diningArea->getKey(),
                    'name' => 'Updated Dining Table',
                    'priority' => '9',
                    'min_capacity' => '2',
                    'max_capacity' => '4',
                    'extra_capacity' => '2',
                    'shape' => 'square',
                    'is_enabled' => '1',
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningTableSolos::onSaveRecord',
        ]);

    expect(DiningTable::where([
        'name' => 'Updated Dining Table',
        'dining_area_id' => $diningArea->getKey(),
        'priority' => 9,
        'min_capacity' => 2,
        'max_capacity' => 4,
        'extra_capacity' => 2,
        'shape' => 'square',
        'is_enabled' => 1,
    ])->exists())->toBeTrue();
});

it('deletes dining table', function(): void {
    $diningArea = DiningArea::factory()->create();
    $diningTable = DiningTable::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'recordId' => $diningTable->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningTableSolos::onDeleteRecord',
        ]);

    expect(DiningTable::find($diningTable->getKey()))->toBeNull();
});

it('attaches new dining section', function(): void {
    $diningArea = DiningArea::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningSections::onLoadRecord',
        ])
        ->assertSee('New Section');

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'recordId' => '',
            'DiningArea' => [
                'recordData' => [
                    'location_id' => $diningArea->location->getKey(),
                    'name' => 'New Dining Section',
                    'priority' => '9',
                    'description' => 'New Dining Section Description',
                    'is_enabled' => '0',
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningSections::onSaveRecord',
        ]);

    expect(DiningSection::where([
        'location_id' => $diningArea->location->getKey(),
        'name' => 'New Dining Section',
        'priority' => 9,
        'description' => 'New Dining Section Description',
        'is_enabled' => 0,
    ])->exists())->toBeTrue();
});

it('updates dining section', function(): void {
    $diningArea = DiningArea::factory()->create();
    $diningSection = DiningSection::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'recordId' => $diningSection->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningSections::onLoadRecord',
        ])
        ->assertSee('Edit Section')
        ->assertSee($diningSection->name);

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'recordId' => $diningSection->getKey(),
            'DiningArea' => [
                'recordData' => [
                    'location_id' => $diningArea->location->getKey(),
                    'name' => 'Updated Dining Table',
                    'priority' => '9',
                    'description' => 'Updated Dining Section Description',
                    'is_enabled' => '1',
                ],
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningSections::onSaveRecord',
        ]);

    expect(DiningSection::where([
        'location_id' => $diningArea->location->getKey(),
        'name' => 'Updated Dining Table',
        'priority' => '9',
        'description' => 'Updated Dining Section Description',
        'is_enabled' => '1',
    ])->exists())->toBeTrue();
});

it('deletes dining section', function(): void {
    $diningArea = DiningArea::factory()->create();
    $diningSection = DiningSection::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.reservation.dining_areas', ['slug' => 'edit/'.$diningArea->getKey()]), [
            'recordId' => $diningSection->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'formDiningSections::onDeleteRecord',
        ]);

    expect(DiningSection::find($diningSection->getKey()))->toBeNull();
});
