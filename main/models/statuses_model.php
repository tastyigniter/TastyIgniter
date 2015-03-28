<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Statuses_model extends CI_Model {

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

	public function getStatus($status_id) {
		$this->db->from('statuses');

		$this->db->where('status_id', $status_id);
		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			return $query->row_array();
		}
	}

	public function addStatusHistory($for = '', $add = array()) {
		$query = FALSE;

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
}

/* End of file statuses_model.php */
/* Location: ./main/models/statuses_model.php */