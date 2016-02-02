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
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer_online Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Customer_online.php
 * @link           http://docs.tastyigniter.com
 */
class Customer_online {

    public $auto_track = TRUE;
    protected $geoip;

    public function __construct() {
		$this->CI =& get_instance();

		$this->initialize();
	}

	public function initialize() {
        if ($this->auto_track === TRUE) {
            $this->track();
        }
	}

    public function track() {
        if (!$this->CI->input->valid_ip($this->CI->input->ip_address())) {
            return;
        }

        $this->CI->load->library('customer');
        $user_agent = $this->getUserAgent();

        $input_data = array();
        $input_data['ip_address']       = $this->CI->input->ip_address();
        $input_data['customer_id']      = $this->CI->customer->isLogged() ? $this->CI->customer->getId() : '0';
        $input_data['access_type']      = $user_agent['type'];
        $input_data['browser']          = $user_agent['browser'];
        $input_data['country_code']     = $this->getCountry();
        $input_data['request_uri']      = str_replace(site_url(), '', current_url());
        $input_data['referrer_uri']     = str_replace(site_url(), '', $this->CI->agent->referrer());
        $input_data['date_added']       = mdate('%Y-%m-%d %H:%i:%s', time());
        $input_data['user_agent']       = $user_agent['string'];

        $this->_saveActivity($input_data);
    }

    private function getTimeout() {
        return ($this->CI->config->item('customer_online_time_out') > 120) ? $this->CI->config->item('customer_online_time_out') : 120;
    }

    public function getArchiveTimeout() {
        $customer_online_archive_time_out = ($this->CI->config->item('customer_online_archive_time_out') > 0) ? $this->CI->config->item('customer_online_archive_time_out') : 0;
        return $archive_time_out = 86400 * ($customer_online_archive_time_out * 30);
    }

    public function getUserAgent() {
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
        } else {
            $user_agent['type'] = $user_agent['browser'] = '';
        }

        $user_agent['string'] = $this->CI->agent->agent_string();
        return $user_agent;
    }

    public function getLastOnline($ip) {
        $this->CI->load->model('Customer_online_model');

		if ($activity = $this->CI->Customer_online_model->getLastOnline($ip)) {
            $last_activities = array(
                'activity_id' 	=> $activity['activity_id'],
                'customer_id' 	=> $activity['customer_id'],
                'access_type' 	=> $activity['access_type'],
                'browser' 		=> $activity['browser'],
                'user_agent' 	=> $activity['user_agent'],
                'request_uri' 	=> $activity['request_uri'],
                'referrer_uri' 	=> $activity['referrer_uri'],
                'date_added' 	=> $activity['date_added']
            );
		}

		return $last_activities;
	}

	private function _saveActivity($input_data = array()) {
        $save = TRUE;

        is_array($input_data) OR $input_data = array();

		!empty($input_data['customer_id']) OR $input_data['customer_id'] = '0';

        if ($last_online = $this->getLastOnline($input_data['ip_address'])) {
            if ((time() - strtotime($last_online['date_added'])) <= $this->getTimeout()) {
                $save = FALSE;
            }
        }

        if ($save === TRUE) {
            return $this->CI->db->insert('customers_online', $input_data);
        }
    }

	public function getCountry() {
		if (!defined('GEOIP_DATAFILE')) {
			define('GEOIP_DATAFILE', dirname(__FILE__).'/geoip/GeoIP.dat');
		}

		global $GEOIP_REGION_NAME;
		include(dirname(__FILE__) .'/geoip/geoip.inc');
		require_once(dirname(__FILE__) .'/geoip/geoipregionvars.php');

		if (!isset($this->geoip)) {
			$this->geoip = geoip_open(GEOIP_DATAFILE, GEOIP_STANDARD);
		}

		$country_code = geoip_country_code_by_addr($this->geoip, $this->CI->input->ip_address());

		if (isset($this->geoip)) {
			geoip_close($this->geoip);
		}

        return (!empty($country_code)) ? $country_code : '0';
	}
}

// END Customer_online class

/* End of file Customer_online.php */
/* Location: ./system/tastyigniter/libraries/Customer_online.php */