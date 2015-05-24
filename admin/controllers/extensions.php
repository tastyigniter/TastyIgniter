<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions extends Admin_Controller {

    public $_permission_rules = array('access[index|edit|add]', 'modify[index|edit|add]');

   	public function __construct() {
		parent::__construct();
		$this->load->model('Extensions_model');
	}

	public function index() {
        $this->template->setTitle('Modules');
        $this->template->setHeading('Modules');
        $this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/add'));

        $data['text_empty'] 		= 'There are no extensions available.';

        $data['extensions'] = array();
        $results = $this->Extensions_model->getList('module');
        foreach ($results as $result) {
            if ($result['installed'] === TRUE) {
                $extension_id = $result['extension_id'];
                $manage = site_url('extensions?action=uninstall&name='.$result['name']);
            } else {
                $extension_id = '-';
                $manage = site_url('extensions?action=install&name='.$result['name']);
            }

            $data['extensions'][] = array(
				'extension_id' 	=> $extension_id,
				'name' 			=> $result['name'],
				'title' 		=> $result['title'],
				'installed' 	=> $result['installed'],
				'type' 			=> $result['type'],
				'options' 		=> $result['options'],
				'edit' 			=> site_url('extensions/edit?action=edit&name='.$result['name']),
				'manage'		=> $manage
			);
        }

        if ($this->input->get('name') AND $this->input->get('action')) {
            if ($this->input->get('action') === 'install' AND $this->_installExtension()) {
                redirect('extensions');
            }

            if ($this->input->get('action') === 'uninstall' AND $this->_uninstallExtension()) {
                redirect('extensions');
            }
        }

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('extensions', $data);
    }

	public function edit() {
		$extension_name = $this->input->get('name');
		$action = $this->input->get('action');
		$loaded = FALSE;
        $error_msg = FALSE;

        if ($extension = $this->Extensions_model->getExtension('module', $extension_name)) {
            $data['extension_name'] = $extension['name'];
            $ext_controller = $extension['name'] . '/admin_' . $extension['name'];
            $ext_class = strtolower('admin_'.$extension['name']);

            if (isset($extension['installed'], $extension['config'], $extension['options']) AND $action === 'edit') {
                if ($extension['config'] === FALSE) {
                    $error_msg = 'An error occurred, module extension config file failed to load';
                } else if ($extension['options'] === FALSE) {
                    $error_msg = 'An error occurred, module extension admin options disabled';
                } else if ($extension['installed'] === FALSE) {
                    $error_msg = 'An error occurred, module extension is not installed properly';
                } else if (!$this->user->hasPermissions('access', $extension_name)) {
                    $error_msg = 'You do not have the right permission to access this module';
                } else if ($this->input->post() AND !$this->user->hasPermissions('modify', $extension_name)) {
                    $error_msg = 'You do not have the right permission to modify this module';
                } else {
                    $_GET['extension_id'] = isset($extension['extension_id']) ? $extension['extension_id'] : 0;
                    $this->load->module($ext_controller);
                    if (class_exists($ext_class, FALSE)) {
                        $data['extension'] = $this->{$ext_class}->index($extension);
                        $loaded = TRUE;
                    } else {
                        $error_msg = 'An error occurred, module extension class failed to load: admin_'.$extension_name;
                    }
                }
            }
        }

        if (!$loaded OR $error_msg) {
            $this->alert->set('warning', $error_msg);
            redirect(referrer_url());
        }

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('extensions_edit', $data);
	}

	public function add() {
        $this->template->setTitle('Module: Install');
        $this->template->setHeading('Module: Install');
        $this->template->setButton('Upload', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton('Upload & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setBackButton('btn btn-back', site_url('extensions'));

        $data['action']	= site_url('extensions/add');

        if ($this->_uploadExtension() === TRUE) {
            if ($this->input->post('save_close') === '1') {
                redirect('extensions');
            }

            redirect('extensions/add');
        }

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('extensions_add', $data);
	}

	private function _uploadExtension() {
    	if (isset($_FILES['extension_zip']) AND $this->validateUpload() === TRUE) {
            if ($this->Extensions_model->upload('module', $_FILES['extension_zip'])) {
                $this->alert->set('success', 'Module extension uploaded successfully');
                return TRUE;
            }

            $this->alert->danger_now('An error occurred (upload failed or already exists), please try again.');
        }

		return FALSE;
	}

	private function _installExtension() {
    	if ($this->input->get('action') === 'install') {
 			if ($this->Extensions_model->extensionExists($this->input->get('name'))) {
	    		if ($this->Extensions_model->install('module', $this->input->get('name'))) {
					$this->alert->set('success', 'Extension Installed successfully.');
					return TRUE;
	    		}
	    	}

            $this->alert->danger_now('An error occurred, please try again.');
        }

        return FALSE;
	}

	private function _uninstallExtension() {
    	if ($this->input->get('action') === 'uninstall') {
            if ($this->Extensions_model->uninstall('module', $this->input->get('name'))) {
                $this->alert->set('success', 'Extension Uninstalled successfully.');
                return TRUE;
            }
		}

		return FALSE;
	}

    private function validateUpload() {
        if (!empty($_FILES['extension_zip']['name']) AND !empty($_FILES['extension_zip']['tmp_name'])) {

            if ($_FILES['extension_zip']['type'] !== 'application/zip') {
                $this->alert->danger_now('The filetype you are attempting to upload is not allowed.');
                return FALSE;
            }

            $_FILES['extension_zip']['name'] = html_entity_decode($_FILES['extension_zip']['name'], ENT_QUOTES, 'UTF-8');
            $_FILES['extension_zip']['name'] = str_replace(array('"', "'", "/", "\\"), "", $_FILES['extension_zip']['name']);
            $filename = $this->security->sanitize_filename($_FILES['extension_zip']['name']);
            $_FILES['extension_zip']['name'] = basename($filename);

            if (!empty($_FILES['extension_zip']['error'])) {
                $this->alert->danger_now('PHP File Uploading Error No'. $_FILES['extension_zip']['error']);
                return FALSE;
            }

            if (is_uploaded_file($_FILES['extension_zip']['tmp_name'])) return TRUE;
            return FALSE;
        }
    }
}

/* End of file extensions.php */
/* Location: ./admin/controllers/extensions.php */