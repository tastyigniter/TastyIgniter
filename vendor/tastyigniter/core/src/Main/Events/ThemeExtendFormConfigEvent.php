<?php

declare(strict_types=1);

namespace Igniter\Main\Events;

use Igniter\Flame\Traits\EventDispatchable;

class ThemeExtendFormConfigEvent
{
    use EventDispatchable;

    final public function __construct(public string $themeName, public array $config) {}

    public function getConfig(): array
    {
        return $this->config;
    }
}
