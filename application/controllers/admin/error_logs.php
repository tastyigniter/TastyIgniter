<?php
class Error_logs extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/error_logs')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Error Logs';
		$data['sub_menu_delete'] 	= 'Clear';
		
		if ($this->config->item('log_path') === '') {
			$log_path = 'application/logs/';
		} else {
			$log_path = $this->config->item('log_path');		
		}
			
		if ( file_exists($log_path .'logs.php')) {

			$logs = file_get_contents($log_path .'logs.php');
			$remove = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n";
	
			$data['logs'] = str_replace($remove, '', $logs);
		} else { 
			$data['logs'] = '';
		}
				
		//Delete Error Log
		if ($this->input->post() && $this->_clearLog() === TRUE) {
				
			redirect('admin/error_logs');
		}

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/error_logs', $data);
	}

	public function _clearLog() {
    	if (!$this->user->hasPermissions('modify', 'admin/error_logs')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			//$this->form_validation->set_rules('logs', '', 'trim|htmlspecialchars|prep_for_form');

			if ($this->config->item('log_path') === '') {
				$log_path = APPPATH .'/logs/';
			} else {
				$log_path = $this->config->item('log_path');		
			}
			
			if (is_readable($log_path .'logs.php')) {
				$log = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";

				$this->load->helper('file');
       	 		write_file($log_path .'logs.php', $log);

				$this->session->set_flashdata('alert', '<p class="success">Logs Cleared Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}
}
