<?php

namespace Tests\Unit;

use App\Services\LocationContext;
use Igniter\Local\Models\Location;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class LocationContextTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_authorized_location_can_be_selected_and_tampered_session_is_rejected(): void
    {
        $context = $this->context([$this->location(10)]);
        Log::shouldReceive('info')->once();

        $this->assertSame(10, $context->set(10)->getKey());
        $this->assertSame(10, session(LocationContext::SESSION_KEY));

        session()->put(LocationContext::SESSION_KEY, 99);
        $this->assertNull($context->current());
        $this->assertFalse(session()->has(LocationContext::SESSION_KEY));
    }

    public function test_unauthorized_and_inactive_locations_are_denied(): void
    {
        $context = $this->context([$this->location(10), $this->location(11, false)]);

        $this->assertFalse($context->canAccess(11));
        $this->assertFalse($context->canAccess(99));
        Log::shouldReceive('warning')->once();
        $this->expectException(AuthorizationException::class);
        $context->set(99);
    }

    public function test_global_mode_requires_permission_and_has_no_transaction_location(): void
    {
        $context = $this->context([$this->location(10)], false);
        Log::shouldReceive('warning')->once();
        $this->expectException(AuthorizationException::class);
        $context->setGlobal();
    }

    public function test_permitted_global_mode_does_not_scope_reporting_query(): void
    {
        $context = $this->context([$this->location(10)], true);
        Log::shouldReceive('info')->once();
        $context->setGlobal();

        $this->assertTrue($context->isGlobal());
        $this->assertNull($context->currentId());
        $query = Mockery::mock(Builder::class);
        $this->assertSame($query, $context->scopeQuery($query));
    }

    public function test_current_location_scopes_operational_query(): void
    {
        $context = $this->context([$this->location(10)]);
        session()->put(LocationContext::SESSION_KEY, 10);
        $query = Mockery::mock(Builder::class);
        $query->shouldReceive('where')->once()->with('orders.location_id', 10)->andReturnSelf();

        $this->assertSame($query, $context->scopeQuery($query, 'orders.location_id'));
    }

    private function context(array $locations, bool $viewAll = false): LocationContext
    {
        $relation = Mockery::mock();
        $relation->shouldReceive('get')->andReturn(new Collection($locations));
        $user = Mockery::mock();
        $user->shouldReceive('isSuperUser')->andReturnFalse();
        $user->shouldReceive('locations')->andReturn($relation);
        $user->shouldReceive('hasPermission')->with('Restaurant.LocationContext.ViewAll')->andReturn($viewAll);
        $user->shouldReceive('hasPermission')->with('Admin.Locations')->andReturnFalse();
        $user->shouldReceive('getAuthIdentifier')->andReturn(5);

        return app(LocationContext::class)->forUser($user);
    }

    private function location(int $id, bool $active = true): Location
    {
        $location = new Location;
        $location->location_id = $id;
        $location->location_name = 'Branch '.$id;
        $location->location_status = $active;

        return $location;
    }
}
