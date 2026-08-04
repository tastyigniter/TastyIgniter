<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\Pos;

use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Http\Controllers\AdminPageController;
use Naxas\RestaurantOps\Models\PosOrder;
use Naxas\RestaurantOps\Pos\Contracts\PosOrderServiceContract;
use Naxas\RestaurantOps\Pos\Exceptions\PosException;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftContextContract;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class PosOrders extends AdminPageController
{
    public function __construct(private readonly PosOrderServiceContract $orders)
    {
        parent::__construct();
    }

    public function screen(): Response
    {
        $user = $this->user();
        $shift = app(ShiftContextContract::class)->currentForStaff((int) $user->getAuthIdentifier());
        $held = $shift ? PosOrder::where('shift_id', $shift->getKey())->where('status', 'held')->latest()->limit(20)->get() : collect();

        return response($this->renderAdminPage('Naxas.RestaurantOps::pos.index', compact('shift', 'held'), lang('Naxas.RestaurantOps::default.navigation.pos'), 'restaurant-ops-pos'));
    }

    public function index(): Response
    {
        $query = PosOrder::with('items')->where('location_id', app(LocationContextContract::class)->currentId())->latest();
        if (request()->filled('status')) {
            $query->where('status', request()->string('status'));
        }

        return response()->json(['data' => $query->paginate(30)]);
    }

    public function active(): Response
    {
        return $this->orderList('active', lang('Naxas.RestaurantOps::default.navigation.active_orders'));
    }

    public function held(): Response
    {
        return $this->orderList('held', lang('Naxas.RestaurantOps::default.navigation.held_orders'));
    }

    public function show(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);
        $this->resource($posOrder);

        return response()->json(['data' => $posOrder->load(['items', 'approvals', 'events'])]);
    }

    public function store(): Response
    {
        return $this->respond(fn () => $this->orders->createDraft($this->user(), request()->all(), (string) request()->header('Idempotency-Key')), 201);
    }

    public function update(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_order_update_use_specific_action', 'message' => 'Use a versioned POS action endpoint.']], 422);
    }

    public function addItem(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);
        $this->resource($posOrder);

        return $this->respond(fn () => $this->orders->addItem($posOrder, $this->user(), request()->all(), $this->version(), (string) request()->header('Idempotency-Key')), 201);
    }

    public function updateItem(string $posOrderId, string $itemId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_item_update_requires_fresh_selection', 'message' => 'Submit a fresh authoritative selection through the add-item endpoint, then remove the unsent prior revision.']], 422);
    }

    public function removeItem(string $posOrderId, string $itemId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_void_approval_required', 'message' => 'Item removal is exposed only after the void/remove service verifies kitchen visibility.']], 409);
    }

    public function discount(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_discount_approval_required', 'message' => 'Discount approval metadata is available; automatic application remains disabled by the conservative zero threshold.']], 409);
    }

    public function voidRequest(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_void_approval_required', 'message' => 'Manager approval is required for kitchen-visible item voids.']], 409);
    }

    public function hold(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);

        return $this->action($posOrder, fn () => $this->orders->hold($posOrder, $this->user(), $this->version(), request()->input('reason')));
    }

    public function recall(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);

        return $this->action($posOrder, fn () => $this->orders->recall($posOrder, $this->user(), $this->version()));
    }

    public function confirm(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);

        return $this->action($posOrder, fn () => $this->orders->confirm($posOrder, $this->user(), $this->version()));
    }

    public function kitchen(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);

        return $this->action($posOrder, fn () => $this->orders->requestKitchen($posOrder, $this->user(), $this->version()));
    }

    public function payment(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);

        return $this->action($posOrder, fn () => $this->orders->lockForPayment($posOrder, $this->user(), $this->version()));
    }

    public function cancel(string $posOrderId): Response
    {
        $posOrder = PosOrder::query()->findOrFail($posOrderId);

        return $this->action($posOrder, fn () => $this->orders->cancel($posOrder, $this->user(), $this->version(), (string) request()->input('reason')));
    }

    private function action(PosOrder $order, callable $action): Response
    {
        $this->resource($order);

        return $this->respond($action);
    }

    private function resource(PosOrder $order): void
    {
        if ((int) $order->location_id !== (int) app(LocationContextContract::class)->currentId()) {
            throw PosException::forbidden('pos_location_forbidden', 'Cross-location POS access is prohibited.');
        }
    }

    private function version(): int
    {
        $value = filter_var(request()->input('version'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (! $value) {
            throw new PosException('pos_order_version_conflict', 'A valid order version is required.', 409);
        }

        return $value;
    }

    private function respond(callable $callback, int $status = 200): Response
    {
        try {
            return response()->json(['data' => $callback()], $status);
        } catch (PosException $e) {
            return response()->json(['error' => ['code' => $e->errorCode, 'message' => $e->getMessage()]], $e->status);
        } catch (Throwable $e) {
            report($e);

            return response()->json(['error' => ['code' => 'pos_concurrency_conflict', 'message' => 'The POS operation could not be completed safely.']], 409);
        }
    }

    private function user(): mixed
    {
        return app('admin.auth')->user();
    }

    private function orderList(string $status, string $title): Response
    {
        $orders = PosOrder::with('items')
            ->where('location_id', app(LocationContextContract::class)->currentId())
            ->where('status', $status)
            ->latest()
            ->paginate(30);

        $menuItem = $status === 'held' ? 'restaurant-ops-pos-held' : 'restaurant-ops-pos-active';

        return response($this->renderAdminPage('Naxas.RestaurantOps::pos.orders', compact('orders', 'status', 'title'), $title, $menuItem));
    }
}
