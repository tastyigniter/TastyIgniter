<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Messages_model extends CI_Model {

    public function getCount($filter = array()) {
		if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$this->db->where('message_recipients.customer_id', $filter['customer_id']);
			$this->db->where('message_recipients.status', '1');

			$this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');
			$this->db->from('messages');
			return $this->db->count_all_results();
		}
    }

	public function getList($filter = array()) {
		if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			if (!empty($filter['page']) AND $filter['page'] !== 0) {
				$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
			}

			if ($this->db->limit($filter['limit'], $filter['page'])) {
				$this->db->select('*, messages.date_added');
				$this->db->from('messages');
				$this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');
				$this->db->join('customers', 'customers.customer_id = message_recipients.customer_id', 'left');

				$this->db->group_by('messages.message_id');
				$this->db->order_by('messages.date_added', 'DESC');

				$this->db->where('message_recipients.customer_id', $filter['customer_id']);
				$this->db->where('message_recipients.status', '1');

				$query = $this->db->get();
				$result = array();

				if ($query->num_rows() > 0) {
					$result = $query->result_array();
				}

				return $result;
			}
		}
	}

	public function viewMessage($customer_id = '', $message_id) {
		if (is_numeric($message_id) AND is_numeric($customer_id)) {
			$this->db->select('*, message_recipients.status, messages.date_added');
			$this->db->from('messages');
			$this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');
			$this->db->join('customers', 'customers.customer_id = message_recipients.customer_id', 'left');

			$this->db->where('messages.message_id', $message_id);
			$this->db->where('messages.send_type', 'account');
			$this->db->where('message_recipients.customer_id', $customer_id);

			$query = $this->db->get();
			return $query->row_array();
		}
	}

	public function getInboxTotal($customer_id = '') {
		if (is_numeric($customer_id)) {
			$this->db->from('messages');
			$this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');

			$this->db->where('message_recipients.customer_id', $customer_id);
			$this->db->where('message_recipients.state', '0');
			$this->db->where('message_recipients.status', '1');
			$this->db->where('messages.send_type', 'account');

			$total = $this->db->count_all_results();

			if ($total < 1) {
				$total = '';
			}

			return $total;
		}
	}

	public function updateState($message_id, $customer_id, $state) {
		$query = FALSE;

		if (is_numeric($message_id) AND is_numeric($customer_id)) {
			if ($state === 'trash') {
				$this->db->set('status', '0');
			} else if ($state === 'inbox') {
				$this->db->set('status', '1');
			} else if (is_numeric($state)) {
				$this->db->set('state', $state);
			}

			$this->db->where('message_id', $message_id);
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->update('message_recipients');
		}

		return $query;
	}
}

/* End of file messages_model.php */
/* Location: ./main/models/messages_model.php */