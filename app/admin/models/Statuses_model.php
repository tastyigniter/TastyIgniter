<?php namespace Admin\Models;

use Model;

/**
 * Statuses Model Class
 *
 * @package Admin
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

    public $relation = [
        'hasMany' => [
            'status_history' => 'Admin\Models\Status_history_model',
        ],
    ];

    public static function getDropdownOptionsForOrder()
    {
        return static::isForOrder()->dropdown('status_name');
    }

    public static function getDropdownOptionsForReservation()
    {
        return static::isForReservation()->dropdown('status_name');
    }

    //
    // Scopes
    //

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

    //
    // Helpers
    //

    /**
     * Return status_for attribute as lang text, used by
     *
     * @param $value
     * @param $row
     *
     * @return string
     */
    public function getStatusForNameAttribute($value)
    {
        return ($this->status_for == 'reserve') ? lang('text_reservation') : lang('text_order');
    }

    public static function listStatuses()
    {
        return static::all()->keyBy('status_id');
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

        return $query->orderBy('status_for')->get();
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
        $staffTable = $this->getTablePrefix('staffs');
        $statusHistoryTable = $this->getTablePrefix('status_history');
        $statusesTable = $this->getTablePrefix('statuses');

        $query = Status_history_model::selectRaw("status_history_id, {$statusHistoryTable}.date_added, {$staffTable}.staff_name,".
            " {$statusHistoryTable}.assignee_id, {$statusesTable}.status_name, {$statusesTable}.status_color, ".
            "{$statusHistoryTable}.notify, {$statusHistoryTable}.comment")
                                     ->where('object_id', $order_id)
                                     ->where('status_history.status_for', $for)
                                     ->orderBy('status_history.date_added', 'DESC')
                                     ->joinStatusAndStaffTables();

        return $query->get();
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
        $query = Status_history_model::where('status_for', $for)
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

        $query = Status_history_model::where('status_for', $for)
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

        return Status_history_model::insertGetId($add);
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