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
		$results = [];

		$installed_themes = $this->getThemes();
		foreach ($this->theme_manager->paths() as $name => $themePath) {

			if (!($themeObj = $this->theme_manager->findTheme($name))) continue;

			if ($themeObj->domain === ADMINDIR) continue;

			$themePath = ltrim($themePath['path'], DIRECTORY_SEPARATOR);
			$installed_theme = (isset($installed_themes[$name])) ? $installed_themes[$name] : [];

			$theme_config = $this->theme_manager->themeMeta($name);
			$results[$name] = array_merge($theme_config, [
				'extension_id' => (!empty($installed_theme['extension_id'])) ? $installed_theme['extension_id'] : 0,
				'screenshot'   => root_url($themePath . '/screenshot.png'),
				'path'         => $themePath,
				'is_writable'  => is_writable($themePath),
				'is_child'     => $themeObj->isChild,
				'parent'       => $themeObj->parent,
				'installed'    => !empty($installed_theme) ? TRUE : FALSE,
				'activated'    => $themeObj->activated,
				'data'         => !empty($installed_theme['data']) ? $installed_theme['data'] : [],
				'customizer'   => $themeObj->customizer,
			]);
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
			$row['data'] = ($row['serialized'] == '1' AND !empty($row['data'])) ? @unserialize($row['data']) : [];
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
	 * Update installed extensions config value
	 *
	 * @param string $theme
	 * @param bool $install
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateInstalledThemes($theme = null, $install = TRUE)
	{
		$installed_themes = $this->config->item('installed_themes');

		if (empty($installed_themes) OR !is_array($installed_themes)) {
			$installed_themes = $this->select('name')->where('type', 'theme')
									 ->where('status', '1')->getAsArray();
			if ($installed_themes) {
				$installed_themes = array_flip(array_column($installed_themes, 'name'));
				$installed_themes = array_fill_keys(array_keys($installed_themes), TRUE);
			}
		}

		if (!is_null($theme) AND $this->theme_manager->hasTheme($theme)) {
			if ($install) {
				$installed_themes[$theme] = TRUE;
			} else {
				unset($installed_themes[$theme]);
			}
		}

		$this->load->model('Settings_model');
		$this->Settings_model->addSetting('prefs', 'installed_themes', $installed_themes, '1');
		$this->config->set_item('installed_themes', $installed_themes);
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
				$query = $theme['name'];
			}

			if ($query !== FALSE) {
				$this->updateInstalledThemes($name);

				$active_theme_options = $this->config->item('active_theme_options');
				$active_theme_options[MAINDIR] = [$theme['code'], $theme['data']];

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

		if (isset($update['data'])) {
			$update['data'] = serialize($update['data']);
			$update['serialized'] = '1';
		}

		$query = FALSE;

		$themeModel = $this->where([
			['type', '=', 'theme'],
			['name', '=', $update['name']],
		])->first();

		if ($themeModel) {
			$themeModel->fill($update)->save();
			$query = TRUE;
		} else if (!empty($update['name'])) {
			unset($update['old_title']);
			$query = $this->insertGetId(array_merge($update, [
				'type' => 'theme',
				'name' => $update['name'],
			]));
		}

		if ($query) {
			$this->updateInstalledThemes($update['name']);

			if (!empty($update['data']) AND $this->config->item(MAINDIR, 'default_themes') == $update['name'] . '/') {
				$active_theme_options = $this->config->item('active_theme_options');
				$active_theme_options[MAINDIR] = [$update['name'], $update['data']];

				$this->Settings_model->addSetting('prefs', 'active_theme_options', $active_theme_options, '1');
			}
		}

		return $query;
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
	public function copyTheme($theme_name = null, $copy_data = TRUE)
	{
		$query = FALSE;

		if (!empty($theme_name)) {

			$themeModel = $this->where('type', 'theme')->where('name', $theme_name)->first();

			if (!is_null($themeModel)) {
				$row = $themeModel->toArray();
				unset($row['extension_id']);
				$row['name'] = $this->findThemeName("{$row['name']}-child");
				$row['old_title'] = $row['title'];
				$row['title'] = "{$row['title']} Child";
				$row['data'] = ($copy_data AND $row['serialized'] == '1') ? unserialize($row['data']) : [];

				if ($query = $this->updateTheme($row)) {
					$query = $this->theme_manager->createChild($theme_name, $row);
				}
			}
		}

		return $query;
	}

	/**
	 * Find an existing theme in DB by theme code
	 *
	 * @param string $code
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function themeExists($code)
	{
		return $this->where('type', 'theme')->where('name', $code)->first() ? TRUE : FALSE;
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
		do {
			$newThemeCode = ($count > 0) ? "{$theme_name}-{$count}" : $theme_name;
			$count++;
		} // Already exist in DB? Try again
		while ($this->themeExists($newThemeCode));

		return $newThemeCode;
	}

	/**
	 * Delete a single theme by name
	 *
	 * @param string $theme_name
	 * @param bool $delete_data
	 *
	 * @return bool
	 */
	public function deleteTheme($theme_name, $delete_data = TRUE)
	{
		$themeModel = $this->where('type', 'theme')->where('name', $theme_name)->first();

		if ($delete_data) {
			$themeModel->delete();
		} else {
			$themeModel->status = 0;
			$themeModel->save();
		}

		$this->updateInstalledThemes($theme_name, FALSE);

		$query = $this->theme_manager->removeTheme($theme_name);

		return $query;
	}
}

/* End of file Themes_model.php */
/* Location: ./system/tastyigniter/models/Themes_model.php */