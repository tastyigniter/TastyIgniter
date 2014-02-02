<?php
class Error_logs extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists(APPPATH .'/views/admin/error_logs.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

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
		$data['sub_menu_update'] 	= 'Clear';
		
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
		if ($this->input->post('logs') && $this->_clearLog() === TRUE) {
				
			redirect('admin/error_logs');
		}

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/error_logs', $data);
		$this->load->view('admin/footer');
	}

	public function _clearLog() {
    	if (!$this->user->hasPermissions('modify', 'admin/error_logs')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			//$this->form_validation->set_rules('logs', '', 'trim|htmlspecialchars|prep_for_form');

			if ($this->config->item('log_path') === '') {
				$log_path = 'application/logs/';
			} else {
				$log_path = $this->config->item('log_path');		
			}
			
			if (is_readable($log_path .'logs.php')) {
				unlink($log_path .'logs.php');

				$this->session->set_flashdata('alert', '<p class="success">Logs Cleared Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}
