<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Traits;

use Igniter\Admin\Models\Status;
use Igniter\Cart\Models\Menu;
use Igniter\Local\Facades\Location as LocationFacade;
use Igniter\Local\Models\Location;
use Igniter\Local\Traits\LocationAwareWidget;

beforeEach(function(): void {
    $this->traitObject = new class
    {
        use LocationAwareWidget;

        public function testIsLocationAware(array $config): bool
        {
            return $this->isLocationAware($config);
        }

        public function testLocationApplyScope($query, array $config = [])
        {
            return $this->locationApplyScope($query, $config);
        }
    };
});

it('returns true when location is aware and location check passes', function(): void {
    LocationFacade::shouldReceive('check')->andReturn(true);
    $config = ['locationAware' => true];

    $result = $this->traitObject->testIsLocationAware($config);

    expect($result)->toBeTrue();
});

it('returns false when location is not aware', function(): void {
    $config = ['locationAware' => false];

    $result = $this->traitObject->testIsLocationAware($config);

    expect($result)->toBeFalse();
});

it('applies location scope to location model', function(): void {
    $location = Location::factory()->create();
    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([$location->id]);
    $query = Location::query();
    $config = ['locationAware' => true];

    $this->traitObject->testLocationApplyScope($query, $config);

    expect($query->toSql())->toContain('where `location_id` in (?)');
});

it('does not apply location scope when model is not locationable', function(): void {
    $query = Status::query();
    $config = ['locationAware' => true];

    $this->traitObject->testLocationApplyScope($query, $config);

    expect($query->toSql())->not->toContain('where `location_id` in (?)');
});

it('does not apply location scope when location is not current or assigned', function(): void {
    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([]);
    $query = Menu::query();
    $config = ['locationAware' => true];

    $this->traitObject->testLocationApplyScope($query, $config);

    expect($query->toSql())->not->toContain('where `location_id` in (?)');
});

it('applies location scope to assigned only', function(): void {
    $location = Location::factory()->create();
    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([$location->id]);

    $query = Menu::query();
    $config = ['locationAware' => 'assignedOnly'];

    $this->traitObject->testLocationApplyScope($query, $config);

    expect($query->toSql())->toContain('where exists');
});

it('applies location scope', function(): void {
    $location = Location::factory()->create();
    LocationFacade::shouldReceive('currentOrAssigned')->andReturn([$location->id]);

    $query = Menu::query();
    $config = ['locationAware' => true];

    $this->traitObject->testLocationApplyScope($query, $config);

    expect($query->toSql())->toContain('`locationables`.`locationable_type` = ? and `locationables`.`location_id` in (?)) or not exists');
});
