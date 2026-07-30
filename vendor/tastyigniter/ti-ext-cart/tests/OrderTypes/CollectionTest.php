<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\OrderTypes;

use Igniter\Cart\OrderTypes\Collection;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\Location as LocationModel;

beforeEach(function(): void {
    $location = LocationModel::factory()->create();
    $this->settings = $location->settings()->create([
        'item' => LocationModel::COLLECTION,
        'data' => ['lead_time' => 60],
    ]);
    $this->collection = new Collection($location, [
        'code' => LocationModel::COLLECTION, 'name' => 'Collection',
    ]);
});

it('returns open description correctly', function(): void {
    expect($this->collection->getOpenDescription())->toContain(60);
});

it('returns opening description correctly', function(): void {
    expect($this->collection->getOpeningDescription('ddd hh:mm a'))->toContain('12:00 am');
});

it('returns closed description correctly', function(): void {
    expect($this->collection->getClosedDescription())->toBe(sprintf(
        lang('igniter.cart::default.text_collection_time_info'),
        lang('igniter.local::default.text_is_closed')
    ));
});

it('returns disabled description correctly', function(): void {
    expect($this->collection->getDisabledDescription())->toBe(lang('igniter.cart::default.text_collection_is_disabled'));
});

it('returns active status correctly', function(): void {
    Location::shouldReceive('orderType')->once()->andReturn('collection');

    expect($this->collection->isActive())->toBeTrue();
});

it('returns disabled status correctly', function(): void {
    $this->settings->update([
        'item' => LocationModel::COLLECTION,
        'data' => ['is_enabled' => 0],
    ]);

    expect($this->collection->isDisabled())->toBeTrue();
});
