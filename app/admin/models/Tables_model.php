<?php namespace Admin\Models;

use Model;

/**
 * Tables Model Class
 *
 * @package Admin
 */
class Tables_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'tables';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'table_id';

    public $fillable = ['table_name', 'min_capacity', 'max_capacity', 'max_capacity'];

    public $relation = [
        'hasManyThrough' => [
            'reservations' => [
                'Admin\Models\Reservations_model',
                'throughKey' => 'table_id',
                'through'    => 'Admin\Models\Location_tables_model',
            ],
        ],
        'belongsToMany'  => [
            'locations' => ['Admin\Models\Locations_model', 'table' => 'location_tables'],
        ],
    ];

    /**
     * Scope a query to only include enabled location
     *
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('table_status', 1);
    }

    public function scopeWhereHasLocation($query, $locationId)
    {
        return $query->whereHas('locations',
            function ($query) use ($locationId) {
                $query->where('locations.location_id', $locationId);
            });
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
