<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Tests\MySql;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class PaymentSchemaTest extends TestCase
{
    public function test_payment_money_columns_have_mysql_precision(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            $this->markTestSkipped('Opt-in MySQL test; SQLite is not concurrency proof.');
        }

        $table = DB::getTablePrefix().'naxas_restaurant_ops_pos_payment_tenders';
        $columns = DB::select("SHOW COLUMNS FROM {$table} WHERE Field IN ('amount_received','amount_applied','change_amount')");
        self::assertCount(3, $columns);
        foreach ($columns as $column) {
            self::assertSame('decimal(15,4)', strtolower($column->Type));
        }
    }
}
