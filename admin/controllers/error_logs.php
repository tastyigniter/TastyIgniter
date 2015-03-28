<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Error_logs extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
	}

	public function index() {

		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'error_logs')) {
  			redirect('permission');
		}

		$this->template->setTitle('Error Logs');
		$this->template->setHeading('Error Logs');
		$this->template->setButton('Clear', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$log_path = IGNITEPATH .'/logs/';

		if ( file_exists($log_path .'logs.php')) {

			$logs = file_get_contents($log_path .'logs.php');
			$remove = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed'); ?".">\n";

			$data['logs'] = str_replace($remove, '', $logs);
		} else {
			$data['logs'] = '';
		}

		//Delete Error Log
		if ($this->input->post() AND $this->_clearLog() === TRUE) {

			redirect('error_logs');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('error_logs', $data);
	}

	public function _clearLog() {
    	if (!$this->user->hasPermissions('modify', 'error_logs')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
    	} else {
			$log_path = IGNITEPATH .'/logs/';

			if (is_readable($log_path .'logs.php')) {
				$log = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed'); ?".">\n\n";

				$this->load->helper('file');
       	 		write_file($log_path .'logs.php', $log);

				$this->alert->set('success', 'Logs Cleared Sucessfully!');
			}
		}

		return TRUE;
	}
}

/* End of file error_logs.php */
/* Location: ./admin/controllers/error_logs.php */