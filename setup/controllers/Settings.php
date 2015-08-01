<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Settings extends Base_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Setup_model');

        if ($this->session->tempdata('setup') === 'step_3' OR $this->config->item('ti_version') === TI_VERSION) {
            redirect('success');
        }
    }

    public function index() {
        if ($this->session->tempdata('setup') !== 'step_2') {
            redirect('database');
        }

        $data['heading'] 		= 'TastyIgniter - Setup - Settings';
        $data['sub_heading'] 	= 'Restaurant Settings';
        $data['back_url'] 		= site_url('database');

        if ($this->input->post('site_name')) {
            $data['site_name'] = $this->input->post('site_name');
        } else if ($this->config->item('site_name')) {
            $data['site_name'] = $this->config->item('site_name');
        } else {
            $data['site_name'] = '';
        }

        if ($this->input->post('site_email')) {
            $data['site_email'] = $this->input->post('site_email');
        } else if ($this->config->item('site_email')) {
            $data['site_email'] = $this->config->item('site_email');
        } else {
            $data['site_email'] = '';
        }

        if ($this->input->post('staff_name')) {
            $data['staff_name'] = $this->input->post('staff_name');
        } else {
            $data['staff_name'] = '';
        }

        if ($this->input->post('username')) {
            $data['username'] = $this->input->post('username');
        } else {
            $data['username'] = '';
        }

        if ($this->input->post('password')) {
            $data['password'] = $this->input->post('password');
        } else {
            $data['password'] = '';
        }

        if ($this->input->post() AND $this->_checkSettings() === TRUE) {
            redirect('success');
        }

        if ( !file_exists(VIEWPATH .'/settings.php')) {
            show_404();
        } else {
            $this->load->view('header', $data);
            $this->load->view('settings', $data);
            $this->load->view('footer', $data);
        }
    }

    private function _checkSettings() {
        $this->form_validation->set_rules('site_name', 'Restaurant name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
        $this->form_validation->set_rules('site_email', 'Restaurant email', 'xss_clean|trim|required|valid_email');
        $this->form_validation->set_rules('staff_name', 'Staff name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
        $this->form_validation->set_rules('username', 'Username', 'xss_clean|trim|required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|trim|required|min_length[6]|max_length[128]|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirm password', 'xss_clean|trim|required');

        if ($this->form_validation->run() === TRUE) {
            $add = array(
                'site_name' 	=> $this->input->post('site_name'),
                'site_email' 	=> $this->input->post('site_email'),
                'staff_name' 	=> $this->input->post('staff_name'),
                'username' 		=> $this->input->post('username'),
                'password' 		=> $this->input->post('password')
            );

            $current_version = $this->doMigration();

            if ($this->Setup_model->addUser($add)) {
                $this->session->set_tempdata('setup', 'step_3', 300);
                return TRUE;
            } else {
                $this->alert->danger_now('Error installing user and site settings.');
            }
        }
    }

    private function doMigration() {
        $this->load->library('migration');
        $row = $this->db->select('version')->get('migrations')->row();
        $old_version = !empty($row) ? $row->version : '0';

        if (($current_version = $this->migration->current()) === FALSE) {
            show_error($this->migration->error_string());
        }

        if ($current_version !== FALSE AND $old_version !== $current_version) {
            if ( ! $this->Setup_model->loadInitialSchema()) {
                log_message('info', 'Migration: initial_schema execution failed');
            }
        }

        if ($current_version !== FALSE AND $this->input->post_get('demo_data') === '1') {
            if ( ! $this->Setup_model->loadDemoSchema($this->input->post_get('demo_data'))) {
                log_message('info', 'Migration: demo_schema execution failed');
            }
        }

        return $current_version;
    }
}

/* End of file settings.php */
/* Location: ./setup/controllers/settings.php */
