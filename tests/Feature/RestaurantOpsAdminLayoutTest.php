<?php

declare(strict_types=1);

namespace Tests\Feature;

use Igniter\Admin\Classes\AdminController;
use Igniter\Flame\Support\Facades\Igniter;
use Naxas\RestaurantOps\Http\Controllers\MenuConfiguration\MenuConfigurations;
use Naxas\RestaurantOps\Http\Controllers\MenuIntegration\OrderItemSnapshots;
use Naxas\RestaurantOps\Http\Controllers\OperationalLandings;
use Naxas\RestaurantOps\Http\Controllers\Pos\PosOrders;
use Naxas\RestaurantOps\Http\Controllers\Shifts\CashierShifts;
use Tests\TestCase;

final class RestaurantOpsAdminLayoutTest extends TestCase
{
    public function test_every_html_controller_uses_the_native_admin_controller(): void
    {
        foreach ([OperationalLandings::class, MenuConfigurations::class, OrderItemSnapshots::class, PosOrders::class, CashierShifts::class] as $controller) {
            self::assertTrue(is_subclass_of($controller, AdminController::class), $controller);
        }
    }

    public function test_extension_views_are_admin_content_fragments_without_a_duplicate_shell(): void
    {
        $root = base_path('extensions/naxas/restaurantops/resources/views');

        $views = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root));
        foreach ($views as $view) {
            if (! $view->isFile() || $view->getExtension() !== 'php') {
                continue;
            }
            $path = $view->getPathname();
            $contents = file_get_contents($path);
            self::assertStringNotContainsString('<html', strtolower($contents), $path);
            self::assertStringNotContainsString('<head', strtolower($contents), $path);
            self::assertStringNotContainsString('<body', strtolower($contents), $path);
            self::assertStringNotContainsString('@extends(', $contents, $path);
            self::assertStringNotContainsString('<link ', strtolower($contents), $path);
        }
    }

    public function test_overview_defines_native_shell_context_and_permission_aware_named_actions(): void
    {
        $controller = file_get_contents(base_path('extensions/naxas/restaurantops/src/Http/Controllers/OperationalLandings.php'));
        $view = file_get_contents(base_path('extensions/naxas/restaurantops/resources/views/landing.blade.php'));
        $base = file_get_contents(base_path('extensions/naxas/restaurantops/src/Http/Controllers/AdminPageController.php'));

        self::assertStringContainsString("\$workspace === 'overview' ? 'overview'", $controller);
        self::assertStringContainsString('OperationalAccessService', $controller);
        self::assertStringContainsString("route(\$requiresSelection ? 'admin.location-context.select' : \$module['route'])", $controller);
        self::assertStringContainsString("AdminMenu::setContext(\$menuItem, 'restaurant-operations')", $base);
        self::assertStringContainsString('Template::setTitle($title)', $base);
        self::assertStringContainsString("route('admin.location-context.select')", $view);
        self::assertStringNotContainsString('Restaurant.POS.Access', $view);
        self::assertStringNotContainsString('admin_url(', $view);
        self::assertStringNotContainsString('Module foundation. Functional workflows', $view);
        self::assertStringContainsString('Restaurant Operations foundation is active.', $view);
    }

    public function test_admin_uri_remains_configurable_for_restaurant_ops_routes(): void
    {
        self::assertStringStartsWith(Igniter::adminUri().'/', route('naxas.restaurantops.overview', absolute: false));
    }
}
