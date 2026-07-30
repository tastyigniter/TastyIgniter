<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\Reservation\Models\DiningArea;
use Igniter\Reservation\Models\DiningSection;
use Mockery;

it('returns correct record editor options', function(): void {
    $diningArea = DiningArea::factory()->create();
    DiningSection::factory()->count(5)->create([
        'location_id' => $diningArea->location_id,
    ]);

    expect(DiningSection::make()->getRecordEditorOptions($diningArea)->count())->toBe(5);
});

it('returns correct priority options', function(): void {
    $diningSection = new DiningSection;
    $expectedOptions = [
        lang('igniter.reservation::default.dining_tables.text_priority_0'),
        lang('igniter.reservation::default.dining_tables.text_priority_1'),
        lang('igniter.reservation::default.dining_tables.text_priority_2'),
        lang('igniter.reservation::default.dining_tables.text_priority_3'),
        lang('igniter.reservation::default.dining_tables.text_priority_4'),
        lang('igniter.reservation::default.dining_tables.text_priority_5'),
        lang('igniter.reservation::default.dining_tables.text_priority_6'),
        lang('igniter.reservation::default.dining_tables.text_priority_7'),
        lang('igniter.reservation::default.dining_tables.text_priority_8'),
        lang('igniter.reservation::default.dining_tables.text_priority_9'),
    ];

    expect($diningSection->getPriorityOptions())->toBe($expectedOptions);
});

it('applies where is reservable scope', function(): void {
    $builder = Mockery::mock(Builder::class);
    $builder->shouldReceive('where')->with('is_enabled', 1)->once()->andReturnSelf();

    $diningSection = new DiningSection;
    $diningSection->scopeWhereIsReservable($builder);
});

it('configures dining section model correctly', function(): void {
    $diningSection = new DiningSection;

    expect(class_uses_recursive($diningSection))
        ->toContain(Locationable::class)
        ->and($diningSection->getTable())->toBe('dining_sections')
        ->and($diningSection->timestamps)->toBeFalse()
        ->and($diningSection->relation)->toEqual([
            'belongsTo' => [
                'location' => [Location::class],
            ],
            'hasMany' => [
                'dining_areas' => [DiningArea::class, 'foreignKey' => 'location_id', 'otherKey' => 'location_id'],
            ],
        ]);
});
