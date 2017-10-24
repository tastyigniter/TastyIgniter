<?php namespace System\Models;

use Admin\Facades\AdminAuth;
use Artisan;
use Carbon\Carbon;
use Model;
use Igniter\Traits\DelegateToCI;

/**
 * Currencies Model Class
 *
 * @package System
 */
class Currencies_model extends Model
{
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

    const UPDATED_AT = 'date_modified';

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
     *
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
     * Return all currencies
     *
     * @return array
     */
    public function getCurrencies()
    {
        return $this->joinCountry()->get();
    }

    /**
     * Find a single currency by currency_id
     *
     * @param int $currency_id
     *
     * @return array
     */
    public function getCurrency($currency_id)
    {
        return $this->joinCountry()->find($currency_id);
    }

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
    public function updateRates($forceUpdates = false)
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

    /**
     * Create a new or update existing currency
     *
     * @param int $currency_id
     * @param array $save
     *
     * @return bool|int The $currency_id of the affected row, or FALSE on failure
     */
    public function saveCurrency($currency_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $currencyModel = $this->findOrNew($currency_id);

        $saved = $currencyModel->fill($save)->save();

        return $saved ? $currencyModel->getKey() : $saved;
    }

    /**
     * Delete a single or multiple currency by currency_id
     *
     * @param string|array $currency_id
     *
     * @return int  The number of deleted rows
     */
    public function deleteCurrency($currency_id)
    {
        if (is_numeric($currency_id)) $currency_id = [$currency_id];

        if (!empty($currency_id) AND ctype_digit(implode('', $currency_id))) {
            return $this->whereIn('currency_id', $currency_id)->delete();
        }
    }

    protected function queryYahooFinance($currencies)
    {
        $yahoo__query = 'select * from yahoo.finance.xchange where pair in ("'.implode(', ', $currencies).'")';
        $yahoo_query_url = "http://query.yahooapis.com/v1/public/yql?q=".urlencode($yahoo__query)."&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $yahoo_query_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $content = curl_exec($curl);
        curl_close($curl);

        $json = json_decode($content, TRUE);

        if (!isset($json['query']['results']['rate']))
            return [];

        if (!isset($json['query']['results']['rate'][0])) {
            $json['query']['results']['rate'] = [$json['query']['results']['rate']];
        }

        return $json['query']['results']['rate'];
    }
}