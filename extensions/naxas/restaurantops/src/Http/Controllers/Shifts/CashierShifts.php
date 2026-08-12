<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\Shifts;

use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Http\Controllers\AdminPageController;
use Naxas\RestaurantOps\Models\CashierShift;
use Naxas\RestaurantOps\Models\CashMovement;
use Naxas\RestaurantOps\Shifts\CashierShiftContext;
use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CashierShifts extends AdminPageController
{
    public function __construct(private readonly CashierShiftContext $shifts)
    {
        parent::__construct();
    }

    public function index(): Response
    {
        $user = $this->user();
        $query = CashierShift::query()->orderByDesc('opened_at');
        if (! $user->hasPermission('Restaurant.Shifts.ViewBranch')) {
            $query->where('staff_id', $user->getAuthIdentifier());
        }
        if (! app(LocationContextContract::class)->isGlobal()) {
            $query->where('location_id', app(LocationContextContract::class)->currentId());
        }
        foreach (['status', 'staff_id'] as $filter) {
            if (request()->filled($filter)) {
                $query->where($filter, request()->input($filter));
            }
        }
        if (request()->filled('date_from')) {
            $query->where('opened_at', '>=', request()->date('date_from')->startOfDay());
        }
        if (request()->filled('date_to')) {
            $query->where('opened_at', '<=', request()->date('date_to')->endOfDay());
        }
        $records = $query->paginate(30)->withQueryString();
        $canOpen = $user->hasPermission('Restaurant.Shifts.Open');

        $title = lang('Naxas.RestaurantOps::default.navigation.shifts');

        return response($this->renderAdminPage('Naxas.RestaurantOps::shifts.index', compact('records', 'canOpen'), $title, 'restaurant-ops-shifts'));
    }

    public function openForm(): Response
    {
        return response($this->renderAdminPage('Naxas.RestaurantOps::shifts.open', ['activeShift' => $this->shifts->currentForStaff((int) $this->user()->getAuthIdentifier())], lang('Naxas.RestaurantOps::default.shifts.open'), 'restaurant-ops-active-shift'));
    }

    public function mine(): Response
    {
        $user = $this->user();
        $shift = $this->shifts->currentForStaff((int) $user->getAuthIdentifier());
        $canOpen = $user->hasPermission('Restaurant.Shifts.Open');

        $title = lang('Naxas.RestaurantOps::default.navigation.active_shift');

        return response($this->renderAdminPage('Naxas.RestaurantOps::shifts.mine', compact('shift', 'canOpen'), $title, 'restaurant-ops-active-shift'));
    }

    public function branchReview(): Response
    {
        request()->merge(['status' => request()->input('status', 'submitted')]);
        $query = CashierShift::query()
            ->where('location_id', app(LocationContextContract::class)->currentId())
            ->orderByDesc('opened_at');
        if (request()->filled('status')) {
            $query->where('status', request()->input('status'));
        }
        $records = $query->paginate(30)->withQueryString();

        $title = lang('Naxas.RestaurantOps::default.navigation.shift_review');

        return response($this->renderAdminPage('Naxas.RestaurantOps::shifts.branch-review', compact('records'), $title, 'restaurant-ops-shift-review'));
    }

    public function store(): Response
    {
        return $this->respond(fn () => $this->shifts->open($this->user(), (string) request()->input('opening_cash'), request()->input('terminal_code'), request()->input('opening_note')), 201);
    }

    public function show(string $shiftId): Response
    {
        $shift = CashierShift::query()->findOrFail($shiftId);
        $this->authorizeResource($shift);
        $summary = $this->shifts->calculateSummary($shift);
        $shift->load(['movements', 'submissions.denominations']);

        return request()->expectsJson()
            ? response()->json(['data' => $shift, 'summary' => $summary])
            : response($this->renderAdminPage('Naxas.RestaurantOps::shifts.show', compact('shift', 'summary'), 'Shift #'.$shift->getKey(), 'restaurant-ops-shifts'));
    }

    public function movement(string $shiftId): Response
    {
        $shift = CashierShift::query()->findOrFail($shiftId);
        $this->authorizeResource($shift, true);

        return $this->respond(fn () => $this->shifts->addMovement($shift, $this->user(), (string) request()->input('type'), (string) request()->input('amount'), (string) request()->input('reason_code'), request()->input('reason_text'), request()->header('Idempotency-Key')), 201);
    }

    public function reverse(string $shiftId, string $movementId): Response
    {
        $shift = CashierShift::query()->findOrFail($shiftId);
        $movement = CashMovement::query()->where('shift_id', $shift->getKey())->findOrFail($movementId);
        $this->authorizeResource($shift, true);

        return $this->respond(fn () => $this->shifts->reverseMovement($shift, $movement, $this->user(), (string) request()->input('reason')));
    }

    public function requestClose(string $shiftId): Response
    {
        $shift = CashierShift::query()->findOrFail($shiftId);
        $this->authorizeResource($shift, true);

        return $this->respond(fn () => $this->shifts->requestClosing($shift, $this->user()));
    }

    public function submit(string $shiftId): Response
    {
        $shift = CashierShift::query()->findOrFail($shiftId);
        $this->authorizeResource($shift, true);

        return $this->respond(fn () => $this->shifts->submit($shift, $this->user(), request()->input('counted_cash'), (array) request()->input('denominations', []), request()->input('closing_note')), 201);
    }

    public function approve(string $shiftId): Response
    {
        $shift = CashierShift::query()->findOrFail($shiftId);
        $this->authorizeResource($shift);

        return $this->respond(fn () => $this->shifts->approve($shift, $this->user()));
    }

    public function reject(string $shiftId): Response
    {
        $shift = CashierShift::query()->findOrFail($shiftId);
        $this->authorizeResource($shift);

        return $this->respond(fn () => $this->shifts->reject($shift, $this->user(), (string) request()->input('reason')));
    }

    public function forceClose(string $shiftId): Response
    {
        $shift = CashierShift::query()->findOrFail($shiftId);
        $this->authorizeResource($shift);

        return $this->respond(fn () => $this->shifts->forceClose($shift, $this->user(), (string) request()->input('reason')));
    }

    private function authorizeResource(CashierShift $shift, bool $own = false): void
    {
        $this->shifts->assertLocation($shift);
        $user = $this->user();
        if (($own || ! $user->hasPermission('Restaurant.Shifts.ViewBranch')) && $shift->staff_id !== (int) $user->getAuthIdentifier()) {
            throw ShiftException::forbidden('shift_access_denied', 'You may only operate your own shift.');
        }
    }

    private function respond(callable $callback, int $status = 200): Response
    {
        try {
            $result = $callback();
        } catch (ShiftException $exception) {
            return response()->json(['error' => ['code' => $exception->errorCode, 'message' => $exception->getMessage()]], $exception->status);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json(['error' => ['code' => 'shift_concurrency_conflict', 'message' => 'The shift operation could not be completed safely.']], 409);
        }

        return response()->json(['data' => $result], $status);
    }

    private function user(): mixed
    {
        return app('admin.auth')->user();
    }
}
