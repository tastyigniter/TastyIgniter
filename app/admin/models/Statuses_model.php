<?php namespace Admin\Models;

use Admin\Traits\Locationable;
use Model;

/**
 * Statuses Model Class
 */
class Statuses_model extends Model
{
    use Locationable;

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'statuses';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'status_id';

    public $casts = [
        'notify_customer' => 'boolean',
    ];

    public $relation = [
        'hasMany' => [
            'status_history' => 'Admin\Models\Status_history_model',
        ],
        'morphToMany' => [
            'locations' => ['Admin\Models\Locations_model', 'name' => 'locationable'],
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
            'order' => lang('admin::lang.statuses.text_order'),
            'reserve' => lang('admin::lang.statuses.text_reservation'),
        ];
    }

    public static function getDropdownOptionsForOrder()
    {
        $query = static::isForOrder();

        if (app('admin.location')->getModel()) {
            $query->whereHasOrDoesntHaveLocation(app('admin.location')->getModel()->location_id);
        }

        return $query->dropdown('status_name');
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
