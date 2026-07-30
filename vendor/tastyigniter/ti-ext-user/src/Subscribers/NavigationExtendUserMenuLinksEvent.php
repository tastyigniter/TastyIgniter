<?php

declare(strict_types=1);

namespace Igniter\User\Subscribers;

use Igniter\Flame\Traits\EventDispatchable;
use Illuminate\Support\Collection;

class NavigationExtendUserMenuLinksEvent
{
    use EventDispatchable;

    public function __construct(public Collection $links) {}

    public static function eventName(): string
    {
        return 'admin.menu.extendUserMenuLinks';
    }
}
