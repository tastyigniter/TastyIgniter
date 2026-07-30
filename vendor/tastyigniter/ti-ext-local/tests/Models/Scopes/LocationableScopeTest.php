<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models\Scopes;

use Igniter\Flame\Database\Builder;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\Scopes\LocationableScope;

it('applies where has location with single location id', function(): void {
    $location = Location::factory()->create();
    $builder = mock(Builder::class);
    $builder->shouldReceive('withoutGlobalScope')->andReturnSelf();
    $builder->shouldReceive('getModel->locationableRelationName')->andReturn('location');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getRelated->getKeyName')->andReturn('id');
    $builder->shouldReceive('getModel->locationableIsSingleRelationType')->andReturn(true);
    $builder->shouldReceive('whereIn')->with('id', [$location->getKey()])->andReturnSelf();

    $whereHasLocation = (new LocationableScope)->addWhereHasLocation();
    $result = $whereHasLocation($builder, $location);

    expect($result)->toBe($builder);
});

it('applies where has location with multiple location ids', function(): void {
    $builder = mock(Builder::class);
    $builder->shouldReceive('withoutGlobalScope')->andReturnSelf();
    $builder->shouldReceive('getModel->locationableRelationName')->andReturn('location');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getRelated->getKeyName')->andReturn('id');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getTable')->andReturn('menus');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getParent->getTable')->andReturn('menus');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getRelated->getKeyName')->andReturn('id');
    $builder->shouldReceive('getModel->locationableIsSingleRelationType')->andReturnFalse();
    $builder->shouldReceive('getModel->locationableIsMorphRelationType')->andReturnTrue();
    $builder->shouldReceive('whereHas')->andReturnSelf();
    $builder->shouldReceive('whereIn')->with('id', [1, 2])->andReturnSelf();

    $whereHasLocation = (new LocationableScope)->addWhereHasLocation();
    $result = $whereHasLocation($builder, [1, 2]);

    expect($result)->toBe($builder);
});

it('applies where has location with multiple location ids and nor morph type', function(): void {
    $builder = mock(Builder::class);
    $builder->shouldReceive('withoutGlobalScope')->andReturnSelf();
    $builder->shouldReceive('getModel->locationableRelationName')->andReturn('location');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getRelated->getKeyName')->andReturn('id');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getTable')->andReturn('menus');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getParent->getTable')->andReturn('menus');
    $builder->shouldReceive('getModel->getLocationableRelationObject->getRelated->getKeyName')->andReturn('id');
    $builder->shouldReceive('getModel->locationableIsSingleRelationType')->andReturnFalse();
    $builder->shouldReceive('getModel->locationableIsMorphRelationType')->andReturnFalse();
    $builder->shouldReceive('whereHas')->andReturnSelf();
    $builder->shouldReceive('whereIn')->with('id', [1, 2])->andReturnSelf();

    $whereHasLocation = (new LocationableScope)->addWhereHasLocation();
    $result = $whereHasLocation($builder, [1, 2]);

    expect($result)->toBe($builder);
});

it('applies where has or doesnt have location with single location id', function(): void {
    $builder = mock(Builder::class);
    $builder->shouldReceive('withoutGlobalScope')->andReturnSelf();
    $builder->shouldReceive('where')->andReturnUsing(function($callback) use ($builder) {
        $callback($builder);

        return $builder;
    });
    $builder->shouldReceive('whereHasLocation')->with(1)->andReturnSelf();
    $builder->shouldReceive('getModel->locationableIsSingleRelationType')->andReturn(true);
    $builder->shouldReceive('getModel->getLocationableRelationObject->getRelated->getKeyName')->andReturn('id');
    $builder->shouldReceive('orWhereNull')->with('id')->andReturnSelf();

    $whereHasOrDoesntHaveLocation = (new LocationableScope)->addWhereHasOrDoesntHaveLocation();
    $result = $whereHasOrDoesntHaveLocation($builder, 1);

    expect($result)->toBe($builder);
});

it('applies where has or doesnt have location with multiple location ids', function(): void {
    $builder = mock(Builder::class);
    $builder->shouldReceive('withoutGlobalScope')->andReturnSelf();
    $builder->shouldReceive('where')->andReturnUsing(function($callback) use ($builder) {
        $callback($builder);

        return $builder;
    });
    $builder->shouldReceive('whereHasLocation')->with([1, 2])->andReturnSelf();
    $builder->shouldReceive('getModel->locationableIsSingleRelationType')->andReturnFalse();
    $builder->shouldReceive('getModel->locationableRelationName')->andReturn('locations');
    $builder->shouldReceive('orWhereNull')->with('id')->andReturnSelf();
    $builder->shouldReceive('orDoesntHave')->with('locations')->andReturnSelf();

    $whereHasOrDoesntHaveLocation = (new LocationableScope)->addWhereHasOrDoesntHaveLocation();
    $result = $whereHasOrDoesntHaveLocation($builder, [1, 2]);

    expect($result)->toBe($builder);
});
