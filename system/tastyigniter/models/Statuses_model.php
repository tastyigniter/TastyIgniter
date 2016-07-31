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
 * Statuses Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Statuses_model.php
 * @link           http://docs.tastyigniter.com
 */
class Statuses_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'statuses';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'status_id';

	protected $has_many = array(
		'status_history' => 'Status_history_model',
	);

	/**
	 * Scope a query to only include order statuses
	 *
	 * @return $this
	 */
	public function isForOrder() {
		return $this->where('status_for', 'order');
	}

	/**
	 * Scope a query to only include reservation statuses
	 *
	 * @return $this
	 */
	public function isForReservation() {
		return $this->where('status_for', 'reserve');
	}

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
	 * List all statuses matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array|bool
	 */
	public function getList($filter = array()) {
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
		if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
			$this->where('status_for', $filter['filter_type']);
		}

		return $this;
	}

	/**
	 * Return all status by order or reservation
	 *
	 * @param string $for
	 *
	 * @return array
	 */
	public function getStatuses($for = '') {
		if (!empty($for)) {
			$this->where('status_for', $for);
		}

		return $this->order_by('status_for')->find_all();
	}

	/**
	 * Return all status history by order or reservation
	 *
	 * @param $for
	 * @param $order_id
	 *
	 * @return array
	 */
	public function getStatusHistories($for, $order_id) {
		$this->load->model('Status_history_model');
		$this->Status_history_model->select('status_history_id, status_history.date_added, staffs.staff_name, status_history.assignee_id, statuses.status_name, statuses.status_color, status_history.notify, status_history.comment');
		$this->Status_history_model->where('object_id', $order_id);
		$this->Status_history_model->where($this->table_prefix('status_history') . '.status_for', $for);
		$this->Status_history_model->order_by('status_history.date_added', 'DESC');

		return $this->Status_history_model->with('statuses', 'staffs')->find_all();
	}

	/**
	 * Find a single status history
	 *
	 * @param string $for
	 * @param int    $order_id
	 * @param array  $status_id
	 *
	 * @return array
	 */
	public function getStatusHistory($for = NULL, $order_id, $status_id = array()) {
		$this->load->model('Status_history_model');
		$this->Status_history_model->where('status_for', $for);
		$this->Status_history_model->where('status_history.object_id', $order_id);

		if (!empty($status_id)) {
			$this->Status_history_model->where_in('status_history.status_id', (array)$status_id);
		}

		return $this->Status_history_model->order_by('status_history.date_added', 'DESC')->find();
	}


	/**
	 * Search for status history by order_id
	 *
	 * @param string $for
	 * @param int    $order_id
	 * @param array  $status_id
	 *
	 * @return bool
	 */
	public function statusExists($for = NULL, $order_id, $status_id = array()) {
		$for = ($for === 'reservation') ? 'reserve' : $for;

		$this->load->model('Status_history_model');
		$this->Status_history_model->where('status_for', $for);
		$this->Status_history_model->where('status_history.object_id', $order_id);

		if (!empty($status_id)) {
			$this->Status_history_model->where_in('status_history.status_id', (array)$status_id);
		}

		if ($this->Status_history_model->find()) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Find a single status by status_id
	 *
	 * @param int $status_id
	 *
	 * @return array
	 */
	public function getStatus($status_id) {
		return $this->find($status_id);
	}

	/**
	 * Return a single status comment by status_id
	 *
	 * @param string $status_id
	 *
	 * @return string
	 */
	public function getStatusComment($status_id = '') {
		if ($status_id !== '') {
			if ($row = $this->find($status_id)) {
				return $row['status_comment'];
			}
		}
	}

	/**
	 * Create a new or update existing status
	 *
	 * @param int   $status_id
	 * @param array $save
	 *
	 * @return bool|int The $status_id of the affected row, or FALSE on failure
	 */
	public function saveStatus($status_id, $save = array()) {
		if (empty($save)) return FALSE;

		return $this->skip_validation(TRUE)->save($save, $status_id);
	}

	/**
	 * Create a new status history
	 *
	 * @param string $for
	 * @param array  $add
	 *
	 * @return bool
	 */
	public function addStatusHistory($for = '', $add = array()) {
		if (!empty($add)) return FALSE;

		if ($for !== '') {
			$add['status_for'] = $for;
		}

		$this->load->model('Status_history_model');

		return $this->Status_history_model->insert($add);
	}

	/**
	 * Delete a single or multiple status by status_id
	 *
	 * @param string|array $status_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteStatus($status_id) {
		if (is_numeric($status_id)) $status_id = array($status_id);

		if (!empty($status_id) AND ctype_digit(implode('', $status_id))) {
			return $this->delete('status_id', $status_id);
		}
	}
}

/* End of file Statuses_model.php */
/* Location: ./system/tastyigniter/models/Statuses_model.php */