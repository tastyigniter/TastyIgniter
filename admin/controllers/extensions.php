<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions extends Admin_Controller {

   	public function __construct() {
		parent::__construct();
        $this->load->model('Extensions_model');
    }

	public function index() {
        $this->user->restrict('Admin.Modules');

        $this->template->setTitle('Modules');
        $this->template->setHeading('Modules');
        $this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/add'));

        $data['text_empty'] 		= 'There are no extensions available.';

        $data['extensions'] = array();
        $results = $this->Extensions_model->getList(array('type' => 'module'));
        foreach ($results as $result) {
            if ($result['installed'] === TRUE) {
                $extension_id = $result['extension_id'];
                $manage = site_url('extensions/edit?action=uninstall&name='.$result['name'].'&id='.$extension_id);
            } else {
                $extension_id = '-';
                $manage = site_url('extensions/edit?action=install&name='.$result['name'].'&id='.$extension_id);
            }

            $data['extensions'][] = array(
				'extension_id' 	=> $extension_id,
				'name' 			=> $result['name'],
				'title' 		=> $result['title'],
				'installed' 	=> $result['installed'],
				'type' 			=> $result['type'],
				'options' 		=> $result['options'],
				'edit' 			=> site_url('extensions/edit?action=edit&name='.$result['name'].'&id='.$extension_id),
				'delete' 		=> site_url('extensions/edit?action=delete&name='.$result['name'].'&id='.$extension_id),
				'manage'		=> $manage
			);
        }

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('extensions', $data);
    }

	public function edit() {
        $this->user->restrict('Admin.Modules.Access');

        $extension_name = $this->input->get('name');
		$action = $this->input->get('action');
		$loaded = FALSE;
        $error_msg = FALSE;

        if ($extension = $this->Extensions_model->getExtension('module', $extension_name, FALSE)) {

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
                } else {
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

        if ($this->input->get('name') AND $this->input->get('action') AND $action !== 'edit') {
            $_POST = $_GET;

            if ($this->input->get('action') === 'install' AND $this->_install()) {
                redirect('extensions');
            }

            if ($this->input->get('action') === 'uninstall' AND $this->_uninstall()) {
                redirect('extensions');
            }

            if ($this->input->get('action') === 'delete' AND $this->_delete()) {
                redirect('extensions');
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
        $this->user->restrict('Admin.Modules.Access');

        $this->template->setTitle('Module');
        $this->template->setHeading('Module: Upload');
        $this->template->setButton('Upload', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton('Upload & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setBackButton('btn btn-back', site_url('extensions'));

        $data['_action']	= site_url('extensions/add');

        if ($this->_uploadExtension() === TRUE) {
            if ($this->input->post('save_close') === '1') {
                redirect('extensions');
            }

            redirect('extensions/add');
        }

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('extensions_add', $data);
	}

    private function _delete() {
        if ($this->input->get('action') === 'delete') {
            $this->user->restrict('Admin.Modules.Delete');

            if ($this->Extensions_model->extensionExists($this->input->get('name'))) {
                if ($this->Extensions_model->delete('module', $this->input->get('name'), $this->input->get('id'))) {
                    $this->alert->set('success', 'Extension deleted successfully.');
                }
            }

            $this->alert->danger_now('An error occurred, please try again.');
        }

        redirect('extensions');
	}

    private function _install() {
    	if ($this->input->get('action') === 'install') {
            $this->user->restrict('Admin.Modules.Manage');

            if ($this->Extensions_model->extensionExists($this->input->get('name'))) {
	    		if ($this->Extensions_model->install('module', $this->input->get('name'), $this->input->get('id'))) {
					$this->alert->set('success', 'Extension Installed successfully.');
					return TRUE;
	    		}
	    	}

            $this->alert->danger_now('An error occurred, please try again.');
        }

        return FALSE;
	}

    private function _uninstall() {
    	if ($this->input->get('action') === 'uninstall') {
            $this->user->restrict('Admin.Modules.Manage');

            if ($this->Extensions_model->uninstall('module', $this->input->get('name'), $this->input->get('id'))) {
                $this->alert->set('success', 'Extension Uninstalled successfully.');
                return TRUE;
            }
		}

		return FALSE;
	}

    private function _uploadExtension() {
        if (isset($_FILES['extension_zip'])) {
            $this->user->restrict('Admin.Modules.Add', site_url('extensions/add'));

            if ($this->validateUpload() === TRUE) {
                if ($this->Extensions_model->upload('module', $_FILES['extension_zip'])) {
                    $this->alert->set('success', 'Module extension uploaded successfully');

                    return TRUE;
                }

                $this->alert->danger_now('An error occurred (upload failed or already exists), please try again.');
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