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
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Themes Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Themes_model.php
 * @link           http://docs.tastyigniter.com
 */
class Themes_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'extensions';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'extension_id';

	protected $fillable = ['extension_id', 'type', 'name', 'data', 'serialized', 'status', 'title', 'version'];

	/**
	 * List all themes matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array|bool
	 */
	public function getList($filter = [])
	{
		$themes = $this->getThemes();
		$themes_list = list_themes();

		$results = [];

		if (!empty($themes) AND !empty($themes_list)) {
			foreach ($themes_list as $theme) {
				if ($theme['location'] === ADMINDIR) continue;

				$db_theme = (isset($themes[$theme['basename']]) AND !empty($themes[$theme['basename']])) ? $themes[$theme['basename']] : [];

				$extension_id = (!empty($db_theme['extension_id'])) ? $db_theme['extension_id'] : 0;
				$theme_name = (!empty($db_theme['name'])) ? $db_theme['name'] : $theme['basename'];

				$results[$theme['basename']] = [
					'extension_id' => $extension_id,
					'name'         => $theme_name,
					'title'        => isset($theme['config']['title']) ? $theme['config']['title'] : $theme_name,
					'version'      => isset($theme['config']['version']) ? $theme['config']['version'] : '',
					'description'  => isset($theme['config']['description']) ? $theme['config']['description'] : '',
					'author'       => isset($theme['config']['author']) ? $theme['config']['author'] : '',
					'screenshot'   => root_url($theme['path'] . '/screenshot.png'),
					'path'         => $theme['path'],
					'is_writable'  => is_writable($theme['path']),
					'child'        => !empty($theme['config']['child']) ? $theme['config']['child'] : '',
					'parent'       => !empty($theme['config']['parent']) ? $theme['config']['parent'] : '',
					'data'         => !empty($db_theme['data']) ? $db_theme['data'] : [],
					'config'       => $theme['config'],
					'customize'    => (isset($theme['config']['customize']) AND !empty($theme['config']['customize'])) ? TRUE : FALSE,
				];
			}

			foreach ($results as $name => &$theme) {
				if (!empty($theme['parent'])) {
					$results[$theme['parent']]['child'] = [];
					$results[$theme['parent']]['child'][$name] = $theme;
				}
			}
		}

		return $results;
	}

	public function paginateWithFilter($filter = [])
	{
		$result = new stdClass;
		$result->pagination = $result->list = [];

		$result->list = $this->getList($filter);

		$config['base_url'] = $this->getCurrentUrl();
		$config['total_rows'] = count($result->list);
		$config['per_page'] = isset($filter['limit']) ? $filter['limit'] : $this->config->item('page_limit');

		if (isset($filter['limit']) AND isset($filter['page'])) {
			$result->list = array_slice($result->list, ($filter['page'] - 1) * $filter['page'], $filter['limit']);
		}

		$result->pagination = $this->buildPaginateHtml($config);

		return $result;
	}

	/**
	 * Return all themes
	 *
	 * @return array
	 */
	public function getThemes()
	{
		$results = [];

		$rows = $this->where('type', 'theme')->getAsArray();
		foreach ($rows as $row) {
			$row['data'] = ($row['serialized'] == '1' AND !empty($row['data'])) ? unserialize($row['data']) : [];
			$results[$row['name']] = $row;
		}

		return $results;
	}

	/**
	 * Find a single theme by name
	 *
	 * @param string $name
	 *
	 * @return array
	 */
	public function getTheme($name = '')
	{
		$results = [];

		if (!empty($name)) {
			$themes_list = $this->getList();

			if (!empty($themes_list) AND is_array($themes_list)) {
				if (isset($themes_list[$name]) AND is_array($themes_list[$name])) {
					$results = $themes_list[$name];
				}
			}
		}

		return $results;
	}

	/**
	 * Activate theme
	 *
	 * @param string $name
	 *
	 * @return bool|mixed
	 */
	public function activateTheme($name)
	{
		$query = FALSE;

		if (!empty($name) AND $theme = $this->getTheme($name)) {
			$default_themes = $this->config->item('default_themes');
			$default_themes[MAINDIR] = $name . '/';

			unset($default_themes[MAINDIR . '_parent']);
			if (!empty($theme['parent'])) {
				$default_themes[MAINDIR . '_parent'] = $theme['parent'] . '/';
			}

			$this->load->model('Settings_model');
			if ($this->Settings_model->addSetting('prefs', 'default_themes', $default_themes, '1')) {
				$query = $theme['title'];
			}

			if ($query !== FALSE) {
				$active_theme_options = $this->config->item('active_theme_options');
				$active_theme_options[MAINDIR] = [$theme['name'], $theme['data']];

				$this->Settings_model->deleteSettings('prefs', 'customizer_active_style');  //@to-do remove in next version release
				$this->Settings_model->addSetting('prefs', 'active_theme_options', $active_theme_options, '1');
			}
		}

		return $query;
	}

	/**
	 * Create a new or update existing theme
	 *
	 * @param array $update
	 *
	 * @return bool
	 */
	public function updateTheme($update = [])
	{
		if (empty($update)) return FALSE;

		$update['status'] = '1';

		if (!empty($update['data'])) {
			$update['data'] = serialize($update['data']);
			$update['serialized'] = '1';
		} else {
			$update['data'] = serialize([]);
		}

		$query = FALSE;
		if (!empty($update['extension_id']) AND !empty($update['name'])) {
			$query = $this->where([
				['type', '=', 'theme'],
				['name', '=', $update['name']],
				['extension_id', '=', $update['extension_id']],
			])->update($update);
		} else if (!empty($update['name'])) {
			unset($update['old_title']);
			$query = $this->insertGetId(array_merge($update, [
				'type' => 'theme',
				'name' => $update['name'],
			]));
		}

		if ($query) {
			$active_theme_options = $this->config->item('active_theme_options');
			$active_theme_options[MAINDIR] = [$update['name'], $update['data']];

			if ($this->config->item(MAINDIR, 'default_themes') == $update['name'] . '/') {
				$this->Settings_model->addSetting('prefs', 'active_theme_options', $active_theme_options, '1');
			}
		}

		return $query;
	}

	/**
	 * Extract uploaded theme zip folder
	 *
	 * @param array $file
	 * @param string $domain
	 *
	 * @return bool
	 */
	public function extractTheme($file = [], $domain = MAINDIR)
	{
		if (isset($file['tmp_name']) AND class_exists('ZipArchive')) {

			$zip = new ZipArchive;

			chmod($file['tmp_name'], DIR_READ_MODE);

			$THEMEPATH = ROOTPATH . $domain . '/views/themes';

			if ($zip->open($file['tmp_name']) === TRUE) {
				$theme_dir = $zip->getNameIndex(0);

				if (preg_match('/\s/', $theme_dir) OR file_exists($THEMEPATH . '/' . $theme_dir)) {
					return $this->lang->line('error_theme_exists');
				}

				$zip->extractTo($THEMEPATH);
				$zip->close();

				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Create child theme from existing theme files and data
	 *
	 * @param string $theme_name
	 * @param array $files
	 * @param bool $copy_data
	 *
	 * @return bool
	 */
	public function copyTheme($theme_name = null, $files = [], $copy_data = TRUE)
	{
		$query = FALSE;

		if (!empty($theme_name)) {

			$themeModel = $this->where('type', 'theme')->where('name', $theme_name)->first();

			if (!is_null($themeModel)) {
				$row = $themeModel->toArray();
				unset($row['extension_id']);
				$row['name'] = $this->findThemeName("{$row['name']}-child");
				$row['old_title'] = $row['title'];
				$row['title'] = "{$row['title']} Child Theme";
				$row['data'] = ($copy_data AND $row['serialized'] == '1') ? unserialize($row['data']) : [];

				if ($query = $this->updateTheme($row)) {
					$query = create_child_theme_files($files, $theme_name, $row);
				}
			}
		}

		return $query;
	}

	/**
	 * Create a unique theme name
	 *
	 * @param string $theme_name
	 * @param int $count
	 *
	 * @return string
	 */
	protected function findThemeName($theme_name, $count = 0)
	{
		$tmp_name = ($count > 0) ? "{$theme_name}-{$count}" : $theme_name;
		$theme = $this->where('type', 'theme')->where('name', $tmp_name)->first();

		if (!empty($theme) OR is_dir(ROOTPATH . MAINDIR . "/views/themes/{$tmp_name}")) {
			$count++;

			return $this->findThemeName($theme_name, $count);
		}

		return $tmp_name;
	}

	/**
	 * Delete a single theme by name
	 *
	 * @param string $theme_name
	 * @param bool $delete_data
	 *
	 * @return bool
	 */
	public function deleteTheme($theme_name = null, $delete_data = TRUE)
	{
		$query = FALSE;

		if (!empty($theme_name)) {

			if ($delete_data) {
				$query = $this->queryBuilder()->table('extensions')->where('type', 'theme')->where('name', $theme_name)->delete();
			}

			$query = delete_theme($theme_name);
		}

		return $query;
	}
}

/* End of file Themes_model.php */
/* Location: ./system/tastyigniter/models/Themes_model.php */