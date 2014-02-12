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
								
				$this->CI->currency_symbol 	= $row['currency_symbol'];
				$this->CI->currency_code 	= $row['currency_code'];
			
			}

		} else {
			
			$this->CI->currency_symbol = '';
			$this->CI->currency_code = '';
		
		}
	}
	
	public function getCurrencyCode() {
		return $this->CI->currency_code;
	}
	
	public function format($num) {
		if (empty($num)) {
			$num = '0';	
		}

		return $this->CI->currency_symbol . number_format($num, 2, '.', ',');	
	}
}