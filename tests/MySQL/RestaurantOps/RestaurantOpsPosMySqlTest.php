<?php

declare(strict_types=1);

namespace Tests\MySQL\RestaurantOps;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Throwable;

final class RestaurantOpsPosMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (env('RESTAURANT_OPS_MYSQL_TEST') !== '1') {
            $this->markTestSkipped('Set RESTAURANT_OPS_MYSQL_TEST=1 with a disposable MySQL test database.');
        }
        try {
            if (DB::connection()->getDriverName() !== 'mysql') {
                $this->markTestSkipped('MySQL is required.');
            } DB::select('select 1');
        } catch (Throwable $exception) {
            $this->markTestSkipped('RestaurantOps MySQL connection unavailable: '.$exception->getMessage());
        }
    }

    public function test_pos_schema_has_decimal_indexes_and_unique_official_link(): void
    {
        self::assertTrue(Schema::hasTable('naxas_restaurant_ops_pos_orders'));
        $prefix = DB::connection()->getTablePrefix();
        $columns = collect(DB::select("SHOW COLUMNS FROM `{$prefix}naxas_restaurant_ops_pos_orders`"))->keyBy('Field');
        self::assertSame('decimal(15,4)', strtolower($columns['order_total']->Type));
        self::assertSame('decimal(15,4)', strtolower($columns['outstanding_total']->Type));
        $indexes = collect(DB::select("SHOW INDEX FROM `{$prefix}naxas_restaurant_ops_pos_orders`"))->pluck('Key_name')->unique();
        self::assertContains('naxas_ops_pos_official_unique', $indexes);
        self::assertContains('naxas_ops_pos_location_status', $indexes);
        self::assertContains('naxas_ops_pos_shift_status', $indexes);
    }
}
