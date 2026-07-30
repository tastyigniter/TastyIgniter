<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Facades\Igniter\System\Helpers\SystemHelper;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\Igniter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

/**
 * Hub Manager Class
 */
class HubManager
{
    public function listItems(array $filter = []): array
    {
        return $this->requestRemoteData('items', array_merge(['include' => 'require'], $filter));
    }

    public function getSiteDetail(): array
    {
        return $this->getDetail('site');
    }

    public function getItemDetail(array $itemName): array
    {
        return array_get($this->getDetail('item', $itemName), 'data', []);
    }

    public function getItemDetails(array $itemNames): array
    {
        return $this->getDetails('item', $itemNames);
    }

    public function applyInstalledItems(array $itemNames): array
    {
        return $this->requestRemoteData('core/installed', ['items' => $itemNames]);
    }

    protected function getDetail(string $type, array $itemName = []): array
    {
        return $this->requestRemoteData($type.'/detail', ['item' => $itemName]);
    }

    protected function getDetails(string $type, array $itemNames = []): array
    {
        return $this->requestRemoteData($type.'/details', ['items' => $itemNames]);
    }

    protected function requestRemoteData(string $uri, array $params = [], ?string $eTag = null): array
    {
        throw_unless($endpoint = config('igniter-system.updatesEndpoint'), new SystemException(
            'Updates endpoint not configured',
        ));

        $client = Http::baseUrl($endpoint);

        $response = $client->acceptJson()
            ->withHeaders($this->prepareHeaders($params))
            ->post($uri, $this->prepareRequest($params));

        if (!$response->ok()) {
            if ($errors = $response->json('errors')) {
                logger()->debug('Server validation errors: '.print_r($errors, true));
            }

            throw new SystemException($response->json('message', 'Error occurred while processing your request.'));
        }

        throw_if(
            $eTag && $response->json('data.hash') !== $eTag,
            new SystemException('ETag mismatch, please try again.'),
        );

        return $response->json();
    }

    protected function prepareRequest(array $params): array
    {
        $params['client'] = 'tastyigniter';
        $params['server'] = base64_encode(serialize([
            'php' => PHP_VERSION,
            'url' => SystemHelper::resolveUrl(),
            'version' => Igniter::version(),
            'host' => gethostname() ?: 'unknown',
        ]));

        if (config('igniter-system.edgeUpdates', false)) {
            $params['edge'] = 1;
        }

        return $params;
    }

    protected function prepareHeaders(array $params): array
    {
        $headers = [];
        $siteKey = config('igniter-system.carteKey') ?: params('carte_key', '');
        if ($siteKey) {
            $headers['Authorization'] = 'Bearer '.$siteKey;
        }

        if (!App::runningInConsole()) {
            $headers['X-Igniter-Host'] = gethostname() ?: 'unknown';
            $headers['X-Igniter-User-Ip'] = request()->ip();
        }

        $headers['X-Igniter-Platform'] = SystemHelper::platformHeaderValue();

        return $headers;
    }

    //
    // Language Packs
    //

    public function listLanguages(array $filter = []): array
    {
        return $this->requestRemoteData('languages', $filter);
    }

    public function getLanguage(string $locale): array
    {
        return $this->requestRemoteData('language/'.$locale);
    }

    public function applyLanguagePack(string $locale, ?array $items = null): array
    {
        return $this->requestRemoteData('language/apply', [
            'locale' => $locale,
            'items' => $items,
        ]);
    }

    public function downloadLanguagePack(string $eTag, array $params = []): array
    {
        return $this->requestRemoteData('language/download', $params, $eTag);
    }

    public function publishTranslations(string $locale, array $packs = []): array
    {
        return $this->requestRemoteData('language/upload', [
            'locale' => $locale,
            'item' => $packs,
        ]);
    }
}
