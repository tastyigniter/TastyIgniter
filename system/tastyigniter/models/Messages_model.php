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
 * Messages Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Messages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Messages_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'messages';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'message_id';

	protected $belongs_to = array(
		'staffs'    => array('Staffs_model', 'sender_id'),
		'customers' => array('Customers_model', 'message_meta.value'),
	);

	protected $has_many = array(
		'message_meta' => array('Message_meta_model'),
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count();
	}

	/**
	 * List all options matching the filter
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getList($filter = array()) {
		$this->select('*, messages.date_added, messages.status AS message_status');

		return $this->filter($filter)->find_all();
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$this->queryCustomerInboxMessages($filter);
		} else if (APPDIR === ADMINDIR) {

			if ($filter['filter_folder'] === 'inbox') {
				$this->queryInboxMessages($filter);
			} else if ($filter['filter_folder'] === 'draft') {
				$this->queryDraftMessages($filter);
			} else if ($filter['filter_folder'] === 'sent') {
				$this->querySentMessages($filter);
			} else if ($filter['filter_folder'] === 'archive') {
				$this->queryArchiveMessages($filter);
			} else if ($filter['filter_folder'] === 'all') {
				$this->queryAllMessages($filter);
			}

			if (!empty($filter['filter_search']) OR !empty($filter['filter_recipient'])
				OR !empty($filter['filter_type']) OR !empty($filter['filter_date'])
			) {
				$this->group_start();
				if (!empty($filter['filter_search'])) {
					$this->like('staff_name', $filter['filter_search']);
					$this->or_like('subject', $filter['filter_search']);
				}

				if (!empty($filter['filter_recipient'])) {
					$this->where('recipient', $filter['filter_recipient']);
				}

				if (!empty($filter['filter_type'])) {
					$this->where('send_type', $filter['filter_type']);
				}

				if (!empty($filter['filter_date'])) {
					$date = mdate('%Y-%m', strtotime($filter['filter_date']));
					$this->like('messages.date_added', $date, 'after');
				}
				$this->group_end();
			}
		}

		return $this;
	}

	/**
	 * Create SQL query to retrieve customer inbox message
	 *
	 * @param array $filter
	 */
	protected function queryCustomerInboxMessages($filter = array()) {
		if (isset($filter['customer_id'])) {
			$this->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');
			$this->join('customers', 'customers.customer_id = message_meta.value AND message_meta.item = ' . $this->escape('customer_id'), 'left');

			$this->where('message_meta.status', '1');
			$this->where('message_meta.deleted', '0');
			$this->where('messages.send_type', 'account');
			$this->where('message_meta.item', 'customer_id');
			$this->where('message_meta.value', $filter['customer_id']);
		}
	}

	/**
	 * Create SQL query to retrieve inbox message
	 *
	 * @param array $filter
	 */
	protected function queryInboxMessages($filter = array()) {
		if (isset($filter['filter_staff'])) {
			$this->select('message_meta.status AS recipient_status');

			$this->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');
			$this->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

			$this->where('messages.status >=', '1');
			$this->where('message_meta.status', '1');
			$this->where('message_meta.deleted', '0');
			$this->where('messages.send_type', 'account');
			$this->where('message_meta.item', 'staff_id');
			$this->where('message_meta.value', $filter['filter_staff']);
		}
	}

	/**
	 * Create SQL query to retrieve draft message
	 *
	 * @param array $filter
	 */
	protected function queryDraftMessages($filter = array()) {
		if (isset($filter['filter_staff'])) {
			$this->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');

			$this->where('messages.status', '0');
			$this->where('messages.sender_id', $filter['filter_staff']);
		}
	}

	/**
	 * Create SQL query to retrieve sent message
	 *
	 * @param array $filter
	 */
	protected function querySentMessages($filter = array()) {
		if (isset($filter['filter_staff'])) {
			$this->select('message_meta.status AS recipient_status');
			$this->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');
			$this->join('message_meta', 'message_meta.message_id = messages.message_id AND message_meta.item = ' . $this->escape('sender_id'), 'left');

			$this->where('messages.status', '1');
			$this->where('message_meta.status', '1');
			$this->where('message_meta.deleted', '0');
			$this->where('message_meta.item', 'sender_id');
			$this->where('message_meta.value', $filter['filter_staff']);
		}
	}

	/**
	 * Create SQL query to retrieve archive message
	 *
	 * @param array $filter
	 */
	protected function queryArchiveMessages($filter = array()) {
		if (isset($filter['filter_staff'])) {
			$this->select('message_meta.status AS recipient_status');
			$this->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');
			$this->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

			$this->where('messages.status', '1');
			$this->where('message_meta.deleted', '1');
			$this->where('message_meta.value', $filter['filter_staff']);

			$this->group_start();
			$this->where('message_meta.item', 'staff_id');
			$this->or_where('message_meta.item', 'sender_id');
			$this->group_end();
		}
	}

	/**
	 * Create SQL query to retrieve inbox message
	 *
	 * @param array $filter
	 */
	protected function queryAllMessages($filter = array()) {
		if (isset($filter['filter_staff'])) {
			$this->select('message_meta.status AS recipient_status');
			$this->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');
			$this->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

			$this->where('messages.status', '1');
			$this->where('message_meta.value', $filter['filter_staff']);
			$this->where('message_meta.deleted !=', '2');

			$this->group_start();
			$this->where('message_meta.item', 'staff_id');
			$this->or_where('message_meta.item', 'sender_id');
			$this->group_end();
		}
	}

	/**
	 * Find a single message by message_id
	 *
	 * @param int $message_id
	 *
	 * @return array
	 */
	public function getMessage($message_id) {
		return $this->find($message_id);
	}

	/**
	 * Find a single draft message by message_id
	 *
	 * @param int $message_id
	 *
	 * @return array
	 */
	public function getDraftMessage($message_id) {
		$this->where('sender_id', $this->user->getStaffId());
		$this->where('message_id', $message_id);
		$this->where('status', '0');

		return $this->find();
	}

	/**
	 * Return all recipients of a message
	 *
	 * @param int $message_id
	 *
	 * @return array
	 */
	public function getRecipients($message_id) {
		$this->load->model('Message_meta_model');
		$this->Message_meta_model->select('message_meta.*, staffs.staff_id, staffs.staff_name, staffs.staff_email, customers.customer_id, customers.first_name, customers.last_name, customers.email');
		$this->Message_meta_model->join('staffs', "staffs.staff_id = message_meta.value OR staffs.staff_email = message_meta.value", 'left');
		$this->Message_meta_model->join('customers', "customers.customer_id = message_meta.value OR customers.email = message_meta.value", 'left');

		$this->Message_meta_model->where('item !=', 'sender_id');
		$this->Message_meta_model->where('message_id', $message_id);

		return $this->Message_meta_model->find_all();
	}

	/**
	 * Return the dates of all messages
	 *
	 * @return array
	 */
	public function getMessageDates() {
		$this->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->group_by('MONTH(date_added)');
		$this->group_by('YEAR(date_added)');

		return $this->find_all();
	}

	/**
	 * Find a single message by message_id and user_id
	 *
	 * @param int    $message_id
	 * @param string $user_id
	 *
	 * @return array
	 */
	public function viewMessage($message_id, $user_id = '') {
		if (is_numeric($message_id) AND is_numeric($user_id)) {
			$this->select('*, message_meta.status, messages.date_added, message_meta.status AS recipient_status, messages.status AS message_status');
			$this->group_by('messages.message_id');
			$this->where('messages.message_id', $message_id);

			if (APPDIR === ADMINDIR) {
				$this->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');

				$this->group_start();
				$this->where('message_meta.item', 'sender_id');
				$this->or_where('message_meta.item', 'staff_id');
				$this->group_end();

				$this->where('message_meta.value', $user_id);
			} else {
				$this->join('customers', 'customers.customer_id = message_meta.value', 'left');

				$this->where('messages.status', '1');
				$this->where('message_meta.status', '1');
				$this->where('message_meta.deleted', '0');
				$this->where('messages.send_type', 'account');
				$this->where('message_meta.item', 'customer_id');
				$this->where('message_meta.value', $user_id);
			}

			$this->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

			return $this->find();
		}
	}

	/**
	 * Count the number of unread inbox messages
	 *
	 * @param string $user_id
	 *
	 * @return string
	 */
	public function getUnreadCount($user_id = '') {
		if (is_numeric($user_id) AND $this->table_exists('message_meta')) {
			$this->where('messages.status', '1');
			$this->where('message_meta.status', '1');
			$this->where('message_meta.deleted', '0');
			$this->where('message_meta.state', '0');
			$this->where('messages.send_type', 'account');
			$this->where('message_meta.value', $user_id);

			if (APPDIR === ADMINDIR) {
				$this->where('message_meta.item', 'staff_id');
			} else {
				$this->where('message_meta.item', 'customer_id');
			}

			$this->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

			return $this->count();
		}
	}

	/**
	 * Update a message state or status
	 *
	 * @param int    $message_meta_id
	 * @param int    $user_id
	 * @param string $state
	 * @param string $folder
	 *
	 * @return bool
	 */
	public function updateState($message_meta_id, $user_id, $state, $folder = '') {
		$query = FALSE;

		if (!is_array($message_meta_id)) $message_meta_id = array($message_meta_id);

		if (is_numeric($user_id)) {
			$update = array();
			if ($state === 'unread') {
				$update['state'] = '0';
			} else if ($state === 'read') {
				$update['state'] = '1';
			} else if ($state === 'restore') {
				$update['status'] = '1';
				$update['deleted'] = '0';
			} else if ($state === 'archive') {
				$update['deleted'] = '1';
			} else if ($state === 'trash') {
				$update['deleted'] = '2';
			}

			$where['value'] = $user_id;
			$this->load->model('Message_meta_model');
			$this->Message_meta_model->where_in('message_meta_id', $message_meta_id);

			if (APPDIR === ADMINDIR) {
				if ($folder === 'inbox') {
					$this->Message_meta_model->where('item', 'staff_id');
				} else if ($folder === 'sent') {
					$this->Message_meta_model->where('item', 'sender_id');
				} else {
					$this->Message_meta_model->group_start();
					$this->Message_meta_model->where('item', 'sender_id');
					$this->Message_meta_model->or_where('item', 'staff_id');
					$this->Message_meta_model->group_end();
				}
			} else {
				$this->Message_meta_model->where('item', 'customer_id');
			}

			$query = $this->Message_meta_model->update($where, $update);
		}

		return $query;
	}

	/**
	 * Create a new or update existing message
	 *
	 * @param int   $message_id
	 * @param array $save
	 *
	 * @return bool|int The $message_id of the affected row, or FALSE on failure
	 */
	public function saveMessage($message_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['save_as_draft']) AND $save['save_as_draft'] === '1') {
			$save['status'] = '0';
		} else {
			$save['status'] = '1';
		}

		$save['sender_id'] = $this->user->getStaffId();
		$save['date_added'] = mdate('%Y-%m-%d %H:%i:%s', time());

		$message_id = $this->skip_validation(TRUE)->save($save, $message_id);
		if (is_numeric($message_id) AND empty($save['save_as_draft'])
			AND !empty($save['recipient']) AND !empty($save['send_type'])
		) {
			$this->sendMessage($message_id, $save);
		}

		return $message_id;
	}

	/**
	 * Send a new or existing message
	 *
	 * @param       $message_id
	 * @param array $send
	 *
	 * @return bool
	 */
	protected function sendMessage($message_id, $send = array()) {
		$results = array();

		$column = ($send['send_type'] === 'email') ? 'email' : 'id';

		if (empty($send['save_as_draft']) OR $send['save_as_draft'] !== '1') {
			$this->load->model('Customers_model');

			switch ($send['recipient']) {
				case 'all_newsletters':
					$results = $this->Customers_model->getCustomersByNewsletterForMessages($column);
					break;
				case 'all_customers':
					$results = $this->Customers_model->getCustomersForMessages($column);
					break;
				case 'customer_group':
					$results = $this->Customers_model->getCustomersByGroupIdForMessages($column,
						$send['customer_group_id']);
					break;
				case 'customers':
					if (isset($send['customers'])) {
						$results = $this->Customers_model->getCustomerForMessages($column, $send['customers']);
					}

					break;
				case 'all_staffs':
					$results = $this->Staffs_model->getStaffsForMessages($column);
					break;
				case 'staff_group':
					$results = $this->Staffs_model->getStaffsByGroupIdForMessages($column, $send['staff_group_id']);
					break;
				case 'staffs':
					if (isset($send['staffs'])) {
						$results = $this->Staffs_model->getStaffForMessages($column, $send['staffs']);
					}

					break;
			}

			$results['sender_id'] = $this->user->getStaffId();

			if (!empty($results) AND $this->addRecipients($message_id, $send, $results)) {
				return TRUE;
			}
		}
	}

	/**
	 * Add message recipients to database
	 *
	 * @param $message_id
	 * @param $send
	 * @param $recipients
	 *
	 * @return bool
	 */
	public function addRecipients($message_id, $send, $recipients) {
		$this->load->model('Message_meta_model');
		$this->Message_meta_model->delete('message_id', $message_id);

		$suffix = ($send['send_type'] === 'email') ? 'email' : 'id';

		if ($recipients) {
			$insert = array();
			foreach ($recipients as $key => $recipient) {
				if (!empty($recipient)) {
					$status = (is_numeric($recipient)) ? '1' : $this->_sendMail($message_id, $recipient);

					$insert[]['value'] = $recipient;
					$insert[]['message_id'] = $message_id;
					$insert[]['status'] = $status;

					if ($key === 'sender_id') {
						$insert[]['item'] = 'sender_id';
					} else if (in_array($send['recipient'], array('all_staffs', 'staff_group', 'staffs'))) {
						$insert[]['item'] = 'staff_' . $suffix;
					} else {
						$insert[]['item'] = 'customer_' . $suffix;
					}
				}
			}

			if (!($query = $this->Message_meta_model->insert('message_meta', $insert))) {
				return FALSE;
			}

			return $query;
		}
	}

	/**
	 * Delete a single or multiple message by message_id
	 *
	 * @param int    $message_id
	 * @param string $user_id
	 *
	 * @return mixed
	 */
	public function deleteMessage($message_id, $user_id = '') {
		if (is_numeric($message_id)) $message_id = array($message_id);

		if (!empty($message_id) AND ctype_digit(implode('', $message_id))) {
			// Delete draft messages
			$this->where('sender_id', $user_id);
			$this->where('status', '0');

			return $this->delete('message_id', $message_id);
		}
	}

	/**
	 * Send a message to recipient email or account
	 *
	 * @param int    $message_id
	 * @param string $email
	 *
	 * @return string
	 */
	public function _sendMail($message_id, $email) {
		if (!empty($message_id) AND !empty($email)) {
			$this->load->library('email');

			$mail_data = $this->getMessage($message_id);
			if (isset($mail_data['subject'], $mail_data['body'])) {
				$this->email->initialize();

				$this->email->from($this->config->item('site_email'), $this->config->item('site_name'));

				$this->email->to(strtolower($email));
				$this->email->subject($mail_data['subject']);
				$this->email->message($mail_data['body']);

				if (!$this->email->send()) {
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

/* End of file Messages_model.php */
/* Location: ./system/tastyigniter/models/Messages_model.php */