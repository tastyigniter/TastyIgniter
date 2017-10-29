<?php namespace Admin\Models;

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
        'end_time'   => 'time',
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
}