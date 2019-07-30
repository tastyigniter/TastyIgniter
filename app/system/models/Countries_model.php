<?php namespace System\Models;

use Igniter\Flame\Database\Traits\Sortable;
use Main\Models\Image_tool_model;
use Model;

/**
 * Countries Model Class
 * @package System
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

    protected $fillable = ['country_id', 'country_name', 'iso_code_2', 'iso_code_3', 'format', 'status'];

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
