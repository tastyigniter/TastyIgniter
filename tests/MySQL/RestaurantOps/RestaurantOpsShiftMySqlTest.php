<?php

declare(strict_types=1);

namespace Tests\MySQL\RestaurantOps;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Throwable;

final class RestaurantOpsShiftMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        if (env('RESTAURANT_OPS_MYSQL_TEST') !== '1') $this->markTestSkipped('Set RESTAURANT_OPS_MYSQL_TEST=1 with a disposable MySQL test database.');
        try {
            if (DB::connection()->getDriverName() !== 'mysql') $this->markTestSkipped('MySQL is required.');
            DB::connection()->getPdo();
        } catch (Throwable $exception) {
            $this->markTestSkipped('RestaurantOps MySQL connection unavailable: '.$exception->getMessage());
        }
    }

    public function test_shift_schema_has_innodb_decimal_indexes_and_uniqueness(): void
    {
        $tables = ['naxas_restaurant_ops_cashier_shifts', 'naxas_restaurant_ops_cash_movements', 'naxas_restaurant_ops_shift_submissions', 'naxas_restaurant_ops_shift_denominations'];
        foreach ($tables as $table) self::assertTrue(Schema::hasTable($table), $table.' must be migrated');
        $database = DB::connection()->getDatabaseName();
        $columns = DB::select("select table_name,column_name,column_type from information_schema.columns where table_schema=? and table_name like 'naxas_restaurant_ops_%' and column_name in ('opening_cash','expected_cash','counted_cash','variance','amount','denomination','total')", [$database]);
        self::assertNotEmpty($columns);
        foreach ($columns as $column) self::assertSame('decimal(15,4)', strtolower($column->column_type));
        $indexes = DB::select('show index from naxas_restaurant_ops_cashier_shifts');
        self::assertNotEmpty(array_filter($indexes, fn (object $index): bool => $index->Key_name === 'naxas_ops_shift_active_staff_unique' && (int)$index->Non_unique === 0));
        self::assertStringContainsString('InnoDB', DB::selectOne('show create table naxas_restaurant_ops_cashier_shifts')->{'Create Table'});
        $submissionIndexes = DB::select('show index from naxas_restaurant_ops_shift_submissions');
        self::assertNotEmpty(array_filter($submissionIndexes, fn (object $index): bool => $index->Key_name === 'naxas_ops_submission_revision_unique' && (int)$index->Non_unique === 0));
    }
}
