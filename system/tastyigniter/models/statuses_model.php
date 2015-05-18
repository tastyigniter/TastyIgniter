<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Statuses_model extends TI_Model {

	public function getStatuses($for = FALSE) {
		$this->db->from('statuses');

		if (!empty($for)) {
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
		$this->db->select('status_history_id, status_history.date_added, staffs.staff_name, status_history.assignee_id, statuses.status_name, status_history.notify, status_history.comment');
		$this->db->from('status_history');
		$this->db->join('statuses', 'statuses.status_id = status_history.status_id', 'left');
		$this->db->join('staffs', 'staffs.staff_id = status_history.staff_id', 'left');
		$this->db->where('object_id', $order_id);
		$this->db->where($this->db->dbprefix('status_history').'.status_for', $for);
		$this->db->order_by('status_history.date_added', 'DESC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getStatusHistory($for = FALSE, $order_id) {
		$this->db->select('history_id, status_history.date_added, staffs.staff_name, statuses.status_name, status_history.notify, status_history.comment');
		$this->db->from('status_history');
		$this->db->where('status_for', $for);
		$this->db->order_by('status_history.date_added', 'DESC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->row_array();
		}

		return $result;
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

	public function updateStatus($update = array()) {
		$query = FALSE;

		if (!empty($update['status_name'])) {
			$this->db->set('status_name', $update['status_name']);
		}

        if (!empty($update['status_color'])) {
            $this->db->set('status_color', $update['status_color']);
        }

        if (!empty($update['status_comment'])) {
            $this->db->set('status_comment', $update['status_comment']);
        }

        if (!empty($update['status_for'])) {
			$this->db->set('status_for', $update['status_for']);
		}

		if ($update['notify_customer'] === '1') {
			$this->db->set('notify_customer', $update['notify_customer']);
		} else {
			$this->db->set('notify_customer', '0');
		}

		if (!empty($update['status_id'])) {
			$this->db->where('status_id', $update['status_id']);
			$query = $this->db->update('statuses');
		}

		return $query;
	}

	public function addStatus($add = array()) {
		$query = FALSE;

		if (!empty($add['status_name'])) {
			$this->db->set('status_name', $add['status_name']);
		}

        if (!empty($add['status_color'])) {
            $this->db->set('status_color', $add['status_color']);
        }

        if (!empty($add['status_comment'])) {
            $this->db->set('status_comment', $add['status_comment']);
        }

		if (!empty($add['status_for'])) {
			$this->db->set('status_for', $add['status_for']);
		}

		if ($add['notify_customer'] === '1') {
			$this->db->set('notify_customer', $add['notify_customer']);
		} else {
			$this->db->set('notify_customer', '0');
		}

		if (!empty($add)) {
			if ($this->db->insert('statuses')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function addStatusHistory($for = '', $add = array()) {
		$query = FALSE;

		if (!empty($add['staff_id'])) {
			$this->db->set('staff_id', $add['staff_id']);
		}

		if (!empty($add['assignee_id'])) {
			$this->db->set('assignee_id', $add['assignee_id']);
		}

		if (!empty($add['object_id'])) {
			$this->db->set('object_id', $add['object_id']);
		}

		if (!empty($add['status_id'])) {
			$this->db->set('status_id', $add['status_id']);
		}

		if ($for !== '') {
			$this->db->set('status_for', $for);
		}

		if ($add['notify'] === '1') {
			$this->db->set('notify', $add['notify']);
		} else {
			$this->db->set('notify', '0');
		}

		if (!empty($add['comment'])) {
			$this->db->set('comment', $add['comment']);
		}

		if (!empty($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}

		if (!empty($add)) {
			if ($this->db->insert('status_history')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}

	public function deleteStatus($status_id) {
		if (is_numeric($status_id)) {
			$this->db->where('status_id', $status_id);
			$this->db->delete('statuses');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file statuses_model.php */
/* Location: ./system/tastyigniter/models/statuses_model.php */