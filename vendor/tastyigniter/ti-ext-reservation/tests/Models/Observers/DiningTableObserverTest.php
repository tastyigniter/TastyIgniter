<?php

declare(strict_types=1);

namespace Igniter\Reservation\Tests\Models\Observers;

use Igniter\Flame\Exception\SystemException;
use Igniter\Reservation\Models\DiningTable;
use Igniter\Reservation\Models\Observers\DiningTableObserver;
use Mockery;

it('fixes tree when saving dining table without left or right values', function(): void {
    $diningTable = Mockery::mock(DiningTable::class)->makePartial();
    $diningTable->shouldReceive('getRgt')->andReturn(null);
    $diningTable->shouldReceive('getLft')->andReturn(null);
    $diningTable->shouldReceive('fixTree')->once();

    (new DiningTableObserver)->saving($diningTable);
});

it('updates parent name when dining table is saved', function(): void {
    $children = collect([
        Mockery::mock(DiningTable::class)->makePartial(['name' => 'Child1']),
        Mockery::mock(DiningTable::class)->makePartial(['name' => 'Child2']),
    ]);
    $diningTable = Mockery::mock(DiningTable::class)->makePartial();
    $parent = Mockery::mock(DiningTable::class)->makePartial();
    $parent->children = $children;
    $parent->shouldReceive('saveQuietly')->once();
    $diningTable->shouldReceive('extendableGet')->with('parent_id')->andReturn(1);
    $diningTable->shouldReceive('extendableGet')->with('parent')->andReturn($parent);

    (new DiningTableObserver)->saved($diningTable);
});

it('throws exception when deleting dining table with parent', function(): void {
    $diningTable = Mockery::mock(DiningTable::class)->makePartial();
    $diningTable->shouldReceive('extendableGet')->with('parent_id')->andReturn(1);

    expect(fn() => (new DiningTableObserver)->deleting($diningTable))
        ->toThrow(SystemException::class);
});

it('saves descendants as root and fixes tree when deleting combo dining table', function(): void {
    $diningTable = Mockery::mock(DiningTable::class)->makePartial();
    $descendant = Mockery::mock(DiningTable::class)->makePartial();
    $diningTable->shouldReceive('extendableGet')->with('is_combo')->andReturnTrue();
    $diningTable->shouldReceive('descendants->each')->andReturnUsing(function($callback) use ($descendant): void {
        $callback($descendant);
    });
    $descendant->shouldReceive('saveAsRoot')->once();
    $diningTable->shouldReceive('refreshNode')->once();

    (new DiningTableObserver)->deleting($diningTable);
});
