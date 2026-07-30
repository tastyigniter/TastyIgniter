<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models;

use Igniter\Flame\Database\Attach\HasMedia;
use Igniter\Flame\Database\Traits\HasPermalink;
use Igniter\Local\Models\Concerns\HasDeliveryAreas;
use Igniter\Local\Models\Concerns\HasWorkingHours;
use Igniter\Local\Models\Concerns\LocationHelpers;
use Igniter\Local\Models\Location;
use Igniter\Local\Models\LocationArea;
use Igniter\Local\Models\Scopes\LocationScope;
use Igniter\System\Models\Concerns\Defaultable;
use Igniter\System\Models\Concerns\HasCountry;
use Igniter\System\Models\Concerns\Switchable;

it('returns dropdown options for enabled locations', function(): void {
    $location1 = Location::factory()->create(['location_name' => 'Location 1', 'location_status' => true]);
    $location2 = Location::factory()->create(['location_name' => 'Location 2', 'location_status' => false]);

    $result = Location::getDropdownOptions();

    expect($result)->toHaveKey($location1->getKey(), 'Location 1')
        ->and($result)->not->toHaveKey($location2->getKey());
});

it('checks if onboarding is complete with valid default location', function(): void {
    Location::clearDefaultModel();
    $location = Location::factory()->create([
        'location_lat' => '12.345678',
        'location_lng' => '98.765432',
    ]);
    $location->makeDefault();
    $location->delivery_areas()->save(LocationArea::factory()->create(['is_default' => true]));

    $result = Location::onboardingIsComplete();

    expect($result)->toBeTrue();
});

it('checks if onboarding is incomplete without default location', function(): void {
    Location::clearDefaultModel();
    $default = Location::getDefault();
    $default->delete();
    Location::clearDefaultModel();

    $result = Location::onboardingIsComplete();

    expect($result)->toBeFalse();
});

it('checks if onboarding is incomplete with default location missing coordinates', function(): void {
    $location = Location::factory()->create(['location_lat' => null, 'location_lng' => null]);
    $location->delivery_areas()->create(['is_default' => true]);

    $result = Location::onboardingIsComplete();

    expect($result)->toBeFalse();
});

it('checks if onboarding is incomplete with default location missing delivery areas', function(): void {
    Location::factory()->create(['location_lat' => '12.345678', 'location_lng' => '98.765432']);

    $result = Location::onboardingIsComplete();

    expect($result)->toBeFalse();
});

it('applies filters to query builder', function(): void {
    $query = Location::query()->applyFilters([
        'enabled' => 1,
        'position' => [['latitude' => 1, 'longitude' => 2]],
        'sort' => 'location_name desc',
        'search' => 'Location category',
    ]);

    expect($query->toSql())
        ->toContain('`locations`.`location_status` = ?')
        ->toContain('radians( location_lat )', 'radians( location_lng )', ' AS distance')
        ->toContain('lower(location_name) like ?', 'lower(location_address_1) like ?', 'lower(description) like ?')
        ->toContain('order by `location_name` desc');
});

it('configures location model correctly', function(): void {
    $location = new Location;
    $location->location_name = 'Location Name';

    expect(class_uses_recursive($location))
        ->toContain(Defaultable::class)
        ->toContain(HasCountry::class)
        ->toContain(HasDeliveryAreas::class)
        ->toContain(HasMedia::class)
        ->toContain(HasPermalink::class)
        ->toContain(HasWorkingHours::class)
        ->toContain(LocationHelpers::class)
        ->toContain(Switchable::class)
        ->and($location->getTable())->toBe('locations')
        ->and($location->getKeyName())->toBe('location_id')
        ->and($location->timestamps)->toBeTrue()
        ->and($location->getCasts())->toHaveKeys(['location_lat', 'location_lng'])
        ->and($location->getMorphClass())->toBe('locations')
        ->and($location->getGlobalScopes())->toHaveKey(LocationScope::class)
        ->and($location->relation)->toBeArray()
        ->and($location->getPurgeableAttributes())->toContain('options', 'delivery_areas')
        ->and($location->permalinkable)->toBe([
            'permalink_slug' => [
                'source' => 'location_name',
                'controller' => 'local',
            ],
        ])
        ->and($location->mediable)->toBe([
            'thumb',
            'gallery' => ['multiple' => true],
        ])
        ->and($location->defaultableName())->toBe('Location Name')
        ->and($location->location_thumb)->toBeNull();
});
