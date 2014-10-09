<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setting {
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->setSettings();
	}
	
	public function setSettings() {
		if (defined('TI_SETUP') AND TI_SETUP === 'installed') {
			$this->CI->load->database();
			$this->setConfig();

			if ($this->CI->config->item('permalink') == '1') {
				$this->setPermalinkQuery();
			}
		
			if ($this->CI->config->item('maintenance_mode') === '1') {  													// if customer is not logged in redirect to account login page
				$this->setMaintainance();
			}

			if (defined('ENVIRONMENT') AND ENVIRONMENT !== 'production' AND ! $this->CI->input->is_ajax_request()) {
				$this->CI->output->enable_profiler(TRUE);
			}

			if ($this->CI->config->item('timezone')) {
				date_default_timezone_set($this->CI->config->item('timezone'));
			}
		
			if ($this->CI->config->item('cache_mode') == '1') {
				$this->CI->output->cache($this->CI->config->item('cache_time'));
			}
		}
	}
	
	public function setConfig() {
		$this->CI->load->model('Settings_model');
				
      	$settings = $this->CI->Settings_model->getAll();      
		
		if ($settings) {
			foreach ($settings as $setting) {
		
				if (!empty($setting['serialized'])) {
					$this->CI->config->set_item($setting['item'], unserialize($setting['value']));
				} else {
					$this->CI->config->set_item($setting['item'], $setting['value']);
				}
			}	
		}
		
		if ($this->CI->config->item('index_file_url') === '1') {
			$this->CI->config->set_item('index_page', '');
		}
	}
		
	public function setMaintainance() {
		$this->CI->load->library('user');
	
		if ($this->CI->uri->segment(1) !== ADMIN_URI AND $this->CI->uri->segment(1) !== 'maintenance' AND !$this->CI->user->isLogged()) {		
			redirect('main/maintenance');
		}
	}

	public function setPermalinkQuery() {
		$this->CI->load->library('permalink');
		$this->CI->permalink->setQuery();
	}
}

// END Setting Class

/* End of file Setting.php */
/* Location: ./application/libraries/Setting.php */