<?php namespace Admin\Models;

use Carbon\Carbon;
use Model;

/**
 * Mealtimes Model Class
 *
 * @package Admin
 */
class Mealtimes_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'mealtimes';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'mealtime_id';

    public $casts = [
        'start_time' => 'time',
        'end_time' => 'time',
        'mealtime_status' => 'boolean',
    ];

    public function getDropdownOptions()
    {
        $this->isEnabled()->dropdown('mealtime_name');
    }

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        return $query->where('mealtime_status', 1);
    }

    public function isAvailable($datetime = null)
    {
        if (is_null($datetime))
            $datetime = Carbon::now();

        if (!$datetime instanceof Carbon) {
            $datetime = Carbon::parse($datetime);
        }

        return $datetime->between(
            Carbon::createFromTimeString($this->start_time),
            Carbon::createFromTimeString($this->end_time)
        );
    }

    public function isAvailableNow()
    {
        $this->isAvailable();
    }
}