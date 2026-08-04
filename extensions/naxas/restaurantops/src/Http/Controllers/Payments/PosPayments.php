<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Http\Controllers\Payments;

use Naxas\RestaurantOps\Contracts\LocationContextContract;
use Naxas\RestaurantOps\Http\Controllers\AdminPageController;
use Naxas\RestaurantOps\Http\Requests\Payments\ReversalRequest;
use Naxas\RestaurantOps\Http\Requests\Payments\SettlePaymentRequest;
use Naxas\RestaurantOps\Models\PosOrder;
use Naxas\RestaurantOps\Models\PosPayment;
use Naxas\RestaurantOps\Models\PosPaymentReversal;
use Naxas\RestaurantOps\Payments\Exceptions\PaymentException;
use Naxas\RestaurantOps\Payments\PosPaymentService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class PosPayments extends AdminPageController
{
    public function __construct(private PosPaymentService $payments)
    {
        parent::__construct();
    }

    public function page(string $orderId): Response
    {
        $order = $this->order($orderId);

        return response($this->renderAdminPage('Naxas.RestaurantOps::payments.payment', ['order' => $order, 'providers' => config('restaurant-ops.payment.mobile_providers', [])], "Payment #{$order->getKey()}", 'restaurant-ops-pos'));
    }

    public function prepare(string $orderId): Response
    {
        $order = $this->order($orderId);

        return response()->json(['data' => ['pos_order_id' => $order->getKey(), 'official_order_id' => $order->order_id, 'status' => $order->status, 'version' => $order->version, 'currency' => config('restaurant-ops.payment.currency', 'BDT'), 'payable_total' => $order->outstanding_total, 'methods' => ['cash', 'card', 'mobile'], 'mobile_providers' => config('restaurant-ops.payment.mobile_providers', [])]]);
    }

    public function store(SettlePaymentRequest $request, string $orderId): Response
    {
        return $this->respond(fn () => $this->payments->settle($this->order($orderId), $this->user(), $request->validated(), (string) $request->header('Idempotency-Key')), 201);
    }

    public function show(string $orderId, string $paymentId): Response
    {
        return response()->json(['data' => $this->payment($orderId, $paymentId)->load(['tenders', 'receipt', 'events'])]);
    }

    public function receipt(string $orderId): Response
    {
        $payment = PosPayment::where('pos_order_id', $this->order($orderId)->getKey())->where('status', 'paid')->with('receipt')->latest()->firstOrFail();

        return response($this->renderAdminPage('Naxas.RestaurantOps::payments.receipt', ['payment' => $payment, 'receipt' => $payment->receipt], "Receipt {$payment->receipt_number}", 'restaurant-ops-pos'));
    }

    public function print(string $orderId): Response
    {
        return $this->printReceipt($orderId, false);
    }

    public function reprint(string $orderId): Response
    {
        return $this->printReceipt($orderId, true);
    }

    public function reverseRequest(ReversalRequest $request, string $orderId, string $paymentId): Response
    {
        return $this->respond(fn () => $this->payments->requestReversal($this->payment($orderId, $paymentId), (int) $this->user()->getAuthIdentifier(), $request->validated('reason')), 201);
    }

    public function reverseApprove(string $orderId, string $paymentId): Response
    {
        return $this->respond(function () use ($orderId, $paymentId) {
            $payment = $this->payment($orderId, $paymentId);
            $reversal = PosPaymentReversal::where('pos_payment_id', $payment->getKey())->where('status', 'pending')->latest()->firstOrFail();

            return $this->payments->approveReversal($payment, $reversal, (int) $this->user()->getAuthIdentifier());
        });
    }

    private function printReceipt(string $orderId, bool $reprint): Response
    {
        $payment = PosPayment::where('pos_order_id', $this->order($orderId)->getKey())->where('status', 'paid')->latest()->firstOrFail();
        $receipt = $this->payments->print($payment, (int) $this->user()->getAuthIdentifier(), $reprint);

        return response()->json(['data' => ['payment_id' => $payment->getKey(), 'receipt_number' => $receipt->receipt_number, 'print_count' => $receipt->print_count, 'preview_url' => route('naxas.restaurantops.pos.receipt.show', $orderId)]]);
    }

    private function order(string $id): PosOrder
    {
        $order = PosOrder::findOrFail($id);
        if ((int) $order->location_id !== (int) app(LocationContextContract::class)->currentId()) {
            throw PaymentException::forbidden('payment_location_forbidden', 'Cross-location access is prohibited.');
        }

        return $order;
    }

    private function payment(string $orderId, string $id): PosPayment
    {
        return PosPayment::where('pos_order_id', $this->order($orderId)->getKey())->findOrFail($id);
    }

    private function respond(callable $callback, int $status = 200): Response
    {
        try {
            return response()->json(['data' => $callback()], $status);
        } catch (PaymentException $e) {
            return response()->json(['error' => ['code' => $e->errorCode, 'message' => $e->getMessage()]], $e->status);
        } catch (Throwable $e) {
            report($e);

            return response()->json(['error' => ['code' => 'payment_operation_failed', 'message' => 'The payment operation could not be completed safely.']], 409);
        }
    }

    private function user(): mixed
    {
        return app('admin.auth')->user();
    }
}
