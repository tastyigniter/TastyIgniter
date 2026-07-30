<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency;

use Igniter\Flame\Currency\Converters\AbstractConverter;
use Illuminate\Support\Collection;
use Illuminate\Support\Manager;
use Override;

class Converter extends Manager
{
    public function getExchangeRates(string $base, Collection $currencies): array
    {
        $currencies = ($currencies->map->getCode())->all();

        return $this->driver()->getExchangeRates($base, $currencies);
    }

    /**
     * Get a driver instance.
     */
    #[Override]
    public function driver(mixed $driver = null): AbstractConverter
    {
        $driver = $driver ?: $this->getDefaultDriver();

        return $this->createDriver($driver);
    }

    #[Override]
    public function getDefaultDriver(): string
    {
        return $this->container['config']['igniter-currency.converter'] ?? 'openexchangerates';
    }

    public function createOpenExchangeRatesDriver(): AbstractConverter
    {
        $config = $this->container['config']['igniter-currency.converters.openexchangerates'];

        return new $config['class']($config);
    }

    public function createFixerIODriver(): AbstractConverter
    {
        $config = $this->container['config']['igniter-currency.converters.fixerio'];

        return new $config['class']($config);
    }
}
