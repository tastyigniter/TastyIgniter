<?php namespace System\Classes;

use Cache;
use Exception;
use Request;

/**
 * Hub Manager Class
 * @package System
 */
class HubManager
{
    use \Igniter\Flame\Traits\Singleton;

    const ENDPOINT = 'http://api.tasty-cms.com/v2';

    protected $siteKey;

    protected $cachePrefix;

    protected $cacheLife;

    protected $downloadsPath;

    protected $installer;

    public function initialize()
    {
        $this->cachePrefix = 'hub_';
        $this->downloadsPath = storage_path('temp/hub');
    }

    public function setCacheLife($period = null)
    {
        $this->cacheLife = $period * 60;

        return $this;
    }

    public function listItems($filter = [])
    {
        $cacheFile = $this->getCacheFilePath('items', serialize($filter));

        if (!$items = Cache::get($cacheFile)) {
            $items = $this->requestRemoteData('items', array_merge(['include' => 'require'], $filter));

            if (!empty($items) AND is_array($items))
                Cache::put($cacheFile, $items, $this->cacheLife);
        }

        return $items;
    }

    public function getDetail($type, $itemName = [])
    {
        return $this->requestRemoteData("{$type}/detail", ['item' => json_encode($itemName)]);
    }

    public function getDetails($type, $itemNames = [])
    {
        return $this->requestRemoteData("{$type}/details", ['items' => json_encode($itemNames)]);
    }

    public function applyItems($type, $itemNames = [])
    {
        $postData = [
            'version' => params('ti_version'),
            'items'   => json_encode($itemNames),
        ];

        $response = $this->requestRemoteData("{$type}/apply", $postData);

        return $response;
    }

    public function applyItemsToUpdate($itemNames, $force = FALSE)
    {
        $itemNames = json_encode($itemNames);

        $cacheFile = $this->getCacheFilePath('updates', $itemNames);

        if ($force OR !$response = Cache::get($cacheFile)) {
            $response = $this->requestRemoteData('core/apply', [
                'version' => params('ti_version'),
                'items'   => $itemNames,
                'include' => 'tags',
            ]);

            if (is_array($response)) {
                $response['check_time'] = time();
                Cache::put($cacheFile, $response, $this->cacheLife);
            }
        }

        return $response;
    }

    public function downloadFile($fileType, $filePath, $fileHash, $params = [])
    {
        return $this->requestRemoteFile("{$fileType}/download", [
            'item' => json_encode($params),
        ], $filePath, $fileHash);
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

    private function getCacheFilePath($fileName, $suffix)
    {
        $cachePath = str_split(substr(md5($this->cachePrefix.$fileName), 0, 9), 3);
        $cachePath = implode(DIRECTORY_SEPARATOR, $cachePath);

//        dd($this->cachePrefix);
//        if (!is_dir($this->cachePrefix))
//            mkdir($this->cachePrefix, 0777, true);

        return $this->cachePrefix.$fileName.'_'.md5($suffix);
    }

    public function setSecurity($key, $info)
    {
        params()->set('carte_key', $key ? encrypt($key) : '');

        if ($info AND is_array($info))
            params()->set('carte_info', $info);

        params()->save();
    }

    public function getSecurity()
    {
        return (!$carteKey = params('carte_key')) ? md5('NULL') : decrypt($carteKey);
    }

    public function getSysInfo()
    {
        $info = [
            'domain' => root_url(),
            'ver'    => params('ti_version'),
            'os'     => php_uname(),
            'php'    => phpversion(),
        ];

        return $info;
    }

    protected function requestRemoteData($url, $params = [])
    {
        try {
            $curl = $this->prepareRequest($url, $params);
            $result = curl_exec($curl);

            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500)
                throw new Exception('Server error try again');

            curl_close($curl);
        } catch (Exception $ex) {
            throw new Exception('Server responded with error: '.$ex->getMessage());
        }

        $response = null;
        try {
            $response = @json_decode($result, TRUE);
        } catch (Exception $ex) {
        }

        if (isset($response['message']) AND !in_array($httpCode, [200, 201])) {
            throw new Exception($response['message']);
        }

        return $response;
    }

    protected function requestRemoteFile($url, $params = [], $filePath, $fileHash)
    {
        if (!is_dir($fileDir = dirname($filePath)))
            throw new Exception("Downloading failed, download path not found.");

        try {
            $curl = $this->prepareRequest($url, $params);
            $fileStream = fopen($filePath, 'w+');
            curl_setopt($curl, CURLOPT_FILE, $fileStream);
            $result = curl_exec($curl);

            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500)
                throw new Exception('Server error try again');

            curl_close($curl);
        } catch (Exception $ex) {
            throw new Exception('Server responded with error: '.$ex->getMessage());
        }

        if (file_exists($filePath)) {
            $fileSha = sha1_file($filePath);
            if ($fileHash != $fileSha) {
                $response = @json_decode(file_get_contents($filePath), TRUE);
                @unlink($filePath);

                if (isset($response['message'])) {
                    throw new Exception(isset($response['message']) ? $response['message'] : '');
                }
                else {
                    throw new Exception("Download failed, File hash mismatch: {$fileHash} (expected) vs {$fileSha} (actual)");
                }
            }
        }

        return TRUE;
    }

    protected function prepareRequest($uri, $params)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, static::ENDPOINT.'/'.$uri);
        curl_setopt($curl, CURLOPT_USERAGENT, Request::userAgent());
        curl_setopt($curl, CURLOPT_TIMEOUT, 3600);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_REFERER, url()->current());
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

        $info = $this->getSysInfo();
        $params['server'] = base64_encode(serialize($info));

        if ($siteKey = $this->getSecurity()) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ["TI-Rest-Key: bearer {$siteKey}"]);
        }

        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));

        return $curl;
    }

    protected function createSignature($postData, $siteKey)
    {
        return base64_encode(hash_hmac('sha256', serialize($postData), $siteKey));
    }
}