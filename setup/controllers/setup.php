<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setup extends Base_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('Setup_model');

        if ($this->session->tempdata('setup') === 'step_3' AND $this->config->item('ti_version') === 'v1.3-beta') {
            $this->success;
        }
	}

	public function index() {
        $this->session->set_tempdata('setup', '', 300);

		$error = 0;

        $php_required  = '5.4';
        $php_installed = phpversion();

		$data['heading'] 					= 'TastyIgniter - Setup';
		$data['sub_heading'] 				= 'Server Requirements';
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
			'/system/tastyigniter/config/database.php',
			'/system/tastyigniter/config/routes.php',
			'/system/tastyigniter/logs/',
			'/assets/downloads/',
			'/assets/images/'
		);

        foreach ($writables as $writable) {
            if (!is_writable(ROOTPATH . $writable)) {
				$error = 1;
                $status = '<i class="fa fa-exclamation-triangle red"></i>';
            } else {
                $status = '<i class="fa fa-check-square-o green"></i>';
            }

            $data['writables'][] = array(
                'file' => $writable,
                'status' => $status
            );
        }

		if ($this->input->post()) {

			if ($error === 0) {
				$this->session->set_tempdata('setup', 'step_1', 300);
				redirect('database');
			}

			$this->alert->set('danger', 'Please check below to make sure all server requirements are provided!');
		}

		if ( ! file_exists(VIEWPATH .'/setup.php')) {
			show_404();
		} else {
			$this->load->view('header', $data);
			$this->load->view('setup', $data);
			$this->load->view('footer', $data);
		}
	}
}

/* End of file setup.php */
/* Location: ./setup/controllers/setup.php */
