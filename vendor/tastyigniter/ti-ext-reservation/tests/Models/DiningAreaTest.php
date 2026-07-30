<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models;

use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningSection;
use Igniter\Reservation\Models\DiningTable;
use Igniter\Reservation\Models\Reservation;
use Mockery;

it('returns dropdown options with names', function(): void {
    $diningArea = DiningArea::factory()->create();

    $options = DiningArea::getDropdownOptions()->all();

    expect($options)->toBeArray()
        ->and($options)->toHaveKey($diningArea->id, $diningArea->name);
});

it('returns tables for floor plan', function(): void {
    $diningArea = DiningArea::factory()->create();
    $diningArea->available_tables()->save($diningTable = DiningTable::factory()->create());

    $tables = $diningArea->getTablesForFloorPlan()->all();

    expect($tables)->toBeArray()
        ->and($tables[0])->toHaveKey('id', $diningTable->id);
});

it('returns dining tables with reservation', function(): void {
    $diningArea = DiningArea::factory()->create();
    $diningArea->available_tables()->save($diningTable = DiningTable::factory()->create());
    $reservation = Reservation::factory()->create();
    $reservation->tables()->attach($diningTable);

    $reservations = collect([$reservation]);
    $tables = $diningArea->getDiningTablesWithReservation($reservations)->all();

    expect($tables)->toBeArray()
        ->and($tables[0])->toHaveKey('id', $diningTable->id);
});

it('returns correct dining table count', function(): void {
    $diningArea = Mockery::mock(DiningArea::class)->makePartial();
    $diningArea->shouldReceive('getAttribute')->with('available_tables')->andReturn(collect([1, 2, 3]));

    expect($diningArea->dining_table_count)->toBe(3);
});

it('duplicates dining area with tables', function(): void {
    $diningArea = Mockery::mock(DiningArea::class)->makePartial();
    $diningArea->name = 'Original';
    $diningArea->shouldReceive('replicate')->andReturnSelf();
    $diningArea->shouldReceive('save')->once();
    $diningArea->shouldReceive('getKey')->andReturn(2);

    $table = Mockery::mock(DiningTable::class)->makePartial();
    $table->is_combo = false;
    $table->shouldReceive('replicate')->andReturnSelf();
    $table->shouldReceive('save')->once();
    $table->shouldReceive('setAttribute')->with('dining_area_id', 2)->once();

    $diningArea->shouldReceive('getAttribute')->with('dining_tables')->andReturn(collect([$table]));

    $newDiningArea = $diningArea->duplicate();

    expect($newDiningArea->name)->toBe('Original (copy)');
});

it('creates combo dining table', function(): void {
    $diningArea = DiningArea::factory()->create();
    $table1 = DiningTable::factory()->create([
        'shape' => 'square',
        'dining_area_id' => $diningArea->id,
        'dining_section_id' => 1,
        'min_capacity' => 2,
        'max_capacity' => 4,
    ]);
    $table2 = DiningTable::factory()->create([
        'shape' => 'square',
        'dining_area_id' => $diningArea->id,
        'dining_section_id' => 1,
        'min_capacity' => 2,
        'max_capacity' => 4,
    ]);

    $tables = collect([$table1, $table2]);

    $comboTable = $diningArea->createCombo($tables);

    expect($comboTable->name)->toBe($table1->name.'/'.$table2->name)
        ->and($comboTable->shape)->toBe('square')
        ->and($comboTable->dining_area_id)->toBe($diningArea->id)
        ->and($comboTable->dining_section_id)->toBe(1)
        ->and($comboTable->min_capacity)->toBe(4)
        ->and($comboTable->max_capacity)->toBe(8)
        ->and($comboTable->is_combo)->toBeTrue()
        ->and($comboTable->is_enabled)->toBeTrue()
        ->and($table1->fresh()->parent_id)->toBe($comboTable->id)
        ->and($table2->fresh()->parent_id)->toBe($comboTable->id);
});

it('throws an exception when table already combined', function(): void {
    $diningArea = DiningArea::factory()->create();
    $table1 = DiningTable::factory()->create();
    $table2 = DiningTable::factory()->create();
    $table2->parent()->associate($table1)->save();

    $tables = collect([$table1, $table2]);

    expect(fn() => $diningArea->createCombo($tables))
        ->toThrow(new FlashException(lang('igniter.reservation::default.dining_areas.alert_table_already_combined')));
});

it('throws an exception when combining tables from different sections', function(): void {
    $diningArea = DiningArea::factory()->create();
    $table1 = DiningTable::factory()->create(['dining_section_id' => 1]);
    $table2 = DiningTable::factory()->create(['dining_section_id' => 2]);

    $tables = collect([$table1, $table2]);

    expect(fn() => $diningArea->createCombo($tables))
        ->toThrow(new FlashException(lang('igniter.reservation::default.dining_areas.alert_table_combo_section_mismatch')));
});

it('configures dining area model correctly', function(): void {
    $diningArea = new DiningArea;

    expect(class_uses_recursive($diningArea))
        ->toContain(Locationable::class)
        ->and($diningArea->getTable())->toBe('dining_areas')
        ->and($diningArea->timestamps)->toBeTrue()
        ->and($diningArea->getCasts()['floor_plan'])->toBe('array')
        ->and($diningArea->getMorphClass())->toBe('dining_areas')
        ->and($diningArea->relation['hasMany']['dining_sections'])->toBe([DiningSection::class, 'foreignKey' => 'location_id', 'otherKey' => 'location_id'])
        ->and($diningArea->relation['hasMany']['dining_tables'])->toBe([DiningTable::class, 'delete' => true])
        ->and($diningArea->relation['hasMany']['dining_table_solos'])->toBe([DiningTable::class, 'scope' => 'whereIsNotCombo'])
        ->and($diningArea->relation['hasMany']['dining_table_combos'])->toBe([DiningTable::class, 'scope' => 'whereIsCombo'])
        ->and($diningArea->relation['hasMany']['available_tables'])->toBe([DiningTable::class, 'scope' => 'whereIsRoot'])
        ->and($diningArea->relation['belongsTo']['location'])->toBe([Location::class]);
});
