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
 * Statuses Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Statuses_model.php
 * @link           http://docs.tastyigniter.com
 */
class Statuses_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_type'])) {
			$this->db->where('status_for', $filter['filter_type']);
		}

		$this->db->from('statuses');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('statuses');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
				$this->db->where('status_for', $filter['filter_type']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getStatuses($for = FALSE) {
		$this->db->from('statuses');
		$this->db->order_by('status_for', 'ASC');

		if ( ! empty($for)) {
			$this->db->where('status_for', $for);
		}

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStatusHistories($for, $order_id) {
		$this->db->select('status_history_id, status_history.date_added, staffs.staff_name, status_history.assignee_id, statuses.status_name, statuses.status_color, status_history.notify, status_history.comment');
		$this->db->from('status_history');
		$this->db->join('statuses', 'statuses.status_id = status_history.status_id', 'left');
		$this->db->join('staffs', 'staffs.staff_id = status_history.staff_id', 'left');
		$this->db->where('object_id', $order_id);
		$this->db->where($this->db->dbprefix('status_history') . '.status_for', $for);
		$this->db->order_by('status_history.date_added', 'DESC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStatusHistory($for = FALSE, $order_id, $status_id = array()) {
		$this->db->from('status_history');
		$this->db->where('status_for', $for);
		$this->db->where('status_history.object_id', $order_id);

		if (!empty($status_id)) {
			$this->db->where_in('status_history.status_id', (array) $status_id);
		}

		$this->db->order_by('status_history.date_added', 'DESC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->row_array();
		}

		return $result;
	}


	public function statusExists($for = FALSE, $order_id, $status_id = array()) {
		$for = ($for === 'reservation') ? 'reserve' : $for;

		$this->db->from('status_history');
		$this->db->where('status_for', $for);
		$this->db->where('status_history.object_id', $order_id);

		if (!empty($status_id)) {
			$this->db->where_in('status_history.status_id', (array) $status_id);
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return TRUE;
		}

		return FALSE;
	}

	public function getStatus($status_id) {
		$this->db->from('statuses');

		$this->db->where('status_id', $status_id);
		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getStatusComment($status_id = '') {
		if ($status_id !== '') {
			$this->db->from('statuses');

			$this->db->where('status_id', $status_id);
			$query = $this->db->get();

			if ($this->db->affected_rows() > 0) {
				$row = $query->row_array();

				return $row['status_comment'];
			}
		}
	}

	public function saveStatus($status_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['status_name'])) {
			$this->db->set('status_name', $save['status_name']);
		}

		if (isset($save['status_color'])) {
			$this->db->set('status_color', $save['status_color']);
		}

		if (isset($save['status_comment'])) {
			$this->db->set('status_comment', $save['status_comment']);
		}

		if (isset($save['status_for'])) {
			$this->db->set('status_for', $save['status_for']);
		}

		if (isset($save['notify_customer']) AND $save['notify_customer'] === '1') {
			$this->db->set('notify_customer', $save['notify_customer']);
		} else {
			$this->db->set('notify_customer', '0');
		}

		if (is_numeric($status_id)) {
			$this->db->where('status_id', $status_id);
			$query = $this->db->update('statuses');
		} else {
			$query = $this->db->insert('statuses');
			$status_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($status_id)) ? $status_id : FALSE;
	}

	public function addStatusHistory($for = '', $add = array()) {
		$query = FALSE;

		if (isset($add['staff_id'])) {
			$this->db->set('staff_id', $add['staff_id']);
		}

		if (isset($add['assignee_id'])) {
			$this->db->set('assignee_id', $add['assignee_id']);
		}

		if (isset($add['object_id'])) {
			$this->db->set('object_id', $add['object_id']);
		}

		if (isset($add['status_id'])) {
			$this->db->set('status_id', $add['status_id']);
		}

		if ($for !== '') {
			$this->db->set('status_for', $for);
		}

		if (isset($add['notify']) AND $add['notify'] === '1') {
			$this->db->set('notify', $add['notify']);
		} else {
			$this->db->set('notify', '0');
		}

		if (isset($add['comment'])) {
			$this->db->set('comment', $add['comment']);
		}

		if (isset($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}

		if ( ! empty($add)) {
			if ($this->db->insert('status_history')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function deleteStatus($status_id) {
		if (is_numeric($status_id)) $status_id = array($status_id);

		if ( ! empty($status_id) AND ctype_digit(implode('', $status_id))) {
			$this->db->where_in('status_id', $status_id);
			$this->db->delete('statuses');

			return $this->db->affected_rows();
		}
	}
}

/* End of file statuses_model.php */
/* Location: ./system/tastyigniter/models/statuses_model.php */