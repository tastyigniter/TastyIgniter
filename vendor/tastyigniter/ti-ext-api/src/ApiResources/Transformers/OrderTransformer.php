<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Currency\Facades\Currency;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    protected array $availableIncludes = [
        'customer',
        'location',
        'address',
        'payment_method',
        'status',
        'status_history',
        'assignee',
        'assignee_group',
    ];

    public function transform(Order $order): array
    {
        return $this->mergesIdAttribute($order, [
            'currency' => Currency::getDefault()->currency_code,
            'order_totals' => $order->getOrderTotals(),
            'order_menus' => $order->getOrderMenusWithOptions(),
        ]);
    }

    public function includeCustomer(Order $order): ?Item
    {
        return $order->customer ? $this->item($order->customer, new CustomerTransformer, 'customers') : null;
    }

    public function includeLocation(Order $order): Item
    {
        return $this->item($order->location, new LocationTransformer, 'locations');
    }

    public function includeAddress(Order $order): ?Item
    {
        return $order->address ? $this->item($order->address, new AddressTransformer, 'addresses') : null;
    }

    public function includePaymentMethod(Order $order): ?Item
    {
        return $order->payment_method ? $this->item($order->payment_method, new PaymentMethodTransformer, 'payment_methods') : null;
    }

    public function includeStatus(Order $order): Item
    {
        return $this->item($order->status, new StatusTransformer, 'statuses');
    }

    public function includeStatusHistory(Order $order): Collection
    {
        return $this->collection($order->status_history, new StatusHistoryTransformer, 'status_history');
    }

    public function includeAssignee(Order $order): ?Item
    {
        return $order->assignee ? $this->item($order->assignee, new UserTransformer, 'assignee') : null;
    }

    public function includeAssigneeGroup(Order $order): ?Item
    {
        return $order->assignee_group ? $this->item($order->assignee_group, new UserGroupTransformer, 'assignee_group') : null;
    }
}
