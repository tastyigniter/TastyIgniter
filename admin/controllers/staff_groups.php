<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Staff_groups extends Admin_Controller {

    public $_permission_rules = array('access[index|edit]', 'modify[index|edit]');

    public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->model('Staff_groups_model');
	}

	public function index() {
		$this->template->setTitle('Staff Groups');
		$this->template->setHeading('Staff Groups');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There is no staff group available.';

		//load ratings data into array
		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'		=> $result['staff_group_id'],
				'staff_group_name'		=> $result['staff_group_name'],
				'edit'					=> site_url('staff_groups/edit?id=' . $result['staff_group_id'])
			);
		}

		if ($this->input->post('delete') AND $this->_deleteStaffGroup() === TRUE) {
		    redirect('staff_groups');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('staff_groups', $data);
	}

	public function edit() {
		$group_info = $this->Staff_groups_model->getStaffGroup((int) $this->input->get('id'));

		if ($group_info) {
			$staff_group_id = $group_info['staff_group_id'];
			$data['action']	= site_url('staff_groups/edit?id='. $staff_group_id);
		} else {
		    $staff_group_id = 0;
			$data['action']	= site_url('staff_groups/edit');
		}

		$title = (isset($group_info['staff_group_name'])) ? $group_info['staff_group_name'] : 'New';
		$this->template->setTitle('Staff Group: '. $title);
		$this->template->setHeading('Staff Group: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('staff_groups'));

		if (isset($this->input->post['staff_group_name'])) {
			$data['staff_group_name'] = $this->input->post['staff_group_name'];
		} else if (isset($group_info['staff_group_name'])) {
			$data['staff_group_name'] = $group_info['staff_group_name'];
		} else {
			$data['staff_group_name'] = '';
		}

		if (isset($this->input->post['location_access'])) {
			$data['location_access'] = $this->input->post['location_access'];
		} else if (isset($group_info['location_access'])) {
			$data['location_access'] = $group_info['location_access'];
		} else {
			$data['location_access'] = '';
		}

		if ($this->input->post('permission')) {
			$permission = $this->input->post('permission');
		} else if (isset($group_info['permission'])) {
			$permission = unserialize($group_info['permission']);
		}

		if (isset($permission['access'])) {
			$data['access'] = $permission['access'];
		} else {
			$data['access'] = array();
		}

		if (isset($permission['modify'])) {
			$data['modify'] = $permission['modify'];
		} else {
			$data['modify'] = array();
		}

		$ignore_path = array('login', 'logout', 'dashboard', 'permission', 'notifications');

		$files = glob(APPPATH .'/controllers/'.'*.php');

		$data['paths'] = array();
		foreach ($files as $file) {
			$file_name = basename($file, '.php');
			if (!in_array($file_name, $ignore_path)) {
				$data['paths'][] = array(
					'name'				=> ''. $file_name,
					'description'		=> 'Ability to access or modify '. str_replace('_', ' ', $file_name)
				);
			}
		}

		$this->load->model('Extensions_model');
		$extensions = $this->Extensions_model->getList();
		$data['module_paths'] = $data['payment_paths'] = array();
		foreach ($extensions as $key => $modules) {
			foreach ($modules as $module) {
				if (!in_array($module['name'], $ignore_path)) {
					$data[$key.'_paths'][] = array(
						'name'				=> ''. $module['name'],
						'description'		=> 'Ability to access or modify '. str_replace('_', ' ', $module['name'])
					);
				}
			}
		}

		if ($this->input->post() AND $staff_group_id = $this->_saveStaffGroup()) {
			if ($this->input->post('save_close') === '1') {
				redirect('staff_groups');
			}

			redirect('staff_groups/edit?id='. $staff_group_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('staff_groups_edit', $data);
	}

	private function _saveStaffGroup() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($staff_group_id = $this->Staff_groups_model->saveStaffGroup($this->input->get('id'), $this->input->post())) { // calls model to save data to SQL
				$this->alert->set('success', 'Staff Groups ' . $save_type . ' successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

			return $staff_group_id;
		}
	}

	private function _deleteStaffGroup() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Staff_groups_model->deleteStaffGroup($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Staff Groups': 'Staff Group';
                $this->alert->set('success', $prefix.' deleted successfully.');
            } else {
                $this->alert->set('warning', 'An error occurred, nothing deleted.');
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('staff_group_name', 'Group Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('location_access', 'Location Access', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('permission[access][]', 'Access Permission', 'xss_clean|trim');
		$this->form_validation->set_rules('permission[modify][]', 'Modify Permission', 'xss_clean|trim');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file staff_groups.php */
/* Location: ./admin/controllers/staff_groups.php */