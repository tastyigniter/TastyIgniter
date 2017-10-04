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
	protected $schema = array();

	public function querySchema($table, $schema = 'initial') {
		if (!empty($this->schema[$schema][$table])) {
			$this->db->query($this->schema[$schema][$table]);
		}

		if (!empty($this->schema[$schema][$table.'_for_multi'])) {
			$this->db->query($this->schema[$schema][$table.'_for_multi']);
		}
	}

	// --------------------------------------------------------------------

	public function loadSchema($schema_type = 'initial') {
		include(IGNITEPATH . '/migrations/'.$schema_type.'_schema.php');

		if (!empty($schema)) {
			$this->schema[$schema_type] = $schema;
		}

		if ($schema_type === 'initial' AND $this->input->post('demo_data') === '1') {
			$this->loadSchema('demo');
		}
	}

	public function addUser($add = array()) {
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

	public function updateSettings($setting = array(), $upgrade = FALSE) {
		if ($upgrade === FALSE AND empty($setting['site_name']) AND empty($setting['site_email'])) {
			return TRUE;
		}

		foreach ($setting as $key => $value) {
			$setting_row = array(
				'sort'       => ($key === 'ti_setup') ? 'prefs' : 'config',
				'item'       => $key,
				'value'      => $value,
				'serialized' => '0',
			);

			if ($this->db->replace('settings', $setting_row) === FALSE) {
				return FALSE;
			}
        }

		return TRUE;
	}

	public function updateLocation($setting = array()) {
		$this->load->model('Locations_model');
		$this->Locations_model->saveLocation('11', array(
			'location_name' => $setting['site_name'],
			'location_email' => $setting['site_email'],
		));

		$this->load->model('Settings_model');
		$this->Settings_model->addSetting('prefs', 'main_address', $this->Locations_model->getAddress(11), '1');

		$this->load->model('Permalink_model');
		$permalink = array('permalink_id' => '22', 'slug' => $setting['site_name']);
		$this->Permalink_model->savePermalink('local', $permalink, 'location_id=11');
	}

	public function updateVersion($version = NULL) {
		$this->db->where('sort', 'prefs');
		$this->db->where('item', 'ti_version');
		$this->db->delete('settings');

		$this->db->set('sort', 'prefs');
		$this->db->set('item', 'ti_version');
		$this->db->set('value', (empty($version)) ? TI_VERSION : $version);
		$this->db->set('serialized', '0');
		$this->db->insert('settings');
	}
}

/* End of file setup_model.php */
/* Location: ./setup/models/setup_model.php */