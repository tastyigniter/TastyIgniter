<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models\Scopes;

use Igniter\Flame\Database\Builder;
use Igniter\Local\Models\Scopes\LocationScope;

it('applies position to builder with valid coordinates', function(): void {
    $builder = mock(Builder::class);
    $builder->shouldReceive('selectDistance')->with(12.345678, 98.765432)->andReturnSelf();

    $applyPosition = (new LocationScope)->addApplyPosition();
    $result = $applyPosition($builder, ['latitude' => 12.345678, 'longitude' => 98.765432]);

    expect($result)->toBe($builder);
});

it('selects distance in kilometers when distance unit is km', function(): void {
    setting()->set('distance_unit', 'km');
    $builder = mock(Builder::class);
    $builder->shouldReceive('selectRaw')->with(
        '( 6371 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) * cos( radians( location_lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( location_lat ) ) ) ) AS distance',
        [12.345678, 98.765432, 12.345678],
    )->andReturnSelf();

    $selectDistance = (new LocationScope)->addSelectDistance();
    $result = $selectDistance($builder, 12.345678, 98.765432);

    expect($result)->toBe($builder);
});

it('selects distance in miles when distance unit is miles', function(): void {
    setting()->set('distance_unit', 'miles');
    $builder = mock(Builder::class);
    $builder->shouldReceive('selectRaw')->with(
        '( 3959 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) * cos( radians( location_lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( location_lat ) ) ) ) AS distance',
        [12.345678, 98.765432, 12.345678],
    )->andReturnSelf();

    $selectDistance = (new LocationScope)->addSelectDistance();
    $result = $selectDistance($builder, 12.345678, 98.765432);

    expect($result)->toBe($builder);
});
