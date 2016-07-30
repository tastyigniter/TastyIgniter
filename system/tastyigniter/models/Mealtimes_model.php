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
 * Mealtimes Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Mealtimes_model.php
 * @link           http://docs.tastyigniter.com
 */
class Mealtimes_model extends TI_Model {
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'mealtimes';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'mealtime_id';

	protected $casts = array(
		'start_time' => 'time',
		'end_time'   => 'time',
	);

	/**
	 * Return all enabled mealtimes
	 * @return array
	 */
	public function getMealtimes() {
		return $this->find_all();
	}

	/**
	 * Find a single mealtime by mealtime_id
	 *
	 * @param $mealtime_id
	 *
	 * @return object
	 */
	public function getMealtime($mealtime_id) {
		return $this->find($mealtime_id);
	}

	/**
	 * Create a new or update existing mealtimes
	 *
	 * @param array $mealtimes
	 *
	 * @return bool
	 */
	public function updateMealtimes($mealtimes = array()) {
		$query = FALSE;

		if ( ! empty($mealtimes)) {
			foreach ($mealtimes as $mealtime) {
				$this->skip_validation(TRUE)->save($mealtime, $mealtime['mealtime_id']);
			}

			$query = TRUE;
		}

		return $query;
	}
}

/* End of file Mealtimes_model.php */
/* Location: ./system/tastyigniter/models/Mealtimes_model.php */