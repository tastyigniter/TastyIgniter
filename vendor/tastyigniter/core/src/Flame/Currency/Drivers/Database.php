<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Drivers;

use DateTime;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Collection;
use Override;

class Database extends AbstractDriver
{
    protected ConnectionInterface $database;

    /**
     * Create a new driver instance.
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->database = app('db')->connection($this->config('connection'));
    }

    #[Override]
    public function create(array $params): bool
    {
        // Ensure the currency doesn't already exist
        if ($this->find(array_get($params, 'code', array_get($params, 'currency_code')), null) !== null) {
            return true;
        }

        $params = array_merge([
            'currency_name' => '',
            'currency_code' => '',
            'currency_symbol' => '',
            'currency_rate' => 1,
            'currency_status' => 0,
            'updated_at' => now()->toDateTimeString(),
        ], $params);

        return $this->database->table($this->config('table'))->insert($params);
    }

    #[Override]
    public function all(): array
    {
        $collection = new Collection($this->database->table($this->config('table'))->get());

        return $collection->keyBy('currency_code')
            ->map(function($item): array {
                $format = $item->thousand_sign.'0'.$item->decimal_sign.str_repeat('0', (int)$item->decimal_position);

                return [
                    'currency_id' => $item->currency_id,
                    'currency_name' => $item->currency_name,
                    'currency_code' => strtoupper((string)$item->currency_code),
                    'currency_symbol' => $item->currency_symbol,
                    'format' => $item->symbol_position
                        ? '1'.$format.$item->currency_symbol
                        : $item->currency_symbol.'1'.$format,
                    'currency_rate' => $item->currency_rate,
                    'currency_status' => $item->currency_status,
                    'updated_at' => $item->updated_at,
                ];
            })
            ->all();
    }

    #[Override]
    public function find(string $code, ?int $active = 1): mixed
    {
        $query = $this->database->table($this->config('table'))
            ->where('currency_code', strtoupper($code));

        // Make active optional
        if (!is_null($active)) {
            $query->where('currency_status', $active);
        }

        return $query->first();
    }

    #[Override]
    public function update(string $code, array $attributes, ?DateTime $timestamp = null): int
    {
        $table = $this->config('table');

        // Create timestamp
        if (empty($attributes['updated_at'])) {
            $attributes['updated_at'] = new DateTime('now');
        }

        return $this->database->table($table)
            ->where('currency_code', strtoupper($code))
            ->update($attributes);
    }

    #[Override]
    public function delete(string $code): int
    {
        $table = $this->config('table');

        return $this->database->table($table)
            ->where('currency_code', strtoupper($code))
            ->delete();
    }
}
