<?php

declare(strict_types=1);

namespace Igniter\Reservation\Models;

use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Sortable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Concerns\Switchable;

/**
 * Tables Model Class
 *
 * @deprecated Use the DiningTable model instead
 */
class Table extends Model
{
    use HasFactory;
    use Locationable;
    use Sortable;
    use Switchable;

    public const LOCATIONABLE_RELATION = 'locations';

    public const SWITCHABLE_COLUMN = 'table_status';

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
    ];

    public $relation = [
        'morphToMany' => [
            'locations' => [Location::class, 'name' => 'locationable'],
        ],
    ];

    public $timestamps = true;

    // @codeCoverageIgnoreStart
    public static function getDropdownOptions()
    {
        return self::selectRaw('table_id, concat(table_name, " (", min_capacity, " - ", max_capacity, ")") AS display_name')
            ->dropdown('display_name');
    }

    public function scopeWhereBetweenCapacity($query, $noOfGuests)
    {
        return $query->where('min_capacity', '<=', $noOfGuests)
            ->where('max_capacity', '>=', $noOfGuests);
    }

    // @codeCoverageIgnoreEnd
}
