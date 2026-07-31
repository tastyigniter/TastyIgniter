<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

final class RestaurantOpsMigrationSqliteSmokeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'restaurantops_sqlite', 'database.connections.restaurantops_sqlite' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => true]]);
        DB::purge('restaurantops_sqlite');
        DB::connection('restaurantops_sqlite')->getPdo();
    }

    public function test_extension_migrations_are_reversible_on_sqlite_as_a_syntax_smoke_only(): void
    {
        $migrations = [
            require base_path('extensions/naxas/restaurantops/database/migrations/2026_07_31_000001_create_restaurant_ops_staff_preferences_table.php'),
            require base_path('extensions/naxas/restaurantops/database/migrations/2026_07_31_000100_create_menu_configuration_tables.php'),
            require base_path('extensions/naxas/restaurantops/database/migrations/2026_07_31_000200_create_menu_integration_support_tables.php'),
        ];
        foreach ($migrations as $migration) {
            $migration->up();
        }

        self::assertTrue(Schema::hasTable('naxas_restaurant_ops_item_variants'));
        self::assertTrue(Schema::hasColumn('naxas_restaurant_ops_order_item_snapshots', 'total_price'));
        self::assertTrue(Schema::hasTable('naxas_restaurant_ops_snapshot_failures'));
        self::assertTrue(Schema::hasTable('naxas_restaurant_ops_cart_idempotency'));

        foreach (array_reverse($migrations) as $migration) {
            $migration->down();
        }
        self::assertFalse(Schema::hasTable('naxas_restaurant_ops_staff_preferences'));
        self::assertFalse(Schema::hasTable('naxas_restaurant_ops_order_item_snapshots'));
        self::assertFalse(Schema::hasTable('naxas_restaurant_ops_snapshot_failures'));
        self::assertFalse(Schema::hasTable('naxas_restaurant_ops_cart_idempotency'));
    }
}
