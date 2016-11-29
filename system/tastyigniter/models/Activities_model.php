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
 * Activities Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Activities_model.php
 * @link           http://docs.tastyigniter.com
 */
class Activities_model extends Model
{
	/**
	 * @var string The database table name
	 */
	public $table = 'activities';

	/**
	 * @var string The database table primary key
	 */
	public $primaryKey = 'activity_id';

	protected $fillable = ['domain', 'context', 'user', 'user_id', 'action', 'message', 'status', 'date_added'];

	public $timestamps = TRUE;

	/**
	 * @var array Auto-fill the created date field on insert
	 */
	const CREATED_AT = 'date_added';

	/**
	 * Filter database records
	 *
	 * @param $query
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('status', $filter['filter_status']);
		}

		return $query;
	}

	/**
	 * Log activity to database
	 *
	 * @param int $user_id    the logged in admin or customer id
	 * @param string $action  the activity action taken e.g (added, updated, assigned, custom,...)
	 * @param string $context where the activity occurred, the controller name
	 * @param string $message the activity message to record
	 */
	public function logActivity($user_id, $action, $context, $message)
	{
		if (is_numeric($user_id) AND is_string($action) AND is_string($message)) {
			// set the current domain (e.g admin, main, module)
			$domain = (!empty($this->router->fetch_module())) ? 'module' : APPDIR;

			// set user if customer is logged in and the domain is not admin
			$user = 'staff';
			if ($domain !== ADMINDIR) {
				$this->load->library('customer');
				if ($this->customer->islogged()) {
					$user = 'customer';
				}
			}

			$data['user'] = $user;
			$data['domain'] = $domain;
			$data['context'] = $context;

			if (is_numeric($user_id))
				$data['user_id'] = $user_id;

			if (is_string($action))
				$data['action'] = $action;

			if (is_string($message))
				$data['message'] = $message;

			$this->create($data);
		}
	}

	/**
	 * Return the activity message language text
	 *
	 * @param string $lang
	 * @param array $search
	 * @param array $replace
	 *
	 * @return string
	 */
	public function getMessage($lang, $search = [], $replace = [])
	{
		$this->lang->load('activities');

		return str_replace($search, $replace, $this->lang->line($lang));
	}
}

/* End of file Activities_model.php */
/* Location: ./system/tastyigniter/models/Activities_model.php */