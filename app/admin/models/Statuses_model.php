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
        return ($this->status_for == 'reserve') ? lang('admin::lang.statuses.text_reservation') : lang('admin::lang.statuses.text_order');
    }

    public function getStatusForDropdownOptions()
    {
        return [
            'order'   => lang('admin::lang.statuses.text_order'),
            'reserve' => lang('admin::lang.statuses.text_reservation'),
        ];
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

    //
    // Helpers
    //

    public static function listStatuses()
    {
        return static::all()->keyBy('status_id');
    }
}