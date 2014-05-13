<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting {
	
	public function __construct() {
		$this->CI =& get_instance();

		if (file_exists(APPPATH .'/extensions/setup/')) {
			if ($this->CI->uri->segment(1) !== 'setup') {
				redirect('setup');
			}
		} else {
			$this->setConfig();
		}
		
		$this->setMaintainance();

		if (defined('ENVIRONMENT') AND ENVIRONMENT !== 'production' AND ! $this->CI->input->is_ajax_request()) {
			$this->CI->output->enable_profiler(TRUE);
		}
	}
	
	public function setConfig() {
		$this->CI->load->database();
		$this->CI->load->model('Settings_model');
				
      	$settings = $this->CI->Settings_model->getAll();      
		
		if ($settings) {
			foreach ($settings as $setting) {
		
				if (!empty($setting['serialized'])) {
					$this->CI->config->set_item($setting['key'], unserialize($setting['value']));
				} else {
					$this->CI->config->set_item($setting['key'], $setting['value']);
				}
			}	
		}
		
		if ($this->CI->config->item('timezone')) {
			date_default_timezone_set($this->CI->config->item('timezone'));
		}
		
		if ($this->CI->config->item('index_file_url') === '1') {
			$this->CI->config->set_item('index_page', '');
		}
		
		if ($this->CI->config->item('cache_mode') == '1') {
			$this->CI->output->cache($this->CI->config->item('cache_time'));
		}
	}

	public function setMaintainance() {
		$this->CI->load->library('user');
	
		if (!empty($this->CI->config->item('maintenance_mode')) AND ($this->CI->config->item('maintenance_mode') === '1') AND !$this->CI->user->isLogged()) {  													// if customer is not logged in redirect to account login page
			if ($this->CI->uri->segment(1) !== 'admin' AND $this->CI->uri->segment(1) !== 'maintenance') {		
				redirect('main/maintenance');
			}
		}
	}
}

// END Setting Class

/* End of file Setting.php */
/* Location: ./application/libraries/Setting.php */