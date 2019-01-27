<?php namespace System\Classes;

use ApplicationException;
use Cache;
use Carbon\Carbon;
use Config;
use Exception;
use Log;
use Request;

/**
 * Hub Manager Class
 * @package System
 */
class HubManager
{
    use \Igniter\Flame\Traits\Singleton;

    const ENDPOINT = 'https://api.tastyigniter.com/v2';

    protected $cachePrefix;

    protected $cacheTtl;

    public function initialize()
    {
        $this->cachePrefix = 'hub_';
        $this->cacheTtl = 0;
    }

    public function listItems($filter = [])
    {
        $cacheKey = $this->getCacheKey('items', $filter);

        if (!$items = Cache::get($cacheKey)) {
            $items = $this->requestRemoteData('items', array_merge(['include' => 'require'], $filter));

            if (!empty($items) AND is_array($items))
                Cache::put($cacheKey, $items, $this->cacheTtl);
        }

        return $items;
    }

    public function getDetail($type, $itemName = [])
    {
        return $this->requestRemoteData("{$type}/detail", ['item' => $itemName]);
    }

    public function getDetails($type, $itemNames = [])
    {
        return $this->requestRemoteData("{$type}/details", ['items' => $itemNames]);
    }

    public function applyItems($itemNames = [])
    {
        $response = $this->requestRemoteData('core/apply', [
            'items' => $itemNames,
            'version' => params('ti_version'),
            'edge' => Config::get('system.edgeUpdates', FALSE),
        ]);

        return $response;
    }

    public function applyItemsToUpdate($itemNames, $force = FALSE)
    {
        $cacheKey = $force ? null : $this->getCacheKey('updates', $itemNames);

        if (!$response = Cache::get($cacheKey)) {
            $response = $this->requestRemoteData('core/apply', [
                'items' => $itemNames,
                'include' => 'tags',
                'version' => params('ti_version'),
                'force' => $force,
                'edge' => Config::get('system.edgeUpdates', FALSE),
            ]);

            if ($cacheKey AND is_array($response)) {
                $response['check_time'] = Carbon::now()->toDateTimeString();
                Cache::put($cacheKey, $response, $this->cacheTtl);
            }
        }

        return $response;
    }

    public function applyCoreVersion()
    {
        $result = $this->requestRemoteData('ping', [
            'edge' => Config::get('system.edgeUpdates', FALSE),
        ]);

        return array_get($result, 'pong', 'v3.0.0');
    }

    public function buildMetaArray($response)
    {
        if (isset($response['type']))
            $response = ['items' => [$response]];

        if (isset($response['items'])) {
            $extensions = [];
            foreach ($response['items'] as $item) {
                if ($item['type'] == 'extension' AND
                    (!ExtensionManager::instance()->findExtension($item['type']) OR ExtensionManager::instance()->isDisabled($item['code']))
                ) {
                    if (isset($item['tags']))
                        arsort($item['tags']);

                    $extensions[$item['code']] = $item;
                }
            }

            unset($response['items']);
            $response['extensions'] = $extensions;
        }

        return $response;
    }

    public function downloadFile($filePath, $fileHash, $params = [])
    {
        return $this->requestRemoteFile('core/download', [
            'item' => $params,
            'edge' => Config::get('system.edgeUpdates', FALSE),
        ], $filePath, $fileHash);
    }

    protected function getSecurityKey()
    {
        return (!$carteKey = params('carte_key')) ? md5('NULL') : decrypt($carteKey);
    }

    protected function getCacheKey($fileName, $suffix)
    {
        return $this->cachePrefix.$fileName.'_'.md5(serialize($suffix));
    }

    protected function requestRemoteData($url, $params = [])
    {
        $result = null;

        try {
            $curl = $this->prepareRequest($url, $params);
            $result = curl_exec($curl);

            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500)
                throw new ApplicationException('Server error try again');

            curl_close($curl);
        }
        catch (Exception $ex) {
            throw new ApplicationException('Server responded with error: '.$ex->getMessage());
        }

        $response = null;
        try {
            $response = @json_decode($result, TRUE);
        }
        catch (Exception $ex) {
        }

        if (isset($response['message']) AND !in_array($httpCode, [200, 201])) {
            if (isset($response['errors']))
                Log::debug('Server validation errors: '.print_r($response['errors'], TRUE));

            throw new ApplicationException($response['message']);
        }

        return $response;
    }

    protected function requestRemoteFile($url, $params = [], $filePath, $fileHash)
    {
        if (!is_dir($fileDir = dirname($filePath)))
            throw new ApplicationException("Downloading failed, download path ({$filePath}) not found.");

        try {
            $curl = $this->prepareRequest($url, $params);
            $fileStream = fopen($filePath, 'wb');
            curl_setopt($curl, CURLOPT_FILE, $fileStream);
            curl_exec($curl);

            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500)
                throw new ApplicationException('Server error try again');

            curl_close($curl);
            fclose($fileStream);
        }
        catch (Exception $ex) {
            throw new ApplicationException('Server responded with error: '.$ex->getMessage());
        }

        $fileSha = sha1_file($filePath);

        if ($fileHash != $fileSha) {
            $error = @json_decode(file_get_contents($filePath), TRUE);
            @unlink($filePath);

            Log::info(
                array_get($error, 'message')
                    ? $error
                    : "Download failed, File hash mismatch: {$fileHash} (expected) vs {$fileSha} (actual)"
            );

            throw new ApplicationException(sprintf('Downloading %s failed, check error logs.', array_get($params, 'item.name')));
        }

        return TRUE;
    }

    protected function prepareRequest($uri, $params)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, Config::get('system.hubEndpoint', static::ENDPOINT).'/'.$uri);
        curl_setopt($curl, CURLOPT_USERAGENT, Request::userAgent());
        curl_setopt($curl, CURLOPT_TIMEOUT, 3600);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_REFERER, url()->current());
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

        $params['url'] = base64_encode(root_url());

        if ($siteKey = $this->getSecurityKey()) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ["TI-Rest-Key: bearer {$siteKey}"]);
        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));

        return $curl;
    }
}
