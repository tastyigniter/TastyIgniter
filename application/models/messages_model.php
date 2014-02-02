<?php
class Messages_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count() {
		$this->db->where('type !=', 'alert');
		$this->db->from('messages');
	
		return $this->db->count_all_results();
    }
    
    public function alerts_record_count($filter = array()) {
		$this->db->where('to', $filter['staff_id']);
		$this->db->where('type', 'alert');
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

			$this->db->where('type !=', 'alert');

			$query = $this->db->get();
			return $query->result_array();
		}
	}
	
	public function getMainInbox() {
		$this->db->from('messages');
		
		$this->db->order_by('date', 'DESC');

		$this->db->where('to', '0');
		$this->db->where('type', 'customers');

		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getMainInboxTotal() {
		$this->db->from('messages');
		
		$this->db->where('to', '0');
		$this->db->where('type', 'customers');

		return $this->db->count_all_results();
	}
	
	public function getAlertsList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
		
        if ($this->db->limit($filter['limit'], $filter['page'])) {	
			$this->db->from('messages');
			$this->db->join('staffs', 'staffs.staff_id = messages.sender', 'left');
		
			$this->db->order_by('date', 'DESC');

			if (!empty($filter['staff_id'])) {
				$this->db->where('to', $filter['staff_id']);
				$this->db->where('type', 'alert');
			}
		
			$this->db->where('type', 'alert');

			$query = $this->db->get();
			return $query->result_array();		
		}
	}
	
	public function getStaffAlerts($staff_id) {
		$this->db->from('messages');
		$this->db->join('staffs', 'staffs.staff_id = messages.sender', 'left');
		
		$this->db->order_by('date', 'DESC');

		if (isset($staff_id)) {
			$this->db->where('to', $staff_id);
			$this->db->where('type', 'alert');
		}
		
		$this->db->where('type', 'alert');

		$query = $this->db->get();
		return $query->result_array();
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
	
	public function sendMessage($type, $send_data = array()) {
		
		if (!empty($send_data['date'])) {
			$this->db->set('date', $send_data['date']);
		}
			
		if (!empty($send_data['time'])) {
			$this->db->set('time', $send_data['time']);
		}
			
		if (!empty($send_data['sender'])) {
			$this->db->set('sender', $send_data['sender']);
		}
			
		if (!empty($send_data['to'])) {
			$this->db->set('to', $send_data['to']);
		}
			
		if (!empty($send_data['subject'])) {
			$this->db->set('subject', $send_data['subject']);
		}
			
		if (!empty($send_data['body'])) {
			$this->db->set('body', $send_data['body']);
		}
			
		if (!empty($type)) {
			$this->db->set('type', $type);
			$this->db->insert('messages');
		}
			
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function deleteMessage($message_id) {

		$this->db->where('message_id', $message_id);

		$this->db->delete('messages');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}
