<?php

declare(strict_types=1);

namespace Tests\MySQL\RestaurantOps;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Throwable;

final class RestaurantOpsMySqlIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (env('RESTAURANT_OPS_MYSQL_TEST') !== '1') {
            $this->markTestSkipped('Set RESTAURANT_OPS_MYSQL_TEST=1 with .env.testing.mysql to run destructive disposable-database checks.');
        }
        try {
            if (DB::connection()->getDriverName() !== 'mysql') {
                $this->markTestSkipped('The RestaurantOps MySQL suite requires a MySQL connection.');
            }
            DB::connection()->getPdo();
        } catch (Throwable $exception) {
            $this->markTestSkipped('RestaurantOps MySQL connection unavailable: '.$exception->getMessage());
        }
    }

    public function test_mysql_schema_has_required_money_indexes_and_unique_snapshot_identity(): void
    {
        foreach (['naxas_restaurant_ops_item_variants', 'naxas_restaurant_ops_availability_overrides', 'naxas_restaurant_ops_order_item_snapshots', 'naxas_restaurant_ops_snapshot_failures', 'naxas_restaurant_ops_cart_idempotency'] as $table) {
            self::assertTrue(Schema::hasTable($table), $table.' must be migrated');
        }
        $prefix = DB::connection()->getTablePrefix();
        $database = DB::connection()->getDatabaseName();
        $money = DB::select("select table_name, column_name, column_type from information_schema.columns where table_schema = ? and table_name like ? and column_name in ('price_value','price_adjustment','price_override','upgrade_surcharge','total_price')", [$database, $prefix.'naxas_restaurant_ops_%']);
        self::assertNotEmpty($money);
        foreach ($money as $column) {
            self::assertSame('decimal(15,4)', strtolower($column->column_type));
        }
        $indexes = DB::select('show index from `'.$prefix.'naxas_restaurant_ops_order_item_snapshots`');
        self::assertNotEmpty(array_filter($indexes, fn (object $index): bool => $index->Key_name === 'naxas_ops_snapshot_order_menu_unique' && (int) $index->Non_unique === 0));
        self::assertStringContainsString('InnoDB', DB::selectOne('show create table `'.$prefix.'naxas_restaurant_ops_order_item_snapshots`')->{'Create Table'});
    }
}
