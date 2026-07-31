<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Listeners;

use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\MenuConfiguration\OrderSnapshotService;
use Naxas\RestaurantOps\MenuIntegration\EnhancedCartMetadata;
use Naxas\RestaurantOps\Models\SnapshotFailure;
use Throwable;

final class PersistEnhancedOrderSnapshots
{
    public function __construct(
        private readonly EnhancedCartMetadata $metadata,
        private readonly OrderSnapshotService $snapshots,
        private readonly AuditLogger $audit,
    ) {}

    public function handle(object $order): void
    {
        foreach ($order->menus()->get() as $orderMenu) {
            if (! $payload = $this->metadata->decode($orderMenu->comment)) {
                continue;
            }
            $snapshot = $this->snapshot($payload);
            try {
                $this->snapshots->write((int) $order->getKey(), (int) $orderMenu->getKey(), $snapshot);
                $orderMenu->comment = $this->metadata->note($orderMenu->comment);
                $orderMenu->saveQuietly();
                SnapshotFailure::query()->where('order_menu_id', $orderMenu->getKey())->delete();
                $this->audit->info('restaurantops.snapshot_persisted', ['order_id' => $order->getKey(), 'order_menu_id' => $orderMenu->getKey(), 'configuration_hash' => $snapshot['configuration_hash']]);
            } catch (Throwable $exception) {
                $this->recordFailure((int) $order->getKey(), (int) $orderMenu->getKey(), $snapshot, $exception);
            }
        }
    }

    public function retryFailure(SnapshotFailure $failure): void
    {
        $this->snapshots->write($failure->order_id, $failure->order_menu_id, $failure->snapshot);
        $failure->delete();
        $this->audit->info('restaurantops.snapshot_reconciled', ['order_id' => $failure->order_id, 'order_menu_id' => $failure->order_menu_id]);
    }

    private function snapshot(array $payload): array
    {
        return [
            'contract_version' => '1.0',
            'menu_item' => ['id' => $payload['menu_id'], 'name' => $payload['menu_name'], 'kitchen_name' => $payload['kitchen_name']],
            'variant' => $payload['variant'], 'modifier_groups' => $payload['modifiers'],
            'combo_components' => $payload['combo_selections'],
            'location' => ['id' => $payload['location_id'], 'name' => $payload['location_name']],
            'service_type' => $payload['service_type'], 'channel' => $payload['channel'],
            'item_note' => $payload['item_note'], 'pricing' => $payload['price_breakdown'],
            'unit_total' => $payload['authoritative_unit_total'],
            'line_total' => $payload['authoritative_line_total'],
            'total_price' => $payload['authoritative_line_total'],
            'configuration_hash' => $payload['configuration_hash'],
        ];
    }

    private function recordFailure(int $orderId, int $orderMenuId, array $snapshot, Throwable $exception): void
    {
        try {
            $failure = SnapshotFailure::query()->firstOrNew(['order_menu_id' => $orderMenuId]);
            $failure->fill(['order_id' => $orderId, 'snapshot' => $snapshot, 'last_error' => mb_substr($exception->getMessage(), 0, 2000), 'attempts' => ($failure->attempts ?? 0) + 1, 'last_attempt_at' => now()])->save();
        } catch (Throwable $recordException) {
            report($recordException);
        }
        $this->audit->warning('restaurantops.snapshot_reconciliation_required', ['order_id' => $orderId, 'order_menu_id' => $orderMenuId, 'exception' => $exception::class]);
        report($exception);
    }
}
