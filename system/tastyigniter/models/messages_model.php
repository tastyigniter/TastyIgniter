<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Messages_model extends TI_Model {

    public function getCount($filter = array()) {
        if (APPDIR === ADMINDIR) {
            if (!empty($filter['filter_search'])) {
                $this->db->like('staff_name', $filter['filter_search']);
                $this->db->or_like('subject', $filter['filter_search']);
            }

            if ($filter['filter_folder'] !== 'all') {
                $this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');
                $this->db->where('message_recipients.staff_id', $filter['filter_staff']);

                if ($filter['filter_folder'] === 'inbox') {
                    $this->db->where('message_recipients.status', '1');
                }

                if ($filter['filter_folder'] === 'trash') {
                    $this->db->where('message_recipients.status', '0');
                }
            }

            $this->db->join('staffs', 'staffs.staff_id = messages.staff_id_from', 'left');
        } else if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
            $this->db->where('message_recipients.customer_id', $filter['customer_id']);
            $this->db->where('message_recipients.status', '1');
            $this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');
            $this->db->join('customers', 'customers.customer_id = message_recipients.customer_id', 'left');
        }

        $this->db->from('messages');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

        if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->select('*, messages.date_added');
			$this->db->from('messages');
			$this->db->group_by('messages.message_id');

            if (APPDIR === ADMINDIR) {
                $this->db->join('staffs', 'staffs.staff_id = messages.staff_id_from', 'left');

                if ($filter['filter_folder'] !== 'all' AND $filter['filter_folder'] !== 'sent') {
                    $this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');
                    $this->db->where('message_recipients.staff_id', $filter['filter_staff']);

                    if ($filter['filter_folder'] === 'inbox') {
                        $this->db->where('message_recipients.status', '1');
                    }

                    if ($filter['filter_folder'] === 'trash') {
                        $this->db->where('message_recipients.status', '0');
                    }
                }

                if ($filter['filter_folder'] === 'sent') {
                    $this->db->where('staff_id_from', $filter['filter_staff']);
                }

                if (!empty($filter['filter_search'])) {
                    $this->db->like('staff_name', $filter['filter_search']);
                    $this->db->or_like('subject', $filter['filter_search']);
                }

                if (!empty($filter['filter_recipient'])) {
                    $this->db->where('recipient', $filter['filter_recipient']);
                }

                if (!empty($filter['filter_type'])) {
                    $this->db->where('send_type', $filter['filter_type']);
                }
            } else if (!empty($filter['customer_id'])) {
                $this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');
                $this->db->where('message_recipients.customer_id', $filter['customer_id']);
                $this->db->where('message_recipients.status', '1');
            }

            if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
                $this->db->order_by($filter['sort_by'], $filter['order_by']);
            }

            $query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getMessage($message_id) {
		if ($message_id) {
			$this->db->from('messages');
			$this->db->where('message_id', $message_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function getRecipients($message_id) {
		if ($message_id) {
			$this->db->select('*, message_recipients.staff_email, message_recipients.status');
			$this->db->from('message_recipients');
			$this->db->join('staffs', 'staffs.staff_id = message_recipients.staff_id', 'left');
			$this->db->join('customers', 'customers.customer_id = message_recipients.customer_id', 'left');
			$this->db->where('message_id', $message_id);

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getMessageDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('messages');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function viewMessage($message_id, $user_id = '') {
		if (is_numeric($message_id)) {
			$this->db->select('*, message_recipients.status, messages.date_added');
			$this->db->from('messages');
			$this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');

            if (APPDIR === ADMINDIR) {
                $this->db->join('staffs', 'staffs.staff_id = messages.staff_id_from', 'left');
                $this->db->group_by('messages.message_id');

                $this->db->where('message_recipients.staff_id', $user_id);
                $this->db->where('message_recipients.message_id', $message_id);
                if (!is_numeric($user_id)) {
                    $this->db->where('messages.message_id', $message_id);
                }
            } else {
                $this->db->join('customers', 'customers.customer_id = message_recipients.customer_id', 'left');
                $this->db->where('messages.message_id', $message_id);
                $this->db->where('messages.send_type', 'account');
                $this->db->where('message_recipients.customer_id', $user_id);
            }

			$query = $this->db->get();
			return $query->row_array();
		}
	}

	public function getUnreadCount($user_id = '') {
		if (is_numeric($user_id)) {
			if (APPDIR === ADMINDIR) {
                $this->db->where('message_recipients.staff_id', $user_id);
            } else {
                $this->db->where('message_recipients.customer_id', $user_id);
            }

			$this->db->where('message_recipients.state < ', '1');
			$this->db->where('message_recipients.status', '1');
			$this->db->where('messages.send_type', 'account');

			$this->db->from('messages');
			$this->db->join('message_recipients', 'message_recipients.message_id = messages.message_id', 'left');

			$total = $this->db->count_all_results();

			if ($total < 1) {
				$total = '';
			}

			return $total;
		}
	}

	public function updateState($message_id, $user_id, $state) {
		$query = FALSE;

		if (is_numeric($message_id) AND is_numeric($user_id)) {
			if ($state === 'trash') {
				$this->db->set('status', '0');
			} else if ($state === 'inbox') {
				$this->db->set('status', '1');
			} else if (is_numeric($state)) {
				$this->db->set('state', $state);
			}

			$this->db->where('message_id', $message_id);

            if (APPDIR === ADMINDIR) {
                $this->db->where('staff_id', $user_id);
            } else {
                $this->db->where('customer_id', $user_id);
            }

			$query = $this->db->update('message_recipients');
        }

        return $query;
    }

	public function sendMessage($add = array(), $recipients = array()) {
		$query = FALSE;

		if (!empty($add['staff_id_from'])) {
			$this->db->set('staff_id_from', $add['staff_id_from']);
		}

		if (!empty($add['send_type'])) {
			$this->db->set('send_type', $add['send_type']);
		}

		if (!empty($add['recipient'])) {
			$this->db->set('recipient', $add['recipient']);
		}

		if (!empty($add['subject'])) {
			$this->db->set('subject', $add['subject']);
		}

		if (!empty($add['body'])) {
			$this->db->set('body', $add['body']);
		}

		if (!empty($add['date_added'])) {
			$this->db->set('date_added', $add['date_added']);
		}

		$this->db->set('status', '1');

		if ($this->db->insert('messages')) {
			$message_id = $this->db->insert_id();

			$this->addRecipients($message_id, $recipients, $add['send_type']);

			$query = $message_id;
		}

		return $query;
	}

	public function addRecipients($message_id, $recipients = array(), $send_type = 'account') {
		if (is_numeric($message_id) AND !empty($recipients) AND is_array($recipients)) {
            $this->db->where('message_id', $message_id);
            $this->db->delete('message_recipients');

            if (isset($recipients['customer_ids']) AND $send_type === 'account') {
				foreach ($recipients['customer_ids'] as $customer_id) {
					$this->db->set('customer_id', $customer_id);
					$this->db->set('message_id', $message_id);
					$this->db->set('status', '1');
					$this->db->insert('message_recipients');
				}
			}

			if (isset($recipients['customer_emails']) AND $send_type === 'email') {
				foreach ($recipients['customer_emails'] as $customer_email) {
					$this->db->set('customer_email', $customer_email);
					$this->db->set('message_id', $message_id);
					$this->db->set('status', $this->_sendMail($message_id, $customer_email));
					$this->db->insert('message_recipients');
				}
			}

			if (isset($recipients['staff_ids']) AND $send_type === 'account') {
				foreach ($recipients['staff_ids'] as $staff_id) {
					$this->db->set('staff_id', $staff_id);
					$this->db->set('message_id', $message_id);
					$this->db->set('status', '1');
					$this->db->insert('message_recipients');
				}
			}

			if (isset($recipients['staff_emails']) AND $send_type === 'email') {
				foreach ($recipients['staff_emails'] as $staff_email) {
					$this->db->set('staff_email', $staff_email);
					$this->db->set('message_id', $message_id);
					$this->db->set('status', $this->_sendMail($message_id, $staff_email));
					$this->db->insert('message_recipients');
				}
			}
		}
	}

	public function deleteMessage($message_id) {
        if (is_numeric($message_id)) $message_id = array($message_id);

        if (!empty($message_id) AND ctype_digit(implode('', $message_id))) {
            $this->db->where_in('message_id', $message_id);
            $this->db->delete('messages');

            if (($affected_rows = $this->db->affected_rows()) > 0) {
                $this->db->where_in('message_id', $message_id);
                $this->db->delete('message_recipients');

                return $affected_rows;
            }
        }
	}

	public function _sendMail($message_id, $email) {
		if (!empty($message_id) AND !empty($email)) {
			$this->load->library('email');
			$this->load->library('mail_template');

			$mail_data = $this->getMessage($message_id);
			if ($mail_data) {
				$this->email->initialize();

				$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));

				$this->email->to(strtolower($email));
				$this->email->subject($mail_data['subject']);
				$this->email->message($mail_data['body']);

				if ( ! $this->email->send()) {
                    log_message('debug', $this->email->print_debugger(array('headers')));
                    $notify = '0';
				} else {
					$notify = '1';
				}

				return $notify;
			}
		}
	}
}

/* End of file messages_model.php */
/* Location: ./system/tastyigniter/models/messages_model.php */