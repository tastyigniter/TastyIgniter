<?php
class Setup extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->library('user');
		$this->load->model('Setup_model');	    
		
		$sess_admin_data = array(
			'user_id' 			=> '',
			'staff_department'	=> '',
			'username' 			=> ''
		);
		
		$this->session->unset_userdata($sess_admin_data);
	}

	public function index() {
			
		//check if file exists in views
		if ( ! file_exists(APPPATH .'/extensions/setup/views/setup.php')) {
			show_404();
		}
	
		if ($this->config->item('ti_setup') === 'success') {
			$this->session->set_flashdata('alert', '<p class="error">PLEASE REMEMBER TO COMPLETELY REMOVE THE SETUP FOLDER. <br />You will not be able to proceed beyond this point until the setup folder has been removed. This is a security feature of TastyIgniter!</p>');				
			redirect('setup/success');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		

		$data['heading'] 					= 'TastyIgniter - Setup';
        $data['php_version'] 				= 'is version '. phpversion() .' supported?';
		$data['mysqli_installed'] 			= 'is MySQLi installed?';
		$data['curl_installed'] 			= 'is cURL installed?';
		$data['register_globals_enabled'] 	= 'is Register Globals turned off?';
		$data['magic_quotes_gpc_enabled'] 	= 'is Magic Quotes GPC turned off?';
		$data['file_uploads_enabled'] 		= 'is File Uploads turned on?';
		$data['is_writable'] 				= 'is writable?';
				
		$error = 0;
        
        $php_required  = '5.4';

        if (phpversion() < $php_required) {
			$error = 1;
			$data['php_status'] = '<span class="red">No</span>';
        } else {
			$data['php_status'] = '<span class="">Yes</span>';
        }

        if (!extension_loaded('mysqli')) {
			$error = 1;
			$data['mysqli_status'] = '<span class="red">No</span>';
        } else {
			$data['mysqli_status'] = '<span class="">Yes</span>';
        }

        if (!extension_loaded('curl')) {
			$error = 1;
			$data['curl_status'] = '<span class="red">No</span>';
        } else {
			$data['curl_status'] = '<span class="">Yes</span>';
        }

		if (!ini_get('register_globals')) {
			$data['register_globals_status'] = '<span class="">Yes</span>';
        } else {
			$data['register_globals_status'] = '<span class="red">No</span>';
		}
		
		if (!ini_get('magic_quotes_gpc')) {
			$data['magic_quotes_gpc_status'] = '<span class="">Yes</span>';
        } else {
			$data['magic_quotes_gpc_status'] = '<span class="red">No</span>';
		}
		
		if (!ini_get('file_uploads')) {
			$error = 1;
			$data['file_uploads_status'] = '<span class="red">No</span>';
        } else {
			$data['file_uploads_status'] = '<span class="">Yes</span>';
		}
						
		$writables = array(
			'./'. APPPATH .'config/config.php',
			'./'. APPPATH .'config/database.php',
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
                    'status' => '<span class="red">No</span>'
                );

            } else {

                $data['writables'][] = array(
                	'file' => $writable,
                    'status' => '<span class="">Yes</span>'
                );

            }
        }

		$this->session->unset_userdata('setup');
		
		if ($this->input->post()) {
			
			if ($error === 0) {
				$this->session->set_userdata('setup', 'step_1');
			}
		
			redirect('setup/database');
		}
		
		$this->load->view('setup/setup', $data);
	}

	public function database() {
			
		//check if file exists in views
		if ( !file_exists(APPPATH .'/extensions/setup/views/database.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if ($this->session->userdata('setup') !== 'step_1') {
			$this->session->set_flashdata('alert', '<p class="error">Please check below to make sure all server requirements are provided!</p>');				
			redirect('setup/setup');			
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		
		
		$data['heading'] 		= 'TastyIgniter - Setup - Database';

		if ($this->input->post('db_name')) {
			$data['db_name'] = $this->input->post('db_name');		
		} else {
			$data['db_name'] = '';		
		}
		
		if ($this->input->post('db_host')) {
			$data['db_host'] = $this->input->post('db_host');		
		} else {
			$data['db_host'] = 'localhost';		
		}
		
		if ($this->input->post('db_user')) {
			$data['db_user'] = $this->input->post('db_user');		
		} else {
			$data['db_user'] = '';		
		}
		
		if ($this->input->post('db_pass')) {
			$data['db_pass'] = $this->input->post('db_pass');		
		} else {
			$data['db_pass'] = '';		
		}
		
		if ($this->input->post() && $this->_checkDatabase() === TRUE) {
						
			redirect('setup/settings');
		}
		
		$this->load->view('database', $data);
	}

	public function settings() {
			
		//check if file exists in views
		if ( !file_exists(APPPATH .'/extensions/setup/views/settings.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}
		
		if ($this->session->userdata('setup') !== 'step_2') {
			redirect('setup/database');			
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else { 
			$data['alert'] = '';
		}		

		$data['heading'] 		= 'TastyIgniter - Setup - Settings';

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
		
		if ($this->input->post() && $this->_checkSettings() === TRUE){
						
			redirect('setup/success');
		}
		
		$this->load->view('setup/settings', $data);
	}

	public function success() {
			
		//check if file exists in views
		if ( !file_exists(APPPATH .'/extensions/setup/views/success.php')) {
			// Whoops, we don't have a page for that!
			show_404();
		}

		if ($this->config->item('ti_setup') === 'success') {
		
			if ($this->session->flashdata('alert')) {
				$data['alert'] = $this->session->flashdata('alert');
			} else { 
				$data['alert'] = '<p class="error">PLEASE REMEMBER TO COMPLETELY REMOVE THE SETUP FOLDER. <br />You will not be able to proceed beyond this point until the setup folder has been removed. This is a security feature of TastyIgniter!</p>';
			}		
		
			$data['heading'] 			= 'TastyIgniter - Setup - Successful';
			$data['complete_setup'] 	= '<a href="'. site_url('admin') .'">Remove Setup Folder</a>';
			
			$this->session->unset_userdata('setup');

			$this->load->view('setup/success', $data);
		
		} else {
		
			//$this->session->set_flashdata('alert', '<p class="error">INSTALLATION WAS NOT SUCCESSFUL. <br />Please try again.</p>');				
			redirect('setup');					
		
		}
		
	}

	public function complete() {
			
		$setup_dir = APPPATH .'/extensions/setup/';
		$setup_old = APPPATH .'/extensions/setup_old/';
		
		if (file_exists($setup_dir)) {
			if (rename($setup_dir, $setup_old)) {
				redirect('admin/login');
			}
		}

		redirect('setup/success');
	}

	public function _checkDatabase() {
		
		$this->load->helper('file');
		
		$this->form_validation->set_rules('db_name', 'Database Name', 'trim|required');
		$this->form_validation->set_rules('db_host', 'Hostname', 'trim|required|callback_handle_connect');
		$this->form_validation->set_rules('db_user', 'Username', 'trim|required');
		$this->form_validation->set_rules('db_pass', 'Password', 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
	
			$db_path	= APPPATH .'config/database.php';
			$db_driver 	= 'mysqli';
			$db_user 	= $this->input->post('db_user');
			$db_pass 	= $this->input->post('db_pass');
			$db_host 	= $this->input->post('db_host');
			$db_name	= $this->input->post('db_name');

			if (is_readable($db_path)) {

        		$db_file = read_file($db_path);
		
				$db_file = str_replace('$db[\'default\'][\'hostname\'] = \'localhost\'', '$db[\'default\'][\'hostname\'] = \'' . $db_host . '\'', $db_file);
				$db_file = str_replace('$db[\'default\'][\'username\'] = \'\'', '$db[\'default\'][\'username\'] = \'' . $db_user . '\'', $db_file);
				$db_file = str_replace('$db[\'default\'][\'password\'] = \'\'', '$db[\'default\'][\'password\'] = \'' . $db_pass . '\'', $db_file);
				$db_file = str_replace('$db[\'default\'][\'database\'] = \'\'', '$db[\'default\'][\'database\'] = \'' . $db_name . '\'', $db_file);
				//$db_file = str_replace('$db[\'default\'][\'db_debug\'] = FALSE', '$db[\'default\'][\'db_debug\'] = TRUE', $db_file);

       	 		$error = 0;
       	 		
       	 		if ( ! write_file($db_path, $db_file)) {
					$error = 1;
				}
				
       	 		if ($error === 1) {
 					$this->session->set_flashdata('alert', 'Unable to write database file!');
       	 		} else if ($error === 0) {
					$this->session->set_userdata('setup', 'step_2'); 		
       	 			return TRUE;
       	 		}

		       	 redirect('setup/database');       	 		
			}
		}
	}
	
	public function _checkSettings() {
		
		$this->load->helper('file');

		$this->form_validation->set_rules('site_name', 'Restaurant Name', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('site_email', 'Restaurant Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('staff_name', 'Staff Name', 'trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[128]|matches[confirm_password]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			//$this->session->unset_userdata('setup');$config['sess_use_database']	= TRUE;


			$add = array(
				'site_name' 		=> $this->input->post('site_name'),
				'site_email' 		=> $this->input->post('site_email'),
				'staff_name' 		=> $this->input->post('staff_name'),
				'username' 			=> $this->input->post('username'),
				'password' 			=> $this->input->post('password')
			);
			
			$success = 1;
			
			if ($this->Setup_model->dbInstall()) {
				$config_path	= APPPATH .'config/config.php';
				$config_file = read_file($config_path);
	
				$config_file = str_replace('$config[\'sess_use_database\']	= FALSE', '$config[\'sess_use_database\'] 	= TRUE', $config_file);
				$config_file = str_replace('$config[\'ti_setup\'] = \'\'', '$config[\'ti_setup\'] = \'success\'', $config_file);

			
				if ( ! write_file($config_path, $config_file)) {
					$success = 0;
					$this->session->set_flashdata('alert', 'Unable to write config file!');
				} else {
					if ( ! $this->Setup_model->addUser($add)) {
						$success = 0;
						$this->session->set_flashdata('alert', 'Error installing user and site settings!');
					}
				}
			} else {
				$success = 0;
 				$this->session->set_flashdata('alert', 'Error installing database!');
			}

			if ($success === 1) {
				$this->session->set_userdata('setup', 'step_3'); 		
				return TRUE;
			}

			redirect('setup/settings');       	 		
		}
	}
	
	public function handle_connect() {

		$db_user 	= $this->input->post('db_user');
		$db_pass 	= $this->input->post('db_pass');
		$db_host 	= $this->input->post('db_host');
		$db_name	= $this->input->post('db_name');
 		 
		$db_check = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
		
		if (mysqli_connect_error()) {
        	$this->form_validation->set_message('handle_connect', 'Database connection was unsuccessful, please make sure the database server, username and password is correct.');
			return FALSE;
		} else {
			mysqli_close($db_check);
			return TRUE;
		}
	}
}