<?php namespace System\Models;

use Admin\Models\Image_tool_model;
use Igniter\Flame\Database\Traits\Sortable;
use Model;

/**
 * Countries Model Class
 * @package System
 */
class Countries_model extends Model
{
    use Sortable;

    /**
     * @var string The database table name
     */
    protected $table = 'countries';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'country_id';

    protected $fillable = ['country_id', 'country_name', 'iso_code_2', 'iso_code_3', 'format', 'status', 'flag'];

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
    // Accessors & Mutators
    //

    public function getFlagUrlAttribute($value)
    {
        return Image_tool_model::resize($this->flag, ['default' => 'flags/no_flag.png']);
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

    /**
     * Filter database records
     *
     * @param $query
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['country_name']);
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('status', $filter['filter_status']);
        }

        return $query;
    }
}