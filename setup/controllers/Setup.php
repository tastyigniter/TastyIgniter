<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setup extends Base_Controller {

    protected $setup_step;
    protected $setup_timeout = '120';
    protected $setup_proceed = FALSE;

    public function __construct() {
		parent::__construct();

        $this->load->model('Setup_model');

        $this->setup_step = $this->uri->segment(1);

        if ($this->setup_step !== 'success' AND $this->installer->isInstalled()) {
            redirect('success');
        }

        if ($this->session->tempdata('setup_step') === $this->setup_step) {
            $this->setup_proceed = TRUE;
        }
    }

	public function index() {
        $this->license();
    }

    public function license() {
        $data['text_heading'] 		= $this->lang->line('text_license_heading');
        $data['text_sub_heading'] 	= $this->lang->line('text_license_sub_heading');
        $data['setup_step'] 	    = $this->setup_step;

        if ($this->input->post('licence_agreed')) {
            $this->session->set_tempdata('setup_step', 'requirements', $this->setup_timeout);
            redirect('requirements');
        }

        if ( ! file_exists(VIEWPATH .'/license.php')) {
            show_404();
        } else {
            $this->load->view('header', $data);
            $this->load->view('license', $data);
            $this->load->view('footer', $data);
        }

    }

	public function requirements() {
        if ($this->setup_proceed === FALSE) {
            $this->alert->set('danger', $this->lang->line('alert_license_error'));
            redirect('license');
        }

        $data['text_heading'] 		    = $this->lang->line('text_requirement_heading');
        $data['text_sub_heading'] 		= $this->lang->line('text_requirement_sub_heading');
        $data['installed_php_version']  = $this->installer->installed_php_version;
        $data['required_php_version']   = $this->installer->required_php_version;
        $data['requirements']           = $this->installer->checkRequirements();
        $data['writables']              = $this->installer->checkWritable();
        $data['setup_step'] 	    = $this->setup_step;

        $data['back_url'] 		        = site_url('license');

        if ($this->input->post('requirements')) {
            if (!in_array(FALSE, $data['requirements'], TRUE) AND !in_array(FALSE, $data['writables'], TRUE)) {
                $this->session->set_tempdata('setup_step', 'database', $this->setup_timeout);
                redirect('database');
            }

            $this->alert->set('danger_now', $this->lang->line('alert_requirement_error'));
        }

        if ( ! file_exists(VIEWPATH .'/requirements.php')) {
            show_404();
        } else {
            $this->load->view('header', $data);
            $this->load->view('requirements', $data);
            $this->load->view('footer', $data);
        }
	}

	public function database() {
        if ($this->setup_proceed === FALSE) {
            $this->alert->set('danger', $this->lang->line('alert_requirement_error'));
            redirect('requirements');
        }

        if ($this->installer->db_exists === TRUE OR $this->_validateDatabase() === TRUE) {
            $this->session->set_tempdata('setup_step', 'settings', $this->setup_timeout);
            redirect('settings');
        }

        $data['text_heading'] 		= $this->lang->line('text_database_heading');
        $data['text_sub_heading'] 	= $this->lang->line('text_database_sub_heading');
        $data['setup_step'] 	    = $this->setup_step;
        $data['back_url'] 		    = site_url('requirements');

        foreach (array('database', 'hostname', 'username', 'password', 'dbprefix') as $item) {
            if ($this->input->post($item)) {
                $data[$item] = $this->input->post($item);
            } else if (isset($this->db->{$item})) {
                $data[$item] = $this->db->{$item};
            } else {
                $data[$item] = '';
            }
        }

        $this->load->helper('string');
        $data['dbprefix'] = strtolower(random_string('alnum', '9').'_');

        if ( ! file_exists(VIEWPATH .'/database.php')) {
            show_404();
        } else {
            $this->load->view('header', $data);
            $this->load->view('database', $data);
            $this->load->view('footer', $data);
        }
	}

	public function settings() {
        if ($this->installer->db_exists === FALSE OR $this->setup_proceed === FALSE) {
            $this->alert->set('danger', $this->lang->line('alert_database_error'));
            redirect('database');
        }

        if ($this->installer->checkSettings() === TRUE OR $this->_validateSettings() === TRUE) {
            $this->session->set_tempdata('setup_step', 'success', $this->setup_timeout);
            redirect('success');
        }

        $data['text_heading'] 		= $this->lang->line('text_settings_heading');
        $data['text_sub_heading'] 	= $this->lang->line('text_settings_sub_heading');
        $data['setup_step'] 	    = $this->setup_step;
        $data['back_url'] 		    = site_url('database');

        foreach (array('site_name', 'site_email', 'staff_name', 'username', 'password') as $item) {
            if ($this->input->post($item)) {
                $data[$item] = $this->input->post($item);
            } else if ($this->config->item($item)) {
                $data[$item] = $this->config->item($item);
            } else {
                $data[$item] = '';
            }
        }

        if ( !file_exists(VIEWPATH .'/settings.php')) {
            show_404();
        } else {
            $this->load->view('header', $data);
            $this->load->view('settings', $data);
            $this->load->view('footer', $data);
        }
    }

	public function success() {
        if ( ! file_exists(VIEWPATH .'/success.php')) {
            show_404();
        }

        if ( ! ($this->setup_proceed === TRUE OR $this->installer->checkSettings() === TRUE)) {
            redirect('requirements');
        }

        $data['text_heading'] 		= $this->lang->line('text_success_heading');
        $data['text_sub_heading'] 	= $this->lang->line('text_success_sub_heading');
        $data['setup_step'] 	    = $this->setup_step;
        $data['admin_url'] 	        = admin_url();
        $data['site_url'] 	        = root_url();

        $this->load->library('user');
        $this->user->logout();

        $this->load->view('header', $data);
        $this->load->view('success', $data);
        $this->load->view('footer', $data);
    }

    private function _validateDatabase() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('database', 'lang:label_database', 'xss_clean|trim|required');
            $this->form_validation->set_rules('hostname', 'lang:label_hostname', 'xss_clean|trim|required');
            $this->form_validation->set_rules('username', 'lang:label_username', 'xss_clean|trim|required');
            $this->form_validation->set_rules('password', 'lang:label_password', 'xss_clean|trim|required');
            $this->form_validation->set_rules('dbprefix', 'lang:label_prefix', 'xss_clean|trim|required');

            if ($this->form_validation->run() === TRUE) {
                if ($this->installer->testDbConnection() === FALSE) {
                    $this->alert->set('danger_now', $this->lang->line('alert_database_error'));
                } else if ($this->installer->writeDbConfiguration() === TRUE) {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    private function _validateSettings() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('site_name', 'lang:label_site_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
            $this->form_validation->set_rules('site_email', 'lang:label_site_email', 'xss_clean|trim|required|valid_email');
            $this->form_validation->set_rules('staff_name', 'lang:label_staff_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
            $this->form_validation->set_rules('username', 'lang:label_admin_username', 'xss_clean|trim|required|min_length[2]|max_length[32]');
            $this->form_validation->set_rules('password', 'lang:label_admin_password', 'xss_clean|trim|required|min_length[6]|max_length[128]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'lang:label_confirm_password', 'xss_clean|trim|required');

            if ($this->form_validation->run() === TRUE) {

                if ($this->installer->setup() === FALSE) {
                    $this->alert->set('danger_now', $this->lang->line('alert_settings_error'));
                } else {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }
}

/* End of file Setup.php */
/* Location: ./setup/controllers/Setup.php */
