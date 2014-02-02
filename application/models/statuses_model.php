<?php
class Statuses_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getStatuses($for = FALSE) {
		$this->db->from('statuses');
		
		if ($for !== FALSE) {
			$this->db->where('status_for', $for);		
		}
		
		$query = $this->db->get();
		
		return $query->result_array();
	}

	public function getStatus($status_id) {
		$this->db->from('statuses');
		
		$this->db->where('status_id', $status_id);
		$query = $this->db->get();
		
		return $query->row_array();
	}

	public function updateStatus($status_for = FALSE, $update = array()) {
		if (!empty($update['status_name'])) {
			$this->db->set('status_name', $update['status_name']);
		}

		if (!empty($update['status_comment'])) {
			$this->db->set('status_comment', $update['status_comment']);
		}

		if ($status_for !== FALSE) {
			$this->db->set('status_for', $status_for);
		}

		if ($update['notify_customer'] === '1') {
			$this->db->set('notify_customer', $update['notify_customer']);
		} else {
			$this->db->set('notify_customer', '0');
		}

		if (!empty($update['status_id'])) {
			$this->db->where('status_id', $update['status_id']);
			$this->db->update('statuses'); 
		}
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addStatus($status_for = FALSE, $add = array()) {
		if (!empty($add['status_name'])) {
			$this->db->set('status_name', $add['status_name']);
		}

		if (!empty($add['status_comment'])) {
			$this->db->set('status_comment', $add['status_comment']);
		}

		if ($status_for !== FALSE) {
			$this->db->set('status_for', $status_for);
		}

		if ($add['notify_customer'] === '1') {
			$this->db->set('notify_customer', $add['notify_customer']);
		} else {
			$this->db->set('notify_customer', '0');
		}

		$this->db->insert('statuses'); 
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteStatus($status_id) {

		$this->db->where('status_id', $status_id);
		
		return $this->db->delete('statuses');
	}
}