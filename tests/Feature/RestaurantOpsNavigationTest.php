<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Middleware\ResolveLocationContext;
use Igniter\Admin\Classes\Navigation;
use Igniter\System\Classes\ExtensionManager;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Http\Middleware\Authenticate as AdminAuthenticate;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Mockery;
use Naxas\RestaurantOps\Extension;
use Naxas\RestaurantOps\Http\Middleware\RequiresOperationalPermission;
use Naxas\RestaurantOps\Http\Middleware\RequiresTransactionalLocation;
use Tests\TestCase;

final class RestaurantOpsNavigationTest extends TestCase
{
    public function test_restaurant_ops_routes_preserve_the_complete_admin_middleware_stack(): void
    {
        $router = app('router');

        foreach ($router->getRoutes() as $route) {
            $name = (string) $route->getName();
            if (! str_starts_with($name, 'naxas.restaurantops.') || str_starts_with($name, 'naxas.restaurantops.v1.')) {
                continue;
            }

            $middleware = $router->gatherRouteMiddleware($route);

            self::assertContains(AddQueuedCookiesToResponse::class, $middleware, $name);
            self::assertContains(StartSession::class, $middleware, $name);
            self::assertContains(AdminAuthenticate::class, $middleware, $name);
            self::assertContains(ResolveLocationContext::class, $middleware, $name);
            self::assertTrue(
                collect($middleware)->contains(fn (string $item): bool => str_starts_with($item, RequiresOperationalPermission::class.':')),
                $name,
            );

            $transactional = collect($route->middleware())->contains('restaurant.ops.transactional');
            self::assertSame($transactional, in_array(RequiresTransactionalLocation::class, $middleware, true), $name);
        }
    }

    protected function tearDown(): void
    {
        AdminAuth::clearResolvedInstance('admin.auth');
        parent::tearDown();
    }

    public function test_superuser_navigation_resolves_every_complete_item_without_warning(): void
    {
        $definitions = $this->definitions();
        $this->assertCompleteSchema($definitions);
        AdminAuth::shouldReceive('user')->andReturn($this->userWithPermissions(fn (): bool => true));

        $visible = $this->resolve($definitions);

        self::assertSame(array_keys($definitions['restaurant-operations']['child']), array_keys($visible['restaurant-operations']['child']));
        self::assertSame([10, 20, 30, 40, 41, 42, 43, 50, 60, 70, 80, 81, 82], array_column($visible['restaurant-operations']['child'], 'priority'));
        $this->assertHumanReadableTitles($visible);
        $this->assertNavigationTargetsRegisteredRoutes($visible);
    }

    public function test_restricted_user_navigation_filters_children_without_partial_items(): void
    {
        $allowed = ['Restaurant.Operations.Access', 'Restaurant.Operations.BranchDashboard'];
        AdminAuth::shouldReceive('user')->andReturn($this->userWithPermissions(fn (string $permission): bool => in_array($permission, $allowed, true)));

        $visible = $this->resolve($this->definitions());

        self::assertSame(['restaurant-ops-overview', 'restaurant-ops-branch'], array_keys($visible['restaurant-operations']['child']));
        $this->assertCompleteSchema($visible);
        $this->assertHumanReadableTitles($visible);
    }

    public function test_navigation_and_permission_translations_fall_back_to_english(): void
    {
        app()->setLocale('fr');
        config()->set('app.fallback_locale', 'en');

        $this->assertHumanReadableTitles($this->definitions());
        foreach (app(ExtensionManager::class)->findExtension('Naxas.RestaurantOps')->registerPermissions() as $definition) {
            foreach (['label', 'group', 'description'] as $field) {
                $this->assertHumanReadable(lang($definition[$field]));
            }
        }
    }

    private function definitions(): array
    {
        $extension = app(ExtensionManager::class)->findExtension('Naxas.RestaurantOps');
        self::assertInstanceOf(Extension::class, $extension);

        return $extension->registerNavigation();
    }

    private function resolve(array $definitions): array
    {
        $navigation = new Navigation;
        $navigation->registerNavItems($definitions);

        return $navigation->getVisibleNavItems();
    }

    private function userWithPermissions(callable $permissions): object
    {
        $user = Mockery::mock();
        $user->shouldReceive('hasPermission')->andReturnUsing($permissions);

        return $user;
    }

    private function assertCompleteSchema(array $items): void
    {
        foreach ($items as $item) {
            foreach (['title', 'href', 'class', 'permission', 'priority'] as $key) {
                self::assertArrayHasKey($key, $item);
            }
            self::assertIsInt($item['priority']);
            if (isset($item['child'])) {
                self::assertIsArray($item['child']);
                $this->assertCompleteSchema($item['child']);
            }
        }
    }

    private function assertHumanReadableTitles(array $items): void
    {
        foreach ($items as $item) {
            $this->assertHumanReadable($item['title']);
            $this->assertHumanReadableTitles($item['child'] ?? []);
        }
    }

    private function assertNavigationTargetsRegisteredRoutes(array $items): void
    {
        $dashboard = route('igniter.admin.dashboard');
        $registeredGetUris = collect(Route::getRoutes()->getRoutes())
            ->filter(fn ($route): bool => in_array('GET', $route->methods(), true))
            ->map(fn ($route): string => $route->uri())
            ->all();

        foreach ($items as $item) {
            self::assertNotSame('', trim($item['href']));
            self::assertNotSame($dashboard, $item['href']);
            self::assertContains(ltrim(parse_url($item['href'], PHP_URL_PATH), '/'), $registeredGetUris);
            $this->assertNavigationTargetsRegisteredRoutes($item['child'] ?? []);
        }
    }

    private function assertHumanReadable(string $value): void
    {
        self::assertNotSame('', trim($value));
        self::assertStringNotContainsString('naxas.restaurantops::', strtolower($value));
        self::assertStringNotContainsString('::default', $value);
        self::assertMatchesRegularExpression('/[A-Za-z]/', $value);
    }
}
