<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Messages Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Messages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Messages_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'messages';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'message_id';

	protected $fillable = ['sender_id', 'date_added', 'send_type', 'recipient', 'subject', 'body', 'status'];

	public $belongsTo = [
		'staffs'    => ['Staffs_model', 'sender_id'],
		'customers' => ['Customers_model', 'message_meta.value'],
	];

	public $hasMany = [
		'message_meta' => ['Message_meta_model'],
	];

	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';

	/**
	 * List all options matching the filter
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getList($filter = [])
	{
		$this->select('*, messages.date_added, messages.status AS message_status');

		return parent::getList($filter);
	}

	public function scopeSelectRecipientStatus($query)
	{
		return $query->selectRaw('*, ' . $this->tablePrefix('message_meta') . '.status AS recipient_status');
	}

	/**
	 * Filter database records
	 *
	 * @param $query
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$query = $this->queryCustomerInboxMessages($query, $filter);
		} else if (APPDIR == ADMINDIR) {

			if ($filter['filter_folder'] == 'inbox') {
				$query = $this->queryInboxMessages($query, $filter);
			} else if ($filter['filter_folder'] == 'draft') {
				$query = $this->queryDraftMessages($query, $filter);
			} else if ($filter['filter_folder'] == 'sent') {
				$query = $this->querySentMessages($query, $filter);
			} else if ($filter['filter_folder'] == 'archive') {
				$query = $this->queryArchiveMessages($query, $filter);
			} else if ($filter['filter_folder'] == 'all') {
				$query = $this->queryAllMessages($query, $filter);
			}

			if (!empty($filter['filter_search']) OR !empty($filter['filter_recipient'])
				OR !empty($filter['filter_type']) OR !empty($filter['filter_date'])
			) {
				$query->where(function ($query) use ($filter) {
					if (!empty($filter['filter_search'])) {
						$query->search($filter['filter_search'], ['staff_name', 'subject']);
					}

					if (!empty($filter['filter_recipient'])) {
						$query->where('recipient', $filter['filter_recipient']);
					}

					if (!empty($filter['filter_type'])) {
						$query->where('send_type', $filter['filter_type']);
					}

					if (!empty($filter['filter_date'])) {
						$date = mdate('%Y-%m', strtotime($filter['filter_date']));
						$query->like('messages.date_added', $date, 'after');
					}
				});
			}
		}

		return $query;
	}

	/**
	 * Create SQL query to retrieve customer inbox message
	 *
	 * @param array $filter
	 */
	protected function queryCustomerInboxMessages($query, $filter = [])
	{
		if (isset($filter['customer_id'])) {
			$query->join('message_meta', 'message_meta.message_id', '=', 'messages.message_id', 'left');
			$query->leftJoin('customers', function ($join) {
				$join->on('customers.customer_id', '=', 'message_meta.value')
					 ->where('message_meta.item', 'customer_id');
			});

			$query->where('message_meta.status', '1');
			$query->where('message_meta.deleted', '0');
			$query->where('messages.send_type', 'account');
			$query->where('message_meta.item', 'customer_id');
			$query->where('message_meta.value', $filter['customer_id']);
		}

		return $query;
	}

	/**
	 * Create SQL query to retrieve inbox message
	 *
	 * @param array $filter
	 */
	protected function queryInboxMessages($query, $filter = [])
	{
		if (isset($filter['filter_staff'])) {
			$query->selectRecipientStatus();

			$query->join('staffs', 'staffs.staff_id', '=', 'messages.sender_id', 'left');
			$query->join('message_meta', 'message_meta.message_id', '=', 'messages.message_id', 'left');

			$query->where(function ($query) use ($filter) {
				$query->where('messages.status', '>=', '1');
				$query->where('message_meta.status', '1');
				$query->where('message_meta.deleted', '0');
				$query->where('messages.send_type', 'account');
				$query->where('message_meta.item', 'staff_id');
				$query->where('message_meta.value', $filter['filter_staff']);
			});
		}

		return $query;
	}

	/**
	 * Create SQL query to retrieve draft message
	 *
	 * @param array $filter
	 */
	protected function queryDraftMessages($query, $filter = [])
	{
		if (isset($filter['filter_staff'])) {
			$query->join('staffs', 'staffs.staff_id', '=', 'messages.sender_id', 'left');

			$query->where('messages.status', '0');
			$query->where('messages.sender_id', $filter['filter_staff']);
		}

		return $query;
	}

	/**
	 * Create SQL query to retrieve sent message
	 *
	 * @param array $filter
	 */
	protected function querySentMessages($query, $filter = [])
	{
		if (isset($filter['filter_staff'])) {
			$query->selectRecipientStatus();
			$query->join('staffs', 'staffs.staff_id', '=', 'messages.sender_id', 'left');
			$query->join('message_meta', function ($join) {
				$join->on('message_meta.message_id', '=', 'messages.message_id')
					 ->where('message_meta.item', 'sender_id');
			});

			$query->where(function ($query) use ($filter) {
				$query->where('messages.status', '1');
				$query->where('message_meta.status', '1');
				$query->where('message_meta.deleted', '0');
				$query->where('message_meta.item', 'sender_id');
				$query->where('message_meta.value', $filter['filter_staff']);
			});
		}

		return $query;
	}

	/**
	 * Create SQL query to retrieve archive message
	 *
	 * @param array $filter
	 */
	protected function queryArchiveMessages($query, $filter = [])
	{
		if (isset($filter['filter_staff'])) {
			$query->selectRecipientStatus();
			$query->join('staffs', 'staffs.staff_id', '=', 'messages.sender_id', 'left');
			$query->join('message_meta', 'message_meta.message_id', '=', 'messages.message_id', 'left');

			$query->where('messages.status', '1');
			$query->where('message_meta.deleted', '1');
			$query->where('message_meta.value', $filter['filter_staff']);

			$query->where(function ($query) use ($filter) {
				$query->where('message_meta.item', 'staff_id');
				$query->orWhere('message_meta.item', 'sender_id');
			});
		}

		return $query;
	}

	/**
	 * Create SQL query to retrieve inbox message
	 *
	 * @param array $filter
	 */
	protected function queryAllMessages($query, $filter = [])
	{
		if (isset($filter['filter_staff'])) {
			$query->selectRecipientStatus();
			$query->join('staffs', 'staffs.staff_id', '=', 'messages.sender_id', 'left');
			$query->join('message_meta', 'message_meta.message_id', '=', 'messages.message_id', 'left');

			$query->where(function ($query) use ($filter) {
				$query->where('messages.status', '1');
				$query->where('message_meta.value', $filter['filter_staff']);
				$query->where('message_meta.deleted', '!=', '2');

				$query->where('message_meta.item', 'staff_id');
				$query->orWhere('message_meta.item', 'sender_id');
			});
		}
	}

	/**
	 * Find a single message by message_id
	 *
	 * @param int $message_id
	 *
	 * @return array
	 */
	public function getMessage($message_id)
	{
		return $this->findOrNew($message_id)->toArray();
	}

	/**
	 * Find a single draft message by message_id
	 *
	 * @param int $message_id
	 *
	 * @return array
	 */
	public function getDraftMessage($message_id)
	{
		return $this->where('sender_id', $this->user->getStaffId())
					->where('message_id', $message_id)
					->where('status', '0')->firstAsArray();
	}

	/**
	 * Return all recipients of a message
	 *
	 * @param int $message_id
	 *
	 * @return array
	 */
	public function getRecipients($message_id)
	{
		$staffTable = $this->tablePrefix('staffs');
		$customersTable = $this->tablePrefix('customers');
		$metaTable = $this->tablePrefix('message_meta');

		$this->load->model('Message_meta_model');
		$query = $this->Message_meta_model->selectRaw("{$metaTable}.*, {$staffTable}.staff_id, {$staffTable}.staff_name, " .
			"{$staffTable}.staff_email, {$customersTable}.customer_id, {$customersTable}.first_name, {$customersTable}.last_name, {$customersTable}.email");

		$query->leftJoin('staffs', function ($join) {
			$join->on('staffs.staff_id', '=', 'message_meta.value')
				 ->orOn('staffs.staff_email', '=', 'message_meta.value');
		});
		$query->leftJoin('customers', function ($join) {
			$join->on('customers.customer_id', '=', 'message_meta.value')
				 ->orOn('customers.email', '=', 'message_meta.value');
		});

		$query->where('item', '!=', 'sender_id');
		$query->where('message_id', $message_id);

		return $query->getAsArray();
	}

	/**
	 * Return the dates of all messages
	 *
	 * @return array
	 */
	public function getMessageDates()
	{
		return $this->pluckDates('date_added');
	}

	/**
	 * Find a single message by message_id and user_id
	 *
	 * @param int $message_id
	 * @param string $user_id
	 *
	 * @return array
	 */
	public function viewMessage($message_id, $user_id = '')
	{
		if (is_numeric($message_id) AND is_numeric($user_id)) {
			$messageTable = $this->tablePrefix('messages');
			$metaTable = $this->tablePrefix('message_meta');

			$query = $this->selectRaw("*, {$metaTable}.status, {$messageTable}.date_added, {$metaTable}.status AS recipient_status, " .
				"{$messageTable}.status AS message_status");
			$query->groupBy('messages.message_id');
			$query->where('messages.message_id', $message_id);

			if (APPDIR == ADMINDIR) {
				$query->join('staffs', 'staffs.staff_id', '=', 'messages.sender_id', 'left');

				$query->where(function ($query) {
					$query->where('message_meta.item', 'sender_id');
					$query->orWhere('message_meta.item', 'staff_id');
				});

				$query->where('message_meta.value', $user_id);
			} else {
				$query->join('customers', 'customers.customer_id', '=', 'message_meta.value', 'left');

				$query->where(function ($query) use ($user_id) {
					$query->where('messages.status', '1');
					$query->where('message_meta.status', '1');
					$query->where('message_meta.deleted', '0');
					$query->where('messages.send_type', 'account');
					$query->where('message_meta.item', 'customer_id');
					$query->where('message_meta.value', $user_id);
				});
			}

			$query->join('message_meta', 'message_meta.message_id', '=', 'messages.message_id', 'left');

			return $query->firstAsArray();
		}
	}

	/**
	 * Count the number of unread inbox messages
	 *
	 * @param string $user_id
	 *
	 * @return string
	 */
	public function getUnreadCount($user_id = '')
	{
		if (is_numeric($user_id) AND $this->hasTable('message_meta')) {
			$query = $this->where('messages.status', '1')
						  ->where('message_meta.status', '1')
						  ->where('message_meta.deleted', '0')
						  ->where('message_meta.state', '0')
						  ->where('messages.send_type', 'account')
						  ->where('message_meta.value', $user_id);

			if (APPDIR == ADMINDIR) {
				$query->where('message_meta.item', 'staff_id');
			} else {
				$query->where('message_meta.item', 'customer_id');
			}

			$query->join('message_meta', 'message_meta.message_id', '=', 'messages.message_id', 'left');

			return $query->count();
		}
	}

	/**
	 * Update a message state or status
	 *
	 * @param int $message_meta_id
	 * @param int $user_id
	 * @param string $state
	 * @param string $folder
	 *
	 * @return bool
	 */
	public function updateState($message_meta_id, $user_id, $state, $folder = '')
	{
		$query = FALSE;

		if (!is_array($message_meta_id)) $message_meta_id = [$message_meta_id];

		if (is_numeric($user_id)) {
			$update = [];
			if ($state == 'unread') {
				$update['state'] = '0';
			} else if ($state == 'read') {
				$update['state'] = '1';
			} else if ($state == 'restore') {
				$update['status'] = '1';
				$update['deleted'] = '0';
			} else if ($state == 'archive') {
				$update['deleted'] = '1';
			} else if ($state == 'trash') {
				$update['deleted'] = '2';
			}

			$where['value'] = $user_id;
			$this->load->model('Message_meta_model');
			$queryBuilder = $this->Message_meta_model->whereIn('message_meta_id', $message_meta_id);

			if (APPDIR == ADMINDIR) {
				if ($folder == 'inbox') {
					$queryBuilder->where('item', 'staff_id');
				} else if ($folder == 'sent') {
					$queryBuilder->where('item', 'sender_id');
				} else {
					$queryBuilder->where(function ($query) {
						$query->where('item', 'sender_id');
						$query->orWhere('item', 'staff_id');
					});
				}
			} else {
				$queryBuilder->where('item', 'customer_id');
			}

			$query = $queryBuilder->update($update);
		}

		return $query;
	}

	/**
	 * Create a new or update existing message
	 *
	 * @param int $message_id
	 * @param array $save
	 *
	 * @return bool|int The $message_id of the affected row, or FALSE on failure
	 */
	public function saveMessage($message_id, $save = [])
	{
		if (empty($save)) return FALSE;

		if (isset($save['save_as_draft']) AND $save['save_as_draft'] == '1') {
			$save['status'] = '0';
		} else {
			$save['status'] = '1';
		}

		$save['sender_id'] = $this->user->getStaffId();

		$messageModel = $this->findOrNew($message_id);

		$saved = $messageModel->fill($save)->save();

		$message_id = $saved ? $messageModel->getKey() : $saved;

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
	protected function sendMessage($message_id, $send = [])
	{
		$results = [];

		$column = ($send['send_type'] == 'email') ? 'email' : 'id';

		if (empty($send['save_as_draft']) OR $send['save_as_draft'] != '1') {
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
	public function addRecipients($message_id, $send, $recipients)
	{
		$this->load->model('Message_meta_model');
		$this->Message_meta_model->where('message_id', $message_id)->delete();

		$suffix = ($send['send_type'] == 'email') ? 'email' : 'id';

		if ($recipients) {
			$insert = [];
			foreach ($recipients as $key => $recipient) {
				if (!empty($recipient)) {
					$status = (is_numeric($recipient)) ? '1' : $this->_sendMail($message_id, $recipient);

					$meta['value'] = $recipient;
					$meta['message_id'] = $message_id;
					$meta['status'] = $status;

					if ($key === 'sender_id') {
						$meta['item'] = 'sender_id';
					} else if (in_array($send['recipient'], ['all_staffs', 'staff_group', 'staffs'])) {
						$meta['item'] = 'staff_' . $suffix;
					} else {
						$meta['item'] = 'customer_' . $suffix;
					}

					$insert[] = $meta;
				}
			}

			if (!($query = $this->Message_meta_model->insertGetId($insert))) {
				return FALSE;
			}

			return $query;
		}
	}

	/**
	 * Delete a single or multiple message by message_id
	 *
	 * @param int $message_id
	 * @param string $user_id
	 *
	 * @return mixed
	 */
	public function deleteMessage($message_id, $user_id = '')
	{
		if (is_numeric($message_id)) $message_id = [$message_id];

		if (!empty($message_id) AND ctype_digit(implode('', $message_id))) {
			// Delete draft messages
			return $this->where('sender_id', $user_id)
						->where('status', '0')->whereIn('message_id', $message_id)->delete();
		}
	}

	/**
	 * Send a message to recipient email or account
	 *
	 * @param int $message_id
	 * @param string $email
	 *
	 * @return string
	 */
	public function _sendMail($message_id, $email)
	{
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
					log_message('debug', $this->email->print_debugger(['headers']));
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