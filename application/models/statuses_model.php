<?php
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

	public function getStatusHistories($for, $order_id) {
		$this->db->select('status_history_id, status_history.date_added, staffs.staff_name, status_history.assigned_id, statuses.status_name, status_history.notify, status_history.comment');
		$this->db->from('status_history');
		$this->db->join('statuses', 'statuses.status_id = status_history.status_id', 'left');
		$this->db->join('staffs', 'staffs.staff_id = status_history.staff_id', 'left');
		$this->db->where('order_id', $order_id);		
		$this->db->where('status_for', $for);		
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
		$this->db->where('for', $for);		
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

	public function addStatusHistory($for = FALSE, $add = array()) {
		if (!empty($add['staff_id'])) {
			$this->db->set('staff_id', $add['staff_id']);
		}

		if (!empty($add['assigned_id'])) {
			$this->db->set('assigned_id', $add['assigned_id']);
		}

		if (!empty($add['order_id'])) {
			$this->db->set('order_id', $add['order_id']);
		}

		if (!empty($add['status_id'])) {
			$this->db->set('status_id', $add['status_id']);
		}

		if ($for !== FALSE) {
			$this->db->set('for', $for);
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

		$this->db->insert('status_history'); 
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteStatus($status_id) {

		$this->db->where('status_id', $status_id);
		
		return $this->db->delete('statuses');
	}
}

/* End of file statuses_model.php */
/* Location: ./application/models/statuses_model.php */