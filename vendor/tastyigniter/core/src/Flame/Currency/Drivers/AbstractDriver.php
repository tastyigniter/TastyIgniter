<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Drivers;

use Igniter\Flame\Currency\Contracts\DriverInterface;
use Illuminate\Support\Arr;

abstract class AbstractDriver implements DriverInterface
{
    /**
     * Create a new driver instance.
     */
    public function __construct(protected array $config = []) {}

    /**
     * Get configuration value.
     */
    protected function config(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->config, $key, $default);
    }
}
