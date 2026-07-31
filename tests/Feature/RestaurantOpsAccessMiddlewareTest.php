<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Http\Request;
use Mockery;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Http\Middleware\RequiresOperationalPermission;
use Naxas\RestaurantOps\Http\Middleware\RequiresTransactionalLocation;
use Naxas\RestaurantOps\Services\OperationalAccessService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

final class RestaurantOpsAccessMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config()->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
    }

    public function test_non_transactional_overview_and_configuration_access_do_not_require_location(): void
    {
        $access = new OperationalAccessService($this->contextWithoutLocation());
        $user = $this->authorizedUser();

        self::assertNull($access->denial($user, 'Restaurant.Operations.Access'));
        self::assertNull($access->denial($user, 'Restaurant.MenuConfig.View'));
    }

    public function test_missing_transactional_location_redirects_to_selector_with_actionable_message(): void
    {
        $guard = Mockery::mock();
        $guard->shouldReceive('user')->andReturn($this->authorizedUser());
        app()->instance('admin.auth', $guard);

        $request = Request::create('/admin/restaurant-ops/pos');
        $request->setLaravelSession(app('session')->driver());
        app()->instance('request', $request);
        $response = (new RequiresTransactionalLocation(new OperationalAccessService($this->contextWithoutLocation())))
            ->handle($request, fn () => response('unexpected'));

        self::assertTrue($response->isRedirect(route('admin.location-context.select')));
        self::assertSame('Select an active assigned location to continue.', session('restaurant_ops_location_message'));
    }

    public function test_missing_route_permission_uses_standard_forbidden_response(): void
    {
        $guard = Mockery::mock();
        $guard->shouldReceive('check')->andReturnTrue();
        $guard->shouldReceive('user')->andReturn($this->authorizedUser(false));
        app()->instance('admin.auth', $guard);

        $this->expectException(HttpException::class);
        $this->expectExceptionCode(0);

        (new RequiresOperationalPermission(new OperationalAccessService($this->contextWithoutLocation())))
            ->handle(Request::create('/admin/restaurant-ops/menu-configuration'), fn () => response('unexpected'), 'Restaurant.MenuConfig.View');
    }

    private function contextWithoutLocation(): LocationContextContract
    {
        $context = Mockery::mock(LocationContextContract::class);
        $context->shouldReceive('isGlobal')->andReturnFalse();
        $context->shouldReceive('current')->andReturnNull();

        return $context;
    }

    private function authorizedUser(bool $allowed = true): object
    {
        return new class($allowed)
        {
            public bool $status = true;

            public function __construct(private readonly bool $allowed) {}

            public function hasPermission(string $permission): bool
            {
                return $this->allowed;
            }
        };
    }
}
