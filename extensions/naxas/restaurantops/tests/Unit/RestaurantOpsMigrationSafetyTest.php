<?php

declare(strict_types=1);

namespace Tests\Unit;

require_once __DIR__.'/../../src/Support/MigrationSchema.php';

use Naxas\RestaurantOps\Support\MigrationSchema;
use PHPUnit\Framework\TestCase;

final class RestaurantOpsMigrationSafetyTest extends TestCase
{
    public function test_identifiers_are_explicit_unique_and_mysql_safe(): void
    {
        $audit = MigrationSchema::identifierAudit('ti_');
        self::assertNotEmpty($audit['identifiers']);
        self::assertSame([], $audit['errors']);
        self::assertLessThanOrEqual(MigrationSchema::INTERNAL_LIMIT, max(array_column($audit['identifiers'], 'length')));
        self::assertCount(count($audit['identifiers']), array_unique(array_column($audit['identifiers'], 'name')));
    }

    public function test_every_restaurant_ops_table_and_required_columns_are_discovered(): void
    {
        $schema = MigrationSchema::tablesAndColumns();
        self::assertCount(23, $schema);
        self::assertContains('default_location_id', $schema['naxas_restaurant_ops_staff_preferences']);
        self::assertContains('active_staff_id', $schema['naxas_restaurant_ops_cashier_shifts']);
        self::assertContains('order_total', $schema['naxas_restaurant_ops_pos_orders']);
    }
}
