<?php

namespace Admin\Models;

use Admin\Traits\Locationable;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Flame\Database\Traits\Validation;

/**
 * Tables Model Class
 */
class Tables_model extends Model
{
    use Locationable;
    use Validation;
    use Sortable;

    const LOCATIONABLE_RELATION = 'locations';

    const SORT_ORDER = 'priority';

    /**
     * @var string The database table name
     */
    protected $table = 'tables';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'table_id';

    protected $casts = [
        'min_capacity' => 'integer',
        'max_capacity' => 'integer',
        'extra_capacity' => 'integer',
        'priority' => 'integer',
        'is_joinable' => 'boolean',
        'table_status' => 'boolean',
    ];

    public $relation = [
        'morphToMany' => [
            'locations' => ['Admin\Models\Locations_model', 'name' => 'locationable'],
        ],
    ];

    public $rules = [
        ['table_name', 'lang:admin::lang.label_name', 'required|min:2|max:255'],
        ['min_capacity', 'lang:admin::lang.tables.label_min_capacity', 'required|integer|min:1|lte:max_capacity'],
        ['max_capacity', 'lang:admin::lang.tables.label_capacity', 'required|integer|min:1|gte:min_capacity'],
        ['extra_capacity', 'lang:admin::lang.tables.label_extra_capacity', 'required|integer'],
        ['priority', 'lang:admin::lang.tables.label_priority', 'required|integer'],
        ['is_joinable', 'lang:admin::lang.tables.label_joinable', 'required|boolean'],
        ['table_status', 'lang:admin::lang.label_status', 'required|boolean'],
    ];

    public $timestamps = TRUE;

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
}
