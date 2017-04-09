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
 * Status History Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Status_history_model.php
 * @link           http://docs.tastyigniter.com
 */
class Status_history_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'status_history';

	protected $primaryKey = 'status_history_id';

	public $belongsTo = [
		'staffs'   => 'Staffs_model',
		'statuses' => ['Statuses_model', 'status_id'],
	];

	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';

	public function scopeJoinStatusAndStaffTables($query)
	{
		$query->join('statuses', 'statuses.status_id', '=', 'status_history.status_id', 'left');
		$query->join('staffs', 'staffs.staff_id', '=', 'status_history.staff_id', 'left');

		return $query;
	}

}

/* End of file Status_history_model.php */
/* Location: ./system/tastyigniter/models/Status_history_model.php */