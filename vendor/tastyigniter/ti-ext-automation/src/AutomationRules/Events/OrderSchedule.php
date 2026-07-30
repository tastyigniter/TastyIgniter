<?php

declare(strict_types=1);

namespace Igniter\Automation\AutomationRules\Events;

use Igniter\Automation\Classes\BaseEvent;
use Igniter\Cart\Models\Order;
use Override;

class OrderSchedule extends BaseEvent
{
    #[Override]
    public function eventDetails(): array
    {
        return [
            'name' => 'Order Hourly Schedule',
            'description' => 'Performed on all recent orders once every hour',
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

        return $params;
    }
}
