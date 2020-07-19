<?php namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Database\Traits\Validation;
use Model;

/**
 * Tables Model Class
 *
 * @package Admin
 */
class Tables_model extends Model
{
    use Locationable;
    use Validation;

    const LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'tables';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'table_id';

    public $casts = [
        'min_capacity' => 'integer',
        'max_capacity' => 'integer',
        'table_status' => 'boolean',
    ];

    public $relation = [
        'hasManyThrough' => [
            'reservations' => [
                'Admin\Models\Reservations_model',
                'throughKey' => 'table_id',
                'through' => 'Admin\Models\Location_tables_model',
            ],
        ],
        'belongsToMany' => [
            'locations' => ['Admin\Models\Locations_model', 'table' => 'location_tables'],
        ],
    ];

    public $rules = [
        ['table_name', 'lang:admin::lang.label_name', 'required|min:2|max:255'],
        ['min_capacity', 'lang:admin::lang.tables.label_min_capacity', 'required|integer|min:1|lte:max_capacity'],
        ['max_capacity', 'lang:admin::lang.tables.label_capacity', 'required|integer|min:1|gte:min_capacity'],
        ['table_status', 'lang:admin::lang.label_status', 'required|boolean'],
    ];

    public static function getDropdownOptions()
    {
        return self::selectRaw('table_id, concat(table_name, " (", min_capacity, " - ", max_capacity, ")") AS display_name')
            ->dropdown('display_name');
    }

    /**
     * Scope a query to only include enabled location
     *
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('table_status', 1);
    }

    public function scopeWhereBetweenCapacity($query, $noOfGuests)
    {
        return $query->where('min_capacity', '<=', $noOfGuests)
            ->where('max_capacity', '>=', $noOfGuests);
    }

    public function scopeWhereHasReservationBetween($query, $start, $end)
    {
        $query->whereHas('reservations', function ($q) use ($start, $end) {
            $q->whereRaw('ADDTIME(reserve_date, reserve_time) between ? and ?', [$start, $end]);
        });

        return $query;
    }
}
