<?php

declare(strict_types=1);

namespace Igniter\Cart\AutomationRules\Events;

use Igniter\Automation\Classes\BaseEvent;
use Igniter\Cart\Models\Order;
use Override;

class OrderAssigned extends BaseEvent
{
    #[Override]
    public function eventDetails(): array
    {
        return [
            'name' => 'Order Assigned Event',
            'description' => 'When an order is assigned to a staff',
            'group' => 'order',
        ];
    }

    #[Override]
    public static function makeParamsFromEvent(array $args, $eventName = null)
    {
        $params = [];
        $order = array_get($args, 0);
        if ($order instanceof Order) {
            $params = $order->mailGetData();
        }

        $params['status'] = $order->status ?? null;
        $params['assignee'] = $order->assignee ?? null;

        return $params;
    }
}
