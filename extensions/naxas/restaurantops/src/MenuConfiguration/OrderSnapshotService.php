<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration;

use Illuminate\Support\Facades\DB;
use Naxas\RestaurantOps\Models\OrderItemSnapshot;

final class OrderSnapshotService
{
    public const int SCHEMA_VERSION = 1;

    public function write(int $orderId, int $orderMenuId, array $snapshot): OrderItemSnapshot
    {
        $payload = $this->normalize($snapshot);

        return DB::transaction(fn (): OrderItemSnapshot => OrderItemSnapshot::query()->firstOrCreate(
            ['order_menu_id' => $orderMenuId],
            ['order_id' => $orderId, 'menu_id' => $payload['menu_item']['id'] ?? null, 'location_id' => $payload['location']['id'] ?? null, 'service_type' => $payload['service_type'] ?? null, 'schema_version' => self::SCHEMA_VERSION, 'configuration_hash' => $payload['configuration_hash'], 'snapshot' => $payload, 'total_price' => $payload['total_price']],
        ));
    }

    public function readOrLegacy(int $orderMenuId, array $legacy): array
    {
        return OrderItemSnapshot::query()->where('order_menu_id', $orderMenuId)->first()?->snapshot ?? ['schema_version' => 0, 'legacy' => true] + $legacy;
    }

    private function normalize(array $snapshot): array
    {
        $snapshot['schema_version'] = self::SCHEMA_VERSION;
        $snapshot['variant'] ??= null;
        $snapshot['modifier_groups'] ??= [];
        $snapshot['combo_components'] ??= [];
        $snapshot['pricing'] ??= [];
        $snapshot['configuration_hash'] ??= hash('sha256', json_encode($snapshot, JSON_THROW_ON_ERROR));
        $snapshot['total_price'] = (string) ($snapshot['total_price'] ?? $snapshot['pricing']['subtotal'] ?? '0.0000');

        return $snapshot;
    }
}
