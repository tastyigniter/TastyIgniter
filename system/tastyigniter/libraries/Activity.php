<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Activity {
	public $ip;
	public $activities = array();
	public $total = 0;
	public $total_customers = 0;
	public $total_guests = 0;
	public $total_robots = 0;
	public $country_code = '';
    public $local_time;
    public $online_time_out;
    public $archive_time_out;
    protected $geoip;

	public function __construct() {
		$this->CI =& get_instance();

		$this->initialize();
	}

	public function initialize() {
		$this->ip = $this->CI->input->ip_address();
		$this->country_code = $this->_getCountry($this->ip);

		$this->local_time = time();
		$this->online_time_out = $this->_getTimeout();

		$this->archive_time_out = $this->_getArchiveTimeout();

		$this->activities = $this->_getActivities();

		if (!empty($this->activities) AND is_array($this->activities)) {
			foreach ($this->activities as $key => $activity) {
				$this->total++;

				if ($activity['customer_id'] > 0) {
					$this->total_customers++;
				} else {
					$this->total_guests++;
				}

				if ($activity['access_type'] === 'robot') {
					$this->total_robots++;
				}

				//$this->_deleteActivityArchive($key);
			}
		}

		if ($this->CI->input->valid_ip($this->ip)) {
			$this->_saveActivity();
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

    public function _getTimeout() {
        $online_time_out = ($this->CI->config->item('activity_online_time_out') > 120) ? $this->CI->config->item('activity_online_time_out') : 120;
        return $this->local_time - $online_time_out;
    }

    public function _getArchiveTimeout() {
        $activity_archive_time_out = ($this->CI->config->item('activity_archive_time_out') > 0) ? $this->CI->config->item('activity_archive_time_out') : 0;
        $archive_time_out = 86400 * ($activity_archive_time_out * 30);
        return $this->local_time - $archive_time_out;
    }

    public function _getUserAgent() {
        $this->CI->load->library('user_agent');
        $user_agent = array();

        if ($this->CI->agent->is_mobile()) {
            $user_agent['type'] = 'mobile';
            $user_agent['browser'] = $this->CI->agent->mobile();
        } else if ($this->CI->agent->is_robot()) {
            $user_agent['type'] = 'robot';
            $user_agent['browser'] = $this->CI->agent->robot();
        } else if ($this->CI->agent->is_browser()) {
            $user_agent['type'] = 'browser';
            $user_agent['browser'] = $this->CI->agent->browser();
        }

        return $user_agent;
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
					'page_views' 	=> $result['page_views'],
					'request_uri' 	=> $result['request_uri'],
					'referrer_uri' 	=> $result['referrer_uri'],
					'date_added' 	=> $result['date_added']
				);
			}
		}

		return $activities;
	}

	public function _saveActivity() {
        $user_agent = $this->_getUserAgent();

		if (isset($this->activities[$this->ip])) {
			$this->_updateActivity($this->ip, $user_agent);
		} else {
			$this->_addActivity($this->ip, $user_agent);
		}
	}

	public function _updateActivity($ip, $user_agent = array()) {
		$cust_info = $this->CI->session->userdata('cust_info');
		$customer_id = (isset($cust_info['customer_id']) AND isset($cust_info['email'])) ? $cust_info['customer_id'] : '0';
		$referrer = (isset($_SERVER['HTTP_REFERER'])) ? str_replace(site_url(), '', $_SERVER['HTTP_REFERER']) : '';
		$country_code = (!empty($this->country_code)) ? $this->country_code : '0';

		//if (isset($this->activities[$this->ip]) AND strtotime($this->activities[$ip]['date_added']) <= $this->time_out) {
		if (isset($this->activities[$this->ip])) {
			$page_views = ($this->activities[$ip]['page_views'] > 0) ? $this->activities[$ip]['page_views'] : '1';

            $this->CI->db->set('customer_id', $customer_id);
			$this->CI->db->set('access_type', $user_agent['type']);
			$this->CI->db->set('browser', $user_agent['browser']);
			$this->CI->db->set('page_views', $page_views + 1);
			$this->CI->db->set('country_code', $country_code);
			$this->CI->db->set('request_uri', uri_string());
			$this->CI->db->set('referrer_uri', $referrer);
			$this->CI->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $this->local_time));
			$this->CI->db->where('activity_id', $this->activities[$ip]['activity_id']);
			$this->CI->db->where('ip_address', $ip);
			$this->CI->db->update('customers_activity');
		}
	}

	public function _addActivity($ip, $user_agent = array()) {
		$cust_info = $this->CI->session->userdata('cust_info');
		$customer_id = (isset($cust_info['customer_id']) AND isset($cust_info['email'])) ? $cust_info['customer_id'] : '0';
        $referrer = (isset($_SERVER['HTTP_REFERER'])) ? str_replace(site_url(), '', $_SERVER['HTTP_REFERER']) : '';
		$country_code = (!empty($this->country_code)) ? $this->country_code : '0';

		if (!isset($this->activities[$this->ip])) {
			$this->CI->db->set('customer_id', $customer_id);
			$this->CI->db->set('access_type', $user_agent['type']);
			$this->CI->db->set('browser', $user_agent['browser']);
			$this->CI->db->set('page_views', '1');
			$this->CI->db->set('country_code', $country_code);
			$this->CI->db->set('request_uri', uri_string());
			$this->CI->db->set('referrer_uri', $referrer);
			$this->CI->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $this->local_time));
			$this->CI->db->set('ip_address', $this->ip);
			$this->CI->db->insert('customers_activity');
		}
	}

	public function _deleteActivityArchive($ip) {
        if ($this->CI->config->item('activity_archive_time_out') > 0 AND isset($this->activities[$this->ip])) {

            if (strtotime($this->activities[$ip]['date_added']) <= $this->archive_time_out) {
                $this->CI->db->where('activity_id', $this->activities[$ip]['activity_id']);
                $this->CI->db->where('ip_address', $ip);
                $this->CI->db->delete('customers_activity');
                unset($this->activities[$this->ip]);
            }
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
/* Location: ./system/tastyigniter/libraries/Activity.php */