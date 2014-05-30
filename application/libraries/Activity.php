<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity {
	public $ip;
	public $activities = array();
	public $total = 0;
	public $total_customers = 0;
	public $total_guests = 0;
	public $total_robots = 0;
	public $country_code = '';
	protected $geoip;

	public function __construct() {
		$this->CI =& get_instance();

		$this->initialize();
	}

	public function initialize() {
		$this->ip = $this->CI->input->ip_address();
		$this->country_code = $this->_getCountry($this->ip);
		
		$this->local_time = time();
		$time_out = ($this->CI->config->item('activity_timeout') > 120) ? $this->CI->config->item('activity_timeout') : 120; 
		$this->time_out = $this->local_time - $time_out;
		
		$this->activities = $this->_getActivities();

		if (!empty($this->activities) AND is_array($this->activities)) {
			foreach ($this->activities as $key => $value) {
				$this->total++;

				if ($value['customer_id'] > 0) {
					$this->total_customers++;
				}

				if ($value['customer_id'] === 0) {
					$this->total_guests++;
				}

				if ($value['access_type'] === 'robot') {
					$this->total_robots++;
				}
			}
		}

		if ($this->CI->input->valid_ip($this->ip)) {
			$this->_setActivity();
		}
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

	public function activities() {
	  return $this->activities;
	} 

	public function _getActivities() {
		$this->CI->load->database();
		$this->CI->db->from('customers_activity');	
		$query = $this->CI->db->get();
		$activities = array();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $result) {
				$activities[$result['ip_address']] = array(
					'activity_id' 	=> $result['activity_id'],
					'customer_id' 	=> $result['customer_id'],
					'access_type' 	=> $result['access_type'],
					'browser' 		=> $result['browser'],
					'request_uri' 	=> $result['request_uri'],
					'referrer_uri' 	=> $result['referrer_uri'],
					'date_added' 	=> $result['date_added']
				);
			}
		}
		
		return $activities;
	}
	
	public function _setActivity() {
		$this->CI->load->library('user_agent');	    
		
		if ($this->CI->agent->is_mobile()) {
			$access_type = 'mobile';
			$browser = $this->CI->agent->mobile();
		} else if ($this->CI->agent->is_robot()) {
			$access_type = 'robot';
			$browser = $this->CI->agent->robot();
		} else if ($this->CI->agent->is_browser()) {
			$access_type = 'browser';
			$browser = $this->CI->agent->browser();
		}

		if (isset($this->activities[$this->ip])) {
			$this->_updateActivity($this->ip, $access_type, $browser);
		} else {
			$this->_addActivity($this->ip, $access_type, $browser);
		}
	}

	public function _updateActivity($ip, $access_type = '', $browser = '') {
		$cust_info = $this->CI->session->userdata('cust_info');
		$customer_id = (isset($cust_info['customer_id']) AND isset($cust_info['email'])) ? $cust_info['customer_id'] : '0';
		$referrer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$country_code = (!empty($this->country_code)) ? $this->country_code : '0';
		
		if (isset($this->activities[$this->ip]) AND strtotime($this->activities[$ip]['date_added']) <= $this->time_out) {
			$this->CI->db->set('customer_id', $customer_id);
			$this->CI->db->set('access_type', $access_type);
			$this->CI->db->set('browser', $browser);
			$this->CI->db->set('country_code', $country_code);
			$this->CI->db->set('request_uri', current_url());
			$this->CI->db->set('referrer_uri', $referrer);
			$this->CI->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $this->local_time));
			$this->CI->db->where('activity_id', $this->activities[$ip]['activity_id']);
			$this->CI->db->where('ip_address', $ip);
			$this->CI->db->update('customers_activity');
		}
	}

	public function _addActivity($ip, $access_type = '', $browser = '') {
		$cust_info = $this->CI->session->userdata('cust_info');
		$customer_id = (isset($cust_info['customer_id']) AND isset($cust_info['email'])) ? $cust_info['customer_id'] : '0';
		$referrer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$country_code = (!empty($this->country_code)) ? $this->country_code : '0';
		
		if (!isset($this->activities[$this->ip])) {
			$this->CI->db->set('customer_id', $customer_id);
			$this->CI->db->set('access_type', $access_type);
			$this->CI->db->set('browser', $browser);
			$this->CI->db->set('country_code', $country_code);
			$this->CI->db->set('request_uri', current_url());
			$this->CI->db->set('referrer_uri', $referrer);
			$this->CI->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $this->local_time));
			$this->CI->db->set('ip_address', $this->ip);
			$this->CI->db->insert('customers_activity');
		}
	}

	public function _getCountry($ip) {
		if (!defined('GEOIP_DATAFILE')) {
			define('GEOIP_DATAFILE', dirname(__FILE__).'/geoip/GeoIP.dat');
		}

		global $GEOIP_REGION_NAME;
		include(dirname(__FILE__) .'/geoip/geoip.inc');
		require_once(dirname(__FILE__) .'/geoip/geoipregionvars.php');

		if (!isset($this->geoip)) {
			$this->geoip = geoip_open(GEOIP_DATAFILE, GEOIP_STANDARD);
		}

		$this->country_code = geoip_country_code_by_addr($this->geoip, $this->ip);
		
		if (isset($this->geoip)) {
			geoip_close($this->geoip);
		}   
	}
}

// END Activity class

/* End of file Activity.php */
/* Location: ./application/libraries/Activity.php */