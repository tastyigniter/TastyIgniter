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
                     ->dropdown('name', 'currency_code');
    }

    //
    // Helpers
    //

    /**
     * Update the accepted currencies
     *
     * @param array $accepted_currencies an indexed array of currency ids
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public static function updateAcceptedCurrencies($accepted_currencies)
    {
        $update = self::where('currency_id', '!=', setting('default_currency_code'))
                      ->update(['currency_status' => '0']);

        if (is_array($accepted_currencies)) {
            $update = self::whereIn('currency_id', $accepted_currencies)
                          ->update(['currency_status' => '1']);
        }

        return $update;
    }
}