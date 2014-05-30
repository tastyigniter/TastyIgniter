<?php
class Alerts_model extends CI_Model {

    public function record_count($filter = array()) {
		if (!empty($filter['staff_id'])) {
			$this->db->where('recipient', $filter['staff_id']);
		}
	
		if (!empty($filter['filter_search'])) {
			$this->db->like('sender', $filter['filter_search']);
			$this->db->or_like('subject', $filter['filter_search']);
		}

		$this->db->where('label', 'alerts');
		$this->db->from('messages');
	
		return $this->db->count_all_results();
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('messages');
			$this->db->join('staffs', 'staffs.staff_id = messages.sender', 'left');
			$this->db->order_by('date', 'DESC');

			if (!empty($filter['staff_id'])) {
				$this->db->where('recipient', $filter['staff_id']);
			}
		
			if (!empty($filter['filter_search'])) {
				$this->db->like('sender', $filter['filter_search']);
				$this->db->or_like('subject', $filter['filter_search']);
			}

			$this->db->where('label', 'alerts');

			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getStaffAlerts($staff_id) {
		$this->db->from('messages');
		$this->db->join('staffs', 'staffs.staff_id = messages.sender', 'left');
		
		$this->db->order_by('date', 'DESC');

		if (isset($staff_id)) {
			$this->db->where('recipient', $staff_id);
			$this->db->where('type', 'alert');
		}
		
		$this->db->where('type', 'alert');

		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}
	
	public function viewAdminMessage($message_id) {
		$this->db->from('messages');
		$this->db->join('staffs', 'staffs.staff_id = messages.sender', 'left');

		$this->db->where('message_id', $message_id);
		
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function viewMessage($message_id) {
		$this->db->from('messages');

		$this->db->where('message_id', $message_id);
		
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function sendAlert($send = array()) {
		
		$current_time = time();
		$this->db->set('date', mdate('%Y-%m-%d %H:%i:%s', $current_time));
		$this->db->set('label', 'alerts');
			
		if (!empty($send['sender'])) {
			$this->db->set('sender', $send['sender']);
		}
			
		if (!empty($send['recipient'])) {
			$this->db->set('recipient', $send['recipient']);
		}
			
		if (!empty($send['subject'])) {
			$this->db->set('subject', $send['subject']);
		}
			
		if (!empty($send['body'])) {
			$this->db->set('body', $send['body']);
		}
			
		$this->db->insert('messages');
			
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteMessage($message_id) {
		if (is_numeric($message_id)) {
			$this->db->where('message_id', $message_id);
			$this->db->delete('messages');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file alerts_model.php */
/* Location: ./application/models/alerts_model.php */