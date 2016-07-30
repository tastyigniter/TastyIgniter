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
 * Activities Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Activities_model.php
 * @link           http://docs.tastyigniter.com
 */
class Activities_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'activities';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'activity_id';

	/**
	 * @var array Auto-fill the created date field on insert
	 */
	protected $timestamps = array('created');

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count();
	}

	/**
	 * List all activities matching the filter array
	 *
	 * @param array $filter
	 *
	 * @return mixed An array of arrays representing the results, or FALSE on failure.
	 */
	public function getList($filter = array()) {
		return $this->filter($filter)->find_all();
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Log activity to database
	 *
	 * @param int    $user_id the logged in admin or customer id
	 * @param string $action  the activity action taken e.g (added, updated, assigned, custom,...)
	 * @param string $context where the activity occurred, the controller name
	 * @param string $message the activity message to record
	 */
	public function logActivity($user_id, $action, $context, $message) {
		if (method_exists($this->router, 'fetch_module')) {
			$this->_module = $this->router->fetch_module();
		}

		if (is_numeric($user_id) AND is_string($action) AND is_string($message)) {
			// set the current domain (e.g admin, main, module)
			$domain = (!empty($this->_module)) ? 'module' : APPDIR;

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

			if (is_numeric($user_id)) {
				$data['user_id'] = $user_id;
			}

			if (is_string($action)) {
				$data['action'] = $action;
			}

			if (is_string($message)) {
				$data['message'] = $message;
			}

			$this->insert($data);
		}
	}

	/**
	 * Return the activity message language text
	 *
	 * @param string $lang
	 * @param array  $search
	 * @param array  $replace
	 *
	 * @return string
	 */
	public function getMessage($lang, $search = array(), $replace = array()) {
		$this->lang->load('activities');

		return str_replace($search, $replace, $this->lang->line($lang));
	}
}

/* End of file Activities_model.php */
/* Location: ./system/tastyigniter/models/Activities_model.php */