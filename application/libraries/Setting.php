<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting {

	private $default_location;
	
	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('Settings_model');
				
      	$settings = $this->CI->Settings_model->getAll();      
		
		foreach ($settings as $setting) {
			
	        if (!empty($setting['serialized'])) {
	        	$this->CI->config->set_item($setting['key'], unserialize($setting['value']));
			} else {
	        	$this->CI->config->set_item($setting['key'], $setting['value']);
			}
		}
	}
}