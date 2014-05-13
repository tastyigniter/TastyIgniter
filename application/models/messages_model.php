<?php
class Messages_model extends CI_Model {

    public function record_count($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('sender', $filter['filter_search']);
			$this->db->or_like('subject', $filter['filter_search']);
		}

		if ($filter['filter_label'] === 'sent') {
			$this->db->where('label !=', 'alerts');
		} else {
			$this->db->where('label', $filter['filter_label']);
		}
		
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

			if (!empty($filter['filter_search'])) {
				$this->db->like('sender', $filter['filter_search']);
				$this->db->or_like('subject', $filter['filter_search']);
			}

			if ($filter['filter_label'] === 'sent') {
				$this->db->where('label !=', 'alerts');
			} else {
				$this->db->where('label', $filter['filter_label']);
			}
			
			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}
	
	public function getMainInbox() {
		$this->db->from('messages');
		
		$this->db->order_by('date', 'DESC');

		$this->db->where('label', 'customers');

		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}
	
	public function getMainInboxTotal() {
		$this->db->from('messages');
		
		$this->db->where('label', 'customers');

		return $this->db->count_all_results();
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
	
	public function sendMessage($send_data = array()) {
		
		$current_time = time();
		$this->db->set('date', mdate('%Y-%m-%d %H:%i:%s', $current_time));
			
		if (!empty($send_data['sender'])) {
			$this->db->set('sender', $send_data['sender']);
		}
			
		if (!empty($send_data['staff_id'])) {
			$this->db->set('staff_id', $send_data['staff_id']);
		}
			
		if (!empty($send_data['receiver'])) {
			$this->db->set('receiver', $send_data['receiver']);
		}
			
		if (!empty($send_data['subject'])) {
			$this->db->set('subject', $send_data['subject']);
		}
			
		if (!empty($send_data['label'])) {
			$this->db->set('label', $send_data['label']);
		}
			
		if (!empty($send_data['body'])) {
			$this->db->set('body', $send_data['body']);
		}
			
		$this->db->insert('messages');
			
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

/* End of file messages_model.php */
/* Location: ./application/models/messages_model.php */