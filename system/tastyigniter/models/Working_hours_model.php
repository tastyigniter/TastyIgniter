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
 * Working hours Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Working_hours_model.php
 * @link           http://docs.tastyigniter.com
 */
class Working_hours_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'working_hours';

	public $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

	public function getHoursByLocation()
	{
		$collection = [];

		$weekdays = $this->getWeekDays();

		foreach ($this->getAsArray() as $row) {
			$type = !empty($row['type']) ? $row['type'] : 'opening';
			$weekday = $weekdays[$row['weekday']];

			$collection[$row['location_id']][$type][$row['weekday']] = array_merge($row, [
				'location_id' => $row['location_id'],
				'day'         => $weekday,
				'type'        => $type,
				'open'        => strtotime("{$weekday} {$row['opening_time']}"),
				'close'       => strtotime("{$weekday} {$row['closing_time']}"),
				'is_24_hours' => ($row['status'] == '1' AND $row['opening_time'] === '00:00:00' AND $row['closing_time'] === '23:59:00'),
			]);
		}

		return $collection;
	}

	public function setWeekDays($weekDays)
	{
		$this->weekDays = $weekDays;
	}

	public function getWeekDays()
	{
		return $this->weekDays;
	}
}

/* End of file Working_hours_model.php */
/* Location: ./system/tastyigniter/models/Working_hours_model.php */