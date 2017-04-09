<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Currency Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\Currency.php
 * @link           http://docs.tastyigniter.com
 */
class Currency
{

	private $currency_id;
	private $currencies = [];

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();

		$this->CI->db->from('currencies');
		$query = $this->CI->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$this->currencies[$row['currency_id']] = [
					'currency_id'      => $row['currency_id'],
					'country_id'       => $row['country_id'],
					'currency_code'    => $row['currency_code'],
					'currency_name'    => $row['currency_name'],
					'currency_symbol'  => $row['currency_symbol'],
					'symbol_position'  => $row['symbol_position'],
					'thousand_sign'    => $row['thousand_sign'],
					'decimal_sign'     => $row['decimal_sign'],
					'decimal_position' => $row['decimal_position'],
					'flag'             => $row['flag'],
					'currency_status'  => $row['currency_status'],
				];
			}
		}

		$this->currency_id = $this->CI->config->item('currency_id');
	}

	public function getCurrencyCode()
	{
		return (!isset($this->currencies[$this->currency_id]['currency_code'])) ? 'GBP' : $this->currencies[$this->currency_id]['currency_code'];
	}

	public function format($number, $currency = '', $format = TRUE)
	{
		$currency = empty($currency) ? $this->currency_id : $currency;

		$currency_symbol = !isset($this->currencies[$currency]['currency_symbol']) ? '&pound;' : $this->currencies[$currency]['currency_symbol'];
		$symbol_position = !isset($this->currencies[$currency]['symbol_position']) ? '0' : $this->currencies[$currency]['symbol_position'];
		$thousand_sign = !isset($this->currencies[$currency]['thousand_sign']) ? ',' : $this->currencies[$currency]['thousand_sign'];
		$decimal_sign = !isset($this->currencies[$currency]['decimal_sign']) ? '.' : $this->currencies[$currency]['decimal_sign'];
		$decimal_position = !isset($this->currencies[$currency]['decimal_position']) ? 2 : (int)$this->currencies[$currency]['decimal_position'];

		$number = !empty($number) ? $number : '0';

		$number = round((float)$number, $decimal_position);

		$string = number_format($number, $decimal_position, $decimal_sign, $thousand_sign);

		if ($format) {
			if ($symbol_position == '1') {
				$string = $string . $currency_symbol;
			} else {
				$string = $currency_symbol . $string;
			}
		}

		return $string;
	}
}

// END Currency Class

/* End of file Currency.php */
/* Location: ./system/tastyigniter/libraries/Currency.php */