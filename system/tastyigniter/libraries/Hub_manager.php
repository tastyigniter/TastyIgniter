<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 2.2
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hub Manager Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Hub_manager.php
 * @link           http://docs.tastyigniter.com
 */
class Hub_manager
{

	protected $siteKey;
	protected $cachePrefix;
	protected $cacheLife;
	protected $downloadsPath;

	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->driver('cache');
		$this->cachePrefix = 'hub_manager_';
		$this->downloadsPath = storage_path('temp/hub');

		$this->setSecurity();
	}

	public function setCacheLife($period = null)
	{
		$this->cacheLife = $period * 60 * 60;

		return $this;
	}

	public function listItems($filter = [])
	{
		$cacheFile = $this->cachePrefix . 'items_' . md5(serialize($filter));
		if (!$items = $this->CI->cache->file->get($cacheFile)) {
			$items = $this->requestRemoteData('items', $filter);

			if (!empty($items) AND is_array($items))
				$this->CI->cache->file->save($cacheFile, $items, $this->cacheLife);
		}

		return $items;
	}

	public function getDetail($itemName)
	{
		return $this->requestRemoteData('item/detail', ['item' => json_encode($itemName)]);
	}

	public function getDetails($itemNames = [])
	{
		return $this->requestRemoteData('item/details', ['items' => json_encode($itemNames)]);
	}

	public function requestUpdateList($itemNames, $force = FALSE)
	{
		$itemNames = json_encode($itemNames);
		$cacheFile = $this->getCacheFilePath('updates', $itemNames);

		if ($force OR !$response = $this->CI->cache->file->get($cacheFile)) {
			$response = $this->requestRemoteData('core/check', ['items' => $itemNames]);

			if (is_array($response)) {
				$response['check_time'] = time();
				$this->CI->cache->file->save($cacheFile, $response, $this->cacheLife);
			}
		}

		if (is_array($response))
			$response = $this->buildMetaArray($response);

		return $response;
	}

	public function applyInstallOrUpdate($itemNames = [])
	{
		$response = $this->requestRemoteData('core/apply', ['items' => json_encode($itemNames)]);

		if (is_array($response))
			return $this->buildMetaArray($response);

		throw new Exception($response);
	}

	public function downloadFile($fileType, $filePath, $fileHash, $params = [])
	{
		return $this->requestRemoteFile("{$fileType}/download", [
			'item' => json_encode($params)
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
					(!Modules::find_extension($item['type']) OR Modules::is_disabled($item['code']))
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

	private function getCacheFilePath($string, $itemNames)
	{
		$cachePath = str_split(substr(md5($this->cachePrefix . $string), 0, 9), 3);
		$cachePath = implode(DIRECTORY_SEPARATOR, $cachePath);

		return $this->cachePrefix. $string.'_' . md5($itemNames);
	}

	public function setSecurity()
	{
		$this->siteKey = empty($siteKey = $this->CI->config->item('site_key')) ? md5('NULL') : $siteKey;
	}

	/**
	 * @return Installer
	 */
	public function getInstaller()
	{
		return $this->CI->installer;
	}

	protected function requestRemoteData($url, $params = [])
	{
		$response = get_remote_data(TI_ENDPOINT . $url, $this->buildPostData($params));
		$response = @json_decode($response, TRUE);

		if (is_null($response)) {
			log_message('error', 'Server error, try again');

			return 'Server error, try again';
		}

		if (isset($response['status']) AND isset($response['message'])) {
			log_message('error', isset($response['message']) ? $response['message'] : '');

			return isset($response['message']) ? $response['message'] : '';
		}

		return $response;
	}

	protected function requestRemoteFile($url, $params = [], $filePath, $fileHash)
	{
		if (!is_dir($fileDir = dirname($filePath)))
			throw new Exception("Downloading failed, download path not found.");

		$fileStream = fopen($filePath, 'w+');

		get_remote_data(TI_ENDPOINT . $url, $this->buildPostData($params, ['FILE' => $fileStream]));

		if (file_exists($filePath)) {
			$fileSha = sha1_file($filePath);
			if ($fileHash != $fileSha) {
				$response = @json_decode(file_get_contents($filePath), TRUE);
				@unlink($filePath);

				if (isset($response['status']) AND isset($response['message'])) {
					log_message('error', isset($response['message']) ? $response['message'] : '');
					throw new Exception(isset($response['message']) ? $response['message'] : '');
				} else {
					log_message('error', "File hash mismatch: {$fileHash} (expected) vs {$fileSha} (actual)");
					throw new Exception("Downloading failed, check error log.");
				}
			}
		}

		return TRUE;
	}

	protected function buildPostData($params = [], $options = [])
	{
		$options['USERAGENT'] = $this->CI->agent->agent_string();
		$options['REFERER'] = page_url();
		$options['AUTOREFERER'] = TRUE;
		$options['FOLLOWLOCATION'] = 1;

		if (empty($options['TIMEOUT']))
			$options['TIMEOUT'] = 3600;

		$info = $this->getInstaller()->getSysInfo();
		$params['version'] = $info['ver'];
		$params['server'] = base64_encode(serialize($info));

		if (isset($params['filter']))
			$params['filter'] = $params['filter'];

		if (!empty($params))
			$options['POSTFIELDS'] = $params;

		if ($this->siteKey)
			$options['HTTPHEADER'][] = TI_SITE_AUTH . ": {$this->siteKey}";

		$options['HTTPHEADER'][] = TI_SIGN_REQUEST . ": " . $this->createSignature($params, $this->siteKey);

		return $options;
	}

	protected function createSignature($postData, $siteKey)
	{
		return base64_encode(hash_hmac('sha256', serialize($postData), $siteKey));
	}
}