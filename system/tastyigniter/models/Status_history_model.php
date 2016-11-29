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
 * Status History Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Status_history_model.php
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