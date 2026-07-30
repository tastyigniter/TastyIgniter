<?php

declare(strict_types=1);

namespace Igniter\Main\Events;

use Igniter\Flame\Traits\EventDispatchable;

final class ThemeGetActiveEvent
{
    use EventDispatchable;

    public static function eventName(): string
    {
        return 'theme.getActiveTheme';
    }
}
