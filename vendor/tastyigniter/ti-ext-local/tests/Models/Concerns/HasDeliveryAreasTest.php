<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models\Concerns;

use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\LocationArea;

it('geocodes address on save', function(): void {
    $location = Location::factory()->create();

    $lat = 37.7749295;
    $lng = -122.4194155;
    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => $lat,
            'longitude' => $lng,
        ]),
    ]));

    $location->is_auto_lat_lng = true;
    $location->location_lat = null;
    $location->location_lng = null;
    $location->save();

    expect($location->location_lat)->toBe($lat)
        ->and($location->location_lng)->toBe($lng);
});

it('does not geocode address if coordinates already exists and not dirty', function(): void {
    $location = Location::factory()->createQuietly([
        'location_lat' => 37.7749295,
        'location_lng' => -122.4194155,
        'location_country_id' => 123,
        'is_auto_lat_lng' => true,
    ]);

    $location->save();

    expect($location->location_lat)->toBe(37.7749295)
        ->and($location->location_lng)->toBe(-122.4194155);
});

it('searchOrDefaultDeliveryArea returns the matching delivery area if found', function(): void {
    $location = Location::factory()->create();
    $area1 = LocationArea::factory()->create([
        'type' => 'address',
        'conditions' => ['min_total' => 10],
        'boundaries' => [],
        'is_default' => true,
    ]);
    $area2 = LocationArea::factory()->create([
        'type' => 'polygon',
        'conditions' => ['min_total' => 20],
        'boundaries' => ['vertices' => '[{"lat":51.525998393642936,"lng":-0.13086516710191232},{"lat":51.506999160557775,"lng":-0.13052184434800607},{"lat":51.50651835413632,"lng":-0.17409930227410442},{"lat":51.526225344669776,"lng":-0.17351994512688762}]'],
    ]);
    $location->delivery_areas()->saveMany([$area1, $area2]);
    $coordinates = GeoliteLocation::createFromArray([
        'latitude' => 51.50987615,
        'longitude' => -0.1446716,
    ])->getCoordinates();

    $result = $location->searchOrDefaultDeliveryArea($coordinates);

    expect($result->getKey())->toBe($area2->getKey());
});

it('searchOrFirstDeliveryArea returns the matching delivery area if found', function(): void {
    $location = Location::factory()->create();
    $area1 = LocationArea::factory()->create([
        'type' => 'address',
        'conditions' => ['min_total' => 10],
        'boundaries' => [],
        'is_default' => true,
    ]);
    $area2 = LocationArea::factory()->create([
        'type' => 'polygon',
        'conditions' => ['min_total' => 20],
        'boundaries' => ['vertices' => '[{"lat":51.525998393642936,"lng":-0.13086516710191232},{"lat":51.506999160557775,"lng":-0.13052184434800607},{"lat":51.50651835413632,"lng":-0.17409930227410442},{"lat":51.526225344669776,"lng":-0.17351994512688762}]'],
    ]);
    $location->delivery_areas()->saveMany([$area1, $area2]);
    $coordinates = GeoliteLocation::createFromArray([
        'latitude' => 51.50987615,
        'longitude' => -0.1446716,
    ])->getCoordinates();

    $result = $location->searchOrFirstDeliveryArea($coordinates);

    expect($result->getKey())->toBe($area2->getKey());
});

it('searchOrFirstDeliveryArea returns the first delivery area if matching not found', function(): void {
    $location = Location::factory()->create();
    $area1 = LocationArea::factory()->create([
        'type' => 'address',
        'conditions' => ['min_total' => 10],
        'boundaries' => [],
    ]);
    $area2 = LocationArea::factory()->create([
        'type' => 'polygon',
        'conditions' => ['min_total' => 20],
        'boundaries' => ['vertices' => '[{"lat":51.525998393642936,"lng":-0.13086516710191232},{"lat":51.506999160557775,"lng":-0.13052184434800607},{"lat":51.50651835413632,"lng":-0.17409930227410442},{"lat":51.526225344669776,"lng":-0.17351994512688762}]'],
    ]);
    $location->delivery_areas()->saveMany([$area1, $area2]);
    $coordinates = GeoliteLocation::createFromArray([
        'latitude' => 51.5086367,
        'longitude' => -0.2200662,
    ])->getCoordinates();

    $result = $location->searchOrFirstDeliveryArea($coordinates);

    expect($result->getKey())->toBe($area1->getKey());
});

it('adds delivery areas on save', function(): void {
    $location = Location::factory()->create();

    $location->delivery_areas = [
        ['area_id' => 1, 'conditions' => ['min_total' => 10]],
        ['area_id' => 2, 'conditions' => ['min_total' => 20]],
    ];

    $location->save();

    expect($location->delivery_areas()->count())->toBe(2);
});
