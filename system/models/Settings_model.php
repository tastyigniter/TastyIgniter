<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use Igniter\Database\Model;

/**
 * Settings Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Settings_model.php
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

            $this->config->writeDBConfigCache();
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

        $this->config->writeDBConfigCache();
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
			$query = $this->where([
				['sort', '=', $sort],
				['item', '=', $item]
			])->delete();
		}

        $this->config->writeDBConfigCache();
        return $query;
	}
}

/* End of file Settings_model.php */
/* Location: ./system/tastyigniter/models/Settings_model.php */