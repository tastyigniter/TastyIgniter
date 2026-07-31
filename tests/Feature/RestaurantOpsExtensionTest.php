<?php

namespace Tests\Feature;

use App\Services\LocationContext;
use Igniter\Local\Models\Location;
use Igniter\System\Classes\ExtensionManager;
use Igniter\User\Models\User;
use Illuminate\Support\Facades\Route;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Extension;
use Naxas\RestaurantOps\Integrations\AdminRouteAdapter;
use Naxas\RestaurantOps\Integrations\LocationAdapter;
use Naxas\RestaurantOps\Integrations\MenuAdapter;
use Naxas\RestaurantOps\Integrations\OrderAdapter;
use Naxas\RestaurantOps\Integrations\PaymentAdapter;
use Naxas\RestaurantOps\Integrations\ReservationAdapter;
use Naxas\RestaurantOps\Integrations\StaffAdapter;
use Tests\TestCase;

class RestaurantOpsExtensionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config()->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
    }

    public function test_extension_is_discovered_and_metadata_is_valid(): void
    {
        $extension = app(ExtensionManager::class)->findExtension('Naxas.RestaurantOps');

        $this->assertInstanceOf(Extension::class, $extension);
        $this->assertSame('Restaurant Operations', $extension->extensionMeta()['name']);
        $manifest = json_decode(file_get_contents(base_path('extensions/naxas/restaurantops/composer.json')), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('0.1.0', $manifest['version']);
    }

    public function test_contract_resolves_to_unchanged_scoped_application_service(): void
    {
        $context = app(LocationContextContract::class);

        $this->assertInstanceOf(LocationContext::class, $context);
        $this->assertSame($context, app(LocationContextContract::class));
    }

    public function test_location_permissions_and_routes_are_registered_exactly_once(): void
    {
        $permissions = app(ExtensionManager::class)->findExtension('Naxas.RestaurantOps')->registerPermissions();
        $expected = ['Restaurant.LocationContext.Access', 'Restaurant.LocationContext.Switch', 'Restaurant.LocationContext.ViewAll', 'Restaurant.LocationContext.Manage'];

        $this->assertSame($expected, array_keys($permissions));
        foreach (['select', 'switch', 'global'] as $route) {
            $name = 'admin.location-context.'.$route;
            $this->assertNotNull(Route::getRoutes()->getByName($name));
            $this->assertCount(1, collect(Route::getRoutes())->filter(fn ($registered): bool => $registered->getName() === $name));
        }
    }

    public function test_public_upstream_integration_seams_are_available(): void
    {
        foreach ([StaffAdapter::class, LocationAdapter::class, OrderAdapter::class, MenuAdapter::class,
            ReservationAdapter::class, PaymentAdapter::class] as $adapter) {
            $this->assertTrue(app($adapter)->available(), $adapter.' official model is unavailable');
        }

        $this->assertTrue(is_callable([new User, 'locations']));
        $this->assertTrue((new Location)->isFillable('location_status'));
        $this->assertSame(config('igniter-routes.adminUri', '/admin'), app(AdminRouteAdapter::class)->uri());
    }

    public function test_foundation_has_no_schema_or_destructive_lifecycle_hook(): void
    {
        $path = base_path('extensions/naxas/restaurantops/database/migrations');

        $this->assertDirectoryDoesNotExist($path);
        $this->assertFalse(method_exists(Extension::class, 'uninstall'));
        $extension = app(ExtensionManager::class)->findExtension('Naxas.RestaurantOps');
        $this->assertSame([], $extension->registerNavigation());
    }
}
