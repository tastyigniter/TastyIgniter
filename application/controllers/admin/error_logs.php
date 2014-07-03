<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Error_logs extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/error_logs')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Error Logs');
		$this->template->setHeading('Error Logs');
		$this->template->setButton('Clear', array('class' => 'btn btn-default', 'onclick' => '$(\'#list-form\').submit();'));
		
		if ($this->config->item('log_path') === '') {
			$log_path = APPPATH .'/logs/';
		} else {
			$log_path = $this->config->item('log_path');		
		}
			
		if ( file_exists($log_path .'logs.php')) {

			$logs = file_get_contents($log_path .'logs.php');
			$remove = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed'); ?".">\n";
	
			$data['logs'] = str_replace($remove, '', $logs);
		} else { 
			$data['logs'] = '';
		}
				
		//Delete Error Log
		if ($this->input->post() AND $this->_clearLog() === TRUE) {
				
			redirect(ADMIN_URI.'/error_logs');
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'error_logs.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'error_logs', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'error_logs', $data);
		}
	}

	public function _clearLog() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/error_logs')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
    	} else { 
			if ($this->config->item('log_path') === '') {
				$log_path = APPPATH .'/logs/';
			} else {
				$log_path = $this->config->item('log_path');		
			}
			
			if (is_readable($log_path .'logs.php')) {
				$log = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed'); ?".">\n\n";

				$this->load->helper('file');
       	 		write_file($log_path .'logs.php', $log);

				$this->session->set_flashdata('alert', '<p class="alert-success">Logs Cleared Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}
}

/* End of file error_logs.php */
/* Location: ./application/controllers/admin/error_logs.php */