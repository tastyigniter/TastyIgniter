<?php

declare(strict_types=1);

namespace Igniter\Admin\Providers;

use Igniter\Admin\EventSubscribers\StatusUpdatedSubscriber;
use Igniter\Flame\Providers\EventServiceProvider as FlameEventServiceProvider;

class EventServiceProvider extends FlameEventServiceProvider
{
    protected $subscribe = [
        StatusUpdatedSubscriber::class,
    ];
}
