<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Converters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Override;

class OpenExchangeRates extends AbstractConverter
{
    const API_URL = 'https://openexchangerates.org/api/latest.json?app_id=%s&base=%s&symbols=%s';

    protected $appId;

    public function __construct(array $config = [])
    {
        $this->appId = $config['apiKey'] ?? '';
    }

    #[Override]
    public function converterDetails(): array
    {
        return [
            'name' => 'Open Exchange Rates',
            'description' => 'Conversion services provided by Open Exchange Rates.',
        ];
    }

    #[Override]
    public function getExchangeRates(string $base, array $currencies): array
    {
        if (!$this->appId) {
            return [];
        }

        $response = $this->cacheCallback($this->getCacheKey(), fn() => Http::get(sprintf(self::API_URL, $this->appId, $base, implode(',', $currencies))));

        if ($response->json('error')) {
            Log::info($response->json('description'));
        }

        return $response->json('rates', []);
    }
}
