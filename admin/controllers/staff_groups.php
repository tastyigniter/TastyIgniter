<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Staff_groups extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor
        $this->user->restrict('Admin.StaffGroups');
        $this->load->model('Staff_groups_model');
        $this->load->model('Permissions_model');
    }

	public function index() {
        $this->template->setTitle('Staff Groups');
		$this->template->setHeading('Staff Groups');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There is no staff group available.';

		//load ratings data into array
		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getList();
		foreach ($results as $result) {
			$data['staff_groups'][] = array(
				'staff_group_id'		=> $result['staff_group_id'],
				'staff_group_name'		=> $result['staff_group_name'],
				'users_count'		    => $this->Staff_groups_model->getUsersCount($result['staff_group_id']),
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
			$data['_action']	= site_url('staff_groups/edit?id='. $staff_group_id);
		} else {
		    $staff_group_id = 0;
			$data['_action']	= site_url('staff_groups/edit');
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

        if ($this->input->post('permissions')) {
            $group_permissions = $this->input->post('permissions');
        } else if (isset($group_info['permissions'])) {
            $group_permissions =  unserialize($group_info['permissions']);
        }

        $data['permissions_list'] = array();
        $results = $this->Permissions_model->getPermissions();
        foreach ($results as $domain => $permissions) {

            foreach ($permissions as $permission) {

                $data['permissions_list'][$domain][] = array(
                    'permission_id'     => $permission['permission_id'],
                    'name'              => $permission['name'],
                    'domain'            => $permission['domain'],
                    'controller'        => $permission['controller'],
                    'description'       => $permission['description'],
                    'action'            => $permission['action'],
                    'group_permissions' => (!empty($group_permissions[$permission['permission_id']])) ? $group_permissions[$permission['permission_id']] : array(),
                    'status'            => $permission['status']
                );
            }
        }

//		if (isset($permission['access'])) {
//			$data['access'] = $permission['access'];
//		} else {
//			$data['access'] = array();
//		}
//
//		if (isset($permission['modify'])) {
//			$data['manage'] = $permission['modify'];
//		} else if (isset($permission['manage'])) {
//			$data['manage'] = $permission['manage'];
//		} else {
//			$data['manage'] = array();
//		}
//
//		if (isset($permission['add'])) {
//			$data['add'] = $permission['add'];
//		} else {
//			$data['add'] = array();
//		}
//
//		if (isset($permission['delete'])) {
//			$data['delete'] = $permission['delete'];
//		} else {
//			$data['delete'] = array();
//		}

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
        if ($this->input->post('permissions')) {
            foreach ($this->input->post('permissions') as $key => $permissions) {
                foreach ($permissions as $k => $permission) {
                    $this->form_validation->set_rules('permissions[' . $key . '][' . $k . ']', ucfirst($permission) . ' Permission', 'xss_clean|trim|alpha|max_length[6]');
                }
                //            $this->form_validation->set_rules('permission['.$key.'][]', 'Manage Permission', 'xss_clean|trim|alpha|max_length[6]');
                //            $this->form_validation->set_rules('permission['.$key.'][]', 'Add Permission', 'xss_clean|trim|alpha|max_length[6]');
                //            $this->form_validation->set_rules('permission['.$key.'][]', 'Delete Permission', 'xss_clean|trim|alpha|max_length[6]');
            }
        }

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file staff_groups.php */
/* Location: ./admin/controllers/staff_groups.php */