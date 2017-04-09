<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use Igniter\Database\Model;

/**
 * Statuses Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Statuses_model.php
 * @link           http://docs.tastyigniter.com
 */
class Statuses_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'statuses';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'status_id';

	public $hasMany = [
		'status_history' => 'Status_history_model',
	];

	/**
	 * Scope a query to only include order statuses
	 *
	 * @param $query
	 *
	 * @return $this
	 */
	public function scopeIsForOrder($query)
	{
		return $query->where('status_for', 'order');
	}

	/**
	 * Scope a query to only include reservation statuses
	 *
	 * @param $query
	 *
	 * @return $this
	 */
	public function scopeIsForReservation($query)
	{
		return $query->where('status_for', 'reserve');
	}

    /**
     * Return status_for attribute as lang text, used by
     *
     * @param $value
     * @param $row
     *
     * @return string
     */
    public function formatStatusFor($value, $row) {
        return ($value == 'reserve') ? lang('text_reservation') : lang('text_order');
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
		if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
			$query->where('status_for', $filter['filter_type']);
		}

		return $query;
	}

	/**
	 * Return all status by order or reservation
	 *
	 * @param string $for
	 *
	 * @return array
	 */
	public function getStatuses($for = '')
	{
		$query = $this->query();

		if (!empty($for)) {
			$query->where('status_for', $for);
		}

		return $query->orderBy('status_for')->getAsArray();
	}

	/**
	 * Return all status history by order or reservation
	 *
	 * @param $for
	 * @param $order_id
	 *
	 * @return array
	 */
	public function getStatusHistories($for, $order_id)
	{
		$this->load->model('Status_history_model');

		$staffTable = $this->tablePrefix('staffs');
		$statusHistoryTable = $this->tablePrefix('status_history');
		$statusesTable = $this->tablePrefix('statuses');

		$query = $this->Status_history_model->selectRaw("status_history_id, {$statusHistoryTable}.date_added, {$staffTable}.staff_name," .
			" {$statusHistoryTable}.assignee_id, {$statusesTable}.status_name, {$statusesTable}.status_color, ".
			"{$statusHistoryTable}.notify, {$statusHistoryTable}.comment")
											->where('object_id', $order_id)
											->where('status_history.status_for', $for)
											->orderBy('status_history.date_added', 'DESC')
											->joinStatusAndStaffTables();
		return $query->getAsArray();
	}

	/**
	 * Find a single status history
	 *
	 * @param string $for
	 * @param int $order_id
	 * @param array $status_id
	 *
	 * @return array
	 */
	public function getStatusHistory($for = null, $order_id, $status_id = [])
	{
		$this->load->model('Status_history_model');
		$query = $this->Status_history_model->where('status_for', $for)
											->where('status_history.object_id', $order_id);

		if (!empty($status_id)) {
			$query->whereIn('status_history.status_id', (array)$status_id);
		}

		return $query->orderBy('status_history.date_added', 'DESC')->firstOrNew()->toArray();
	}

	/**
	 * Search for status history by order_id
	 *
	 * @param string $for
	 * @param int $order_id
	 * @param array $status_id
	 *
	 * @return bool
	 */
	public function statusExists($for = null, $order_id, $status_id = [])
	{
		$for = ($for === 'reservation') ? 'reserve' : $for;

		$this->load->model('Status_history_model');
		$query = $this->Status_history_model->where('status_for', $for)
											->where('status_history.object_id', $order_id);

		if (!empty($status_id)) {
			$query->whereIn('status_history.status_id', (array)$status_id);
		}

		if ($query->first()) {
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
	public function getStatus($status_id)
	{
		return $this->findOrNew($status_id)->toArray();
	}

	/**
	 * Return a single status comment by status_id
	 *
	 * @param string $status_id
	 *
	 * @return string
	 */
	public function getStatusComment($status_id = '')
	{
		if ($status_id !== '') {
			if ($row = $this->getStatus($status_id)) {
				return $row['status_comment'];
			}
		}
	}

	/**
	 * Create a new or update existing status
	 *
	 * @param int $status_id
	 * @param array $save
	 *
	 * @return bool|int The $status_id of the affected row, or FALSE on failure
	 */
	public function saveStatus($status_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$statusModel = $this->findOrNew($status_id);

		$saved = $statusModel->fill($save)->save();

		return $saved ? $statusModel->getKey() : $saved;
	}

	/**
	 * Create a new status history
	 *
	 * @param string $for
	 * @param array $add
	 *
	 * @return bool
	 */
	public function addStatusHistory($for = '', $add = [])
	{
		if (empty($add)) return FALSE;

		if ($for !== '') {
			$add['status_for'] = $for;
		}

		$this->load->model('Status_history_model');

		return $this->Status_history_model->insertGetId($add);
	}

	/**
	 * Delete a single or multiple status by status_id
	 *
	 * @param string|array $status_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteStatus($status_id)
	{
		if (is_numeric($status_id)) $status_id = [$status_id];

		if (!empty($status_id) AND ctype_digit(implode('', $status_id))) {
			return $this->whereIn('status_id', $status_id)->delete();
		}
	}
}

/* End of file Statuses_model.php */
/* Location: ./system/tastyigniter/models/Statuses_model.php */