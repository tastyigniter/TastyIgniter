<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Coordinates;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Models\Location as LocationModel;
use Igniter\Local\Models\LocationArea;
use Igniter\System\Models\Concerns\Defaultable;

it('returns correct conditions attribute', function(): void {
    $locationArea = LocationArea::factory()->create([
        'conditions' => [
            ['type' => 'above', 'amount' => 10.0, 'total' => 100.0],
        ],
    ]);

    $result = $locationArea->conditions;

    expect($result)->toBeArray()
        ->and($result[0]['type'])->toBe('above')
        ->and($result[0]['amount'])->toBe(10)
        ->and($result[0]['total'])->toBe(100);
});

it('returns correct vertices attribute', function(): void {
    $locationArea = LocationArea::factory()->create([
        'boundaries' => ['vertices' => json_encode([['lat' => 12.345678, 'lng' => 98.765432]])],
    ]);

    $result = $locationArea->vertices;

    expect($result)->toBeArray()
        ->and($result[0]->lat)->toBe(12.345678)
        ->and($result[0]->lng)->toBe(98.765432);
});

it('returns empty vertices attribute when boundaries are not set', function(): void {
    $locationArea = LocationArea::factory()->create(['boundaries' => []]);

    $result = $locationArea->vertices;

    expect($result)->toBeArray()
        ->and($result)->toBeEmpty();
});

it('returns correct circle attribute', function(): void {
    $locationArea = LocationArea::factory()->create([
        'boundaries' => [
            'circle' => json_encode(['lat' => 12.345678, 'lng' => 98.765432, 'radius' => 1000]),
        ],
    ]);

    $result = $locationArea->circle;

    expect($result)->toBeObject()
        ->and($result->lat)->toBe(12.345678)
        ->and($result->lng)->toBe(98.765432)
        ->and($result->radius)->toBe(1000);
});

it('returns null circle attribute when boundaries are not set', function(): void {
    $locationArea = LocationArea::factory()->create(['boundaries' => []]);

    $result = $locationArea->circle;

    expect($result)->toBeNull();
});

it('returns correct color attribute when value is set', function(): void {
    $locationArea = LocationArea::factory()->create(['color' => '#FFFFFF']);

    $result = $locationArea->color;

    expect($result)->toBe('#FFFFFF');
});

it('returns random color attribute when value is not set', function(): void {
    $locationArea = LocationArea::factory()->create(['color' => '']);

    $result = $locationArea->color;

    expect($result)->not->toBe('')
        ->and(in_array($result, LocationArea::$areaColors))->toBeTrue();
});

it('returns location id attribute', function(): void {
    $locationArea = LocationArea::factory()->create(['location_id' => 123]);

    $result = $locationArea->getLocationId();

    expect($result)->toBe(123);
});

it('checks if boundary is address type', function(): void {
    $locationArea = LocationArea::factory()->create(['type' => 'address']);

    $result = $locationArea->isAddressBoundary();

    expect($result)->toBeTrue();
});

it('checks if boundary is polygon type', function(): void {
    $locationArea = LocationArea::factory()->create(['type' => 'polygon']);

    $result = $locationArea->isPolygonBoundary();

    expect($result)->toBeTrue();
});

it('pointInVertices returns false when vertices is empty', function(): void {
    $locationArea = LocationArea::factory()->create(['boundaries' => []]);
    $coordinate = mock(CoordinatesInterface::class);

    $result = $locationArea->pointInVertices($coordinate);

    expect($result)->toBeFalse();
});

it('pointInCircle returns false when circle is empty', function(): void {
    $locationArea = LocationArea::factory()->create(['boundaries' => []]);
    $coordinate = mock(CoordinatesInterface::class);

    $result = $locationArea->pointInCircle($coordinate);

    expect($result)->toBeFalse();
});

it('checks if point is inside polygon vertices', function(): void {
    $locationArea = LocationArea::factory()->create([
        'boundaries' => [
            'vertices' => json_encode([['lat' => 12.345678, 'lng' => 98.765432]]),
        ],
    ]);
    $coordinate = mock(CoordinatesInterface::class);
    $coordinate->shouldReceive('getLatitude')->andReturn(12.345678);
    $coordinate->shouldReceive('getLongitude')->andReturn(98.765432);

    $result = $locationArea->pointInVertices($coordinate);

    expect($result)->toBeTrue();
});

it('checks if point is outside polygon vertices', function(): void {
    $locationArea = LocationArea::factory()->create([
        'boundaries' => [
            'vertices' => json_encode([['lat' => 12.345678, 'lng' => 98.765432]]),
        ],
    ]);
    $coordinate = mock(CoordinatesInterface::class);
    $coordinate->shouldReceive('getLatitude')->andReturn(0.0);
    $coordinate->shouldReceive('getLongitude')->andReturn(0.0);

    $result = $locationArea->pointInVertices($coordinate);

    expect($result)->toBeFalse();
});

it('checks if point is inside circle boundary', function(): void {
    $locationArea = LocationArea::factory()->create([
        'boundaries' => [
            'circle' => json_encode(['lat' => 12.345678, 'lng' => 98.765432, 'radius' => 1000]),
        ],
    ]);
    $coordinate = new Coordinates(12.345678, 98.765432);

    $result = $locationArea->pointInCircle($coordinate);

    expect($result)->toBeTrue();
});

it('checks if point is outside circle boundary', function(): void {
    $locationArea = LocationArea::factory()->create([
        'boundaries' => [
            'circle' => json_encode(['lat' => 12.345678, 'lng' => 98.765432, 'radius' => 1000]),
        ],
    ]);
    $coordinate = new Coordinates(0.0, 0.0);

    $result = $locationArea->pointInCircle($coordinate);

    expect($result)->toBeFalse();
});

it('checks if point is inside address boundary', function(): void {
    $locationArea = LocationArea::factory()->create([
        'type' => 'address',
        'boundaries' => [
            'components' => [
                ['type' => 'locality', 'value' => 'White City'],
                ['type' => 'postal_code', 'value' => 'Country'], // Invalid postal code
            ],
        ],
    ]);
    $coordinate = new Coordinates(51.5086367, -0.2200662);
    $address = new GeoliteLocation('google');
    $address->setPostalCode('WC2H 9FA');
    $address->addAdminLevel(2, 'Greater London', 'Greater London');
    $address->setCountryName('United Kingdom');
    $address->setCountryCode('GB');
    Geocoder::shouldReceive('reverse')->with(51.5086367, -0.2200662)->andReturn(collect([$address]));

    $result = $locationArea->checkBoundary($coordinate);

    expect($result)->toBeFalse();
});

it('configures location area model correctly', function(): void {
    $locationArea = new LocationArea;

    expect(class_uses_recursive($locationArea))
        ->toContain(Defaultable::class)
        ->toContain(Sortable::class)
        ->and($locationArea->getTable())->toBe('location_areas')
        ->and($locationArea->getKeyName())->toBe('area_id')
        ->and($locationArea->getFillable())->toEqual([
            'area_id', 'type', 'name', 'boundaries', 'conditions', 'priority', 'is_default',
        ])
        ->and($locationArea->relation)->toEqual([
            'belongsTo' => [
                'location' => [LocationModel::class],
            ],
        ])
        ->and($locationArea->getCasts())->toEqual([
            'area_id' => 'int',
            'boundaries' => 'array',
            'conditions' => 'array',
            'is_default' => 'boolean',
        ])
        ->and($locationArea->getAppends())->toContain('vertices', 'circle')
        ->and(LocationArea::$areaColors)->toEqual([
            '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
            '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
            '#F16745', '#FFC65D', '#7BC8A4', '#4CC3D9', '#93648D', '#404040',
            '#F16745', '#FFC65D',
        ]);
});
