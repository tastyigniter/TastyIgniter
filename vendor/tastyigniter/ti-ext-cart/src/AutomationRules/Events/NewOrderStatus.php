<?php

declare(strict_types=1);

namespace Igniter\Cart\AutomationRules\Events;

use Igniter\Automation\Classes\BaseEvent;
use Igniter\Cart\Models\Order;
use Override;

class NewOrderStatus extends BaseEvent
{
    #[Override]
    public function eventDetails(): array
    {
        return [
            'name' => 'Order Status Update Event',
            'description' => 'When an order status is updated',
            'group' => 'order',
        ];
    }

    #[Override]
    public static function makeParamsFromEvent(array $args, $eventName = null)
    {
        $params = [];
        $order = array_get($args, 0);
        $status = array_get($args, 1);
        if ($order instanceof Order) {
            $params = $order->mailGetData();
        }

        $params['status'] = $status;

        return $params;
    }
}
