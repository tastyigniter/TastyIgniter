<?php

declare(strict_types=1);

namespace Igniter\User\Subscribers;

use Igniter\Cart\Models\Order;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Models\AssignableLog;
use Igniter\User\Notifications\AssigneeUpdatedNotification;
use Illuminate\Contracts\Events\Dispatcher;

class AssigneeUpdatedSubscriber
{
    public function subscribe(Dispatcher $events): array
    {
        return [
            'admin.assignable.assigned' => 'handleAssigned',
        ];
    }

    public function handleAssigned(Order|Reservation $record, AssignableLog $log): void
    {
        AssigneeUpdatedNotification::make()->subject($log)->broadcast();
    }
}
