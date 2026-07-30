<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources;

use Igniter\Api\ApiResources\Repositories\OrderRepository;
use Igniter\Api\ApiResources\Requests\OrderRequest;
use Igniter\Api\ApiResources\Requests\StatusRequest;
use Igniter\Api\ApiResources\Transformers\OrderTransformer;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Http\Actions\RestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Orders API Controller
 */
class Orders extends ApiController
{
    public array $implement = [RestController::class];

    public $restConfig = [
        'actions' => [
            'index' => [
                'pageLimit' => 20,
            ],
            'store' => [],
            'show' => [],
            'update' => [],
            'destroy' => [],
            'updateStatus' => [],
        ],
        'request' => OrderRequest::class,
        'repository' => OrderRepository::class,
        'transformer' => OrderTransformer::class,
    ];

    protected string|array $requiredAbilities = ['orders:*'];

    public function updateStatus(StatusRequest $request, int $orderId): Response
    {
        throw_if(
            ($token = $this->getToken()) && $token->isForCustomer(),
            new AccessDeniedHttpException('Customers are not allowed to update order status.')
        );

        $data = $request->validated();

        $order = app(OrderRepository::class)->find($orderId);

        $data['staff_id'] = $this->user()->getKey();

        $order->updateOrderStatus((int) $data['status_id'], array_only($data, ['comment', 'notify', 'staff_id']));

        $response = $this->fractal()
            ->item($order->refresh())
            ->transformWith(new OrderTransformer)
            ->withResourceName('orders')
            ->toArray();

        return response()->json($response);
    }

    public function restAfterSave($model): void
    {
        if ($orderMenus = (array)request()->input('order_menus', [])) {
            $model->addOrderMenus(json_decode(json_encode($orderMenus)));

            $total_items = 0;
            foreach ($orderMenus as $menuItem) {
                $total_items += $menuItem['qty'];
            }

            $model->total_items = $total_items;
        }

        if ($orderTotals = (array)request()->input('order_totals', [])) {
            $model->addOrderTotals(json_decode(json_encode($orderTotals), true));
        }

        if ($orderStatus = request()->input('status_id', false)) {
            $model->updateOrderStatus($orderStatus, ['comment' => request()->input('status_comment')]);
        }

        if (request()->input('processed', false)) {
            $model->markAsPaymentProcessed();
        }
    }
}
