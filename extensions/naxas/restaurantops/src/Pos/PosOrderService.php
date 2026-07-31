<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Pos;

use Igniter\Cart\Models\Order;
use Igniter\Cart\Models\OrderMenu;
use Igniter\Cart\Models\OrderMenuOptionValue;
use Igniter\Cart\Models\OrderTotal;
use Igniter\User\Models\Address;
use Igniter\User\Models\Customer;
use Illuminate\Support\Facades\DB;
use Naxas\RestaurantOps\Contracts\AuditLogger;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\MenuConfiguration\Contracts\KitchenRoutingResolver;
use Naxas\RestaurantOps\MenuIntegration\IntegrationException;
use Naxas\RestaurantOps\MenuIntegration\MenuSelectionResolver;
use Naxas\RestaurantOps\Models\PosIdempotencyKey;
use Naxas\RestaurantOps\Models\PosOrder;
use Naxas\RestaurantOps\Models\PosOrderEvent;
use Naxas\RestaurantOps\Models\PosOrderItem;
use Naxas\RestaurantOps\Pos\Contracts\PosOrderServiceContract;
use Naxas\RestaurantOps\Pos\Events\PosOrderReadyForKitchen;
use Naxas\RestaurantOps\Pos\Exceptions\PosException;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftContextContract;
use Naxas\RestaurantOps\Shifts\ShiftStatus;

final class PosOrderService implements PosOrderServiceContract
{
    public function __construct(private readonly LocationContextContract $locations, private readonly ShiftContextContract $shifts, private readonly MenuSelectionResolver $selections, private readonly PosStateMachine $states, private readonly KitchenRoutingResolver $stations, private readonly AuditLogger $audit) {}

    public function createDraft(mixed $actor, array $data, string $idempotencyKey): PosOrder
    {
        $actorId = (int) $actor->getAuthIdentifier();
        $location = $this->requireLocation();
        $shift = $this->shifts->requireOpenShift($actorId);
        if ((int) $shift->location_id !== (int) $location->getKey()) {
            throw PosException::forbidden('pos_shift_location_mismatch', 'The open shift belongs to another location.');
        }
        $service = $this->service((string) ($data['service_type'] ?? ''));
        $this->validateCustomer($service, $data);
        $hash = $this->hash($data);
        if ($existing = $this->replay($actorId, 'create', $idempotencyKey, $hash)) {
            return PosOrder::findOrFail($existing);
        }

        return DB::transaction(function () use ($actorId, $location, $shift, $service, $data, $idempotencyKey, $hash): PosOrder {
            $order = PosOrder::create([
                'location_id' => $location->getKey(), 'shift_id' => $shift->getKey(), 'cashier_id' => $actorId,
                'service_type' => $service, 'source' => 'pos', 'status' => PosOrderStatus::DRAFT,
                'customer_id' => $data['customer_id'] ?? null, 'guest_name' => $data['guest_name'] ?? null,
                'guest_phone' => $data['guest_phone'] ?? null, 'guest_email' => $data['guest_email'] ?? null,
                'delivery_address_snapshot' => $service === 'delivery' ? ($data['delivery_address'] ?? null) : null,
                'requested_time' => $data['requested_time'] ?? null, 'guest_count' => $data['guest_count'] ?? null,
                'order_note' => $data['order_note'] ?? null,
            ]);
            PosIdempotencyKey::create(['cashier_id' => $actorId, 'operation' => 'create', 'idempotency_key' => $idempotencyKey, 'request_hash' => $hash, 'pos_order_id' => $order->getKey(), 'response_payload' => ['pos_order_id' => $order->getKey()]]);
            $this->event($order, $actorId, 'draft_created', ['service_type' => $service]);

            return $order;
        }, 3);
    }

    public function addItem(PosOrder $order, mixed $actor, array $selection, int $version, string $idempotencyKey): PosOrderItem
    {
        $this->assertNoClientMoney($selection);
        $actorId = (int) $actor->getAuthIdentifier();
        $hash = $this->hash($selection);
        if ($existing = $this->replay($actorId, 'item.add', $idempotencyKey, $hash)) {
            return PosOrderItem::findOrFail($existing);
        }

        return DB::transaction(function () use ($order, $actorId, $selection, $version, $idempotencyKey, $hash): PosOrderItem {
            $locked = $this->lockEditable($order, $actorId, $version);
            try {
                $resolved = $this->selections->resolve($selection + ['location_id' => $locked->location_id, 'location_mode' => 'location', 'service_type' => $locked->service_type, 'channel' => 'pos']);
            } catch (IntegrationException $e) {
                throw new PosException(str_replace('restaurantops_', 'pos_', $e->errorCode), $e->getMessage(), $e->status);
            }
            $configuration = array_except($resolved, ['price_breakdown', 'authoritative_unit_total', 'authoritative_line_total']);
            $item = PosOrderItem::create(['pos_order_id' => $locked->getKey(), 'menu_id' => $resolved['menu_id'], 'variant_id' => $resolved['variant']['id'], 'quantity' => $resolved['quantity'], 'item_note' => $resolved['item_note'], 'configuration_payload' => $configuration, 'pricing_payload' => $resolved['price_breakdown'], 'configuration_hash' => $resolved['configuration_hash'], 'unit_total' => $resolved['authoritative_unit_total'], 'line_total' => $resolved['authoritative_line_total']]);
            PosIdempotencyKey::create(['cashier_id' => $actorId, 'operation' => 'item.add', 'idempotency_key' => $idempotencyKey, 'request_hash' => $hash, 'pos_order_id' => $locked->getKey(), 'response_payload' => ['item_id' => $item->getKey()]]);
            $this->recalculate($locked);
            $this->event($locked, $actorId, 'item_added', ['item_id' => $item->getKey(), 'menu_id' => $item->menu_id]);

            return $item;
        }, 3);
    }

    public function hold(PosOrder $order, mixed $actor, int $version, ?string $reason = null): PosOrder
    {
        return $this->transition($order, $actor, $version, PosOrderStatus::HELD, ['hold_reason' => $reason, 'held_at' => now()], 'held');
    }

    public function recall(PosOrder $order, mixed $actor, int $version): PosOrder
    {
        return $this->transition($order, $actor, $version, PosOrderStatus::DRAFT, ['recalled_at' => now()], 'recalled');
    }

    public function confirm(PosOrder $order, mixed $actor, int $version): PosOrder
    {
        return DB::transaction(function () use ($order, $actor, $version): PosOrder {
            $locked = $this->lock($order, (int) $actor->getAuthIdentifier(), $version);
            if ($locked->order_id && $locked->status === PosOrderStatus::ACTIVE) {
                return $locked;
            }
            $this->states->assertCan($locked->status, PosOrderStatus::ACTIVE);
            if (! $locked->items()->where('status', 'unsent')->exists()) {
                throw new PosException('pos_item_invalid', 'At least one item is required.');
            }
            $official = $this->syncOfficial($locked);
            $locked->forceFill(['order_id' => $official->getKey(), 'status' => PosOrderStatus::ACTIVE, 'version' => $locked->version + 1])->save();
            $this->event($locked, (int) $actor->getAuthIdentifier(), 'official_order_synchronized', ['order_id' => $official->getKey()]);

            return $locked->fresh(['items']);
        }, 3);
    }

    public function requestKitchen(PosOrder $order, mixed $actor, int $version): PosOrder
    {
        $updated = $this->transition($order, $actor, $version, PosOrderStatus::KITCHEN_PENDING, ['kitchen_ready_at' => now()], 'kitchen_ready');
        $items = $updated->items()->where('status', 'unsent')->get()->map(fn ($item) => $item->configuration_payload + ['item_id' => $item->getKey(), 'quantity' => $item->quantity, 'station' => $this->stations->resolve($item->configuration_payload)])->values()->all();
        PosOrderReadyForKitchen::dispatch(['pos_order_id' => $updated->getKey(), 'official_order_id' => $updated->order_id, 'location_id' => $updated->location_id, 'service_type' => $updated->service_type, 'source' => $updated->source, 'items' => $items, 'revision' => $updated->version]);

        return $updated;
    }

    public function lockForPayment(PosOrder $order, mixed $actor, int $version): PosOrder
    {
        return $this->transition($order, $actor, $version, PosOrderStatus::PAYMENT_PENDING, ['payment_locked_at' => now(), 'outstanding_total' => $order->order_total], 'payment_locked');
    }

    public function cancel(PosOrder $order, mixed $actor, int $version, string $reason): PosOrder
    {
        if (trim($reason) === '') {
            throw new PosException('pos_cancel_reason_required', 'Cancellation reason is required.');
        }

        return $this->transition($order, $actor, $version, PosOrderStatus::CANCELLED, ['cancelled_at' => now(), 'cancelled_by' => $actor->getAuthIdentifier(), 'cancellation_reason' => trim($reason)], 'cancelled');
    }

    private function transition(PosOrder $order, mixed $actor, int $version, string $to, array $attributes, string $event): PosOrder
    {
        return DB::transaction(function () use ($order, $actor, $version, $to, $attributes, $event): PosOrder {
            $locked = $this->lock($order, (int) $actor->getAuthIdentifier(), $version);
            $this->states->assertCan($locked->status, $to);
            $locked->forceFill($attributes + ['status' => $to, 'version' => $locked->version + 1])->save();
            $this->event($locked, (int) $actor->getAuthIdentifier(), $event);

            return $locked->fresh(['items']);
        }, 3);
    }

    private function lockEditable(PosOrder $order, int $actorId, int $version): PosOrder
    {
        $locked = $this->lock($order, $actorId, $version);
        if (! in_array($locked->status, [PosOrderStatus::DRAFT, PosOrderStatus::HELD], true)) {
            throw PosException::conflict('pos_order_immutable', 'Items are not editable in this state.');
        }

        return $locked;
    }

    private function lock(PosOrder $order, int $actorId, int $version): PosOrder
    {
        $locked = PosOrder::query()->lockForUpdate()->findOrFail($order->getKey());
        $location = $this->requireLocation();
        if ((int) $locked->location_id !== (int) $location->getKey()) {
            throw PosException::forbidden('pos_location_forbidden', 'Cross-location POS access is prohibited.');
        } $shift = $this->shifts->requireOpenShift($actorId);
        if ((int) $shift->getKey() !== (int) $locked->shift_id || (int) $locked->cashier_id !== $actorId || $shift->status !== ShiftStatus::Open) {
            throw PosException::forbidden('pos_open_shift_required', 'The original cashier shift must be open.');
        } if ($locked->version !== $version) {
            throw PosException::conflict('pos_order_version_conflict', 'The POS order was changed by another request.');
        }

        return $locked;
    }

    private function requireLocation(): mixed
    {
        if ($this->locations->isGlobal()) {
            throw PosException::forbidden('pos_global_mode_not_allowed', 'Select a concrete branch.');
        } try {
            return $this->locations->requireCurrent();
        } catch (\Throwable) {
            throw PosException::forbidden('pos_location_required', 'Select a concrete branch.');
        }
    }

    private function service(string $service): string
    {
        $service = $service === 'takeaway' ? 'collection' : $service;
        if (! in_array($service, ['collection', 'delivery', 'dine_in'], true)) {
            throw new PosException('pos_service_type_invalid', 'Service type must be dine_in, delivery, or collection.');
        }

        return $service;
    }

    private function validateCustomer(string $service, array $data): void
    {
        if (! empty($data['customer_id']) && ! Customer::find((int) $data['customer_id'])) {
            throw new PosException('pos_customer_invalid', 'Customer does not exist.');
        } if ($service === 'delivery') {
            if (trim((string) ($data['guest_phone'] ?? '')) === '') {
                throw new PosException('pos_delivery_address_invalid', 'A delivery phone is required.');
            } $address = $data['delivery_address'] ?? null;
            if (! is_array($address) || trim((string) ($address['address_1'] ?? '')) === '') {
                throw new PosException('pos_delivery_address_invalid', 'A delivery address is required.');
            } if (! empty($data['address_id']) && ! Address::whereKey($data['address_id'])->where('customer_id', $data['customer_id'] ?? 0)->exists()) {
                throw new PosException('pos_delivery_address_invalid', 'Address does not belong to the selected customer.');
            }
        }
    }

    private function assertNoClientMoney(array $data): void
    {
        foreach (['price', 'unit_total', 'line_total', 'subtotal', 'tax', 'total', 'discount'] as $field) {
            if (array_key_exists($field, $data)) {
                throw new PosException('pos_item_invalid', 'Client-submitted prices and totals are not accepted.');
            }
        }
    }

    private function recalculate(PosOrder $order): void
    {
        $subtotal = (string) $order->items()->whereNotIn('status', ['removed', 'voided'])->sum('line_total');
        $hash = hash('sha256', json_encode($order->items()->orderBy('id')->get(['configuration_hash', 'quantity', 'line_total'])->toArray(), JSON_THROW_ON_ERROR));
        $order->forceFill(['subtotal' => $subtotal, 'order_total' => $subtotal, 'outstanding_total' => $subtotal, 'configuration_hash' => $hash, 'pricing_hash' => $hash, 'version' => $order->version + 1])->save();
    }

    private function syncOfficial(PosOrder $pos): Order
    {
        if ($pos->order_id && $found = Order::find($pos->order_id)) {
            return $found;
        } $name = preg_split('/\s+/', trim((string) $pos->guest_name), 2);
        $official = new Order;
        $official->forceFill(['customer_id' => $pos->customer_id, 'location_id' => $pos->location_id, 'first_name' => $name[0] ?? '', 'last_name' => $name[1] ?? '', 'email' => $pos->guest_email ?? '', 'telephone' => $pos->guest_phone ?? '', 'comment' => $pos->order_note, 'order_type' => $pos->service_type === 'delivery' ? Order::DELIVERY : Order::COLLECTION, 'order_date' => now()->toDateString(), 'order_time' => now()->format('H:i'), 'order_time_is_asap' => true, 'total_items' => $pos->items()->sum('quantity'), 'order_total' => $pos->order_total, 'processed' => false, 'ip_address' => request()->ip()])->save();
        foreach ($pos->items as $item) {
            $config = $item->configuration_payload;
            $row = OrderMenu::create(['order_id' => $official->getKey(), 'menu_id' => $item->menu_id, 'name' => $config['menu_name'] ?? 'Menu item', 'quantity' => $item->quantity, 'price' => $item->unit_total, 'subtotal' => $item->line_total, 'comment' => $item->item_note, 'option_values' => serialize($config['_official_menu_options'] ?? [])]);
            foreach (($config['_official_menu_options'] ?? []) as $option) {
                foreach (($option['values'] ?? []) as $value) {
                    OrderMenuOptionValue::create(['order_id' => $official->getKey(), 'order_menu_id' => $row->getKey(), 'menu_option_id' => $option['id'], 'menu_option_value_id' => $value['id'], 'order_option_name' => $value['name'] ?? '', 'order_option_price' => $value['price'] ?? 0, 'quantity' => $value['qty'] ?? 1, 'free_qty' => $value['free_qty'] ?? 0]);
                }
            }
        } foreach ([['code' => 'subtotal', 'title' => 'Subtotal', 'value' => $pos->subtotal, 'priority' => 0, 'is_summable' => false], ['code' => 'total', 'title' => 'Total', 'value' => $pos->order_total, 'priority' => 999, 'is_summable' => false]] as $total) {
            OrderTotal::create($total + ['order_id' => $official->getKey()]);
        }

        return $official;
    }

    private function replay(int $actor, string $operation, string $key, string $hash): ?int
    {
        if (trim($key) === '') {
            throw new PosException('pos_idempotency_key_required', 'Idempotency-Key is required.');
        } $record = PosIdempotencyKey::where(['cashier_id' => $actor, 'operation' => $operation, 'idempotency_key' => $key])->first();
        if (! $record) {
            return null;
        } if (! hash_equals($record->request_hash, $hash)) {
            throw PosException::conflict('pos_idempotency_conflict', 'The idempotency key was used for different input.');
        }

        return (int) (($record->response_payload['item_id'] ?? null) ?: $record->pos_order_id);
    }

    private function event(PosOrder $order, int $actor, string $type, array $payload = []): void
    {
        PosOrderEvent::create(['pos_order_id' => $order->getKey(), 'event_type' => $type, 'actor_id' => $actor, 'location_id' => $order->location_id, 'payload' => $payload ?: null, 'occurred_at' => now()]);
        $this->audit->info('restaurant_ops.pos.'.$type, ['pos_order_id' => $order->getKey(), 'location_id' => $order->location_id, 'actor_id' => $actor] + $payload);
    }

    private function hash(array $data): string
    {
        ksort($data);

        return hash('sha256', json_encode($data, JSON_THROW_ON_ERROR));
    }
}
