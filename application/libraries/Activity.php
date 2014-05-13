<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity {
	public $ip;
	public $results = array();
	public $total = 0;
	public $total_customers = 0;
	public $total_guests = 0;
	public $total_robots = 0;

	public function __construct() {
		$this->CI =& get_instance();

		$this->initialize();
	}

	public function initialize() {
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->local_time = time();
		$time_out = ($this->CI->config->item('activity_timeout') > 120) ? $this->CI->config->item('activity_timeout') : 120; 
		$this->time_out = $this->local_time - $time_out;
	}

	public function total() {
	  return $this->total;
	}

	public function totalCustomers() {
		return $this->total_customers;
	}

	public function totalGuests() {
		return $this->total_guests;
	}

	public function totalRobots() {
		return $this->total_robots;
	}

	public function results() {
	  return @$this->results;
	} 

	public function online() {
		$results = $this->_getOnline();
		
		foreach ($results as $key => $value) {
			if (strtotime($value['date_added']) <= $this->time_out) {
				unset($results[$key]);
				$this->deleteExpired($key);
			}
		}
		
		$this->_setOnline($results);
			
	  	if ( ! isset($results[$this->ip])) {
			$this->_updateResult($this->ip);
		}
	}

	public function customer($customer_id = '') {
		$customer_id = ($customer_id === '') ? '0' : $customer_id;
		$referrer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';

		if ($this->CI->agent->is_robot()) {
			$access_type = 'robot';
			$browser = $this->CI->agent->robot();
		} else if ($this->CI->agent->is_mobile()) {
			$access_type = 'mobile';
			$browser = $this->CI->agent->mobile();
		} else if ($this->CI->agent->is_browser()) {
			$access_type = 'browser';
			$browser = $this->CI->agent->browser();
		}

		$this->CI->db->from('customers_activity');	
		$this->CI->db->where('customer_id', $customer_id);
		$this->CI->db->where('ip_address', $this->ip);
		$this->CI->db->where('access_type', $access_type);
		$query = $this->CI->db->get();

		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			if (strtotime($row['date_added']) <= $this->time_out) {
				$this->CI->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $this->local_time));
				$this->CI->db->set('request_uri', current_url());
				$this->CI->db->set('referrer_uri', $referrer);
				$this->CI->db->where('customer_id', $customer_id);
				$this->CI->db->where('ip_address', $this->ip);
				$this->CI->db->where('access_type', $access_type);
				$this->CI->db->update('customers_activity');
			}
		} else {
			$this->CI->db->set('customer_id', $customer_id);
			$this->CI->db->set('ip_address', $this->ip);
			$this->CI->db->set('access_type', $access_type);
			$this->CI->db->set('browser', $browser);
			$this->CI->db->set('request_uri', current_url());
			$this->CI->db->set('referrer_uri', $referrer);
			$this->CI->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $this->local_time));
			$this->CI->db->insert('customers_activity');
		}
	}

	public function _getOnline() {
		$this->CI->load->database();
		$this->CI->db->from('online_activity');	
		$query = $this->CI->db->get();
		$results = array();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $result) {
				$results[$result['ip_address']] = array(
					'customer_id' 	=> $result['customer_id'],
					'access_type' 	=> $result['access_type'],
					'browser' 		=> $result['browser'],
					'request_uri' 	=> $result['request_uri'],
					'referrer_uri' 	=> $result['referrer_uri'],
					'date_added' 	=> $result['date_added']
				);
			}
		}
		
		return $results;
	}
	
	public function _updateResult($ip = '') {
		if ($this->CI->input->valid_ip($ip)) {
			$this->CI->load->library('user_agent');	    
			$cust_info = $this->CI->session->userdata('cust_info');
			$customer_id = (isset($cust_info['customer_id']) AND isset($cust_info['email'])) ? $cust_info['customer_id'] : '0';
			$referrer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
			
			if ($this->CI->agent->is_browser()) {
				$access_type = 'browser';
				$browser = $this->CI->agent->browser();
			} else if ($this->CI->agent->is_mobile()) {
				$access_type = 'mobile';
				$browser = $this->CI->agent->mobile();
			} else if ($this->CI->agent->is_robot()) {
				$access_type = 'robot';
				$browser = $this->CI->agent->robot();
			}

			$this->CI->db->set('ip_address', $ip);
			$this->CI->db->set('customer_id', $customer_id);
			$this->CI->db->set('access_type', $access_type);
			$this->CI->db->set('browser', $browser);
			$this->CI->db->set('request_uri', current_url());
			$this->CI->db->set('referrer_uri', $referrer);
			$this->CI->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $this->local_time));
			$this->CI->db->insert('online_activity');
		}	
	}

	public function _setOnline($results = array()) {
		if (!empty($results) AND is_array($results)) {
			$this->results = $results;
			
			foreach ($this->results as $key => $value) {
				if ($value['customer_id'] > 0) {
					$this->total_customers++;
				}

				if ($value['customer_id'] === 0) {
					$this->total_guests++;
				}

				if ($value['access_type'] === 'robot') {
					$this->total_robots++;
				}

				$this->total++;
			}
		}
	}
	
	public function deleteExpired($ip = '') {
		if ($this->CI->input->valid_ip($ip)) {
			$this->CI->db->where('ip_address', $ip);
			$this->CI->db->delete('online_activity');
		}
	}
}

// END CI_Calendar class

/* End of file Calendar.php */
/* Location: ./application/libraries/Calendar.php */