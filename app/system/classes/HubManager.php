<?php namespace System\Classes;

use Exception;
use System\Models\Settings_model;
use Igniter\Flame\Traits\Singleton;

/**
 * Hub Manager Class
 *
 * @package System
 *
 * @property \TI_Loader $load                       TemplateLoader Class.
 * @property \TI_Config $config                     Config Class.
 * @property \CI_Cache $cache                       Cache Class.
 */
class HubManager
{
    use Singleton;

    protected $siteKey;

    protected $cachePrefix;

    protected $cacheLife;

    protected $downloadsPath;

    protected $installer;

    public function initialize()
    {
//        $this->load->driver('cache', ['adapter' => $this->config->item('cache_driver')]);
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

        if (!$items = $this->cache->get($cacheFile)) {
            $items = $this->requestRemoteData('items', array_merge(['include' => 'require'], $filter));

            if (!empty($items) AND is_array($items))
                $this->cache->save($cacheFile, $items, $this->cacheLife);
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
            'version' => TI_VERSION,
            'items'   => json_encode($itemNames),
        ];

        $response = $this->requestRemoteData("{$type}/apply", $postData);

        return $response;
    }

    public function applyItemsToUpdate($itemNames, $force = FALSE)
    {
        $itemNames = json_encode($itemNames);

        $cacheFile = $this->getCacheFilePath('updates', $itemNames);

        if ($force OR !$response = $this->cache->get($cacheFile)) {
            $response = $this->requestRemoteData('core/apply', [
                'version' => TI_VERSION,
                'items'   => $itemNames,
                'include' => 'tags',
            ]);

            if (is_array($response)) {
                $response['check_time'] = time();
                $this->cache->save($cacheFile, $response, $this->cacheLife);
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

    public function setSecurity($key)
    {
        if (!is_string($key))
            return null;

        $this->load->library('encrypt');
        $key = $this->encrypt->encode($key);
        $this->config->set_item('carte_key', $key);
        params()->set('carte_key', $key);
//        $this->siteKey = $this->config->item('carte_key');
    }

    public function getSecurity()
    {
        $this->load->library('encrypt');

        return (!$siteKey = $this->config->item('carte_key')) ? md5('NULL') : $this->encrypt->decode($siteKey);
    }

    /**
     * @return \System\Classes\InstallerManager
     */
    public function getInstaller()
    {
        if (!$this->installer)
            $this->installer = InstallerManager::instance();

        return $this->installer;
    }

    protected function requestRemoteData($url, $params = [])
    {
        try {
            $curl = $this->prepareRequest($url, $params);
            $result = curl_exec($curl);

            log_message('debug', sprintf('Server request: %s', $url));
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500)
                throw new Exception('Server error try again');

            log_message('debug', sprintf('Request information: %s', print_r(curl_getinfo($curl), TRUE)));
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
            if (isset($response['errors'])) log_message('debug', print_r($response['errors'], TRUE));
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

            log_message('debug', sprintf('Server request: %s', $url));
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($httpCode == 500)
                throw new Exception('Server error try again');

            log_message('debug', sprintf('Request information: %s', print_r(curl_getinfo($curl), TRUE)));
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
                    log_message('error', "File hash mismatch: {$fileHash} (expected) vs {$fileSha} (actual)");
                    throw new Exception("Download failed, check error log.");
                }
            }
        }

        return TRUE;
    }

    protected function buildPostData($params = [], $options = [])
    {
        $options['USERAGENT'] = $this->agent->agent_string();
        $options['REFERER'] = page_url();
        $options['AUTOREFERER'] = TRUE;
        $options['FOLLOWLOCATION'] = 1;

        if (empty($options['TIMEOUT']))
            $options['TIMEOUT'] = 3600;

        $info = $this->getInstaller()->getSysInfo();
        $params['version'] = $info['ver'];
        $params['server'] = base64_encode(serialize($info));

        if (!empty($params))
            $options['POSTFIELDS'] = $params;

        if ($this->siteKey)
            $options['HTTPHEADER'][] = TI_SITE_AUTH.": {$this->siteKey}";

        $options['HTTPHEADER'][] = TI_SIGN_REQUEST.": ".$this->createSignature($params, $this->siteKey);

        return $options;
    }

    protected function createSignature($postData, $siteKey)
    {
        return base64_encode(hash_hmac('sha256', serialize($postData), $siteKey));
    }

    protected function prepareRequest($uri, $params)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, TI_ENDPOINT.'/'.$uri);
        curl_setopt($curl, CURLOPT_TIMEOUT, 3600);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

        if ($this->agent->agent_string())
            curl_setopt($curl, CURLOPT_USERAGENT, $this->agent->agent_string());

        if ($siteKey = $this->getSecurity())
            curl_setopt($curl, CURLOPT_HTTPHEADER, [TI_REST_AUTH.": bearer {$siteKey}"]);

        $info = $this->getInstaller()->getSysInfo();
        $params['server'] = base64_encode(serialize($info));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));

        log_message('debug', sprintf('Hub request data: %s', serialize($params)));

        return $curl;
    }
}