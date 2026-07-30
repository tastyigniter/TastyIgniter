<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Converters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Override;

class FixerIO extends AbstractConverter
{
    const API_URL = 'http://data.fixer.io/api/latest?access_key=%s&base=%s&symbols=%s';

    protected $accessKey;

    public function __construct(array $config = [])
    {
        $this->accessKey = $config['apiKey'] ?? '';
    }

    #[Override]
    public function converterDetails(): array
    {
        return [
            'name' => 'Fixer.io',
            'description' => 'Conversion services by Fixer.io',
        ];
    }

    #[Override]
    public function getExchangeRates($base, array $currencies): array
    {
        if (!$this->accessKey) {
            return [];
        }

        $response = $this->cacheCallback($this->getCacheKey(), fn() => Http::get(sprintf(self::API_URL, $this->accessKey, $base, implode(',', $currencies))));

        if (!$response->json('success')) {
            Log::debug('An error occurred when requesting currency exchange rates from fixer.io, check your api key.');
        }

        return $response->json('rates', []);
    }
}
