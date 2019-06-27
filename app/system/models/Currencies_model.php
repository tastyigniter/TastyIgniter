<?php namespace System\Models;

use Model;

/**
 * Currencies Model Class
 * @package System
 */
class Currencies_model extends Model
{
    const UPDATED_AT = 'date_modified';

    /**
     * @var string The database table name
     */
    protected $table = 'currencies';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'currency_id';

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    public $relation = [
        'belongsTo' => [
            'country' => 'System\Models\Countries_model',
        ],
    ];

    public static function getDropdownOptions()
    {
        return static::select(['currencies.country_id', 'priority', 'currency_code'])
                     ->selectRaw("CONCAT_WS(' - ', country_name, currency_code, currency_symbol) as name")
                     ->leftJoin('countries', 'currencies.country_id', '=', 'countries.country_id')
                     ->orderBy('priority')
                     ->where('currency_status', 1)
                     ->dropdown('name', 'currency_code');
    }
}