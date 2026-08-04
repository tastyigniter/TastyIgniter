<?php

namespace Tests\Feature;

use App\Http\Middleware\ResolveLocationContext;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class LocationContextRoutesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config()->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
    }

    public function test_selector_routes_are_registered_without_replacing_existing_admin_login(): void
    {
        $this->assertNotNull(app('router')->getRoutes()->getByName('igniter.admin.login'));
        $this->assertNotNull(app('router')->getRoutes()->getByName('naxas.restaurantops.location-context.select'));
        $this->assertNotNull(app('router')->getRoutes()->getByName('naxas.restaurantops.location-context.switch'));
        $this->assertNotNull(app('router')->getRoutes()->getByName('naxas.restaurantops.location-context.global'));
    }

    public function test_unauthenticated_json_selector_request_has_structured_error(): void
    {
        $guard = Mockery::mock();
        $guard->shouldReceive('check')->once()->andReturnFalse();
        app()->instance('admin.auth', $guard);
        $request = Request::create('/admin/locations/select', 'GET', server: ['HTTP_ACCEPT' => 'application/json']);
        $response = app(ResolveLocationContext::class)->handle($request, fn () => response('unexpected'));

        $this->assertSame(401, $response->getStatusCode());
        $this->assertSame(['error' => [
            'code' => 'authentication_required',
            'message' => 'Authentication is required.',
        ]], $response->getData(true));
    }
}
