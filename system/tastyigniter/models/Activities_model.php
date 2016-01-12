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
class Activities_model extends TI_Model {

	public function getCount($filter = array()) {
		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('status', $filter['filter_status']);
		}

		$this->db->from('activities');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('activities');

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('status', $filter['filter_status']);
			}

			$this->db->order_by('date_added', 'DESC');

			$query = $this->db->get();
			$result = $sort_result = array();

			if ($query->num_rows() > 0) {
				return $query->result_array();
			}

			return $result;
		}
	}

	public function getActivities() {
		$this->db->from('activities');
		$this->db->order_by('date_added', 'DESC');

		$query = $this->db->get();
		$activities = array();

		if ($query->num_rows() > 0) {
			$activities = $query->result_array();
		}

		return $activities;
	}

	public function logActivity($user_id, $action, $context, $message) {
		if (method_exists($this->router, 'fetch_module')) {
			$this->_module = $this->router->fetch_module();
		}

		if (is_numeric($user_id) AND is_string($action) AND is_string($message)) {
			// set the current domain (e.g admin, main, module)
			$domain = ( ! empty($this->_module)) ? 'module' : APPDIR;

			// set user if customer is logged in and the domain is not admin
			$user = 'staff';
			if ($domain !== ADMINDIR) {
				$this->load->library('customer');
				if ($this->customer->islogged()) {
					$user = 'customer';
				}
			}

			$this->db->set('user', $user);
			$this->db->set('domain', $domain);
			$this->db->set('context', $context);

			if (is_numeric($user_id)) {
				$this->db->set('user_id', $user_id);
			}

			if (is_string($action)) {
				$this->db->set('action', $action);
			}

			if (is_string($message)) {
				$this->db->set('message', $message);
			}

			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));

			$this->db->insert('activities');
		}
	}

	public function getMessage($lang, $search = array(), $replace = array()) {
		$this->lang->load('activities');

		return str_replace($search, $replace, $this->lang->line($lang));
	}
}

/* End of file activities_model.php */
/* Location: ./system/tastyigniter/models/activities_model.php */
