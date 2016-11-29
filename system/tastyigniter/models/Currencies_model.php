<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Currencies Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Currencies_model.php
 * @link           http://docs.tastyigniter.com
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

	/**
	 * @var string[] The names of callback methods which
	 * will be called after the insert method.
	 */
	protected $afterCreate = ['autoUpdateRates'];

	public $belongsTo = [
		'country' => 'Countries_model',
	];

	public function scopeJoinCountryTable($query)
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
		$query->joinCountryTable();

		if (!empty($filter['filter_search'])) {
			$query->like('currency_name', $filter['filter_search']);
			$query->orLike('currency_code', $filter['filter_search']);

			$query->orWhereHas('country', function ($q) use ($filter) {
				$q->like('country_name', $filter['filter_search']);
			});
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('currency_status', $filter['filter_status']);
		}

		return $query;
	}

	/**
	 * Return all currencies
	 *
	 * @return array
	 */
	public function getCurrencies()
	{
		return $this->joinCountryTable()->getAsArray();
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
		return $this->joinCountryTable()->findOrNew($currency_id)->toArray();
	}

	/**
	 * Update the accepted currencies
	 *
	 * @param array $accepted_currencies an indexed array of currency ids
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateAcceptedCurrencies($accepted_currencies)
	{
		$update = $this->where('currency_id', '!=', $this->config->item('currency_id'))
					   ->update(['currency_status' => '0']);

		if (is_array($accepted_currencies)) {
			$update = $this->whereIn('currency_id', $accepted_currencies)
						   ->update(['currency_status' => '1']);
		}

		return $update;
	}

	/**
	 * Auto update rates,
	 * called by before_create trigger
	 *
	 * @return void
	 */
	public function autoUpdateRates()
	{
		if ($this->config->item('auto_update_currency_rates') == '1') {
			$this->updateRates(TRUE);
		}
	}

	/**
	 * Update all currency rates
	 *
	 * @param bool $force_refresh
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateRates($force_refresh = FALSE)
	{
		$currency = $this->getCurrency($this->config->item('currency_id'));

		$queryBuilder = $this->where('currency_id', '!=', $this->config->item('currency_id'));
		if (!$force_refresh) {
			$queryBuilder->where('date_modified', '<', mdate('%Y-%m-%d %H:%i:%s', strtotime('-1 day')));
		}

		if ($result = $queryBuilder->getAsArray()) {
			foreach ($result as $row) {
				if (!empty($currency['currency_code'])) {
					$currencies[] = $currency['currency_code'] . $row['currency_code'];
				} else {
					$currencies[] = $row['currency_code'];
				}
			}

			$yahoo__query = 'select * from yahoo.finance.xchange where pair in ("' . implode(', ', $currencies) . '")';
			$yahoo_query_url = "http://query.yahooapis.com/v1/public/yql?q=" . urlencode($yahoo__query) . "&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $yahoo_query_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			$content = curl_exec($curl);
			curl_close($curl);

			$json = json_decode($content, TRUE);

			if (!empty($json['query']['results']['rate'])) {

				if (!isset($json['query']['results']['rate'][0])) {
					$json['query']['results']['rate'] = [$json['query']['results']['rate']];
				}

				foreach ($json['query']['results']['rate'] as $rate) {
					if (isset($rate['id']) AND isset($rate['Rate'])) {
						$currency_code = substr($rate['id'], 3);

						$this->where('currency_code', $currency_code)
							 ->update(['currency_rate' => (float)$rate['Rate']]);
					}
				}

				$this->where('currency_id', $this->config->item('currency_id'))
					 ->update(['currency_rate' => '1.0000']);

				return TRUE;
			}
		}
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

		$currencyModel = $this->joinCountryTable()->findOrNew($currency_id);

		$save = array_merge([
			'iso_alpha2'  => isset($currencyModel->country->iso_code_2) ? $currencyModel->country->iso_code_2 : '',
			'iso_alpha3'  => isset($currencyModel->country->iso_code_3) ? $currencyModel->country->iso_code_3 : '',
			'iso_numeric' => isset($currencyModel->country->iso_numeric) ? $currencyModel->country->iso_numeric : '',
			'flag'        => isset($currencyModel->country->flag) ? $currencyModel->country->flag : '',
		], $save);

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
}

/* End of file Currencies_model.php */
/* Location: ./system/tastyigniter/models/Currencies_model.php */