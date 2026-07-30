<?php

declare(strict_types=1);

namespace Igniter\Flame\Support;

use Igniter\Flame\Traits\ExtendableTrait;

/**
 * Extendable Class
 *
 * If a class extends this class, it will enable support for using "Private traits".
 *
 * Usage:
 *
 *     public array $implement = [\Path\To\Some\Namespace\Class::class];
 *
 * Based on october\extension Extendable Class
 * @link https://github.com/octobercms/library/tree/master/src/Extension/Extendable.php
 */
class Extendable
{
    use ExtendableTrait;

    public function __construct()
    {
        $this->extendableConstruct();
    }

    public function __get(string $name): mixed
    {
        return $this->extendableGet($name);
    }

    public function __set(string $name, mixed $value): void
    {
        $this->extendableSet($name, $value);
    }

    public function __call(string $name, ?array $params): mixed
    {
        return $this->extendableCall($name, $params);
    }

    public static function __callStatic(string $name, ?array $params): mixed
    {
        return self::extendableCallStatic($name, $params);
    }

    public static function extend(callable $callback): void
    {
        self::extendableExtendCallback($callback);
    }

    public static function implement(string|array $class): void
    {
        self::extendableExtendCallback(function($instance) use ($class) {
            $instance->implement = array_unique(array_merge($instance->implement, (array)$class));
        });
    }
}
