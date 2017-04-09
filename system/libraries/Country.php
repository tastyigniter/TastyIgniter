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
 * Country Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\Country.php
 * @link           http://docs.tastyigniter.com
 */
class Country
{

	public function addressFormat($address = [])
	{
		if (!empty($address) AND is_array($address)) {
			if (!empty($address['format'])) {
				$format = $address['format'];
			} else {
				$format = '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{state}' . "\n" . '{country}';
			}

			$find = [
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{state}',
				'{country}',
			];

			$replace = [
				'address_1' => (isset($address['address_1'])) ? $address['address_1'] : '',
				'address_2' => (isset($address['address_2'])) ? $address['address_2'] : '',
				'city'      => (isset($address['city'])) ? $address['city'] : '',
				'postcode'  => (isset($address['postcode'])) ? $address['postcode'] : '',
				'state'     => (isset($address['state'])) ? $address['state'] : '',
				'country'   => (isset($address['country'])) ? $address['country'] : '',
			];

			return str_replace(["\r\n", "\r", "\n"], '<br />', preg_replace(["/\s\s+/", "/\r\r+/", "/\n\n+/"], '<br />', trim(str_replace($find, $replace, $format))));
		}
	}

	public function getCountryNameById($id = null)
	{
		$CI =& get_instance();
		$CI->load->model('Countries_model');

		return $CI->Countries_model->findOrNew($id)->country_name;
	}

	public function getCountryCodeById($id = null, $codeType = 2)
	{
		$CI =& get_instance();
		$CI->load->model('Countries_model');
		$countryModel = $CI->Countries_model->findOrNew($id);

		return $codeType == 2 ? $countryModel->iso_code_2 : $countryModel->iso_code_3;
	}
}
// END Country Class

/* End of file Country.php */
/* Location: ./system/tastyigniter/libraries/Country.php */