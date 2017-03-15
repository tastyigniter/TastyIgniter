<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Setup Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Setup_model.php
 * @link           http://docs.tastyigniter.com
 */
class Setup_model extends TI_Model
{
	protected $schema = [];

	public function querySchema($table, $schema = 'initial')
	{
		if (!empty($this->schema[$schema][$table])) {
			$this->db->query($this->schema[$schema][$table]);
		}

		if ($this->input->post('site_location_mode') === 'multi' AND !empty($this->schema[$schema][$table . '_for_multi'])) {
			$this->db->query($this->schema[$schema][$table . '_for_multi']);
		}
	}

	// --------------------------------------------------------------------

	public function loadSchema($schema_type = 'initial')
	{
		include(IGNITEPATH . '/migrations/' . $schema_type . '_schema.php');

		if (!empty($schema)) {
			$this->schema[$schema_type] = $schema;
		}

		if ($schema_type === 'initial' AND $this->input->post('demo_data') == '1') {
			$this->loadSchema('demo');
		}
	}

	public function addUser($add = [])
	{
		if (empty($add['staff_name']) AND empty($add['username']) AND empty($add['password'])) {
			return TRUE;
		}

		$this->db->where('staff_email', strtolower($add['site_email']));
		$this->db->delete('staffs');

		$this->db->set('staff_email', strtolower($add['site_email']));
		$this->db->set('staff_name', $add['staff_name']);
		$this->db->set('staff_group_id', '11');
		$this->db->set('staff_location_id', '11');
		$this->db->set('language_id', '11');
		$this->db->set('timezone', '0');
		$this->db->set('staff_status', '1');

		$this->db->set('date_added', mdate('%Y-%m-%d', time()));

		$query = $this->db->insert('staffs');

		if ($this->db->affected_rows() > 0 AND $query === TRUE) {
			$staff_id = $this->db->insert_id();

			$this->db->where('username', $add['username']);
			$this->db->delete('users');

			$this->db->set('username', $add['username']);
			$this->db->set('staff_id', $staff_id);
			$this->db->set('salt', $salt = substr(md5(uniqid(rand(), TRUE)), 0, 9));
			$this->db->set('password', sha1($salt . sha1($salt . sha1($add['password']))));

			$query = $this->db->insert('users');
		}

		return $query;
	}

	public function updateSettings($setting = [])
	{
		$prefs_keys = ['ti_setup', 'ti_version', 'site_key'];
		foreach ($setting as $key => $value) {
			$setting_row = [
				'sort'       => (in_array($key, $prefs_keys)) ? 'prefs' : 'config',
				'item'       => $key,
				'value'      => is_array($value) ? serialize($value) : $value,
				'serialized' => is_array($value) ? '1' : '0',
			];

			if ($this->db->replace('settings', $setting_row) === FALSE) {
				return FALSE;
			}
		}

		return TRUE;
	}

	public function updateInstalledExtensions()
	{
		$installed_extensions = $this->config->item('installed_extensions');

		if (empty($installed_extensions) OR !is_array($installed_extensions)) {
			$installed_extensions = $this->db->from('extensions')->select('name')->where_in('type', ['module', 'payment'])
										 ->where('status', '1')->get()->result_array();
			if ($installed_extensions) {
				$installed_extensions = array_flip(array_column($installed_extensions, 'name'));
				$installed_extensions = array_fill_keys(array_keys($installed_extensions), TRUE);
			}
		}

		$this->config->set_item('installed_extensions', $installed_extensions);
		$this->db->replace('settings', [
			'sort'       => 'prefs',
			'item'       => 'installed_extensions',
			'value'      => serialize($installed_extensions),
			'serialized' => '1',
		]);
	}

	public function updateDefaultLocation($setting = [])
	{
		if (empty($setting['site_name']) AND empty($setting['site_email'])) {
			return TRUE;
		}

		$this->db->where('location_id', '11')->update('locations', [
			'location_name'  => $setting['site_name'],
			'location_email' => $setting['site_email'],
		]);

		$this->db->replace('permalinks', [
			'permalink_id' => '22',
			'slug' => url_title($setting['site_name'], '-', TRUE),
			'controller' => 'local',
			'query' => 'location_id=11',
		]);
	}

	public function updateVersion($version = null)
	{
		$settings = [
			'ti_version' => (empty($version)) ? TI_VERSION : $version,
		];

		$this->updateSettings($settings, TRUE);
	}
}

/* End of file Setup_model.php */
/* Location: ./setup/models/Setup_model.php */