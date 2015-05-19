<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setting {

	public function __construct() {
		$this->CI =& get_instance();

		if (is_dir(ROOTPATH.'setup') AND file_exists(APPPATH) AND $this->CI->config->item('ti_version') === 'v1.3-beta') {
			$this->CI->alert->danger_now('PLEASE REMEMBER TO COMPLETELY REMOVE THE SETUP FOLDER. <br />This is a security feature of TastyIgniter!', 'danger');
		}

		if (defined('ENVIRONMENT') AND ENVIRONMENT !== 'production' AND ! $this->CI->input->is_ajax_request()) {
			$this->CI->output->enable_profiler(TRUE);
		}

        if (APPDIR !== 'setup' AND !$this->CI->config->item('ti_version')) {
            redirect(root_url('setup/'));
        }

        if ($this->CI->config->item('maintenance_mode') === '1') {  													// if customer is not logged in redirect to account login page
            $this->setMaintenance();
        }
    }

	public function setMaintenance() {
		if ($this->CI->config->item('maintenance_mode') === '1') {
            $this->CI->load->library('user');
            if (APPDIR === MAINDIR
                AND $this->CI->uri->rsegment(1) !== 'maintenance'
                AND !$this->CI->user->isLogged()) {

                show_error($this->CI->config->item('maintenance_message'), '503', 'Maintenance Enabled');
		    }
        }
    }
}

// END Setting Class

/* End of file Setting.php */
/* Location: ./system/tastyigniter/libraries/Setting.php */