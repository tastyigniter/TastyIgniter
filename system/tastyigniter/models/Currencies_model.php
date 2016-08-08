<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Currencies Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Currencies_model.php
 * @link           http://docs.tastyigniter.com
 */
class Currencies_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'currencies';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'currency_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('updated' => 'date_modified');

	/**
	 * @var string[] The names of callback methods which
	 * will be called after the insert method.
	 */
	protected $after_create = array('autoUpdateRates');

	protected $belongs_to = array(
		'countries' => 'Countries_model',
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		$this->with('countries');

		return parent::getCount($filter);
	}

	/**
	 * List all currencies matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		$this->with('countries');

		return parent::getList($filter);
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('currency_name', $filter['filter_search']);
			$this->or_like('currency_code', $filter['filter_search']);
			$this->or_like('country_name', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('currency_status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all currencies
	 *
	 * @return array
	 */
	public function getCurrencies() {
		return $this->with('countries')->find_all();
	}

	/**
	 * Find a single currency by currency_id
	 *
	 * @param int $currency_id
	 *
	 * @return array
	 */
	public function getCurrency($currency_id) {
		return $this->with('countries')->find($currency_id);
	}

	/**
	 * Update the accepted currencies
	 *
	 * @param array $accepted_currencies an indexed array of currency ids
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function updateAcceptedCurrencies($accepted_currencies) {
		$update = $this->update(array(
			'currency_id !=' => $this->config->item('currency_id')), array(
				'currency_status' => '0',
			)
		);

		if (is_array($accepted_currencies)) {
			$update = $this->update(array('currency_id', $accepted_currencies), array(
					'currency_status' => '1',
				)
			);
		}

		return $update;
	}

	/**
	 * Auto update rates,
	 * called by before_create trigger
	 *
	 * @return void
	 */
	public function autoUpdateRates() {
		if ($this->config->item('auto_update_currency_rates') === '1') {
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
	public function updateRates($force_refresh = FALSE) {

		$currency = $this->find($this->config->item('currency_id'));

		$this->where('currency_id !=', $this->config->item('currency_id'));
		if (!$force_refresh) {
			$this->where('date_modified <', mdate('%Y-%m-%d %H:%i:%s', strtotime('-1 day')));
		}

		if ($result = $this->find_all()) {
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
					$json['query']['results']['rate'] = array($json['query']['results']['rate']);
				}

				foreach ($json['query']['results']['rate'] as $rate) {
					if (isset($rate['id']) AND isset($rate['Rate'])) {
						$currency_code = substr($rate['id'], 3);

						$this->update(array('currency_code' => $currency_code), array('currency_rate' => (float)$rate['Rate']));
					}
				}

				$this->update($this->config->item('currency_id'), array('currency_rate' => '1.0000'));

				return TRUE;
			}
		}
	}

	/**
	 * Create a new or update existing currency
	 *
	 * @param int   $currency_id
	 * @param array $save
	 *
	 * @return bool|int The $currency_id of the affected row, or FALSE on failure
	 */
	public function saveCurrency($currency_id, $save = array()) {
		if (empty($save)) return FALSE;

		return $this->skip_validation(TRUE)->save($save, $currency_id);
	}

	/**
	 * Delete a single or multiple currency by currency_id
	 *
	 * @param string|array $currency_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteCurrency($currency_id) {
		if (is_numeric($currency_id)) $currency_id = array($currency_id);

		if (!empty($currency_id) AND ctype_digit(implode('', $currency_id))) {
			return $this->delete('currency_id', $currency_id);
		}
	}
}

/* End of file Currencies_model.php */
/* Location: ./system/tastyigniter/models/Currencies_model.php */