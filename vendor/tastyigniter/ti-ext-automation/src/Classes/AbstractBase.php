<?php

declare(strict_types=1);

namespace Igniter\Automation\Classes;

use Igniter\Flame\Traits\ExtensionTrait;

abstract class AbstractBase
{
    use ExtensionTrait;

    public static function extend(callable $callback): void
    {
        self::extensionExtendCallback($callback);
    }
}
