<?php namespace System\Models;

use Admin\Facades\AdminAuth;
use Artisan;
use Carbon\Carbon;
use Igniter\Traits\DelegateToCI;
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
        return static::selectRaw("currency_id, CONCAT_WS(' - ', currency_name, currency_code, currency_symbol) as name")
                     ->dropdown('name');
    }

    /**
     * Auto update rates,
     * called by before_create trigger
     * @return void
     */
    public static function autoUpdateRates()
    {
        if (setting('auto_update_currency_rates') == '1') {
            self::make()->updateRates();
        }
    }

    //
    // Scopes
    //

    public function scopeJoinCountry($query)
    {
        return $query->join('countries', 'countries.iso_code_3', '=', 'currencies.iso_alpha3', 'left');
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
        $query->joinCountry();

        if (isset($filter['filter_search']) AND is_string($filter['filter_search'])) {
            $query->search($filter['filter_search'], ['currency_name', 'currency_code']);

            $query->orWhereHas('country', function ($q) use ($filter) {
                $q->search($filter['filter_search'], ['country_name']);
            });
        }

        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('currency_status', $filter['filter_status']);
        }

        return $query;
    }

    //
    // Events
    //

    public function afterCreate()
    {
        self::autoUpdateRates();
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
        $update = self::where('currency_id', '!=', setting('currency_id'))
                      ->update(['currency_status' => '0']);

        if (is_array($accepted_currencies)) {
            $update = self::whereIn('currency_id', $accepted_currencies)
                          ->update(['currency_status' => '1']);
        }

        return $update;
    }

    /**
     * Update all currency rates
     *
     * @param bool $force_refresh
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function updateRates($forceUpdates = FALSE)
    {
        $query = $this->newQuery()->where('currency_id', '!=', setting('currency_id'));
        if (!$forceUpdates)
            $query->whereDate('date_modified', '<', Carbon::yesterday());

        if (!$query->get())
            return FALSE;

        Artisan::call('currency:update');

        activity()->performedOn($this)
                  ->causedBy(AdminAuth::getUser())
                  ->log(lang('system::currencies.activity_updated_event_log'));

        return TRUE;
    }
}