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
 * Mealtimes Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Mealtimes_model.php
 * @link           http://docs.tastyigniter.com
 */
class Mealtimes_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'mealtimes';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'mealtime_id';

	protected $timeFormat = 'h:i a';

	protected $casts = [
		'start_time' => 'time',
		'end_time'   => 'time',
	];

	/**
	 * Return all enabled mealtimes
	 * @return array
	 */
	public function getMealtimes()
	{
		return $this->getAsArray();
	}

	/**
	 * Find a single mealtime by mealtime_id
	 *
	 * @param $mealtime_id
	 *
	 * @return object
	 */
	public function getMealtime($mealtime_id)
	{
		return $this->findOrNew($mealtime_id)->toArray();
	}

	/**
	 * Create a new or update existing mealtimes
	 *
	 * @param array $mealtimes
	 *
	 * @return bool
	 */
	public function updateMealtimes($mealtimes = [])
	{
		$query = FALSE;

		if (!empty($mealtimes)) {
			foreach ($mealtimes as $mealtime) {
				$this->findOrNew($mealtime['mealtime_id'])->fill($mealtime)->save();
			}

			$query = TRUE;
		}

		return $query;
	}
}

/* End of file Mealtimes_model.php */
/* Location: ./system/tastyigniter/models/Mealtimes_model.php */