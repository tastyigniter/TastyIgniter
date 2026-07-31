<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\MenuIntegration;

use Igniter\Cart\Models\OrderMenu;
use Naxas\RestaurantOps\MenuConfiguration\OrderSnapshotService;

final class OrderItemSnapshots
{
    public function show(OrderMenu $orderMenu, OrderSnapshotService $snapshots): mixed
    {
        $legacy = ['menu_item' => ['id' => $orderMenu->menu_id, 'name' => $orderMenu->name], 'item_note' => $orderMenu->comment, 'quantity' => $orderMenu->quantity, 'unit_total' => $orderMenu->price, 'line_total' => $orderMenu->subtotal];
        $snapshot = $snapshots->readOrLegacy((int) $orderMenu->getKey(), $legacy);

        return request()->expectsJson() ? response()->json(['data' => $snapshot]) : view('Naxas.RestaurantOps::order-item-snapshot', compact('orderMenu', 'snapshot'));
    }
}
