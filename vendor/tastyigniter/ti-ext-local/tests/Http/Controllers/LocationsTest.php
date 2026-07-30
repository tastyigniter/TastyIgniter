<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Http\Controllers;

use Igniter\Flame\Geolite\Facades\Geocoder;
use Igniter\Flame\Geolite\Model\Location as GeoliteLocation;
use Igniter\Local\Models\Location;

it('loads locations page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.local.locations'))
        ->assertOk();
});

it('loads create location page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.local.locations', ['slug' => 'create']))
        ->assertOk();
});

it('loads edit location page', function(): void {
    $location = Location::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.local.locations', ['slug' => 'edit/'.$location->getKey()]))
        ->assertOk();
});

it('loads location settings page', function(): void {
    $location = Location::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.local.locations', ['slug' => 'settings/'.$location->getKey()]))
        ->assertOk();
});

it('loads location preview page', function(): void {
    $location = Location::factory()->create();

    actingAsSuperUser()
        ->get(route('igniter.local.locations', ['slug' => 'preview/'.$location->getKey()]))
        ->assertOk();
});

it('sets a default location', function(): void {
    $location = Location::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.local.locations'), [
            'default' => $location->getKey(),
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSetDefault',
        ]);

    Location::clearDefaultModel();
    expect(Location::getDefaultKey())->toBe($location->getKey());
});

it('creates location', function(): void {
    actingAsSuperUser()
        ->post(route('igniter.local.locations', ['slug' => 'create']), [
            'Location' => [
                'location_name' => 'Created Location',
                'location_email' => 'location@domain.tld',
                'location_telephone' => '1234567890',
                'location_address_1' => '123 Street',
                'location_city' => 'City',
                'location_state' => 'State',
                'location_postcode' => '12345',
                'location_country_id' => 1,
                'location_status' => 1,
                'is_auto_lat_lng' => 0,
                'location_lat' => '0.01',
                'location_lng' => '0.01',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Location::where('location_name', 'Created Location')->exists())->toBeTrue();
});

it('creates location with auto fetch coordinates', function(): void {
    $lat = 37.774930;
    $lng = -122.419416;
    Geocoder::shouldReceive('geocode')->andReturn(collect([
        GeoliteLocation::createFromArray([
            'latitude' => $lat,
            'longitude' => $lng,
        ]),
    ]));

    actingAsSuperUser()
        ->post(route('igniter.local.locations', ['slug' => 'create']), [
            'Location' => [
                'location_name' => 'Created Location',
                'location_email' => 'location@domain.tld',
                'location_telephone' => '1234567890',
                'location_address_1' => '123 Street',
                'location_city' => 'City',
                'location_state' => 'State',
                'location_postcode' => '12345',
                'location_country_id' => 1,
                'location_status' => 1,
                'is_auto_lat_lng' => 1,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Location::where([
        ['location_name', 'Created Location'],
        ['location_lat', $lat],
        ['location_lng', $lng],
    ])->exists())->toBeTrue();
});

it('updates location', function(): void {
    $location = Location::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.local.locations', ['slug' => 'edit/'.$location->getKey()]), [
            'Location' => [
                'location_name' => 'Updated Location',
                'location_email' => 'location@domain.tld',
                'location_telephone' => '1234567890',
                'location_address_1' => '123 Street',
                'location_city' => 'City',
                'location_state' => 'State',
                'location_postcode' => '12345',
                'location_country_id' => 1,
                'location_status' => 1,
                'is_auto_lat_lng' => 0,
                'location_lat' => '0.01',
                'location_lng' => '0.01',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(Location::where('location_name', 'Updated Location')->exists())->toBeTrue();
});

it('updates location settings', function(): void {
    $location = Location::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.local.locations', ['slug' => 'settings/'.$location->getKey()]), [
            'Location' => [
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ])
        ->assertOk();
});

it('deletes location', function(): void {
    $location = Location::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.local.locations', ['slug' => 'edit/'.$location->getKey()]), [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(Location::where('location_id', $location->getKey())->exists())->toBeFalse();
});
