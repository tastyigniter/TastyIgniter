<?php

declare(strict_types=1);

namespace Igniter\Admin\EventSubscribers;

use Igniter\Admin\Models\StatusHistory;
use Igniter\Admin\Notifications\StatusUpdatedNotification;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;

class StatusUpdatedSubscriber
{
    public function subscribe(Dispatcher $events): array
    {
        return [
            'admin.statusHistory.added' => 'handleStatusAdded',
        ];
    }

    public function handleStatusAdded(Model $record, StatusHistory $history): void
    {
        StatusUpdatedNotification::make()->subject($history)->broadcast();
    }
}
