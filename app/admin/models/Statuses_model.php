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

    public static function listStatuses()
    {
        return static::all()->keyBy('status_id');
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
}