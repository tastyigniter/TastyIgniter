<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\Pos;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Models\PosOrder;
use Naxas\RestaurantOps\Pos\Contracts\PosOrderServiceContract;
use Naxas\RestaurantOps\Pos\Exceptions\PosException;
use Naxas\RestaurantOps\Shifts\Contracts\ShiftContextContract;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class PosOrders extends Controller
{
    public function __construct(private readonly PosOrderServiceContract $orders) {}

    public function screen(): Response
    {
        $user = $this->user();
        $shift = app(ShiftContextContract::class)->currentForStaff((int) $user->getAuthIdentifier());
        $held = $shift ? PosOrder::where('shift_id', $shift->getKey())->where('status', 'held')->latest()->limit(20)->get() : collect();

        return response()->view('Naxas.RestaurantOps::pos.index', compact('shift', 'held'));
    }

    public function index(Request $request): Response
    {
        $query = PosOrder::with('items')->where('location_id', app(LocationContextContract::class)->currentId())->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return response()->json(['data' => $query->paginate(30)]);
    }

    public function show(PosOrder $posOrder): Response
    {
        $this->resource($posOrder);

        return response()->json(['data' => $posOrder->load(['items', 'approvals', 'events'])]);
    }

    public function store(Request $request): Response
    {
        return $this->respond(fn () => $this->orders->createDraft($this->user(), $request->all(), (string) $request->header('Idempotency-Key')), 201);
    }

    public function update(Request $request, PosOrder $posOrder): Response
    {
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_order_update_use_specific_action', 'message' => 'Use a versioned POS action endpoint.']], 422);
    }

    public function addItem(Request $request, PosOrder $posOrder): Response
    {
        $this->resource($posOrder);

        return $this->respond(fn () => $this->orders->addItem($posOrder, $this->user(), $request->all(), $this->version($request), (string) $request->header('Idempotency-Key')), 201);
    }

    public function updateItem(Request $request, PosOrder $posOrder): Response
    {
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_item_update_requires_fresh_selection', 'message' => 'Submit a fresh authoritative selection through the add-item endpoint, then remove the unsent prior revision.']], 422);
    }

    public function removeItem(PosOrder $posOrder): Response
    {
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_void_approval_required', 'message' => 'Item removal is exposed only after the void/remove service verifies kitchen visibility.']], 409);
    }

    public function discount(PosOrder $posOrder): Response
    {
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_discount_approval_required', 'message' => 'Discount approval metadata is available; automatic application remains disabled by the conservative zero threshold.']], 409);
    }

    public function voidRequest(PosOrder $posOrder): Response
    {
        $this->resource($posOrder);

        return response()->json(['error' => ['code' => 'pos_void_approval_required', 'message' => 'Manager approval is required for kitchen-visible item voids.']], 409);
    }

    public function hold(Request $request, PosOrder $posOrder): Response
    {
        return $this->action($request, $posOrder, fn () => $this->orders->hold($posOrder, $this->user(), $this->version($request), $request->input('reason')));
    }

    public function recall(Request $request, PosOrder $posOrder): Response
    {
        return $this->action($request, $posOrder, fn () => $this->orders->recall($posOrder, $this->user(), $this->version($request)));
    }

    public function confirm(Request $request, PosOrder $posOrder): Response
    {
        return $this->action($request, $posOrder, fn () => $this->orders->confirm($posOrder, $this->user(), $this->version($request)));
    }

    public function kitchen(Request $request, PosOrder $posOrder): Response
    {
        return $this->action($request, $posOrder, fn () => $this->orders->requestKitchen($posOrder, $this->user(), $this->version($request)));
    }

    public function payment(Request $request, PosOrder $posOrder): Response
    {
        return $this->action($request, $posOrder, fn () => $this->orders->lockForPayment($posOrder, $this->user(), $this->version($request)));
    }

    public function cancel(Request $request, PosOrder $posOrder): Response
    {
        return $this->action($request, $posOrder, fn () => $this->orders->cancel($posOrder, $this->user(), $this->version($request), (string) $request->input('reason')));
    }

    private function action(Request $request, PosOrder $order, callable $action): Response
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

    private function version(Request $request): int
    {
        $value = filter_var($request->input('version'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
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
}
