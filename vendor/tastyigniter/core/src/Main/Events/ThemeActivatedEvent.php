<?php

declare(strict_types=1);

namespace Igniter\Main\Events;

use Igniter\Flame\Traits\EventDispatchable;
use Igniter\Main\Models\Theme;

class ThemeActivatedEvent
{
    use EventDispatchable;

    final public function __construct(public Theme $theme) {}

    public static function eventName(): string
    {
        return 'main.theme.activated';
    }
}
