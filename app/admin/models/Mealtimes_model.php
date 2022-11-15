<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Carbon\Carbon;
use Igniter\Flame\Database\Model;

/**
 * Mealtimes Model Class
 */
class Mealtimes_model extends Model
{
    use Locationable;

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'mealtimes';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'mealtime_id';

    protected $casts = [
        'start_time' => 'time',
        'end_time' => 'time',
        'mealtime_status' => 'boolean',
    ];

    public $relation = [
        'morphToMany' => [
            'locations' => ['Admin\Models\Locations_model', 'name' => 'locationable'],
        ],
    ];

    public $timestamps = true;

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
            $datetime->copy()->setTimeFromTimeString($this->start_time),
            $datetime->copy()->setTimeFromTimeString($this->end_time)
        );
    }

    public function isAvailableNow()
    {
        return $this->isAvailable();
    }
}
