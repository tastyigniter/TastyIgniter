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
 * Settings Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Settings_model.php
 * @link           http://docs.tastyigniter.com
 */
class Settings_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'settings';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'setting_id';

	/**
	 * Return all settings
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->find_all();
	}

	/**
	 * Insert new or update multiple existing settings
	 *
	 * @param string $sort
	 * @param array  $update
	 * @param bool   $flush
	 *
	 * @return bool
	 */
	public function updateSettings($sort, $update = array(), $flush = FALSE) {
		if (!empty($update) && !empty($sort)) {
			if ($flush === TRUE) {
				$this->delete('sort', $sort);
			}

			$data = array();
			foreach ($update as $item => $value) {
				if (!empty($item)) {
					if ($flush === FALSE) {
						$this->delete(array('sort' => $sort, 'item' => $item));
					}

					if (isset($value)) {
						$serialized = '0';
						if (is_array($value)) {
							$value = serialize($value);
							$serialized = '1';
						}

						$data[] = array('sort' => $sort, 'item' => $item, 'value' => $value, 'serialized' => $serialized);
					}
				}
			}

			return $this->insert_batch($data);
		}
	}

	/**
	 * Insert new single setting
	 *
	 * @param string $sort
	 * @param string $item
	 * @param string $value
	 * @param string $serialized
	 *
	 * @return bool
	 */
	public function addSetting($sort, $item, $value, $serialized = '0') {
		$query = FALSE;

		if (isset($sort, $item, $value, $serialized)) {
			$this->delete(array('sort' => $sort, 'item' => $item));

			$serialized = '0';
			if (is_array($value)) {
				$value = serialize($value);
				$serialized = '1';
			}

			$query = $this->insert(array(
				'sort'       => $sort,
				'item'       => $item,
				'value'      => $value,
				'serialized' => $serialized,
			));
		}

		return $query;
	}

	/**
	 * Delete a single setting
	 *
	 * @param string $sort
	 * @param string $item
	 *
	 * @return bool
	 */
	public function deleteSettings($sort, $item) {
		if (!empty($sort) AND !empty($item)) {
			return $this->delete(array('sort' => $sort, 'item' => $item));
		}
	}
}

/* End of file Settings_model.php */
/* Location: ./system/tastyigniter/models/Settings_model.php */