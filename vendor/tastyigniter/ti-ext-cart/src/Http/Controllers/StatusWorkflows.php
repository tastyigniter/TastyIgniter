<?php

declare(strict_types=1);

namespace Igniter\Cart\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Models\Status;
use Igniter\Admin\Models\StatusHistory;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Exception\FlashException;
use Igniter\Local\Facades\Location as LocationFacade;
use Illuminate\Support\Carbon;

class StatusWorkflows extends AdminController
{
    protected null|string|array $requiredPermissions = 'Admin.Orders';

    public function accept(string $context, string $orderId): array
    {
        $order = $this->findOrder($orderId);

        $this->validate(request()->all(), [
            'minutes' => 'nullable|integer|min:0',
        ]);

        $acceptedStatusId = setting('accepted_order_status');
        throw_unless($acceptedStatusId, new FlashException(
            lang('igniter.cart::default.orders.alert_accepted_status_missing'),
        ));

        throw_unless($acceptedStatus = Status::query()->find($acceptedStatusId), new FlashException(
            lang('igniter.cart::default.orders.alert_accepted_status_not_found'),
        ));

        throw_if(StatusHistory::alreadyExists($order, $acceptedStatusId), new FlashException(
            lang('igniter.cart::default.orders.alert_accepted_status_already_exists'),
        ));

        $statusComment = null;
        if ($minutesToAdd = request()->integer('minutes')) {
            $orderDateTime = Carbon::parse($order->order_date_time)->addMinutes($minutesToAdd);
            $order->updateQuietly([
                'order_date' => $orderDateTime->toDateString(),
                'order_time' => $orderDateTime->toTimeString(),
            ]);

            $statusComment = collect(setting('delay_times') ?: [])->pluck('comment', 'time')->get($minutesToAdd);
        }

        $order->bindEvent('model.mailGetData', function(array &$data) use ($minutesToAdd, $statusComment): void {
            $data['order_approver'] = [
                'action' => $minutesToAdd > 0 ? 'delay' : 'approve',
                'text' => $statusComment,
            ];
        });

        /** @var Status $acceptedStatus */
        $order->addStatusHistory($acceptedStatus, array_filter(['comment' => $statusComment]));

        $this->fireSystemEvent('igniter.cart.orderAccepted', [$order]);

        return [
            'message' => lang('igniter.cart::default.orders.alert_order_accepted'),
        ];
    }

    public function reject(string $context, string $orderId): array
    {
        $order = $this->findOrder($orderId);

        $this->validate(request()->all(), [
            'reasonCode' => 'nullable|string',
        ]);

        $reasonCode = request()->string('reasonCode');

        $rejectedReason = collect(setting('rejected_reasons') ?: [])->firstWhere('code', $reasonCode);
        $statusComment = array_get($rejectedReason, 'comment');

        throw_unless($reasonCode, new FlashException(lang('igniter.cart::default.orders.alert_missing_reject_code')));

        throw_unless($rejectedStatusId = array_get($rejectedReason, 'status_id'), new FlashException(
            lang('igniter.cart::default.orders.alert_missing_reject_reason_not_found'),
        ));

        throw_unless($rejectedStatus = Status::find($rejectedStatusId), new FlashException(
            lang('igniter.cart::default.orders.alert_missing_reject_status_not_found'),
        ));

        throw_if(StatusHistory::alreadyExists($order, $rejectedStatus->getKey()), new FlashException(
            lang('igniter.cart::default.orders.alert_rejected_status_already_exists'),
        ));

        $order->bindEvent('model.mailGetData', function(array &$data) use ($statusComment): void {
            $data['order_approver'] = [
                'action' => 'decline',
                'text' => $statusComment,
            ];
        });

        /** @var Status $rejectedStatus */
        $order->addStatusHistory($rejectedStatus, array_filter(['comment' => $statusComment]));

        $this->fireSystemEvent('igniter.cart.orderRejected', [$order]);

        return [
            'message' => lang('igniter.cart::default.orders.alert_order_rejected'),
        ];
    }

    protected function findOrder(string $orderId): Order
    {
        throw_unless($orderId, new FlashException(lang('igniter.cart::default.orders.alert_missing_order_id')));

        $locationIds = LocationFacade::currentOrAssigned();
        $query = Order::query();
        if (!empty($locationIds)) {
            $query->whereHasOrDoesntHaveLocation($locationIds);
        }

        throw_unless($order = $query->find($orderId), new FlashException(
            sprintf(lang('igniter.cart::default.orders.alert_order_not_found'), $orderId),
        ));

        /** @var Order $order */
        return $order;
    }
}
