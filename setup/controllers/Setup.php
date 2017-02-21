<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Setup extends Base_Controller {

    protected $setup_step;
    protected $setup_timeout = '900';
    protected $setup_proceed = FALSE;

    public function __construct() {
		parent::__construct();

        $this->load->model('Setup_model');
        $this->load->library('form_validation');

        $this->setup_step = $this->uri->segment(1) ? $this->uri->segment(1) : 'license';
		$this->sess_setup_step = $this->session->tempdata('setup_step');

        if ($this->setup_step !== 'success' AND !$this->input->post('install_step') AND $this->installer->isInstalled()) {
            $this->redirect('success');
        }

        if ($this->sess_setup_step == $this->setup_step) {
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
            $this->redirect('requirements');
        }

        if ( ! file_exists(VIEWPATH .'/license.php')) {
			show_404($this->uri->uri_string());
        } else {
            $this->load->view('header', $data);
            $this->load->view('license', $data);
            $this->load->view('footer', $data);
        }

    }

	public function requirements() {
        if ($this->setup_proceed === FALSE AND $this->sess_setup_step !== 'database') {
            $this->alert->set('danger', $this->lang->line('alert_license_error'));
            $this->redirect('license');
        }

        $data['text_heading'] 		    = $this->lang->line('text_requirement_heading');
        $data['text_sub_heading'] 		= $this->lang->line('text_requirement_sub_heading');
        $data['installed_php_version']  = $this->installer->installed_php_version;
        $data['required_php_version']   = $this->installer->required_php_version;
        $data['requirements']           = $this->installer->checkRequirements();
        $data['writables']              = $this->installer->checkWritable();
        $data['setup_step'] 	    	= $this->setup_step;

        $data['back_url'] 		        = $this->pageUrl('license');

		if ($this->_validateRequirements() === TRUE) {
			$this->session->set_tempdata('setup_step', 'database', $this->setup_timeout);
			$this->redirect('database');
		}

        if ( ! file_exists(VIEWPATH .'/requirements.php')) {
			show_404($this->uri->uri_string());
        } else {
            $this->load->view('header', $data);
            $this->load->view('requirements', $data);
            $this->load->view('footer', $data);
        }
	}

	public function database() {
		if ($this->setup_proceed === FALSE AND $this->_validateRequirements() === FALSE) {
            $this->alert->set('danger', $this->lang->line('alert_requirement_error'));
            $this->redirect('requirements');
        }

        if ($this->installer->db_exists === TRUE OR $this->_validateDatabase() === TRUE) {
            $this->session->set_tempdata('setup_step', 'settings', $this->setup_timeout);
            $this->redirect('settings');
        }

        $data['text_heading'] 		= $this->lang->line('text_database_heading');
        $data['text_sub_heading'] 	= $this->lang->line('text_database_sub_heading');
        $data['setup_step'] 	    = $this->setup_step;
        $data['back_url'] 		    = $this->pageUrl('license');

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
        $data['dbprefix'] = strtolower(random_string('alnum', '5').'_');

        if ( ! file_exists(VIEWPATH .'/database.php')) {
			show_404($this->uri->uri_string());
        } else {
            $this->load->view('header', $data);
            $this->load->view('database', $data);
            $this->load->view('footer', $data);
        }
	}

	public function settings() {
		if ($this->installer->db_exists === FALSE OR $this->setup_proceed === FALSE) {
            $this->alert->set('danger', $this->lang->line('alert_database_error'));
            $this->redirect('database');
        }

        if ($this->installer->checkSettings() === TRUE OR $this->_validateSettings() === TRUE) {
            $this->session->set_tempdata('setup_step', 'complete', $this->setup_timeout);
            $this->redirect('complete');
        }

        $data['text_heading'] 		= $this->lang->line('text_settings_heading');
        $data['text_sub_heading'] 	= $this->lang->line('text_settings_sub_heading');
        $data['setup_step'] 	    = $this->setup_step;
        $data['back_url'] 		    = $this->pageUrl('license');

        foreach (array('site_location_mode', 'site_name', 'site_email', 'staff_name', 'username', 'password', 'demo_data') as $item) {
            if ($this->input->post($item)) {
                $data[$item] = $this->input->post($item);
            } else if ($this->config->item($item)) {
                $data[$item] = $this->config->item($item);
            } else {
                $data[$item] = '';
            }
        }

        if ( !file_exists(VIEWPATH .'/settings.php')) {
			show_404($this->uri->uri_string());
        } else {
            $this->load->view('header', $data);
            $this->load->view('settings', $data);
            $this->load->view('footer', $data);
        }
    }

	public function complete()
	{
		if (!$this->installer->checkSettings() OR $this->setup_proceed === FALSE) {
			$this->alert->set('danger', $this->lang->line('alert_settings_error'));
			$this->redirect('settings');
		}

		$data['text_heading'] 		    = $this->lang->line('text_complete_heading');
		$data['text_sub_heading'] 		= $this->lang->line('text_complete_sub_heading');
		$data['setup_step'] 	    	= $this->setup_step;
		$data['install_step'] 	    	= $this->installer->checkComposerVendor() ? 'getExtensionMeta' : 'downloadComposer';
		$data['install_skip'] 	    	= $this->installer->checkComposerVendor() ? 'finish' : 'downloadComposer';

		$installed_extensions = Modules::list_modules();
		$data['installed_extensions'] = is_array($installed_extensions) ? array_values($installed_extensions) : [];

		$data['site_key'] 		        = $this->config->item('site_key');
		$data['back_url'] 		        = $this->pageUrl('settings');

		if ( ! file_exists(VIEWPATH .'/complete.php')) {
			show_404($this->uri->uri_string());
		} else {
			$this->load->view('header', $data);
			$this->load->view('complete', $data);
			$this->load->view('footer', $data);
		}
	}

	public function success() {
        if ($this->installer->isInstalled() !== TRUE OR ! ($this->setup_proceed === TRUE OR $this->installer->checkSettings() === TRUE)) {
            $this->redirect('requirements');
        }

        $data['text_heading'] 		= $this->lang->line('text_success_heading');
        $data['text_sub_heading'] 	= $this->lang->line('text_success_sub_heading');
        $data['setup_step'] 	    = $this->setup_step;
        $data['admin_url'] 	        = admin_url();
        $data['site_url']           = root_url();

        $this->load->library('user');
        $this->user->logout();

		if ( ! file_exists(VIEWPATH .'/success.php')) {
			show_404($this->uri->uri_string());
		} else {
			$this->load->view('header', $data);
			$this->load->view('success', $data);
			$this->load->view('footer', $data);
		}
    }

	public function fetch()
	{
		$json = [];

		$this->load->library('hub_manager');
		$result = $this->hub_manager->getDetails($this->config->item('required_extensions'));

		if (is_array($result)) {
			foreach ($result as $item)
				$json['results'][] = $item;
		} else {
			$json['error'] = $result;
		}

		$this->output->set_output(json_encode($json));
    }

	public function install()
	{
		$json = null;

		if (($error = $this->_validateInstaller()) === TRUE) {
			$this->load->library('hub_manager');

			try {
				$result = FALSE;
				$post = $this->input->post();
				$install_step = $this->input->post('install_step');

				$params = !isset($post['code']) ? [] : [
					$post['code'] => [
						'code'   => $post['code'],
						'type'   => $post['type'],
						'ver'    => $post['version'],
						'action' => 'install',
					],
				];

				if ($this->input->post('install_skip'))
					unset($post['install_extensions']);

				switch ($install_step) {
					case 'getExtensionMeta':
						$names = [];
						if (isset($post['install_extensions']) AND is_array($post['install_extensions'])) {
							foreach ($post['install_extensions'] as $code => $version) {
								$names[$code] = [
									'type' => 'extension',
									'ver' => $version
								];
							}
						} else {
							$json['redirect'] = $this->pageUrl('success');
						}

						$result = $this->hub_manager->applyInstallOrUpdate($names);
						break;
					case 'downloadComposer':
						if ($this->composer_manager->downloadComposer())
							$result = 'Composer.phar downloaded';
						break;
					case 'extractComposer':
						if ($this->composer_manager->extractComposer())
							$result = 'Composer.phar extracted';
						break;
					case 'installComposer':
						$this->composer_manager->command('install');
						$this->composer_manager->cleanUp();
						$result = 'Composer dependencies installed';
						break;
					case 'downloadExtension':
						$this->installer->downloadFile($post['code'], $post['hash'], $params);
						$result = 'Download complete';
						break;
					case 'extractExtension':
						$this->installer->extractFile($post['code'], $post['type']);
						$result = 'Extension file extracted';
						break;
					case 'installExtension':
						if (!Modules::install_extension($post['code']))
							throw new Exception('Extension installation failed');
						$this->installer->cleanUp();
						$result = 'Extension installed';
						break;
					case 'finish':
						$this->session->set_tempdata('setup_step', 'success', $this->setup_timeout);
						if ($this->installer->complete())
							$result = 'Installation complete';
						$json['redirect'] = $this->pageUrl('success');
						break;
				}

				$json['results'] = $result;
			} catch (Exception $e) {
				$json['error'] = $e->getMessage();
			}
		} else {
			$json['error'] = $error;
		}

		$this->output->set_output(json_encode($json));
	}

	protected function _validateRequirements()
	{
		$requirements = $this->installer->checkRequirements();
		$writable = $this->installer->checkWritable();

		$success = TRUE;

		$requirement_fields = ['php_status', 'mysqli_status', 'pdo_status', 'curl_status', 'gd_status', 'zip_status'];
		foreach ($requirement_fields as $requirement_field) {
			if ($requirements[$requirement_field] < 1)
				$success = FALSE;
		}

		foreach ($writable as $file) {
			if ($file['status'] < 1)
				$success = FALSE;
		}

		if (!$success) $this->alert->set('danger_now', $this->lang->line('alert_requirement_error'));

		return $success;
	}

	protected function _validateDatabase() {
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

	protected function _validateSettings() {
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

	protected function _validateInstaller()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('site_key', 'lang:label_site_key', 'xss_clean|trim');
			$this->form_validation->set_rules('install_extensions[]', 'lang:label_extensions', 'xss_clean|trim');

			if (in_array($this->input->post('install_step'), ['downloadExtension', 'extractExtension', 'installExtension'])) {
				$this->form_validation->set_rules('hash', 'lang:label_meta_data', 'xss_clean|trim');
				$this->form_validation->set_rules('code', 'lang:label_meta_data', 'xss_clean|trim|required');
				$this->form_validation->set_rules('version', 'lang:label_meta_data', 'xss_clean|trim|required');
				$this->form_validation->set_rules('description', 'lang:label_meta_data', 'xss_clean|trim|required');
			}

			if ($this->form_validation->run() === TRUE) {
				$this->installer->saveSiteKey($this->input->post('site_key'));
				return TRUE;
			}

			return $this->form_validation->error_string();
		}

		return 'Form validation failed';
	}
}

/* End of file Setup.php */
/* Location: ./setup/controllers/Setup.php */
