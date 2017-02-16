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
 * @since         File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Updates Manager Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Updates_manager.php
 * @link           http://docs.tastyigniter.com
 */
class Updates_manager
{

	protected $logFile;
	protected $updatedFiles;
	protected $installedItems;

	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->library('hub_manager');

		$this->logFile = $this->CI->config->item('log_path') . 'updates.log';
	}

	public function isLastCheckDue()
	{
		$response = $this->requestUpdateList(false);

		if (isset($response['last_check'])) {
			return (strtotime('-7 day') < strtotime($response['last_check']));
		}

		return TRUE;
	}

	public function getPopularItems($itemType)
	{
		$installedItems = $this->getInstalledItems();

		$items = $this->getHubManager()->setCacheLife(5)->listItems(['browse' => 'popular', 'type' => $itemType]);
		if (isset($items['data'])) foreach ($items['data'] as &$item) {
			$item['installed'] = isset($installedItems[$item['code']]);
		}

		return $items;
	}

	public function searchItems($itemType, $searchQuery)
	{
		$installedItems = $this->getInstalledItems();

		$items = $this->getHubManager()->setCacheLife(5)->listItems([
			'type'   => $itemType,
			'search' => $searchQuery,
		]);

		if (isset($items['data'])) foreach ($items['data'] as &$item) {
			$item['installed'] = isset($installedItems[$item['code']]);
		}

		return $items;
	}

	public function getInstalledItems($type = null)
	{

		if ($this->installedItems)
			return isset($this->installedItems[$type]) ? $this->installedItems[$type] : $this->installedItems;

		$installedItems = [];

		foreach (Modules::list_modules() as $extension) {
			if ($extension = Modules::find_extension($extension) AND $meta = $extension->extensionMeta()) {
				$installedItems['extensions'][$meta['code']] = [
					'ver'  => $meta['version'],
					'type' => 'extension',
				];
			}
		}

		$themeManager = $this->getThemeManager();
		foreach ($themeManager->listThemes() as $theme) {
			if ($meta = $themeManager->themeMeta($theme)) {
				$installedItems['themes'][$theme] = [
					'ver'  => $meta['version'],
					'type' => 'theme',
				];
			}
		}

		$this->installedItems = array_collapse($installedItems);

		if (!is_null($type))
			return isset($installedItems[$type]) ? $installedItems[$type] : [];

		return $this->installedItems;
	}

	public function requestUpdateList($force)
	{
		// Delete setting entry as its no longer in use... remove code in next version
		if ($this->CI->config->item('last_version_check')) {
			$this->CI->load->model('Settings_model');
			$this->CI->Settings_model->deleteSettings('prefs', 'last_version_check');
		}

		if ($force)
			$this->ignoreUpdate(FALSE);

		$result = [];
		$updateCount = 0;

		$installedItems = $this->getInstalledItems();
		$updates = $this->getHubManager()->setCacheLife(3 * 24)->requestUpdateList($installedItems, $force);
		if (is_string($updates))
			return $updates;

		$result['last_check'] = mdate('%d-%m-%Y %H:%i:%s', isset($updates['check_time']) ? $updates['check_time'] : time());

		$ignoredUpdates = $this->getIgnoredUpdates();
		if ($core = array_get($updates, 'core')) {
			$ignoreUpdate = (in_array($core['version'], $ignoredUpdates));
			$core['ignored'] = $ignoreUpdate;
			$result['core'] = $core;

			if (!$ignoreUpdate)
				$updateCount++;
		}

		$extensions = [];
		foreach (array_get($updates, 'extensions', []) as $code => $info) {
			if (!Modules::is_disabled($code)) {
				$info['installed'] = isset($installedItems[$code]);
				$extensions[$code] = $info;
				$updateCount++;
			}
		}

		$themes = [];
		$themeManager = $this->getThemeManager();
		foreach (array_get($updates, 'themes', []) as $code => $info) {
			if (!$themeManager->isDisabled($code)) {
				$info['installed'] = isset($installedItems[$code]);
				$themes[$code] = $info;
				$updateCount++;
			}
		}

		$result['update_count'] = $updateCount;
		$result['items'] = array_merge($extensions, $themes, array_get($updates, 'translations', []));

		return $result;
	}

	public function applyInstallOrUpdate($names)
	{
		$applies = $this->getHubManager()->applyInstallOrUpdate($names);

		$ignoredUpdates = $this->getIgnoredUpdates();
		if ($core = array_get($applies, 'core')) {
			if (in_array($core['version'], $ignoredUpdates))
				unset($applies['core']);
		}

		return $applies;
	}

	public function ignoreUpdate($version)
	{
		if (!is_string($version) OR !version_compare($version, '0.0.1', '>='))
			$version = FALSE;

		$ignoredUpdates = $this->CI->config->item('ignored_updates');
		$ignoredUpdates = ($version AND is_array($ignoredUpdates)) ? $ignoredUpdates : [];
		if ($version AND !in_array($version, $ignoredUpdates)) array_unshift($ignoredUpdates, $version);

		$this->CI->load->model('Settings_model');
		$this->CI->Settings_model->addSetting('prefs', 'ignored_updates', $ignoredUpdates, '1');
		$this->CI->config->set_item('ignored_updates', $ignoredUpdates);

		return TRUE;
	}

	public function getIgnoredUpdates()
	{
		return is_array($this->CI->config->item('ignored_updates')) ? $this->CI->config->item('ignored_updates') : [];
	}

	/**
	 * @return Hub_manager
	 */
	protected function getHubManager()
	{
		return $this->CI->hub_manager;
	}

	/**
	 * @return Theme_manager
	 */
	protected function getThemeManager()
	{
		return $this->CI->theme_manager;
	}

	/**
	 * @return Installer
	 */
	public function getInstaller()
	{
		return $this->CI->installer;
	}

	public function downloadCore($fileCode, $fileHash, $params = [])
	{
		$this->log("Downloading %s: %s", $fileCode, $fileHash);

		$filePath = $this->getFilePath($fileCode);

		if (!is_dir($fileDir = dirname($filePath)))
			mkdir($fileDir, 0777, TRUE);

		return $this->getHubManager()->downloadFile('core', $filePath, $fileHash, $params);
	}

	public function extractCore($fileCode)
	{
		$this->log("Extracting %s files", $fileCode);

		ini_set('max_execution_time', 3600);

		$extractTo = $this->getBaseDirectory('core');

		if (!$this->extractTo($fileCode, $extractTo, TRUE))
			throw new Exception('Failed to extract %s archive file', $fileCode);

		return TRUE;
	}

	public function downloadFile($fileCode, $fileHash, $params = [])
	{
		$this->log("Downloading %s: %s", $fileCode, $fileHash);

		$filePath = $this->getFilePath($fileCode);

		if (!is_dir($fileDir = dirname($filePath)))
			mkdir($fileDir, 0777, TRUE);

		return $this->getHubManager()->downloadFile('item', $filePath, $fileHash, $params);
	}

	public function extractFile($fileCode, $fileType)
	{
		$this->log("Extracting %s files", $fileCode);

		$extractTo = $this->getBaseDirectory($fileType);

		if (!$this->extractTo($fileCode, $extractTo . $fileCode))
			throw new Exception('Failed to extract %s archive file', $fileCode);

		return TRUE;
	}

	public function getBaseDirectory($fileType)
	{
		switch ($fileType) {
			case 'core':
				return base_path();
			case 'extension':
				return current(Modules::folders());
			case 'theme':
				return $this->getThemeManager()->folders()[MAINDIR];
			case 'translation':
				break; // @TODO improve translations
		}
	}

	public function getFilePath($fileCode)
	{
		$fileName = md5($fileCode) . '.zip';

		return storage_path("temp/{$fileName}");
	}

	public function log()
	{
		$args = func_get_args();
		$message = array_shift($args);

		if (is_array($message))
			$message = implode(PHP_EOL, $message);

		$message = "[" . date("Y/m/d h:i:s", time()) . "] " . vsprintf($message, $args) . PHP_EOL;
		file_put_contents($this->logFile, $message, FILE_APPEND);
	}

	/**
	 * Extract a directory contents within a zip File
	 *
	 * @param string $fileCode
	 * @param string $extractTo
	 * @param bool $checkIgnored
	 *
	 * @return string
	 */
	protected function extractTo($fileCode, $extractTo, $checkIgnored = FALSE)
	{
		if (!class_exists('ZipArchive')) return FALSE;

		$zip = new ZipArchive();

		$zipPath = $this->getFilePath($fileCode);
		if (!file_exists($zipPath)) return FALSE;

		chmod($zipPath, 0777);

		if ($zip->open($zipPath) === TRUE) {
			$dirname = trim($zip->getNameIndex(0), DIRECTORY_SEPARATOR);
			$extractTo = rtrim($extractTo, DIRECTORY_SEPARATOR);

			for ($i = 0; $i < $zip->numFiles; $i++) {
				$filename = $zip->getNameIndex($i);

				$pathToCopy = substr($filename, mb_strlen($dirname, "UTF-8"));
				$relativePath = $extractTo . $pathToCopy;

				// Remove the themes, extensions, logs and sessions folder
				if ($checkIgnored AND $this->isFileIgnored($pathToCopy)) continue;

				if (substr($filename, -1) == '/') {
					// Delete existing directory to replace all contents
					if (!is_dir($relativePath))
						@mkdir($relativePath, 0755, TRUE);
				} else {
					$this->copyFiles("zip://" . $zipPath . "#" . $filename, $relativePath);
				}
			}
		}

		@unlink($zipPath);
		$this->log("Extracted {$fileCode} files: %s", json_encode($this->updatedFiles));

		return TRUE;
	}

	protected function getIgnoredFiles()
	{
		$ignitePath = rtrim(str_replace(ROOTPATH, '', IGNITEPATH), DIRECTORY_SEPARATOR);

		$ignoredFiles = [
			'/tests',
			'/' . MAINDIR . '/views/themes',
			'/extensions',
			'/setup',
			'/' . $ignitePath . '/logs',
			'/' . $ignitePath . '/session',
			'/' . $ignitePath . '/config/database.php',
		];

		return $ignoredFiles;
	}

	protected function isFileIgnored($file)
	{
		foreach ($this->getIgnoredFiles() as $ignoredFile) {
			if (strpos($file, $ignoredFile) !== FALSE)
				return TRUE;
		}

		return FALSE;
	}

	protected function copyFiles($source, $destination)
	{
		$source = rtrim($source, '/');
		$destination = rtrim($destination, '/');
		$baseDir = trim(str_replace(rtrim(ROOTPATH, '/'), '', $destination), '/');

		if (file_exists($destination)) {
			if ($this->isFilesIdentical($source, $destination) === FALSE) {
				$this->updatedFiles['modified'][] = $baseDir;
			} else {
				$this->updatedFiles['unchanged'][] = $baseDir;
			}
		} else {
			$this->updatedFiles['added'][] = $baseDir;
		}

		if (!@copy($source, $destination)) {
			$this->updatedFiles['failed'][] = $baseDir;
		}
	}

	protected function isFilesIdentical($file_one, $file_two)
	{
		// Check if filesize is different
		if (@filesize($file_one) !== @filesize($file_two)) {
			return FALSE;
		}

		// Check if content is different
		$open_file_one = @fopen($file_one, 'rb');
		$open_file_two = @fopen($file_two, 'rb');

		$result = TRUE;
		while (!@feof($open_file_one)) {
			if (@fread($open_file_one, 8192) != @fread($open_file_two, 8192)) {
				$result = FALSE;
				break;
			}
		}

		@fclose($open_file_one);
		@fclose($open_file_two);

		return $result;
	}
}
