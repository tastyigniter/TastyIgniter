<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Naxas\RestaurantOps\MenuConfiguration\OrderSnapshotService;
use Tests\TestCase;

final class RestaurantOpsSnapshotServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'restaurantops_snapshot_sqlite', 'database.connections.restaurantops_snapshot_sqlite' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => true]]);
        DB::purge('restaurantops_snapshot_sqlite');
        Schema::create('naxas_restaurant_ops_order_item_snapshots', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_menu_id')->unique();
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('service_type')->nullable();
            $table->unsignedSmallInteger('schema_version');
            $table->string('configuration_hash', 64);
            $table->json('snapshot');
            $table->decimal('total_price', 15, 4);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function test_snapshot_is_immutable_idempotent_and_legacy_fallback_is_available(): void
    {
        $service = app(OrderSnapshotService::class);
        $original = ['menu_item' => ['id' => 10, 'name' => 'Purchased Pizza'], 'variant' => ['name' => '10 inch'], 'location' => ['id' => 4], 'service_type' => 'delivery', 'configuration_hash' => str_repeat('a', 64), 'total_price' => '860.0000'];
        $first = $service->write(1, 100, $original);
        $duplicate = $service->write(1, 100, $original + ['menu_item' => ['id' => 10, 'name' => 'Changed Pizza']]);

        self::assertSame($first->getKey(), $duplicate->getKey());
        self::assertSame('Purchased Pizza', $service->readOrLegacy(100, [])['menu_item']['name']);
        self::assertSame(1, DB::table('naxas_restaurant_ops_order_item_snapshots')->count());
        self::assertSame(['schema_version' => 0, 'legacy' => true, 'name' => 'Legacy Pizza'], $service->readOrLegacy(999, ['name' => 'Legacy Pizza']));
    }
}
