<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setting {

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->setConfig();

		if (is_dir(ROOTPATH.'setup') AND file_exists(APPPATH) AND $this->CI->config->item('ti_version') === 'v1.3-beta') {
			$this->CI->alert->danger_now('PLEASE REMEMBER TO COMPLETELY REMOVE THE SETUP FOLDER. <br />You will not be able to proceed beyond this point until the setup folder has been removed. <br />This is a security feature of TastyIgniter!', 'danger');
		}

		if (defined('ENVIRONMENT') AND ENVIRONMENT !== 'production' AND ! $this->CI->input->is_ajax_request()) {
			$this->CI->output->enable_profiler(TRUE);
		}
	}

	public function setSettings() {
		/*if (defined('TI_SETUP') AND TI_SETUP === 'directory_found') {
			$this->session->set_flashdata('alert', '<p class="alert alert-danger">PLEASE REMEMBER TO COMPLETELY REMOVE THE SETUP FOLDER. <br />You will not be able to proceed beyond this point until the setup folder has been removed. <br />This is a security feature of TastyIgniter!');
		}

		//if (defined('TI_SETUP') AND TI_SETUP === 'installed') {
			$this->CI->load->database();
			$this->setConfig();

			if ($this->CI->config->item('permalink') == '1') {
				$this->setPermalinkQuery();
			}

			if (defined('ENVIRONMENT') AND ENVIRONMENT !== 'production' AND ! $this->CI->input->is_ajax_request()) {
				$this->CI->output->enable_profiler(TRUE);
			}
		//}*/
	}

	public function setConfig() {
		if ($this->CI->db->table_exists($this->CI->db->dbprefix('settings'))) {
			$this->CI->db->from('settings');

			$query = $this->CI->db->get();
			$settings = array();

			if ($query->num_rows() > 0) {
				$settings = $query->result_array();
			}

			if ($settings) {
				foreach ($settings as $setting) {

					if (!empty($setting['serialized'])) {
						$this->CI->config->set_item($setting['item'], unserialize($setting['value']));
					} else {
						$this->CI->config->set_item($setting['item'], $setting['value']);
					}
				}
			}

			if ($this->CI->config->item('timezone')) {
				date_default_timezone_set($this->CI->config->item('timezone'));
			}
		}
	}

	public function setMaintainance() {
		$this->CI->load->library('user');

		if ($this->CI->uri->rsegment(1) !== ADMINDIR AND $this->CI->uri->rsegment(1) !== 'maintenance' AND !$this->CI->user->isLogged()) {
			redirect(root_url('maintenance'));
		}
	}

	public function setPermalinkQuery() {
		$this->CI->load->library('permalink');
		$this->CI->permalink->setQuery();
	}
}

// END Setting Class

/* End of file Setting.php */
/* Location: ./system/tastyigniter/libraries/Setting.php */