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
 * Theme Manager Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Theme_manager.php
 * @link           http://docs.tastyigniter.com
 */
class Theme_manager
{

	/**
	 * @var array of disabled themes.
	 */
	public $installedThemes = [];

	/**
	 * @var array used for storing theme information objects.
	 */
	public $themes = [];
	protected $filesToCopy;

	/**
	 * @var array of themes and their directory paths.
	 */
	protected $paths = [];

	protected $config;
	protected $loadedConfig;
	protected $loadedCustomizerConfig;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('directory');

		$this->config = $this->CI->config->load('template', TRUE);
		$this->filesToCopy = ['theme.json', 'theme_config.php', 'screenshot.png'];

		$this->loadInstalled();
		$this->loadThemes();

	}

	/**
	 * Returns a list of all modules in the system.
	 *
	 * @param $theme
	 *
	 * @return array A list of all modules in the system.
	 */
	public function themeMeta($theme)
	{
		return isset($this->themes[$theme]->config) ? $this->themes[$theme]->config : [];
	}

	/**
	 * Returns a list of all themes in the system.
	 *
	 * @return array A list of all themes in the system.
	 */
	public function listThemes()
	{
		$themes = [];
		foreach ($this->paths() as $theme => $path) {
			$themes[$path['domain']][] = $theme;
		}

		return $themes;
	}

	/**
	 * Loads all installed theme from application config.
	 */
	public function loadInstalled()
	{
		$installedThemes = config_item('installed_themes');
		if (is_null($installedThemes)) {
			$this->CI->load->model('Themes_model');
			$this->CI->Themes_model->updateInstalledThemes();
		}

		if ($installedThemes AND is_array($installedThemes)) {
			$this->installedThemes = config_item('installed_themes');
		}
	}

	/**
	 * Finds all available themes and loads them in to the $themes array.
	 *
	 * @return array
	 */
	public function loadThemes()
	{
		foreach ($this->paths() as $themeCode => $path) {
			$this->loadTheme($themeCode, $path['path']);
		}

		return $this->themes;
	}

	/**
	 * Loads a single theme in to the manager.
	 *
	 * @param string $themeCode Eg: directory_name
	 * @param string $path      Eg: ROOTPATH . THEMEPATH.'directory_name';
	 *
	 * @return object|void
	 */
	public function loadTheme($themeCode, $path)
	{
		if (!$this->checkName($themeCode)) return;

		if (isset($this->themes[$themeCode])) {
			return $this->themes[$themeCode];
		}

		$themeObject = new stdClass();  // change to class
		$themeObject->code = $themeCode;
		$themeObject->domain = $this->findDomain($themeCode);
		$themeObject->isChild = $this->isChild($themeCode);
		$themeObject->parent = $this->findParent($themeCode);
		$themeObject->activated = $this->isActivated($themeCode);
		$themeObject->config = $this->getMetaFromFile($themeCode);

		$themeObject->customizer = null;
		if (APPDIR == ADMINDIR OR $themeObject->domain == MAINDIR)
			$themeObject->customizer = $this->getConfigFromFile($themeCode);

		$this->themes[$themeCode] = $themeObject;
		$this->paths[$themeCode] = $path;

		return $themeObject;
	}

	/**
	 * Find a file.
	 *
	 * Scans for files located within themes directories. Also scans each theme
	 * directories for layouts, partials, and content. Generates fatal error if file
	 * not found.
	 *
	 * @param string $filename The file.
	 * @param string $theme    The theme.
	 * @param string $base     The folder within the theme eg. layouts, partials, content
	 *
	 * @return string|bool
	 */
	public function findFile($filename, $theme, $base = null)
	{
		$path = $this->findPath($theme);

		$themePath = base_path(rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);

//			foreach (['/', '/layouts/', '/partials/'] as $folder) {
		$file = (pathinfo($filename, PATHINFO_EXTENSION)) ? $filename : $filename . '.php';

		if ($themePath AND is_file($path = $themePath . $base . $file)) {
			return $path;
		}

//			}

		return FALSE;
	}

	/**
	 * Returns a theme object based on its name.
	 *
	 * @param $themeCode
	 *
	 * @return mixed|null
	 */
	public function findTheme($themeCode)
	{
		if (!$this->hasTheme($themeCode)) {
			return null;
		}

		return $this->themes[$themeCode];
	}

	/**
	 * Checks to see if an extension has been registered.
	 *
	 * @param $themeCode
	 *
	 * @return bool
	 */
	public function hasTheme($themeCode)
	{
		return isset($this->themes[$themeCode]);
	}

	/**
	 * Returns a theme path based on its name.
	 *
	 * @param $themeCode
	 *
	 * @return string|null
	 */
	public function findPath($themeCode)
	{
		$themePaths = $this->paths();

		return isset($themePaths[$themeCode]['path']) ? $themePaths[$themeCode]['path'] : null;
	}

	/**
	 * Returns the theme domain by looking in its path.
	 *
	 * @param $themeCode
	 *
	 * @return string
	 */
	public function findDomain($themeCode)
	{
		$themePaths = $this->paths();

		return isset($themePaths[$themeCode]['domain']) ? $themePaths[$themeCode]['domain'] : null;
	}

	/**
	 * Returns the theme domain by looking in its path.
	 *
	 * @param $themeCode
	 *
	 * @return string
	 */
	public function findParent($themeCode)
	{
		$config = $this->getMetaFromFile($themeCode);

		return (isset($config['parent']) AND is_string($config['parent'])) ? $config['parent'] : null;
	}

	/**
	 * Create a Directory Map of all themes
	 *
	 * @return array A list of all themes in the system.
	 */
	public function paths()
	{
		$themes = [];
		foreach ($this->folders() as $domain => $folder) {
			foreach (directory_map($folder, 2) as $themeDir => $themeFiles) {
				$folder = rtrim($folder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

				if (is_dir($themeAbsoluteDir = $folder . $themeDir)) {
					$themes[$themeDir] = [
						'domain'   => $domain,
						'basename' => $themeDir,
						'path'     => ltrim(substr($themeAbsoluteDir, strlen(base_path())), DIRECTORY_SEPARATOR),
					];
				}
			}
		}

		return $themes;
	}

	/**
	 * Returns an array of the folders in which themes may be stored.
	 *
	 * @param string $domain
	 *
	 * @return array The folders in which themes may be stored.
	 */
	public function folders($domain = null)
	{
		$folder = 'views/themes';

		 $folders = [
			ADMINDIR => ROOTPATH . ADMINDIR . DIRECTORY_SEPARATOR . $folder,
			MAINDIR  => ROOTPATH . MAINDIR . DIRECTORY_SEPARATOR . $folder,
		];

		return ($domain != null) ? $folders[$domain] : $folders;
	}

	/**
	 * Determines if a theme is a child by looking in the theme config file.
	 *
	 * @param $themeCode
	 *
	 * @return bool
	 */
	public function isChild($themeCode)
	{
		$config = $this->getMetaFromFile($themeCode);

		return (isset($config['parent']) AND is_string($config['parent']));
	}

	/**
	 * Determines if a theme is activated by looking at the default themes config.
	 *
	 * @param $themeCode
	 *
	 * @return bool
	 */
	public function isActivated($themeCode)
	{
		if (!$this->checkName($themeCode)) {
			return FALSE;
		}

		$defaultThemes = config_item('default_themes');
		foreach ($this->folders() as $domain => $path) {
			if (isset($defaultThemes[$domain]) AND trim($defaultThemes[$domain], DIRECTORY_SEPARATOR) == $themeCode)
				return TRUE;
		}

		return FALSE;
	}

	/**
	 * Checks to see if a theme has been registered.
	 *
	 * @param $themeCode
	 *
	 * @return bool
	 */
	public function checkName($themeCode)
	{
		return (strpos($themeCode, '_') === 0 OR preg_match('/\s/', $themeCode)) ? null : $themeCode;
	}

	/**
	 * Search a theme folder for files.
	 *
	 * @param string $themeCode The theme to search
	 * @param string $subFolder If not null, will return only files within sub-folder (ie 'partials').
	 *
	 * @return array $theme_files
	 */
	public function findFiles($themeCode, $subFolder = null)
	{
		// Ensure the directory_map() function is available.
		if (!function_exists('directory_map')) {
			get_instance()->load->helper('directory');
		}

		$themePath = $this->findPath($themeCode);
		$files = directory_map(base_path($themePath));

		return ($subFolder AND isset($files[$subFolder])) ? $files[$subFolder] : $files;
	}

	/**
	 * Search a theme folder for files.
	 *
	 * @param string $themeCode The theme to search
	 * @param string $subFolder If not null, will return only files within sub-folder (ie 'partials').
	 *
	 * @return array $theme_files
	 */
	public function findFilesPath($themeCode, $subFolder = null)
	{

		$themePath = $this->findPath($themeCode);
		$files = $this->findFiles($themeCode, $subFolder);
		$subFolder = !is_null($subFolder) ? $subFolder.DIRECTORY_SEPARATOR : null;

		$_files = [];
		foreach ($files as $key => $file) {
			if (is_string($key)) {
				$_files[] = $this->findFilesPath($themeCode, $key);
			} else {
				$_files[] = $themePath . DIRECTORY_SEPARATOR . $subFolder . $file;
			}
		}

		return array_flatten($_files);
	}

	/**
	 * Build the theme files tree.
	 *
	 * @param array $files
	 * @param string $url
	 * @param string $currentFile
	 *
	 * @return string $themeTree
	 */
	public function buildFilesTree($files, $url, $currentFile = null)
	{
		ksort($files);
		$currentPaths = (!is_null($currentFile)) ? explode('/', $currentFile) : [];

		$html = '<nav class="nav">';
		$html .= $this->_buildFilesTree($files, $url, $currentPaths);
		$html .= '</nav>';

		return $html;
	}

	/**
	 * Load a single theme generic file into an array.
	 *
	 * @param string $filename  The name of the file to locate. The file will be
	 *                          found by looking in the all themes folders.
	 * @param string $themeCode The theme to check.
	 *
	 * @return bool|array The $theme_file array from the file or false if not found. Returns
	 * null if $filename is empty.
	 */
	public function readFile($filename, $themeCode)
	{
		$file = [];
		$themePath = $this->findPath($themeCode);
		$filePath = $themePath . DIRECTORY_SEPARATOR . ltrim($filename, DIRECTORY_SEPARATOR);
		$fileExt = strtolower(substr(strrchr($filename, '.'), 1));

		if (in_array($fileExt, $this->config['allowed_image_ext'])) {
			$file['type'] = 'img';
			$file['content'] = root_url($filePath);
		} else if (in_array($fileExt, $this->config['allowed_file_ext'])) {
			$file['type'] = 'file';
			$file['content'] = htmlspecialchars(file_get_contents(base_path($filePath)));
		} else {
			return null;
		}

		$file = array_merge($file, [
			'name'        => $filename,
			'ext'         => $fileExt,
			'path'        => $filePath,
			'is_writable' => is_really_writable($filePath),
		]);

		return $file;
	}

	/**
	 * Write a theme file.
	 *
	 * @param string $filename       The name of the file to locate. The file will be
	 *                               found by looking in the admin and main themes folders.
	 * @param string $themeCode      The theme to check.
	 * @param array $content         A string of the theme file content to write or replace.
	 * @param boolean|string $return True to return the contents or false to return bool.
	 *
	 * @return bool|string False if there was a problem loading the file. Otherwise,
	 * returns true when $return is false or a string containing the file's contents
	 * when $return is true.
	 */
	public function writeFile($filename, $themeCode, $content = null, $return = FALSE)
	{
		if (empty($filename) OR empty($themeCode)) {
			return FALSE;
		}

		$path = $this->findPath($themeCode);

		if (!file_exists($filePath = base_path($path . DIRECTORY_SEPARATOR . $filename))) {
			return FALSE;
		}

		$fileExt = strtolower(substr(strrchr($filePath, '.'), 1));
		if (!in_array($fileExt, $this->config['allowed_file_ext']) OR !is_really_writable($filePath)) {
			return FALSE;
		}

		if (!function_exists('write_file'))
			$this->CI->load->helper('file');

		if (!write_file($filePath, $content, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
			return FALSE;
		}

		return ($return === TRUE) ? $content : TRUE;
	}

	public function getFilesToCopy($themeCode)
	{
		$files = [];
		foreach ($this->filesToCopy as $file) {
			$path = $this->findFile($file, $themeCode);
			$files[] = $path;
		}

		return $files;
	}

	/**
	 * Create child theme.
	 *
	 * @param string $themeCode The name of the theme to create child from.
	 * @param array $childData  The child theme DB data, the child theme data
	 *                          should be inserted in DB before creating files.
	 *
	 * @return bool Returns false if child them could not be created
	 * or $child_theme already exist.
	 */
	public function createChild($themeCode, $childData = [])
	{
		if (empty($childData) OR !isset($childData['name']))
			return FALSE;

		// preparing the paths
		$parentPath = base_path($this->findPath($themeCode));
		$childPath = dirname($parentPath) . DIRECTORY_SEPARATOR . $childData['name'];

		// creating the destination directory
		if (!is_dir($childPath)) {
			mkdir($childPath, DIR_WRITE_MODE, TRUE);
		}

		$failed = FALSE;
		$themeMeta = $this->themeMeta($themeCode);
		$files = $this->getFilesToCopy($themeCode);

		foreach ($files as $filePath) {
			$filename = basename($filePath);

			if (file_exists("{$childPath}/{$filename}") OR !file_exists($filePath))
				continue;

			if ($filename == 'theme.json') {
				$content = array_merge($themeMeta, [
					'parent' => $themeMeta['code'],
					'code'   => $childData['name'],
					'name'   => $childData['title'],
				]);

				if (!function_exists('write_file'))
					$this->CI->load->helper('file');

				$content = stripslashes(json_encode($content, JSON_PRETTY_PRINT));
				if (!write_file("{$childPath}/{$filename}", $content, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
					return FALSE;
				}
			} else {
				copy($filePath, "{$childPath}/{$filename}");
			}
		}

		return $failed === TRUE ? FALSE : TRUE;
	}

	/**
	 * Extract uploaded/downloaded theme zip folder
	 *
	 * @param array $zipPath The path to the zip folder
	 * @param string $domain The domain in which to extract the theme to
	 *
	 * @return bool
	 */
	public function extractTheme($zipPath, $domain = MAINDIR)
	{
		if (file_exists($zipPath) AND class_exists('ZipArchive', FALSE)) {

			$zip = new ZipArchive;

			chmod($zipPath, DIR_READ_MODE);

			$themesFolder = $this->folders($domain);

			if ($zip->open($zipPath) === TRUE) {
				$themeDir = $zip->getNameIndex(0);

				if ($zip->locateName($themeDir .'theme.json') === FALSE)
					return FALSE;

				if (!$this->checkName($themeDir) OR file_exists($themesFolder . DIRECTORY_SEPARATOR . $themeDir)) {
					return $this->CI->lang->line('error_theme_exists');
				}

				$zip->extractTo($themesFolder);
				$zip->close();

				return $themesFolder . DIRECTORY_SEPARATOR . $themeDir;
			}
		}

		return FALSE;
	}

	/**
	 * Delete existing theme folder from filesystem.
	 *
	 * @param null $themeCode The theme to delete
	 *
	 * @return bool
	 */
	public function removeTheme($themeCode)
	{
		$themePath = $this->findPath($themeCode);

		// Delete the specified admin and main language folder.
		if (!is_dir($themePath = base_path($themePath)))
			return FALSE;

		if ( ! function_exists('delete_files'))
			$this->CI->load->helper('file');

		delete_files($themePath, TRUE);
		rmdir($themePath);

		return TRUE;
	}

	/**
	 * Read theme customizer configuration from the config file
	 *
	 * @param string $themeCode The theme to check.
	 *
	 * @return array|bool
	 */
	public function getConfigFromFile($themeCode)
	{
		if (isset($this->loadedCustomizerConfig[$themeCode]))
			return $this->loadedCustomizerConfig[$themeCode];

		if (!$configPath = $this->findFile('theme_config.php', $themeCode))
			return null;

		include($configPath);

		if (empty($theme) OR !is_array($theme))
			return null;

		$this->loadedCustomizerConfig[$themeCode] = $theme;

		return $theme;
	}

	/**
	 * Read configuration from Config/Meta file
	 *
	 * @param string $themeCode
	 *
	 * @return array|null
	 */
	public function getMetaFromFile($themeCode)
	{
		if (isset($this->loadedConfig[$themeCode]))
			return $this->loadedConfig[$themeCode];

		$config = $this->checkMetaFile($themeCode);
		$this->loadedConfig[$themeCode] = $config;

		if ($config)
			log_message('debug', 'Theme [' . $themeCode . '] config file loaded.');

		return $config;
	}

	/**
	 * Check configuration in Config file
	 *
	 * @param string $themeCode
	 *
	 * @return array|null
	 */
	protected function checkMetaFile($themeCode)
	{
		$isJson = FALSE;
		if ($configPath = $this->findFile('theme.json', $themeCode)) {
			$config = json_decode(file_get_contents($configPath), TRUE);
			$isJson = TRUE;
		} else if ($configPath = $this->findFile('theme_config.php', $themeCode)) {
			include($configPath);
			if (isset($theme)) $config = $theme;
		}

		if (!$configPath) {
			log_message('debug', 'Theme [' . $themeCode . '] does not have a registration file.');
			$config = null;
		}

		$requiredKeys = ['title', 'description', 'version', 'author'];
		if ($isJson) {
			array_shift($requiredKeys);
			$requiredKeys = array_merge($requiredKeys, ['name', 'code', 'tags']);
		}

		if (empty($config) OR !is_array($config) OR array_diff($requiredKeys, array_keys($config)) != []) {
			log_message('debug', 'Theme [' . $themeCode . '] config file does not appear to contain a valid array.');
			$config = null;
		}

		return $config;
	}

	/**
	 * Internal method to build the theme files tree.
	 *
	 * @param array $files
	 * @param string $url
	 * @param array $currentPaths
	 * @param string $parentDir
	 *
	 * @return string $themeTree
	 */
	protected function _buildFilesTree($files, $url, $currentPaths = [], $parentDir = null)
	{
		$html = is_null($parentDir) ? '<ul class="metisFolder">' : '<ul>';

		foreach ($files as $dir => $file) {
			if (is_string($dir)) {
				$active = (in_array($dir, $currentPaths)) ? ' active' : '';
				$html .= '<li class="directory' . $active . '"><a><i class="fa fa-folder-open"></i>&nbsp;&nbsp;' . htmlspecialchars($dir) . '</a>';
				$html .= $this->_buildFilesTree($file, $url, $currentPaths, $dir);
				$html .= '</li>';
			} else {
				$active = (in_array($file, $currentPaths)) ? ' active' : '';
				$fileExt = strtolower(substr(strrchr($file, '.'), 1));
				$fileName = htmlspecialchars($file);

				if (in_array($fileExt, $this->config['allowed_image_ext'])) {
					$link = str_replace('{link}', $parentDir . '/' . urlencode($file), $url);
					$html .= '<li class="img' . $active . '"><a href="' . $link . '"><i class="fa fa-file-image-o"></i>&nbsp;&nbsp;' . $fileName . '</a></li>';
				} else if (in_array($fileExt, $this->config['allowed_file_ext'])) {
					$link = str_replace('{link}', $parentDir . '/' . urlencode($file), $url);
					$html .= '<li class="file' . $active . '"><a href="' . $link . '"><i class="fa fa-file-code-o"></i>&nbsp;&nbsp;' . $fileName . '</a></li>';
				}
			}
		}

		$html .= '</ul>';

		return $html;
	}

}