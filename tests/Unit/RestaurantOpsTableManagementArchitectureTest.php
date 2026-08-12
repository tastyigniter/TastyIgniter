<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

final class RestaurantOpsTableManagementArchitectureTest extends TestCase
{
    public function test_phase_18_schema_uses_nullable_unique_active_marker(): void
    {
        $migration = file_get_contents(__DIR__.'/../../extensions/naxas/restaurantops/database/migrations/2026_08_12_000700_create_table_floor_management_tables.php');
        $this->assertStringContainsString("active_table_id')->nullable()", $migration);
        $this->assertStringContainsString("unique('active_table_id'", $migration);
    }

    public function test_phase_18_permissions_are_registered(): void
    {
        $permissions = file_get_contents(__DIR__.'/../../extensions/naxas/restaurantops/src/Support/PermissionDefinitions.php');
        foreach (['Tables' => 'BillRequest', 'Floors' => 'Manage'] as $group => $action) {
            $this->assertStringContainsString("'{$group}'", $permissions);
            $this->assertStringContainsString("'{$action}'", $permissions);
        }
    }

    public function test_phase_18_routes_cover_table_operations(): void
    {
        $routes = file_get_contents(__DIR__.'/../../extensions/naxas/restaurantops/routes/web.php');
        foreach (['/tables/{table}/open', '/table-sessions/{session}/transfer', '/table-sessions/{session}/merge', '/table-sessions/{session}/split', '/table-sessions/{session}/close'] as $uri) {
            $this->assertStringContainsString($uri, $routes);
        }
    }
}
