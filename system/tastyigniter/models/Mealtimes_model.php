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
 * Mealtimes Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Mealtimes_model.php
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

	protected $casts = [
//		'start_time' => 'time',
//		'end_time'   => 'time',
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