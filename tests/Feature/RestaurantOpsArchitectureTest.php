<?php

declare(strict_types=1);

namespace Tests\Feature;

use Igniter\Cart\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Naxas\RestaurantOps\Http\Controllers\AdminPageController;
use Naxas\RestaurantOps\Http\Controllers\MenuConfiguration\MenuConfigurations;
use Naxas\RestaurantOps\Http\Controllers\MenuIntegration\OrderItemSnapshots;
use Naxas\RestaurantOps\Http\Controllers\OperationalLandings;
use Naxas\RestaurantOps\Http\Controllers\Pos\PosOrders;
use Naxas\RestaurantOps\Http\Controllers\Shifts\CashierShifts;
use ReflectionClass;
use ReflectionNamedType;
use Tests\TestCase;

class RestaurantOpsArchitectureTest extends TestCase
{
    public function test_admin_page_actions_do_not_depend_on_injected_requests_or_models(): void
    {
        foreach ($this->adminPageControllers() as $controller) {
            $reflection = new ReflectionClass($controller);
            self::assertTrue($reflection->getStaticPropertyValue('skipRouteRegister'));

            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->getDeclaringClass()->getName() !== $controller || in_array($method->getName(), ['__construct', 'callAction'], true)) {
                    continue;
                }

                foreach ($method->getParameters() as $parameter) {
                    $type = $parameter->getType();
                    if (! $type instanceof ReflectionNamedType || $type->isBuiltin()) {
                        continue;
                    }

                    self::assertFalse(is_a($type->getName(), Request::class, true), "$controller::{$method->getName()} injects Request");
                    self::assertFalse(is_a($type->getName(), FormRequest::class, true), "$controller::{$method->getName()} injects FormRequest");
                    self::assertFalse(is_a($type->getName(), Model::class, true), "$controller::{$method->getName()} relies on model binding");
                }
            }
        }
    }

    public function test_restaurant_ops_routes_are_unique_resolvable_and_outside_official_locations_namespace(): void
    {
        $names = [];
        foreach (app('router')->getRoutes() as $route) {
            $name = $route->getName();
            if (! is_string($name) || ! str_starts_with($name, 'naxas.restaurantops.')) {
                continue;
            }

            self::assertArrayNotHasKey($name, $names, "Duplicate route name: $name");
            $names[$name] = true;
            self::assertStringNotContainsString('/locations', '/'.$route->uri());
            self::assertStringNotContainsString('Dashboard', $route->getActionName());

            [$controller, $method] = explode('@', $route->getActionName());
            self::assertTrue(class_exists($controller), "Missing route controller: $controller");
            self::assertTrue(method_exists($controller, $method), "Missing route action: {$route->getActionName()}");
        }

        self::assertArrayHasKey('naxas.restaurantops.location-context.select', $names);
    }

    public function test_official_menu_is_the_only_catalog_record_owned_by_menu_operations(): void
    {
        self::assertSame(Menu::class, (new ReflectionClass(Menu::class))->getName());
        $controller = file_get_contents(base_path('extensions/naxas/restaurantops/src/Http/Controllers/MenuConfiguration/MenuConfigurations.php'));
        self::assertStringContainsString('Menu::query()->findOrFail($menuId)', $controller);
        self::assertStringNotContainsString('new Menu', $controller);
        self::assertStringNotContainsString('$menu->fill(', $controller);
        self::assertStringNotContainsString('$menu->save', $controller);
    }

    /** @return array<class-string<AdminPageController>> */
    private function adminPageControllers(): array
    {
        return [
            OperationalLandings::class,
            MenuConfigurations::class,
            OrderItemSnapshots::class,
            PosOrders::class,
            CashierShifts::class,
        ];
    }
}
