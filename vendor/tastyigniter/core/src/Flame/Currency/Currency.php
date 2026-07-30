<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency;

use Carbon\Carbon;
use Igniter\Flame\Currency\Contracts\CurrencyInterface;
use Igniter\Flame\Currency\Contracts\FormatterInterface;
use Illuminate\Contracts\Cache\Factory as FactoryContract;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Currency
{
    protected Repository $cache;

    protected ?CurrencyInterface $model = null;

    protected ?FormatterInterface $formatter = null;

    protected ?string $userCurrency = null;

    protected ?array $currenciesCache = null;

    protected ?Collection $loadedCurrencies = null;

    /**
     * Create a new instance.
     */
    public function __construct(protected array $config, FactoryContract $cache)
    {
        $this->cache = $cache->store($this->config('cache_driver'));
    }

    /**
     * Format given number.
     */
    public function convert(
        string|int|float $amount,
        ?string $from = null,
        ?string $to = null,
        bool $format = true,
    ): null|float|string|int {
        // Get currencies involved
        $from = $from ?: $this->config('default');
        $to = $to ?: $this->getUserCurrency();

        // Ensure exchange rates is fresh
        $this->updateRates();

        // Get exchange rates
        $fromRate = optional($this->getCurrency($from))->getRate();
        $toRate = optional($this->getCurrency($to))->getRate();

        // Skip invalid to currency rates
        if ($toRate === null) {
            return null;
        }

        // Convert amount
        $value = $amount * $toRate * (1 / $fromRate);

        // Should the result be formatted?
        if ($format) {
            return $this->format($value, $to);
        }

        // Return value
        return $value;
    }

    /**
     * Format the value into the desired currency.
     */
    public function format(string|float $value, null|int|string $code = null, bool $includeSymbol = true): string
    {
        // Get default currency if one is not set
        $code = $code ?: $this->config('default');

        if (is_numeric($code)) {
            $code = $this->getCurrency($code)?->getCode() ?: $code;
        }

        // Remove unnecessary characters
        $value = preg_replace('/[\s\',!]/', '', (string)$value);

        // Check for a custom formatter
        if (!is_null($formatter = $this->getFormatter())) {
            return $formatter->format((float)$value, $code);
        }

        // Get the measurement format
        $format = $this->getCurrency($code)?->getFormat();

        // Value Regex
        $valRegex = '/(\d.*|)\d/';

        // Match decimal and a thousand separators
        preg_match_all('/[\s\',.!]/', (string)$format, $separators);

        if (($thousand = array_get($separators, '0.0')) && $thousand == '!') {
            $thousand = '';
        }

        $decimal = array_get($separators, '0.1');

        // Match format for decimals count
        preg_match($valRegex, (string)$format, $valFormat);

        $valFormat = array_get($valFormat, 0, 0);

        // Count decimals length
        $strrchrResult = $decimal ? strrchr((string)$valFormat, (string)$decimal) : false;
        $decimals = $strrchrResult !== false ? strlen(substr($strrchrResult, 1)) : 0;

        // Do we have a negative value?
        $negative = $value < 0 ? '-' : '';
        if ($negative !== '') {
            $value = (float)$value * -1;
        }

        // Format the value
        $value = number_format((float)$value, $decimals, $decimal, $thousand);

        // Apply the formatted measurement
        if ($includeSymbol) {
            $value = preg_replace($valRegex, $value, (string)$format);
        }

        // Return value
        return $negative.$value;
    }

    /**
     * Format the value into a json array
     */
    public function formatToJson(float $value, null|int|string $code = null): array
    {
        // Get default currency if one is not set
        $code = $code ?: $this->config('default');

        if (is_numeric($code)) {
            $code = optional($this->getCurrency($code))->getCode() ?: $code;
        }

        return [
            'currency' => $code,
            'value' => $value,
        ];
    }

    /**
     * Set user's currency.
     */
    public function setUserCurrency(string $code): void
    {
        $this->userCurrency = strtoupper($code);
    }

    /**
     * Return the user's currency code.
     */
    public function getUserCurrency(): string
    {
        $code = $this->userCurrency ?: $this->config('default');

        return optional($this->getCurrency($code))->currency_code;
    }

    /**
     * Determine if the provided currency is valid.
     */
    public function hasCurrency(string $code): bool
    {
        return (bool)$this->getCurrency(strtoupper($code));
    }

    /**
     * Determine if the provided currency is active.
     */
    public function isActive(string $code): bool
    {
        return $code && optional($this->getCurrency($code))->isEnabled();
    }

    /**
     * Return the current currency if the one supplied is not valid.
     */
    public function getCurrency(null|int|string $code = null): ?CurrencyInterface
    {
        if (isset($this->currenciesCache[$code])) {
            return $this->currenciesCache[$code];
        }

        $code = $code ?: $this->getUserCurrency();

        $currency = $this->getCurrencies()->first(fn(CurrencyInterface $currency): bool => ($currency->isEnabled() && $code == $currency->getId()) || ($code === $currency->getCode()));

        return $this->currenciesCache[$code] = $currency;
    }

    /**
     * Return all currencies.
     */
    public function getCurrencies(): Collection
    {
        if (!$this->loadedCurrencies instanceof Collection) {
            $this->loadCurrencies();
        }

        return $this->loadedCurrencies;
    }

    /**
     * Get currency model.
     */
    public function getModel(): CurrencyInterface|\Igniter\System\Models\Currency
    {
        if (!$this->model instanceof CurrencyInterface && ($model = $this->config('model'))) {
            // Create model instance
            $this->model = new $model;
        }

        return $this->model;
    }

    /**
     * Get formatter driver.
     */
    public function getFormatter(): ?FormatterInterface
    {
        if (!$this->formatter instanceof FormatterInterface && $this->config('formatter') !== null) {
            // Get formatter configuration
            $config = $this->config('formatters.'.$this->config('formatter'), []);

            // Get formatter class
            $class = Arr::pull($config, 'class');

            // Create formatter instance
            $this->formatter = new $class(array_filter($config));
        }

        return $this->formatter;
    }

    /**
     * Clear cached currencies.
     */
    public function clearCache(): void
    {
        $this->cache->forget('igniter.currency');
    }

    /**
     * Get configuration value.
     */
    public function config(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->config;
        }

        return Arr::get($this->config, $key, $default);
    }

    protected function loadCurrencies()
    {
        $currencies = $this->cache->rememberForever('igniter.currency', fn() => $this->getModel()->get());

        $this->loadedCurrencies = $currencies;
    }

    //
    //
    //

    public function updateRates(bool $skipCache = false): void
    {
        $base = $this->config('default');

        $rates = $this->getRates($base, $skipCache);

        $this->getCurrencies()->each(function(CurrencyInterface $currency) use ($rates) {
            if ($rate = array_get($rates, $currency->getCode())) {
                $currency->updateRate($rate);
            }
        });
    }

    protected function getRates(string $base, bool $skipCache = false): array
    {
        $duration = Carbon::now()->addHours($this->config('ratesCacheDuration', 0));

        $currencies = $this->getCurrencies();

        if ($skipCache) {
            return app('currency.converter')->getExchangeRates($base, $currencies);
        }

        return $this->cache->remember('igniter.currency.rates', $duration, fn() => app('currency.converter')->getExchangeRates($base, $currencies));
    }

    /**
     * Get a given value from the current currency.
     */
    public function __get(string $key): mixed
    {
        return $this->getCurrency()->$key;
    }

    /**
     * Dynamically call the default driver instance.
     */
    public function __call(string $method, array $parameters): mixed
    {
        return call_user_func_array([$this->getModel(), $method], $parameters);
    }
}
