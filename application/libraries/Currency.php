<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency {
	private $currency_symbol;
	private $currency_code;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		
		if ($this->CI->config->item('currency_id')) {
			$this->CI->db->from('currencies');	
			$this->CI->db->where('currency_id', $this->CI->config->item('currency_id'));
			$query = $this->CI->db->get();

			if ($query->num_rows() === 1) {
			
				$row = $query->row_array();
								
				$this->currency_symbol 	= $row['currency_symbol'];
				$this->currency_code 	= $row['currency_code'];
			
			}

		} else {
			$this->currency_symbol = '£';
			$this->currency_code = 'GBP';
		}
	}
	
	public function getCurrencyCode() {
		return $this->currency_code;
	}
	
	public function format($num) {
		if (empty($num)) {
			$num = '0';	
		}

		return $this->currency_symbol . number_format($num, 2, '.', ',');	
	}
}

// END Currency Class

/* End of file Currency.php */
/* Location: ./application/libraries/Currency.php */