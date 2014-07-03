<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Staff_groups extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Staff_groups_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/staff_groups')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Staff Groups');
		$this->template->setHeading('Staff Groups');
		$this->template->setButton('+ New', array('class' => 'btn btn-success', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-default', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There is no staff group available.';

		//load ratings data into array
		$data['staff_groups'] = array();
		$results = $this->Staff_groups_model->getStaffGroups();
		foreach ($results as $result) {					
			$data['staff_groups'][] = array(
				'staff_group_id'		=> $result['staff_group_id'],
				'staff_group_name'		=> $result['staff_group_name'],
				'edit'					=> site_url(ADMIN_URI.'/staff_groups/edit?id=' . $result['staff_group_id'])
			);
		}
		
		if ($this->input->post('delete') AND $this->_deleteStaffGroup() === TRUE) {
		    redirect(ADMIN_URI.'/staff_groups');
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'staff_groups.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'staff_groups', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'staff_groups', $data);
		}
	}

	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/staff_groups')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$group_info = $this->Staff_groups_model->getStaffGroup((int) $this->input->get('id'));
		
		if ($group_info) {
			$staff_group_id = $group_info['staff_group_id'];
			$data['action']	= site_url(ADMIN_URI.'/staff_groups/edit?id='. $staff_group_id);
		} else {
		    $staff_group_id = 0;
			$data['action']	= site_url(ADMIN_URI.'/staff_groups/edit');
		}

		$title = (isset($group_info['staff_group_name'])) ? $group_info['staff_group_name'] : 'New';	
		$this->template->setTitle('Staff Group: '. $title);
		$this->template->setHeading('Staff Group: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/staff_groups'));

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
	
		$ignore_path = array('login', 'logout', 'dashboard', 'permission', 'alerts');

		$files = glob(APPPATH .'/controllers/'.ADMIN_URI.'/*.php');
	
		$data['paths'] = array();
		foreach ($files as $file) {
			$file_name = basename($file, '.php');
			if (!in_array($file_name, $ignore_path)) {
				$data['paths'][] = array(
					'name'				=> ADMIN_URI.'/'. $file_name,
					'description'		=> 'Ability to access or modify '. str_replace('_', ' ', $file_name)
				);
			}
		}
		
		$mods_ext = glob(EXTPATH .'modules/*');
		$data['module_paths'] = array();
		foreach ($mods_ext as $file) {
			$file_name = basename($file, '.php');
			if (is_dir($file) AND !in_array($file_name, $ignore_path)) {
				$data['module_paths'][] = array(
					'name'				=> ADMIN_URI.'/'. $file_name,
					'description'		=> 'Ability to access or modify '. str_replace('_', ' ', $file_name)
				);
			}
		}
		
		$payment_ext = glob(EXTPATH .'payments/*');
		$data['payment_paths'] = array();
		foreach ($payment_ext as $file) {
			$file_name = basename($file, '.php');
			if (is_dir($file) AND !in_array($file_name, $ignore_path)) {
				$data['payment_paths'][] = array(
					'name'				=> ADMIN_URI.'/'. $file_name,
					'description'		=> 'Ability to access or modify '. str_replace('_', ' ', $file_name)
				);
			}
		}
		
		if ($this->input->post() AND $this->_addStaffGroup() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/staff_groups');
			}
			
			redirect(ADMIN_URI.'/staff_groups/edit?id='. $this->input->post('id'));
		}

		if ($this->input->post() AND $this->_updateStaffGroup() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/staff_groups');
			}
			
			redirect(ADMIN_URI.'/staff_groups/edit?id='. $staff_group_id);
		}
		
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'staff_groups_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'staff_groups_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'staff_groups_edit', $data);
		}
	}

	public function _addStaffGroup() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/staff_groups')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();

			$add['staff_group_name']	= $this->input->post('staff_group_name');
			$add['location_access']		= $this->input->post('location_access');
			
			if ($this->input->post('permission')) {
				$add['permission'] = serialize($this->input->post('permission'));
			} else {
				$add['permission'] = serialize(array('EMPTY'));
			}

			if ($id = $this->Staff_groups_model->addStaffGroup($add)) { // calls model to save data to SQL
				$this->session->set_flashdata('alert', '<p class="alert-success">Staff Groups added sucessfully.</p>');
				$_POST['insert_id'] = $id;
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');
			}
		
			return TRUE;
		}
	}

	public function _updateStaffGroup() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/staff_groups')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();

			$update['staff_group_id']		= $this->input->get('id');
			$update['staff_group_name']		= $this->input->post('staff_group_name');
			$update['location_access']		= $this->input->post('location_access');
		
			if ($this->input->post('permission')) {
				$update['permission'] = serialize($this->input->post('permission'));
			} else {
				$update['permission'] = serialize(array());
			}

			if ($this->Staff_groups_model->updateStaffGroup($update)) { // calls model to save data to SQL
				$this->session->set_flashdata('alert', '<p class="alert-success">Staff Group updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');
			}
		
			return TRUE;
		}
	}	

	public function _deleteStaffGroup() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/staff_groups')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $staff_group_id) {
				$this->Staff_groups_model->deleteStaffGroup($staff_group_id);
			}			
		
			$this->session->set_flashdata('alert', '<p class="alert-success">Staff Group(s) deleted sucessfully!</p>');
		}
				
		return TRUE;
	}
	
	public function validateForm() {
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
/* Location: ./application/controllers/admin/staff_groups.php */