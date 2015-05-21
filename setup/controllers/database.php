<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Database extends Base_Controller {

    private $db_config_path;

    public function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model('Setup_model');

        if ($this->session->userdata('setup') === 'step_3' OR $this->config->item('ti_version')) {
            redirect('success');
        }

        $this->db_config_path = IGNITEPATH . 'config/database.php';
    }

    public function index() {
        if ($this->session->tempdata('setup') !== 'step_1') {
            $this->alert->set('danger', 'Please check below to make sure all server requirements are provided!');
            redirect('setup');
        }

        $data['heading'] 		= 'TastyIgniter - Setup - Database';
        $data['sub_heading'] 	= 'Database Settings';
        $data['back_url'] 		= site_url('setup');

        if (is_file($this->db_config_path)) {
            include($this->db_config_path);
        }

        $db_data = ( ! isset($db) OR ! is_array($db)) ? array() : $db;
        unset($db);

        if ($this->input->post('db_name')) {
            $data['db_name'] = $this->input->post('db_name');
        } else if (isset($db_data['default']['database'])) {
            $data['db_name'] = $db_data['default']['database'];
        } else {
            $data['db_name'] = '';
        }

        if ($this->input->post('db_host')) {
            $data['db_host'] = $this->input->post('db_host');
        } else if (isset($db_data['default']['hostname'])) {
            $data['db_host'] = $db_data['default']['hostname'];
        } else {
            $data['db_host'] = 'localhost';
        }

        if ($this->input->post('db_user')) {
            $data['db_user'] = $this->input->post('db_user');
        } else if (isset($db_data['default']['username'])) {
            $data['db_user'] = $db_data['default']['username'];
        } else {
            $data['db_user'] = '';
        }

        if ($this->input->post('db_pass')) {
            $data['db_pass'] = $this->input->post('db_pass');
        } else {
            $data['db_pass'] = '';
        }

        if ($this->input->post('db_prefix')) {
            $data['db_prefix'] = $this->input->post('db_prefix');
        } else if (isset($db_data['default']['dbprefix'])) {
            $data['db_prefix'] = $db_data['default']['dbprefix'];
        } else {
            $data['db_prefix'] = 'ti_';
        }

        if ($this->input->post('demo_data')) {
            $data['demo_data'] = $this->input->post('demo_data');
        } else {
            $data['demo_data'] = '';
        }

        if ($this->input->post() AND $this->_checkDatabase() === TRUE) {
            redirect('settings');
        }

        if ( ! file_exists(VIEWPATH .'/database.php')) {
            show_404();
        } else {
            $this->load->view('header', $data);
            $this->load->view('database', $data);
            $this->load->view('footer', $data);
        }
    }

    private function _checkDatabase() {
        $this->form_validation->set_rules('db_name', 'Database Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('db_host', 'Hostname', 'xss_clean|trim|required|callback__handle_connect');
        $this->form_validation->set_rules('db_user', 'Username', 'xss_clean|trim|required');
        $this->form_validation->set_rules('db_pass', 'Password', 'xss_clean|trim|required');
        $this->form_validation->set_rules('db_prefix', 'Prefix', 'xss_clean|trim|required');

        if ($this->form_validation->run() === TRUE) {

            $db_path	= $this->db_config_path;
            $db_user 	= $this->input->post('db_user');
            $db_pass 	= $this->input->post('db_pass');
            $db_host 	= $this->input->post('db_host');
            $db_name	= $this->input->post('db_name');
            $db_prefix	= $this->input->post('db_prefix');

            if ( ! is_writable($db_path)) {
                $this->alert->set('danger', 'Unable to write database file.');
                redirect('setup/database');
            } else {
                if ($fp = @fopen(IGNITEPATH .'config/database.php', FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

                    $db_file = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";

                    $db_file .= "$"."active_group = 'default';\n";
                    $db_file .= "$"."query_builder = TRUE;\n\n";

                    $db_file .= "$"."db['default']['dsn'] = '';\n";
                    $db_file .= "$"."db['default']['hostname'] = '". $db_host ."';\n";
                    $db_file .= "$"."db['default']['username'] = '". $db_user ."';\n";
                    $db_file .= "$"."db['default']['password'] = '". $db_pass ."';\n";
                    $db_file .= "$"."db['default']['database'] = '". $db_name ."';\n";
                    $db_file .= "$"."db['default']['dbdriver'] = 'mysqli';\n";
                    $db_file .= "$"."db['default']['dbprefix'] = '". $db_prefix ."';\n";
                    $db_file .= "$"."db['default']['pconnect'] = TRUE;\n";
                    $db_file .= "$"."db['default']['db_debug'] = TRUE;\n";
                    $db_file .= "$"."db['default']['cache_on'] = FALSE;\n";
                    $db_file .= "$"."db['default']['cachedir'] = '';\n";
                    $db_file .= "$"."db['default']['char_set'] = 'utf8';\n";
                    $db_file .= "$"."db['default']['dbcollat'] = 'utf8_general_ci';\n";
                    $db_file .= "$"."db['default']['swap_pre'] = '';\n";
                    $db_file .= "$"."db['default']['autoinit'] = TRUE;\n";
                    $db_file .= "$"."db['default']['encrypt']  = FALSE;\n";
                    $db_file .= "$"."db['default']['compress'] = FALSE;\n";
                    $db_file .= "$"."db['default']['stricton'] = FALSE;\n";
                    $db_file .= "$"."db['default']['failover'] = array();\n";
                    $db_file .= "$"."db['default']['save_queries'] = TRUE;\n\n";

                    $db_file .= "/* End of file database.php */\n";
                    $db_file .= "/* Location: ./system/tastyigniter/config/database.php */\n";

                    flock($fp, LOCK_EX);
                    fwrite($fp, $db_file);
                    flock($fp, LOCK_UN);
                    fclose($fp);

                    @chmod($db_path, FILE_WRITE_MODE);

                    if ($this->doMigration()) {
                        $this->session->set_tempdata('setup', 'step_2', 300);
                        return TRUE;
                    }
                }
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
            if (!$this->Setup_model->addData()) {
                log_message('info', 'Migration: initial_schema execution failed');
            }
        }

        if ($current_version !== FALSE AND $this->input->post_get('demo_data') === '1') {
            if (!$this->Setup_model->addDemoData($this->input->post_get('demo_data'))) {
                log_message('info', 'Migration: demo_schema execution failed');
            }
        }

        return $current_version;
    }

    public function _handle_connect() {
        $db_user 	= $this->input->post('db_user');
        $db_pass 	= $this->input->post('db_pass');
        $db_host 	= $this->input->post('db_host');
        $db_name	= $this->input->post('db_name');

        $db_check = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        if (mysqli_connect_error()) {
            $this->form_validation->set_message('_handle_connect', '<p class="alert alert-danger">Database connection was unsuccessful, please make sure the database server, username and password is correct.');
            return FALSE;
        } else {
            mysqli_close($db_check);
            return TRUE;
        }
    }
}

/* End of file database.php */
/* Location: ./setup/controllers/database.php */
