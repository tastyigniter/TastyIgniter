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
 * Settings Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Settings_model.php
 * @link           http://docs.tastyigniter.com
 */
class Settings_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'settings';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'setting_id';

	/**
	 * Return all settings
	 *
	 * @return array
	 */
	public function getAll()
	{
		return $this->getAsArray();
	}

	/**
	 * Insert new or update multiple existing settings
	 *
	 * @param string $sort
	 * @param array $update
	 * @param bool $flush
	 *
	 * @return bool
	 */
	public function updateSettings($sort, $update = [], $flush = FALSE)
	{
		if (!empty($update) && !empty($sort)) {
			if ($flush === TRUE) {
				$this->where('sort', $sort)->delete();
			}

			$query = FALSE;
			foreach ($update as $item => $value) {
				if (!empty($item)) {
					if ($flush === FALSE) {
						$this->where([
							['sort', '=', $sort],
							['item', '=', $item],
						])->delete();
					}

					if (isset($value)) {
						$serialized = '0';
						if (is_array($value)) {
							$value = serialize($value);
							$serialized = '1';
						}

						$query = $this->insertGetId(['sort' => $sort, 'item' => $item, 'value' => $value, 'serialized' => $serialized]);
					}
				}
			}

			return $query;
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
	public function addSetting($sort, $item, $value, $serialized = '0')
	{
		$query = FALSE;

		if (isset($sort, $item, $value, $serialized)) {
			$this->where([
				['sort', '=', $sort],
				['item', '=', $item],
			])->delete();

			$serialized = '0';
			if (is_array($value)) {
				$value = serialize($value);
				$serialized = '1';
			}

			$query = $this->insertGetId([
				'sort'       => $sort,
				'item'       => $item,
				'value'      => $value,
				'serialized' => $serialized,
			]);
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
	public function deleteSettings($sort, $item)
	{
		if (!empty($sort) AND !empty($item)) {
			return $this->where(
				['sort', '=', $sort],
				['item', '=', $item]
			)->delete();
		}
	}
}

/* End of file Settings_model.php */
/* Location: ./system/tastyigniter/models/Settings_model.php */