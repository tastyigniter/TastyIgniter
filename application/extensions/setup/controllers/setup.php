<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setup extends CI_Controller {

	public function __construct() {
		parent::__construct();
				$this->output->enable_profiler(TRUE);
	}

	public function _remap($method) {
		if ($this->session->userdata('setup') === 'step_3' OR $this->config->item('ti_version') === 'v1.2') {
			$this->success();
		} else {
			$this->$method();
		}
	}

	public function index() {
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		

		$error = 0;
        
        $php_required  = '5.4';
        $php_installed = phpversion();

		$data['heading'] 					= 'TastyIgniter - Setup';
        $data['php_version'] 				= 'is version '. $php_installed .' supported?';
		$data['mysqli_installed'] 			= 'is MySQLi installed?';
		$data['curl_installed'] 			= 'is cURL installed?';
		$data['gd_installed'] 				= 'is GD/GD2 library installed?';
		$data['register_globals_enabled'] 	= 'is Register Globals turned off?';
		$data['magic_quotes_gpc_enabled'] 	= 'is Magic Quotes GPC turned off?';
		$data['file_uploads_enabled'] 		= 'is File Uploads turned on?';
		$data['is_writable'] 				= 'is writable?';
				
        if ($php_installed < $php_required) {
			$error = 1;
			$data['php_status'] = '<i class="fa fa-exclamation-triangle red"></i>';
        } else {
			$data['php_status'] = '<i class="fa fa-check-square-o green"></i>';
        }

        if (!extension_loaded('mysqli')) {
			$error = 1;
			$data['mysqli_status'] = '<i class="fa fa-exclamation-triangle red"></i>';
        } else {
			$data['mysqli_status'] = '<i class="fa fa-check-square-o green"></i>';
        }

        if (!extension_loaded('curl')) {
			$error = 1;
			$data['curl_status'] = '<i class="fa fa-exclamation-triangle red"></i>';
        } else {
			$data['curl_status'] = '<i class="fa fa-check-square-o green"></i>';
        }

        if (!extension_loaded('gd')) {
			$error = 1;
			$data['gd_status'] = '<i class="fa fa-exclamation-triangle red"></i>';
        } else {
			$data['gd_status'] = '<i class="fa fa-check-square-o green"></i>';
        }

		if (ini_get('register_globals')) {
			$error = 1;
			$data['register_globals_status'] = '<i class="fa fa-exclamation-triangle red"></i>';
        } else {
			$data['register_globals_status'] = '<i class="fa fa-check-square-o green"></i>';
		}
		
		if (ini_get('magic_quotes_gpc')) {
			$error = 1;
			$data['magic_quotes_gpc_status'] = '<i class="fa fa-exclamation-triangle red"></i>';
        } else {
			$data['magic_quotes_gpc_status'] = '<i class="fa fa-check-square-o green"></i>';
		}
		
		if (!ini_get('file_uploads')) {
			$error = 1;
			$data['file_uploads_status'] = '<i class="fa fa-exclamation-triangle red"></i>';
        } else {
			$data['file_uploads_status'] = '<i class="fa fa-check-square-o green"></i>';
		}
						
		$writables = array(
			'./'. APPPATH .'config/config.php',
			'./'. APPPATH .'config/database.php',
			'./'. APPPATH .'config/routes.php',
			'./'. APPPATH .'logs/',
			'./'. APPPATH .'logs/logs.php',
			'./assets/download/',
			'./assets/img/'
		);

        foreach ($writables as $writable) {
            if (!is_writable($writable)) {
				$error = 1;
                
                $data['writables'][] = array(
                	'file' => $writable,
                    'status' => '<i class="fa fa-exclamation-triangle red"></i>'
                );
            } else {
                $data['writables'][] = array(
                	'file' => $writable,
                    'status' => '<i class="fa fa-check-square-o green"></i>'
                );
            }
        }

		$this->session->unset_userdata('setup');
		
		if ($this->input->post()) {
			
			if ($error === 0) {
				$this->session->set_userdata('setup', 'step_1');
				redirect('setup/database');
			}
			
			$data['alert'] = '<p class="alert alert-danger">Please check below to make sure all server requirements are provided!</p>';
		}
		
		if ( ! file_exists(APPPATH .'/extensions/setup/views/setup.php')) {
			show_404();
		} else {
			$this->load->view('setup/setup', $data);
		}
	}

	public function database() {
		if ($this->session->userdata('setup') !== 'step_1') {
			$this->session->set_flashdata('alert', '<p class="alert alert-danger">Please check below to make sure all server requirements are provided!</p>');				
			redirect('setup/setup');			
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
		
		$data['heading'] 		= 'TastyIgniter - Setup - Database';

		if (is_file(APPPATH.'config/database.php')) {
			include(APPPATH.'config/database.php');
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
		
		if ($this->input->post() AND $this->_checkDatabase() === TRUE) {
			redirect('setup/settings');
		}
		
		if ( ! file_exists(APPPATH .'/extensions/setup/views/database.php')) {
			show_404();
		} else {
			$this->load->view('database', $data);
		}
	}

	public function settings() {
		$this->load->library('migration');
			
		if ($this->session->userdata('setup') !== 'step_2') {
			redirect('setup/database');			
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		

		$data['heading'] = 'TastyIgniter - Setup - Settings';

		if ($this->input->post('site_name')) {
			$data['site_name'] = $this->input->post('site_name');		
		} else {
			$data['site_name'] = '';		
		}
		
		if ($this->input->post('site_email')) {
			$data['site_email'] = $this->input->post('site_email');		
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
		
		if ($this->input->post('demo_data')) {
			$data['demo_data'] = $this->input->post('demo_data');		
		} else {
			$data['demo_data'] = '';		
		}
		
		if ($this->input->post() AND $this->_checkSettings() === TRUE){
			redirect('setup/success');
		}
		
		if ( !file_exists(APPPATH .'/extensions/setup/views/settings.php')) {
			show_404();
		} else {
			$this->load->view('setup/settings', $data);
		}
	}

	public function success() {
		if ( ! file_exists(APPPATH .'/extensions/setup/views/success.php')) {
			show_404();
		}

		if ($this->session->userdata('setup') === 'step_3' OR $this->config->item('ti_version') === 'v1.2') {
			if (defined('TI_SETUP') AND TI_SETUP === 'directory_found') {
				$data['alert'] = '<p class="alert alert-danger">PLEASE REMEMBER TO COMPLETELY REMOVE THE SETUP FOLDER. <br />You will not be able to proceed beyond this point until the setup folder has been removed. <br />This is a security feature of TastyIgniter!</p>';
			}
			
			$data['heading'] 			= 'TastyIgniter - Setup - Successful';
			$data['complete_setup'] 	= '<a href="'. site_url(ADMIN_URI) .'">Login to Administrator Panel</a>';
			
			$this->load->library('user');
			$this->user->logout();
			$this->session->unset_userdata('setup');

			$this->load->view('setup/success', $data);
		
		} else {
			redirect('setup');					
		}
		
	}

	public function _checkDatabase() {
		$this->load->helper('file');
		
		$this->form_validation->set_rules('db_name', 'Database Name', 'xss_clean|trim|required');
		$this->form_validation->set_rules('db_host', 'Hostname', 'xss_clean|trim|required|callback_handle_connect');
		$this->form_validation->set_rules('db_user', 'Username', 'xss_clean|trim|required');
		$this->form_validation->set_rules('db_pass', 'Password', 'xss_clean|trim|required');
		$this->form_validation->set_rules('db_prefix', 'Prefix', 'xss_clean|trim|required');
		
		if ($this->form_validation->run() === TRUE) {
	
			$db_path	= APPPATH .'config/database.php';
			$db_user 	= $this->input->post('db_user');
			$db_pass 	= $this->input->post('db_pass');
			$db_host 	= $this->input->post('db_host');
			$db_name	= $this->input->post('db_name');
			$db_prefix	= $this->input->post('db_prefix');

			if ( ! is_writable($db_path)) {
				$this->session->set_flashdata('alert', '<p class="alert alert-danger">Unable to write database file.</p>');
				redirect('setup/database');       	 		
			} else {
				if ($fp = @fopen(APPPATH .'config/database.php', FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

					$db_file = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";
			
					$db_file .= "$"."active_group = 'default';\n";
					$db_file .= "$"."active_record = TRUE;\n\n";

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
					$db_file .= "$"."db['default']['stricton'] = FALSE;\n\n";

					$db_file .= "/* End of file database.php */\n";
					$db_file .= "/* Location: ./application/config/database.php */\n";

					flock($fp, LOCK_EX);
					fwrite($fp, $db_file);
					flock($fp, LOCK_UN);
					fclose($fp);

					@chmod($db_path, FILE_WRITE_MODE);

					$this->session->set_userdata('setup', 'step_2'); 		
					return TRUE;
				}
			}
		}
	}
	
	public function _checkSettings() {
		$this->load->model('Setup_model');	    
		$this->load->helper('file');

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
				'password' 		=> $this->input->post('password'),
				'demo_data' 	=> $this->input->post('demo_data')
			);
	
			if ($this->_doMigration()) {
				if ($this->Setup_model->addData($add)) {
					$this->session->set_userdata('setup', 'step_3'); 		
					return TRUE;
				} else {
					$this->session->set_flashdata('alert', '<p class="alert alert-danger">Error installing user and site settings.</p>');
				}
			}

			if ($this->_doMigration()) {
				if ($this->Setup_model->addData($add)) {
					$this->session->set_userdata('setup', 'step_3'); 		
					return TRUE;
				} else {
					$this->session->set_flashdata('alert', '<p class="alert alert-danger">Error installing user and site settings.</p>');
				}
			}

			redirect('setup/settings');       	 		
		}
	}

	public function _doMigration() {
		if ($this->migration->current()) {
			return TRUE;
		} else {
			show_error($this->migration->error_string());
			return FALSE;    	 		
		}
	}
		
	public function handle_connect() {
		$db_user 	= $this->input->post('db_user');
		$db_pass 	= $this->input->post('db_pass');
		$db_host 	= $this->input->post('db_host');
		$db_name	= $this->input->post('db_name');
 		 
		$db_check = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
		
		if (mysqli_connect_error()) {
        	$this->form_validation->set_message('handle_connect', '<p class="alert alert-danger">Database connection was unsuccessful, please make sure the database server, username and password is correct.</p>');
			return FALSE;
		} else {
			mysqli_close($db_check);
			return TRUE;
		}
	}
}

/* End of file setup.php */
/* Location: ./application/extensions/setup/controllers/setup.php */
