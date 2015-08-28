<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Extensions extends Admin_Controller {

   	public function __construct() {
		parent::__construct();

        $this->load->model('Extensions_model');

        $this->lang->load('extensions');
    }

	public function index() {
        $this->user->restrict('Admin.Modules');

        $url = '?';
        $filter = array();
        if ($this->input->get('page')) {
            $filter['page'] = (int) $this->input->get('page');
        } else {
            $filter['page'] = '';
        }

        if ($this->config->item('page_limit')) {
            $filter['limit'] = $this->config->item('page_limit');
        }

        if ($this->input->get('filter_search')) {
            $filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
            $url .= 'filter_search='.$filter['filter_search'].'&';
        } else {
            $data['filter_search'] = '';
        }

        if ($this->input->get('filter_type')) {
            $filter['filter_type'] = $data['filter_type'] = $this->input->get('filter_type');
            $url .= 'filter_type='.$filter['filter_type'].'&';
        } else {
            $data['filter_type'] = '';
        }

        if (is_numeric($this->input->get('filter_status'))) {
            $filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
            $url .= 'filter_status='.$filter['filter_status'].'&';
        } else {
            $filter['filter_status'] = $data['filter_status'] = '';
        }

        if ($this->input->get('sort_by')) {
            $filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
        } else {
            $filter['sort_by'] = $data['sort_by'] = 'name';
        }

        if ($this->input->get('order_by')) {
            $filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
            $data['order_by_active'] = $this->input->get('order_by') .' active';
        } else {
            $filter['order_by'] = $data['order_by'] = 'ASC';
            $data['order_by_active'] = 'ASC';
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
        $this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/add'));

        $order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
        $data['sort_name'] 			= site_url('extensions'.$url.'sort_by=name&order_by='.$order_by);
        $data['sort_type'] 			= site_url('extensions'.$url.'sort_by=type&order_by='.$order_by);

        $data['extensions'] = array();
        $results = $this->Extensions_model->getList($filter);
        foreach ($results as $result) {
            if ($result['config'] !== TRUE) {
                $this->alert->warning_now($result['config']);
                continue;
            }

            if ($result['installed'] === TRUE AND $result['status'] === '1') {
                $manage = 'uninstall';
            } else {
                $manage = 'install';
            }

            $data['extensions'][] = array(
				'extension_id' 	=> $result['extension_id'],
				'author' 		=> isset($result['author']) ? $result['author'] : '--',
				'name' 			=> $result['name'],
				'title' 		=> $result['title'],
				'installed' 	=> $result['installed'],
				'type' 			=> ucfirst($result['type']),
				'description' 	=> isset($result['description']) ? substr($result['description'], 0, 128) : '',
				'settings' 		=> $result['settings'],
				'status' 		=> $result['status'],
				'edit' 			=> site_url('extensions/edit?id='.$result['extension_id'].'&name='.$result['name']),
				'delete' 		=> site_url('extensions/delete?id='.$result['extension_id'].'&name='.$result['name']),
				'manage'		=> site_url('extensions/'.$manage.'?id='.$result['extension_id'].'&name='.$result['name'])
			);
        }

        $this->template->setPartials(array('header', 'footer'));
        $this->template->render('extensions', $data);
    }

	public function edit() {
        $this->user->restrict('Admin.Modules.Access');

        $extension_name = $this->input->get('name');
		$loaded = FALSE;
        $error_msg = FALSE;

        if ($extension = $this->Extensions_model->getExtension($extension_name)) {

            $data['extension_name'] = $extension_name;
            $ext_controller = $extension['name'] . '/admin_' . $extension['name'];
            $ext_class = ucfirst('admin_'.$extension['name']);

            if (isset($extension['config'], $extension['installed'], $extension['settings'])) {
                if ($extension['config'] !== TRUE) {
                    $error_msg = $this->lang->line('error_config');
                } else if ($extension['settings'] === FALSE) {
                    $error_msg = $this->lang->line('error_options');
                } else if ($extension['installed'] === FALSE) {
                    $error_msg = $this->lang->line('error_installed');
                } else {
                    $this->load->module($ext_controller);
                    if (class_exists($ext_class, FALSE)) {
                        $data['extension'] = $this->{strtolower($ext_class)}->index($extension);
                        $loaded = TRUE;
                    } else {
                        $error_msg = sprintf($this->lang->line('error_failed'), $ext_class);
                    }
                }
            }
        }

        if (!$loaded OR $error_msg !== FALSE) {
            $this->alert->set('warning', $error_msg);
            redirect(referrer_url());
        }

		$this->template->render('extensions_edit', $data);
	}

	public function add() {
        $this->user->restrict('Admin.Modules.Access');

        $this->template->setTitle($this->lang->line('text_add_heading'));
        $this->template->setHeading($this->lang->line('text_add_heading'));

        $this->template->setButton($this->lang->line('button_upload'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
        $this->template->setButton($this->lang->line('button_upload_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
        $this->template->setBackButton('btn btn-back', site_url('extensions'));

        $data['_action']	= site_url('extensions/add');

        if ($this->_uploadExtension() === TRUE) {
            if ($this->input->post('save_close') === '1') {
                redirect('extensions');
            }

            redirect('extensions/add');
        }

		$this->template->render('extensions_add', $data);
	}

    public function install() {
        $this->user->restrict('Admin.Modules.Access');
        $this->user->restrict('Admin.Modules.Manage');

        if ($this->Extensions_model->extensionExists($this->input->get('name'))) {
            if ($this->Extensions_model->install('module', $this->input->get('name'), $this->input->get('id'))) {
                log_activity($this->user->getStaffId(), 'installed', 'extensions', get_activity_message('activity_custom_no_link',
                    array('{staff}', '{action}', '{context}', '{item}'),
                    array($this->user->getStaffName(), 'installed', 'extension module', $this->input->get('name'))
                ));

                $this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$this->input->get('name')} installed "));
                $success = TRUE;
            }
        }

        if (empty($success)) $this->alert->danger_now($this->lang->line('alert_error_try_again'));
        redirect('extensions');
    }

    public function uninstall() {
        $this->user->restrict('Admin.Modules.Access');
        $this->user->restrict('Admin.Modules.Manage');

        if ($this->Extensions_model->uninstall('module', $this->input->get('name'), $this->input->get('id'))) {
            log_activity($this->user->getStaffId(), 'uninstalled', 'extensions', get_activity_message('activity_custom_no_link',
                array('{staff}', '{action}', '{context}', '{item}'),
                array($this->user->getStaffName(), 'uninstalled', 'extension module', $this->input->get('name'))
            ));

            $this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$this->input->get('name')} uninstalled "));
        } else {
            $this->alert->danger_now($this->lang->line('alert_error_try_again'));
        }

        redirect('extensions');
	}

    public function delete() {
        $this->user->restrict('Admin.Modules.Access');
        $this->user->restrict('Admin.Modules.Delete');

        if ($this->Extensions_model->extensionExists($this->input->get('name'))) {
            if ($this->Extensions_model->delete('module', $this->input->get('name'), $this->input->get('id'))) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$this->input->get('name')} deleted "));
                $success = TRUE;
            }
        }

        if (empty($success)) $this->alert->danger_now($this->lang->line('alert_error_try_again'));
        redirect('extensions');
    }

    private function _uploadExtension() {
        $this->user->restrict('Admin.Modules.Add', site_url('extensions/add'));

        if (isset($_FILES['extension_zip'])) {
            if ($this->validateUpload() === TRUE) {
                if ($this->Extensions_model->upload('module', $_FILES['extension_zip'])) {
                    $extension_name = basename($_FILES['extension_zip']['name'], '.zip');
                    log_activity($this->user->getStaffId(), 'uploaded', 'extensions', get_activity_message('activity_custom_no_link',
                        array('{staff}', '{action}', '{context}', '{item}'),
                        array($this->user->getStaffName(), 'uploaded', 'extension', $extension_name)
                    ));

                    $alert = sprintf($this->lang->line('alert_success'), "Extension {$extension_name} uploaded ");
                    $alert .= sprintf($this->lang->line('alert_install'), site_url('extensions/install?name=').$extension_name);
                    $this->alert->set('success', $alert);
                    return TRUE;
                }

                $this->alert->danger_now($this->lang->line('alert_error_try_again'));
            }
        }

        return FALSE;
    }

    private function validateUpload() {
        if (!empty($_FILES['extension_zip']['name']) AND !empty($_FILES['extension_zip']['tmp_name'])) {

            if ($_FILES['extension_zip']['type'] !== 'application/zip') {
                $this->alert->danger_now($this->lang->line('error_upload'));
                return FALSE;
            }

            $_FILES['extension_zip']['name'] = html_entity_decode($_FILES['extension_zip']['name'], ENT_QUOTES, 'UTF-8');
            $_FILES['extension_zip']['name'] = str_replace(array('"', "'", "/", "\\"), "", $_FILES['extension_zip']['name']);
            $filename = $this->security->sanitize_filename($_FILES['extension_zip']['name']);
            $_FILES['extension_zip']['name'] = basename($filename);

            if (!empty($_FILES['extension_zip']['error'])) {
                $this->alert->danger_now($this->lang->line('error_php_upload'). $_FILES['extension_zip']['error']);
                return FALSE;
            }

            if (is_uploaded_file($_FILES['extension_zip']['tmp_name'])) return TRUE;
            return FALSE;
        }
    }
}

/* End of file extensions.php */
/* Location: ./admin/controllers/extensions.php */