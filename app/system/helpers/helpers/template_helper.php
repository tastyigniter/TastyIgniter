<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Template helper functions
 *
 * @category       Helpers
 * @package        TastyIgniter\Helpers\template_helper.php
 * @link           http://docs.tastyigniter.com
 */

if ( ! function_exists('get_header')) {
	/**
	 * Get Header
	 *
	 * @return    string
	 */
	function get_header() {
		return get_instance()->template->getPartialView('header');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_footer')) {
	/**
	 * Get Footer
	 *
	 * @return    string
	 */
	function get_footer() {
		return get_instance()->template->getPartialView('footer');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_partial')) {
	/**
	 * Get Partial
	 *
	 * @param string $partial
	 * @param string $class
	 *
	 * @return string
	 */
	function get_partial($partial = '', $class = '') {
		return get_instance()->template->getPartialView($partial, array('class' => $class));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('load_partial')) {
	/**
	 * Load Partial
	 *
	 * @param string $partial
	 * @param array  $data
	 *
	 * @return string
	 */
	function load_partial($partial = '', $data = array()) {
		echo get_instance()->template->loadView($partial, $data);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('partial_exists')) {
	/**
	 * Check if Partial Exist in layout
	 *
	 * @param string $partial
	 *
	 * @return string
	 */
	function partial_exists($partial = '') {
		return (get_instance()->template->getPartialView($partial)) ? TRUE : FALSE;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_doctype')) {
	/**
	 * Get Doctype
	 *
	 * @return    string
	 */
	function get_doctype() {
		return get_instance()->template->getDocType();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_doctype')) {
	/**
	 * Set Doctype
	 *
	 * @param string $doctype
	 */
	function set_doctype($doctype = '') {
		get_instance()->template->setHeadTag('doctype', $doctype);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_metas')) {
	/**
	 * Get metas html tags
	 *
	 * @return    string
	 */
	function get_metas() {
		return get_instance()->template->getMetas();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_meta')) {
	/**
	 * Set metas html tags
	 */
	function set_meta($meta = array()) {
		get_instance()->template->setHeadTag('meta', $meta);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_favicon')) {
	/**
	 * Get favicon html tag
	 *
	 * @return    string
	 */
	function get_favicon() {
		return get_instance()->template->getFavIcon();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_favicon')) {
	/**
	 * Set favicon html tag
	 *
	 * @param string $href
	 */
	function set_favicon($href = '') {
		get_instance()->template->setHeadTag('favicon', $href);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_title')) {
	/**
	 * Get page title html tag
	 *
	 * @return    string
	 */
	function get_title() {
		return get_instance()->template->getTitle();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_title')) {
	/**
	 * Set page title html tag
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	function set_title($title = '') {
		get_instance()->template->setHeadTag('title', $title);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_heading')) {
	/**
	 * Get page heading
	 *
	 * @return    string
	 */
	function get_heading() {
		return get_instance()->template->getHeading();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_heading')) {
	/**
	 * Set page heading
	 *
	 * @param string $heading
	 *
	 * @return string
	 */
	function set_heading($heading = '') {
		get_instance()->template->setHeadTag('heading', $heading);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_style_tags')) {
	/**
	 * Get multiple stylesheet html tags
	 *
	 * @return    string
	 */
	function get_style_tags() {
		return get_instance()->template->getStyleTags();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_style_tag')) {
	/**
	 * Set single stylesheet html tag
	 *
	 * @param string $href
	 * @param string $name
	 * @param null   $priority
	 *
	 * @return string
	 */
	function set_style_tag($href = '', $name = '', $priority = NULL) {
		get_instance()->template->setStyleTag($href, $name, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_style_tags')) {
	/**
	 * Set multiple stylesheet html tags
	 *
	 * @param array $tags
	 *
	 * @return string
	 */
	function set_style_tags($tags = array()) {
		get_instance()->template->setStyleTag($tags);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_script_tags')) {
	/**
	 * Get multiple scripts html tags
	 *
	 * @return    string
	 */
	function get_script_tags() {
		return get_instance()->template->getScriptTags();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_script_tag')) {
	/**
	 * Set single scripts html tags
	 *
	 * @param string $href
	 * @param string $name
	 * @param null   $priority
	 *
	 * @return string
	 */
	function set_script_tag($href = '', $name = '', $priority = NULL) {
		get_instance()->template->setScriptTag($href, $name, $priority);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('set_script_tags')) {
	/**
	 * Set multiple scripts html tags
	 *
	 * @param array $tags
	 *
	 * @return string
	 */
	function set_script_tags($tags = array()) {
		get_instance()->template->setScriptTag($tags);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_active_styles')) {
	/**
	 * Get the active theme custom stylesheet html tag,
	 * generated by customizer
	 *
	 * @return    string
	 */
	function get_active_styles() {
		return get_instance()->template->getActiveStyle();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_theme_options')) {
	/**
	 * Get the active theme options set in theme customizer
	 *
	 * @param string $item
	 *
	 * @return string
	 */
	function get_theme_options($item = '') {
		return get_instance()->template->getActiveThemeOptions($item);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_breadcrumbs')) {
	/**
	 * Get page breadcrumbs
	 *
	 * @return    string
	 */
	function get_breadcrumbs() {
		return get_instance()->template->getBreadcrumb();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_button_list')) {
	/**
	 * Get admin page heading action buttons
	 *
	 * @return    string
	 */
	function get_button_list() {
		return get_instance()->template->getButtonList();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_icon_list')) {
	/**
	 * Get admin page heading icons
	 *
	 * @return    string
	 */
	function get_icon_list() {
		return get_instance()->template->getIconList();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_nav_menu')) {
	/**
	 * Build admin theme navigation menu
	 *
	 * @param array $prefs
	 *
	 * @return string
	 */
	function get_nav_menu($prefs = array()) {
		return get_instance()->template->navMenu($prefs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_theme_partials')) {
	/**
	 * Get the theme partial areas/regions
	 *
	 * @param null   $theme
	 * @param string $domain
	 *
	 * @return string
	 */
	function get_theme_partials($theme = NULL, $domain = 'main') {

		$theme_config = load_theme_config(trim($theme, '/'), $domain);

		return isset($theme_config['partial_area']) ? $theme_config['partial_area'] : array();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_theme_files')) {
	/**
	 * Search a theme folder for files.
	 *
	 * Searches an individual folder for any theme files and returns an array
	 * appropriate for display in the theme tree view.
	 *
	 * @param string $filename The theme folder to search
	 *
	 * @return array $theme_files
	 */
	function find_theme_files($filename = NULL) {
		if (empty($filename)) {
			return NULL;
		}

		$CI =& get_instance();
		$CI->config->load('template');

		$theme_files = array();
		foreach (glob(ROOTPATH . MAINDIR . "/views/themes/{$filename}/*") as $file) {
			$file_name = basename($file);
			$file_ext = strtolower(substr(strrchr($file, '.'), 1));

			$type = '';
			if (is_dir($file) AND ! in_array($file_name, config_item('theme_hidden_folders'))) {
				$type = 'dir';
			} else if ( ! in_array($file_name, config_item('theme_hidden_files'))) {
				if (in_array($file_ext, config_item('allowed_image_ext'))) {
					$type = 'img';
				} else if (in_array($file_ext, config_item('allowed_file_ext'))) {
					$type = 'file';
				}
			}

			if ($type !== '') {
				$theme_files[] = array('type' => $type, 'name' => $file_name, 'path' => $file, 'ext' => $file_ext);
			}
		}

		$type = array();
		foreach ($theme_files as $key => $value) {
			$type[$key] = $value['type'];
		}
		array_multisort($type, SORT_ASC, $theme_files);

		return $theme_files;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('list_themes')) {
	/**
	 * List existing themes in the system
	 *
	 * Lists the existing themes in the system by examining the
	 * theme folders in both admin and main domain, and also gets the theme
	 * config.
	 *
	 * @return array The names,path,config of the theme directories.
	 */
	function list_themes() {
		$themes = array();

		foreach (array(MAINDIR, ADMINDIR) as $domain) {
			foreach (glob(ROOTPATH . "{$domain}/views/themes/*", GLOB_ONLYDIR) as $filepath) {
				$filename = basename($filepath);

				$themes[] = array(
					'location' => $domain,
					'basename' => $filename,
					'path'     => "{$domain}/views/themes/{$filename}",
					'config'   => load_theme_config($filename, $domain),
				);
			}
		}

		return $themes;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('load_theme_config')) {
	/**
	 * Load a single theme config file into an array.
	 *
	 * @param string $filename The name of the theme to locate. The config file
	 *                         will be found and loaded by looking in the admin and main theme folders.
	 * @param string $domain   The domain where the theme is located.
	 *
	 * @return mixed The $theme array from the file or false if not found. Returns
	 * null if $filename is empty.
	 */
	function load_theme_config($filename = NULL, $domain = MAINDIR) {
		if (empty($filename)) {
			return NULL;
		}

		if ( ! file_exists(ROOTPATH . "{$domain}/views/themes/{$filename}/theme_config.php")) {
			log_message('debug', 'Theme [' . $filename . '] does not have a config file.');

			return NULL;
		}

		include(ROOTPATH . "{$domain}/views/themes/{$filename}/theme_config.php");

		if ( ! isset($theme) OR ! is_array($theme)) {
			log_message('debug', 'Theme [' . $filename . '] config file does not appear to contain a valid array.');

			return NULL;
		}

		log_message('debug', 'Theme [' . $filename . '] config file loaded.');

		return $theme;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('load_theme_file')) {
	/**
	 * Load a single theme generic file into an array.
	 *
	 * @param string $filename The name of the file to locate. The file will be
	 *                         found by looking in the admin and main themes folders.
	 * @param string $theme    The theme to check.
	 *
	 * @return mixed The $theme_file array from the file or false if not found. Returns
	 * null if $filename is empty.
	 */
	function load_theme_file($filename = NULL, $theme = NULL) {
		if (empty($filename) OR empty($theme)) {
			return NULL;
		}

		$theme_file_path = ROOTPATH . MAINDIR . "/views/themes/{$theme}/{$filename}";

		if ( ! file_exists($theme_file_path)) {
			return NULL;
		}

		$CI =& get_instance();
		$CI->config->load('template');

		$file_name = basename($theme_file_path);
		$file_ext = strtolower(substr(strrchr($theme_file_path, '.'), 1));

		if (in_array($file_ext, config_item('allowed_image_ext'))) {
			$file_type = 'img';
			$content = root_url(MAINDIR . "/views/themes/{$theme}/{$filename}");
		} else if (in_array($file_ext, config_item('allowed_file_ext'))) {
			$file_type = 'file';
			$content = htmlspecialchars(file_get_contents($theme_file_path));
		} else {
			return NULL;
		}

		$theme_file = array(
			'name'        => $file_name,
			'ext'         => $file_ext,
			'type'        => $file_type,
			'path'        => $theme_file_path,
			'content'     => $content,
			'is_writable' => is_really_writable($theme_file_path),
		);

		return $theme_file;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('delete_theme')) {
	/**
	 * Delete existing theme folder.
	 *
	 * @param null $theme
	 * @param      $domain
	 *
	 * @return bool
	 */
	function delete_theme($theme = NULL, $domain = MAINDIR) {
		if (empty($theme)) {
			return FALSE;
		}

		if ( ! function_exists('delete_files')) {
			get_instance()->load->helper('file');
		}

		// Delete the specified admin and main language folder.
		if (!empty($domain)) {
			$path = ROOTPATH . "{$domain}/views/themes/{$theme}";
			if (is_dir($path)) {
				delete_files($path, TRUE);
				rmdir($path);

				return TRUE;
			}
		}

		return FALSE;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('save_theme_file')) {
	/**
	 * Save a theme file.
	 *
	 * @param string  $filename The name of the file to locate. The file will be
	 *                          found by looking in the admin and main themes folders.
	 * @param string  $theme    The theme to check.
	 * @param array   $new_data A string of the theme file content replace.
	 * @param boolean $return   True to return the contents or false to return TRUE.
	 *
	 * @return bool|string False if there was a problem loading the file. Otherwise,
	 * returns true when $return is false or a string containing the file's contents
	 * when $return is true.
	 */
	function save_theme_file($filename = NULL, $theme = NULL, $new_data = NULL, $return = FALSE) {
		if (empty($filename) OR empty($theme) OR empty($new_data)) {
			return FALSE;
		}

		$theme_file_path = ROOTPATH . MAINDIR . "/views/themes/{$theme}/{$filename}";

		if ( ! file_exists($theme_file_path)) {
			return FALSE;
		}

		$file_ext = strtolower(substr(strrchr($theme_file_path, '.'), 1));

		$CI =& get_instance();
		$CI->config->load('template');

		if ( ! in_array($file_ext, config_item('allowed_file_ext')) OR ! is_really_writable($theme_file_path)) {
			return FALSE;
		}

		if ($fp = @fopen($theme_file_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
			flock($fp, LOCK_EX);
			fwrite($fp, $new_data);
			flock($fp, LOCK_UN);
			fclose($fp);

			@chmod($theme_file_path, FILE_WRITE_MODE);

			return ($return === TRUE) ? $new_data : TRUE;
		}

		return FALSE;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('create_child_theme_files')) {
	/**
	 * Create child theme file(s).
	 *
	 * @param array  $files The name of the files to locate. The file will be
	 *                          found by looking in the main themes folders.
	 * @param string $source_theme      The theme folder to copy the file from.
	 * @param string $child_theme_data 	The child theme data.
	 *
	 * @return bool Returns false if file is not found in $source_theme
	 * or $child_theme already exist.
	 */
	function create_child_theme_files($files = array(), $source_theme = NULL, $child_theme_data = NULL) {
		if (empty($files) OR empty($source_theme) OR empty($child_theme_data)) {
			return FALSE;
		}

		// preparing the paths
		$source_theme = rtrim($source_theme, '/');
		$child_theme = rtrim($child_theme_data['name'], '/');

		$source_theme_path = ROOTPATH . MAINDIR . "/views/themes/" ."{$source_theme}";
		$child_theme_path = ROOTPATH . MAINDIR . "/views/themes/" ."{$child_theme}";

		if ( ! function_exists('write_file')) {
			get_instance()->load->helper('file');
		}

		// creating the destination directory
		if ( ! is_dir($child_theme_path)) {
			mkdir($child_theme_path, DIR_WRITE_MODE, TRUE);
		}

		$failed = FALSE;
		foreach ($files as $file) {
			if (file_exists("{$child_theme_path}/{$file['name']}") OR ! file_exists($file['path'])) {
				continue;
			}

			if ($file['name'] === 'theme_config.php') {
				if ($start = strpos($file['content'], '$theme[\'child\']')) {
					$end = strpos($file['content'], ';', $start);
					$search = substr($file['content'], $start, $end - $start + 1);
					$replace = str_replace('child', 'parent', str_replace('TRUE', '\'' . $source_theme . '\'', $search));

					$file['content'] = str_replace($search, $replace, $file['content']);

					if ($start = strpos($file['content'], '$theme[\'title\']')) {
						$end = strpos($file['content'], ';', $start);
						$search = substr($file['content'], $start, $end - $start + 1);
						$replace = str_replace($child_theme_data['old_title'], $child_theme_data['title'], $search);

						$file['content'] = str_replace($search, $replace, $file['content']);
					}
				}

				if ( ! write_file("{$child_theme_path}/{$file['name']}", html_entity_decode($file['content']))) {
					$failed = TRUE;
				}
			} else {
				copy("{$source_theme_path}/{$file['name']}", "{$child_theme_path}/{$file['name']}");
			}
		}

		return $failed === TRUE ? FALSE : TRUE;
	}
}

// ------------------------------------------------------------------------

/* End of file template_helper.php */
/* Location: ./system/tastyigniter/helpers/template_helper.php */