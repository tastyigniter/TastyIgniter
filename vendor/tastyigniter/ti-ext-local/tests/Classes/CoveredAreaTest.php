<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Classes;

use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Classes\CoveredArea;
use Igniter\Local\Classes\CoveredAreaCondition;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\LocationArea;
use Mockery;

it('calculates delivery amount correctly', function(): void {
    $model = Mockery::mock(LocationArea::class);
    $model->shouldReceive('offsetExists')->andReturnTrue();
    $model->shouldReceive('extendableGet')->with('conditions')->andReturn([
        ['type' => 'above', 'amount' => 10, 'total' => 100, 'priority' => 1],
        ['type' => 'below', 'amount' => 5, 'total' => 50, 'priority' => 2],
    ]);
    $model->shouldReceive('extendableGet')->with('boundaries')->andReturn([
        'distance' => [],
    ]);

    $coveredArea = new CoveredArea($model);

    expect($coveredArea->deliveryAmount(100))->toBe(10.0)
        ->and($coveredArea->deliveryAmount(40))->toBe(5.0);
});

it('calculates delivery amount using delivery charges correctly', function(): void {
    $model = Mockery::mock(LocationArea::class);
    $model->shouldReceive('offsetExists')->andReturnTrue();
    $model->shouldReceive('extendableGet')->with('conditions')->andReturn([
        ['type' => 'above', 'amount' => 10, 'total' => 100, 'priority' => 1],
        ['type' => 'below', 'amount' => 5, 'total' => 50, 'priority' => 2],
    ]);
    $model->shouldReceive('extendableGet')->with('boundaries')->andReturn([
        'distance' => [
            ['distance' => 15, 'type' => 'greater', 'charge' => 1],
            ['distance' => 10, 'type' => 'less', 'charge' => 5],
            ['distance' => 15, 'type' => 'equals_or_greater', 'charge' => 10],
            ['distance' => 12, 'type' => 'equals_or_less', 'charge' => 15],
        ],
    ]);
    Location::shouldReceive('userPosition')->andReturn($userPosition = mock(GeoliteLocation::class));
    $userPosition->shouldReceive('isValid')->andReturnTrue();
    Location::shouldReceive('checkDistance')->andReturn(20, 5, 15, 12);

    $coveredArea = new CoveredArea($model);

    expect($coveredArea->deliveryAmount(100))->toBe(11.0)
        ->and($coveredArea->deliveryAmount(40))->toBe(10.0)
        ->and($coveredArea->deliveryAmount(40))->toBe(15.0)
        ->and($coveredArea->deliveryAmount(40))->toBe(20.0);
});

it('returns minimum order total correctly', function(): void {
    $model = Mockery::mock(LocationArea::class);
    $model->shouldReceive('offsetExists')->andReturnTrue();

    $model->shouldReceive('extendableGet')->with('conditions')->andReturn([
        ['type' => 'above', 'amount' => 10, 'total' => 100, 'priority' => 1],
        ['type' => 'below', 'amount' => 5, 'total' => 50, 'priority' => 2],
    ]);

    $coveredArea = new CoveredArea($model);

    expect($coveredArea->minimumOrderTotal(100))->toBe(100.0)
        ->and($coveredArea->minimumOrderTotal(40))->toBe(50.0);
});

it('returns zero minimum order total when no conditions are met', function(): void {
    $model = Mockery::mock(LocationArea::class);
    $model->shouldReceive('offsetExists')->andReturnTrue();
    $model->shouldReceive('extendableGet')->with('conditions')->andReturn([]);

    $coveredArea = new CoveredArea($model);

    expect($coveredArea->minimumOrderTotal(100))->toBe(0);
});

it('returns unavailable when matched rule is -1', function(): void {
    $model = Mockery::mock(LocationArea::class);
    $model->shouldReceive('offsetExists')->andReturnTrue();
    $model->shouldReceive('extendableGet')->with('conditions')->andReturn([
        ['type' => 'above', 'amount' => -1, 'total' => 100, 'priority' => 1],
    ]);

    $coveredArea = new CoveredArea($model);

    expect($coveredArea->minimumOrderTotal(100))->toBe(100.0);
});

it('lists conditions correctly', function(): void {
    $model = Mockery::mock(LocationArea::class);
    $model->shouldReceive('offsetExists')->andReturnTrue();

    $model->shouldReceive('extendableGet')->with('conditions')->andReturn([
        ['type' => 'above', 'amount' => 10, 'total' => 100, 'priority' => 1],
        ['type' => 'below', 'amount' => 5, 'total' => 50, 'priority' => 2],
    ]);

    $coveredArea = new CoveredArea($model);
    $conditions = $coveredArea->listConditions()->all();

    expect($conditions)->toBeArray()->and($conditions)->toHaveCount(2)
        ->and($conditions[0])->toBeInstanceOf(CoveredAreaCondition::class)
        ->and($conditions[0]->type)->toBe('above')
        ->and($conditions[1]->type)->toBe('below');
});

it('gets condition labels correctly', function(): void {
    $model = Mockery::mock(LocationArea::class);
    $model->shouldReceive('offsetExists')->andReturnTrue();

    $model->shouldReceive('extendableGet')->with('conditions')->andReturn([
        ['type' => 'above', 'amount' => 10, 'total' => 100, 'priority' => 1],
        ['type' => 'below', 'amount' => 5, 'total' => 50, 'priority' => 2],
        ['type' => 'all', 'amount' => 5, 'total' => 0, 'priority' => 3],
        ['type' => 'all', 'amount' => -1, 'total' => 0, 'priority' => 4],
        ['type' => 'above', 'amount' => -1, 'total' => 0, 'priority' => 5],
        ['type' => 'below', 'amount' => -1, 'total' => 0, 'priority' => 6],
    ]);

    $coveredArea = new CoveredArea($model);
    $labels = $coveredArea->getConditionLabels();

    expect($labels)->toBeArray()->and($labels)->toHaveCount(6)
        ->and($labels[0])->toBe('£10.00 above £100.00')
        ->and($labels[1])->toBe('£5.00 below £50.00')
        ->and($labels[2])->toBe('£5.00 on all orders')
        ->and($labels[3])->toContain('not available on all orders')
        ->and($labels[4])->toContain('not available above')
        ->and($labels[5])->toContain('not available below');
});

it('access model attributes', function(): void {
    $model = Mockery::mock(LocationArea::class)->makePartial();
    $model->shouldReceive('getAttribute')->with('name')->andReturn('Area name');

    $coveredArea = new CoveredArea($model);

    expect($coveredArea->name)->toBe('Area name');
});
