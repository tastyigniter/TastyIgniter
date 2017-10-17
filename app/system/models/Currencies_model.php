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
class Currencies_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['filter_search'])) {
			$this->db->like('currency_name', $filter['filter_search']);
			$this->db->or_like('currency_code', $filter['filter_search']);
			$this->db->or_like('country_name', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('currency_status', $filter['filter_status']);
		}

		$this->db->from('currencies');
		$this->db->join('countries', 'countries.country_id = currencies.country_id', 'left');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('currencies');
			$this->db->join('countries', 'countries.country_id = currencies.country_id', 'left');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if ( ! empty($filter['filter_search'])) {
				$this->db->like('currency_name', $filter['filter_search']);
				$this->db->or_like('currency_code', $filter['filter_search']);
				$this->db->or_like('country_name', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('currency_status', $filter['filter_status']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getCurrencies() {
		$this->db->from('currencies');
		$this->db->join('countries', 'countries.country_id = currencies.country_id', 'left');



		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getCurrency($currency_id) {
		$this->db->from('currencies');

		$this->db->where('currency_id', $currency_id);

		$query = $this->db->get();

		if ($this->db->affected_rows() > 0) {
			return $query->row_array();
		}
	}

	public function updateAcceptedCurrencies($accepted_currencies) {
		$this->db->set('currency_status', '0');
		$this->db->where('currency_id !=', $this->config->item('currency_id'));
		$this->db->update('currencies');

		if (is_array($accepted_currencies)) {
			$this->db->set('currency_status', '1');

			$this->db->where_in('currency_id', $accepted_currencies);
			return $this->db->update('currencies');
		}
	}

	public function saveCurrency($currency_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['currency_name'])) {
			$this->db->set('currency_name', $save['currency_name']);
		}

		if (isset($save['currency_code'])) {
			$this->db->set('currency_code', $save['currency_code']);
		}

		if (isset($save['currency_symbol'])) {
			$this->db->set('currency_symbol', $save['currency_symbol']);
		}

		if (isset($save['currency_rate'])) {
			$this->db->set('currency_rate', $save['currency_rate']);
		}

		if (isset($save['symbol_position'])) {
			$this->db->set('symbol_position', $save['symbol_position']);
		}

		if (isset($save['thousand_sign'])) {
			$this->db->set('thousand_sign', $save['thousand_sign']);
		}

		if (isset($save['decimal_sign'])) {
			$this->db->set('decimal_sign', $save['decimal_sign']);
		}

		if (isset($save['decimal_position'])) {
			$this->db->set('decimal_position', $save['decimal_position']);
		}

		if (isset($save['country_id'])) {
			$this->db->set('country_id', $save['country_id']);
		}

		if (isset($save['currency_status']) AND $save['currency_status'] === '1') {
			$this->db->set('currency_status', $save['currency_status']);
		} else {
			$this->db->set('currency_status', '0');
		}

		if (is_numeric($currency_id)) {
			$this->db->where('currency_id', $currency_id);
			$query = $this->db->update('currencies');
		} else {
			$query = $this->db->insert('currencies');
			$currency_id = $this->db->insert_id();

			if ($this->config->item('auto_update_currency_rates') === '1') {
				$this->updateRates(TRUE);
			}

		}

		return ($query === TRUE AND is_numeric($currency_id)) ? $currency_id : FALSE;
	}

	public function updateRates($force_refresh = FALSE) {

		$currency = $this->getCurrency($this->config->item('currency_id'));

		$this->db->from('currencies');
		$this->db->where('currency_id !=', $this->config->item('currency_id'));

		if (!$force_refresh) {
			$this->db->where('date_modified <', mdate('%Y-%m-%d %H:%i:%s', strtotime('-1 day')));
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$currencies[] = !empty($currency['currency_code']) ? $currency['currency_code'].$row['currency_code'] : $row['currency_code'];
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

						$this->db->set('currency_rate', (float) $rate['Rate']);
						$this->db->set('date_modified', mdate('%Y-%m-%d %H:%i:%s', time()));
						$this->db->where('currency_code', $currency_code);
						$this->db->update('currencies');
					}
				}

				$this->db->set('currency_rate', '1.0000');
				$this->db->set('date_modified', mdate('%Y-%m-%d %H:%i:%s', time()));
				$this->db->where('currency_id', $this->config->item('currency_id'));
				$this->db->update('currencies');

				return TRUE;
			}
		}
	}

	public function deleteCurrency($currency_id) {
		if (is_numeric($currency_id)) $currency_id = array($currency_id);

		if ( ! empty($currency_id) AND ctype_digit(implode('', $currency_id))) {
			$this->db->where_in('currency_id', $currency_id);
			$this->db->delete('currencies');

			return $this->db->affected_rows();
		}
	}
}

/* End of file currencies_model.php */
/* Location: ./system/tastyigniter/models/currencies_model.php */