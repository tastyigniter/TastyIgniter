<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Error_logs extends Admin_Controller {

	public function index() {
        $this->lang->load('error_logs');

        $this->user->restrict('Admin.ErrorLogs.Access');

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('text_clear'), array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$log_path = $this->config->item('log_path');

		if ( file_exists($log_path .'logs.php')) {

			$logs = file_get_contents($log_path .'logs.php');
			$remove = "<"."?php defined('BASEPATH') OR exit('No direct script access allowed'); ?".">\n";

			$data['logs'] = str_replace($remove, '', $logs);
		} else {
			$data['logs'] = '';
		}

		//Delete Error Log
		if ($this->input->post() AND $this->_clearLog() === TRUE) {

			redirect('error_logs');
		}

		$this->template->render('error_logs', $data);
	}

	private function _clearLog() {
        $this->user->restrict('Admin.ErrorLogs.Delete');

        $log_path = IGNITEPATH .'/logs/';

        if (is_readable($log_path .'logs.php')) {
			$log = "<"."?php defined('BASEPATH') OR exit('No direct script access allowed'); ?".">\n";

            $this->load->helper('file');
            write_file($log_path .'logs.php', $log);

            $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Logs Cleared '));
        }

		return TRUE;
	}
}

/* End of file error_logs.php */
/* Location: ./admin/controllers/error_logs.php */