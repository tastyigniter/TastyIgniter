<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country {

	public function addressFormat($address = array()) {

		if (!empty($address['format'])) {
			$format = $address['format'];
		} else {
			$format = '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{state}' . "\n" . '{country}';
		}
	
		$find = array(
			'{address_1}',
			'{address_2}',
			'{city}',
			'{postcode}',
			'{state}',
			'{country}'
		);

		$replace = array(
			'address_1' 	=> $address['address_1'],
			'address_2' 	=> $address['address_2'],
			'city'      	=> $address['city'],
			'postcode'  	=> $address['postcode'],
			'state'     	=> $address['state'],
			'country' 		=> $address['country']  
		);

		return str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
	}
}
// END Country Class

/* End of file Country.php */
/* Location: ./application/libraries/Country.php */