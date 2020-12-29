<?php

namespace System\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Model;

/**
 * Countries Model Class
 */
class Countries_model extends Model
{
    use Sortable;

    const SORT_ORDER = 'priority';

    /**
     * @var string The database table name
     */
    protected $table = 'countries';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'country_id';

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
        'priority' => 'integer',
    ];

    public $relation = [
        'hasOne' => [
            'currency' => 'System\Models\Currencies_model',
        ],
    ];

    public static function getDropdownOptions()
    {
        return static::isEnabled()->dropdown('country_name');
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled country
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }
}
