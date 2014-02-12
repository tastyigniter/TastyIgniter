<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting {
	
	public function __construct() {
		$this->CI =& get_instance();
		
		if ($this->checkSetupFolder() === TRUE) {
			if ($this->CI->uri->segment(1) !== 'setup') {
				redirect('setup');
			}
		} else {
			$this->setConfig();
		}

		if ( ! $this->CI->input->is_ajax_request()) {
			$this->CI->output->enable_profiler(TRUE);
		}
	}
	
	public function setConfig() {
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
	}
	
	public function checkSetupFolder() {
		if (file_exists(APPPATH .'/extensions/setup/')) {
			return TRUE;
		}	

		if ($this->CI->config->item('ti_setup') !== 'success') {
			return TRUE;		
		}
		
		return FALSE;
	}
}