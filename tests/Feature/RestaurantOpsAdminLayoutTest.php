<?php

declare(strict_types=1);

namespace Tests\Feature;

use Igniter\Admin\Classes\AdminController;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
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
        self::assertStringContainsString("route(\$requiresSelection ? 'naxas.restaurantops.location-context.select' : \$module['route'])", $controller);
        self::assertStringContainsString("AdminMenu::setContext(\$menuItem, 'restaurant-operations')", $base);
        self::assertStringContainsString('Template::setTitle($title)', $base);
        self::assertStringContainsString("Template::setBlock('body', \$contents)", $base);
        self::assertStringContainsString('return $this->makeLayout()', $base);
        self::assertStringNotContainsString('$this->makeView($view', $base);
        self::assertStringContainsString("route('naxas.restaurantops.location-context.select')", $view);
        self::assertStringNotContainsString('Restaurant.POS.Access', $view);
        self::assertStringNotContainsString('admin_url(', $view);
        self::assertStringNotContainsString('Module foundation. Functional workflows', $view);
        self::assertStringContainsString('Restaurant Operations foundation is active.', $view);
    }

    public function test_overview_view_contract_renders_empty_optional_business_data_without_error(): void
    {
        view()->addNamespace('Naxas.RestaurantOps', base_path('extensions/naxas/restaurantops/resources/views'));

        $html = view('Naxas.RestaurantOps::landing', $this->overviewData())->render();

        self::assertStringContainsString('Operations Overview', $html);
        self::assertStringContainsString('No active branches assigned', $html);
        self::assertStringContainsString('Customized / non-operational', $html);
        self::assertStringContainsString('No additional operational modules are assigned', $html);
        self::assertStringContainsString('Select an active assigned branch', $html);
        self::assertStringNotContainsString('Naxas.RestaurantOps::', $html);
        self::assertStringNotContainsString('<html', strtolower($html));
    }

    public function test_overview_view_contract_renders_normalized_location_and_quick_action(): void
    {
        view()->addNamespace('Naxas.RestaurantOps', base_path('extensions/naxas/restaurantops/resources/views'));
        $location = new class extends Model
        {
            protected $guarded = [];
        };
        $location->forceFill(['location_name' => 'Ottoman Xpress']);
        $data = $this->overviewData() + [];
        $data['activeLocation'] = $location;
        $data['activeLocationLabel'] = 'Ottoman Xpress';
        $data['assignedLocations'] = new EloquentCollection([$location]);
        $data['assignedLocationCount'] = 1;
        $data['accessibleModuleCount'] = 1;
        $data['quickActions'] = collect([['label' => 'POS', 'icon' => 'fa-cash-register', 'url' => route('naxas.restaurantops.pos')]]);
        $data['transactionalContextReady'] = true;
        $data['readiness']['locationSelected'] = true;
        $data['readiness']['assignedToActive'] = true;
        $data['readiness']['transactionalReady'] = true;
        $data['readinessMessages'] = collect();

        $html = view('Naxas.RestaurantOps::landing', $data)->render();

        self::assertStringContainsString('Ottoman Xpress', $html);
        self::assertStringContainsString('POS', $html);
        self::assertStringContainsString(route('naxas.restaurantops.pos'), $html);
        self::assertStringNotContainsString('Select an active assigned branch', $html);
    }

    public function test_admin_uri_remains_configurable_for_restaurant_ops_routes(): void
    {
        self::assertStringStartsWith(Igniter::adminUri().'/', route('naxas.restaurantops.overview', absolute: false));
    }

    private function overviewData(): array
    {
        return [
            'pageTitle' => 'Operations Overview',
            'pageSubtitle' => 'Monitor branch context, operational access, and current staff readiness.',
            'workspace' => 'overview',
            'staffName' => 'Owner Test',
            'operationalProfileLabel' => 'Customized / non-operational',
            'staffActive' => true,
            'activeLocation' => null,
            'activeLocationLabel' => 'Branch not selected',
            'assignedLocations' => new EloquentCollection,
            'assignedLocationCount' => 0,
            'accessSummary' => collect(),
            'accessibleModuleCount' => 0,
            'quickActions' => collect(),
            'workspaceAction' => null,
            'transactionalContextReady' => false,
            'globalMode' => false,
            'readiness' => ['staffActive' => true, 'locationSelected' => false, 'assignedToActive' => false, 'transactionalReady' => false, 'global' => false],
            'readinessMessages' => collect(['Select an active assigned branch to use transactional modules.']),
        ];
    }
}
