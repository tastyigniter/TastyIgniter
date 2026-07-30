<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Drivers;

use DateTime;
use Illuminate\Support\Arr;
use Override;

class Filesystem extends AbstractDriver
{
    /**
     * Database manager instance.
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Create a new driver instance.
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->filesystem = app('filesystem')->disk($this->config('disk'));
    }

    #[Override]
    public function create(array $params): bool
    {
        // Get blacklist path
        $path = $this->config('path');

        // Get all as an array
        $currencies = $this->all();

        // Verify the currency doesn't exists
        if (isset($currencies[$params['code']])) {
            return true;
        }

        // Created at stamp
        $created = (new DateTime('now'))->format('Y-m-d H:i:s');

        $currencies[$params['code']] = array_merge([
            'name' => '',
            'code' => '',
            'symbol' => '',
            'format' => '',
            'currency_rate' => 1,
            'active' => 0,
            'created_at' => $created,
            'updated_at' => $created,
        ], $params);

        return $this->filesystem->put($path, json_encode($currencies, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    #[Override]
    public function all(): array
    {
        // Get blacklist path
        $path = $this->config('path');

        // Get contents if file exists
        $contents = $this->filesystem->exists($path)
            ? $this->filesystem->get($path)
            : '{}';

        return json_decode((string)$contents, true);
    }

    #[Override]
    public function find(string $code, ?int $active = 1): mixed
    {
        $currency = Arr::get($this->all(), $code);

        // Skip active check
        if (is_null($active)) {
            return $currency;
        }

        return Arr::get($currency, 'currency_status', 1) ? $currency : null;
    }

    #[Override]
    public function update(string $code, array $attributes, ?DateTime $timestamp = null): int
    {
        // Get blacklist path
        $path = $this->config('path');

        // Get all as an array
        $currencies = $this->all();

        // Verify the currency exists
        if (isset($currencies[$code]) === false) {
            return 0;
        }

        // Create timestamp
        if (empty($attributes['updated_at'])) {
            $attributes['updated_at'] = (new DateTime('now'))->format('Y-m-d H:i:s');
        }

        // Merge values
        $currencies[$code] = array_merge($currencies[$code], $attributes);

        return (int)$this->filesystem->put($path, json_encode($currencies, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    #[Override]
    public function delete(string $code): int
    {
        // Get blacklist path
        $path = $this->config('path');

        // Get all as an array
        $currencies = $this->all();

        // Verify the currency exists
        if (isset($currencies[$code]) === false) {
            return 0;
        }

        unset($currencies[$code]);

        return (int)$this->filesystem->put($path, json_encode($currencies, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
