<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Session\ArraySessionHandler;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Naxas\RestaurantOps\Http\Requests\EnhancedCartRequest;
use Naxas\RestaurantOps\MenuIntegration\CartIdempotencyStore;
use Naxas\RestaurantOps\MenuIntegration\EnhancedCartMetadata;
use Naxas\RestaurantOps\MenuIntegration\IntegrationException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class RestaurantOpsMenuIntegrationContractTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.key' => 'test-key', 'database.default' => 'restaurantops_contract_sqlite', 'database.connections.restaurantops_contract_sqlite' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => true]]);
        DB::purge('restaurantops_contract_sqlite');
        Schema::create('naxas_restaurant_ops_cart_idempotency', function (Blueprint $table): void {
            $table->id();
            $table->string('scope_hash', 64);
            $table->string('key_hash', 64);
            $table->string('request_hash', 64);
            $table->string('status', 16);
            $table->json('response')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
            $table->unique(['scope_hash', 'key_hash']);
        });
    }

    public function test_enhanced_metadata_round_trips_without_changing_customer_note(): void
    {
        $codec = new EnhancedCartMetadata;
        $metadata = ['contract_version' => '1.0', 'canonical_cart_identity' => str_repeat('a', 64), 'item_note' => 'Less spicy'];
        $comment = $codec->encode('Less spicy', $metadata);

        self::assertSame($metadata, $codec->decode($comment));
        self::assertSame('Less spicy', $codec->note($comment));
        self::assertNull($codec->decode('ordinary legacy comment'));
    }

    public function test_cart_idempotency_replays_same_request_and_rejects_key_reuse(): void
    {
        $store = new Store('test', new ArraySessionHandler(120));
        $store->setId('test-session');
        $idempotency = new CartIdempotencyStore($store);
        $idempotency->claim('retry-key', 'request-a');
        $idempotency->remember('retry-key', 'request-a', ['data' => ['row_id' => 'abc']]);

        self::assertSame(['data' => ['row_id' => 'abc']], $idempotency->replay('retry-key', 'request-a'));

        $this->expectException(IntegrationException::class);
        $idempotency->replay('retry-key', 'request-b');
    }

    #[DataProvider('tamperingFields')]
    public function test_request_contract_prohibits_client_prices(string $field): void
    {
        $request = new EnhancedCartRequest;
        $validator = Validator::make($this->validPayload() + [$field => '0.01'], $request->rules());

        self::assertTrue($validator->fails());
        self::assertArrayHasKey($field, $validator->errors()->toArray());
    }

    public function test_request_contract_bounds_quantity_and_rejects_global_mode(): void
    {
        $request = new EnhancedCartRequest;
        $negative = Validator::make(array_replace($this->validPayload(), ['quantity' => -1]), $request->rules());
        $extreme = Validator::make(array_replace($this->validPayload(), ['quantity' => 100]), $request->rules());
        $global = Validator::make(array_replace($this->validPayload(), ['location_mode' => 'global']), $request->rules());

        self::assertTrue($negative->fails());
        self::assertTrue($extreme->fails());
        self::assertTrue($global->fails());
    }

    public static function tamperingFields(): array
    {
        return array_map(fn (string $field): array => [$field], ['unit_price', 'price', 'subtotal', 'total', 'modifier_price', 'discount']);
    }

    private function validPayload(): array
    {
        return ['contract_version' => '1.0', 'menu_id' => 1, 'location_id' => 1, 'service_type' => 'delivery', 'channel' => 'storefront', 'quantity' => 1, 'variant_id' => 1, 'modifier_selections' => [], 'combo_selections' => []];
    }
}
