<?php

declare(strict_types=1);

namespace Igniter\User\AutomationRules\Events;

use Igniter\Automation\Classes\BaseEvent;
use Override;

class CustomerRegistered extends BaseEvent
{
    #[Override]
    public function eventDetails(): array
    {
        return [
            'name' => 'Customer Registered Event',
            'description' => 'When a customer registers',
            'group' => 'customer',
        ];
    }

    #[Override]
    public static function makeParamsFromEvent(array $args, $eventName = null): array
    {
        return $args;
    }
}
