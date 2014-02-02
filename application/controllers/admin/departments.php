<?php
class Departments extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Departments_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists(APPPATH .'/views/admin/departments.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/departments')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Departments';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new department</a></li>';
		$data['text_empty'] 		= 'There are no department(s) added in your database.';

		//load ratings data into array
		$data['departments'] = array();
		$results = $this->Departments_model->getDepartments();
		foreach ($results as $result) {					
			$data['departments'][] = array(
				'department_id'		=>	$result['department_id'],
				'department_name'	=>	$result['department_name'],
				'edit'				=> $this->config->site_url('admin/departments/edit/' . $result['department_id'])
			);
		}
		
		$ignore_path = array(
			'admin/login',
			'admin/logout',
			'admin/dashboard',
			'common/forgotten'
		);

	
		$files = glob(APPPATH .'/controllers/admin/*.php');
		$extension_files = glob(APPPATH .'extensions/admin/controllers/*.php');
	
		$paths = array();
		foreach (array_merge($files, $extension_files) as $file) {
			$file_name = 'admin/'. basename($file, '.php');

			if (!in_array($file_name, $ignore_path)) {
				$paths[] = $file_name;
			}
		}
		
		$data['paths'] = $paths;

		// check POST submit, validate fields and send quantity data to model
		if ($this->input->post() && $this->_addDepartment() === TRUE) {
		
		    redirect('admin/departments');
		}

		//check if POST submit then remove quantity_id
		if ($this->input->post('delete') && $this->_deleteDepartment() === TRUE) {
			
		    redirect('admin/departments');
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/departments', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {

		if ( !file_exists(APPPATH .'/views/admin/departments_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/departments')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		//check if customer_id is set in uri string
		if ($this->uri->segment(4)) {
			$department_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/departments');
		}

		$department_info = $this->Departments_model->getDepartment($department_id);
		
		if ($department_info) {
			$data['heading'] 			= 'Departments';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/departments');

			if (isset($this->input->post['department_name'])) {
				$data['department_name'] = $this->input->post['department_name'];
			} elseif (isset($department_info['department_name'])) {
				$data['department_name'] = $department_info['department_name'];
			} else { 
				$data['department_name'] = '';
			}

			$permission = $this->input->post('permission');

			if (isset($permission['access'])) {
				$data['access'] = $permission['access'];
			} elseif (isset($department_info['permission']['access'])) {
				$data['access'] = $department_info['permission']['access'];
			} else { 
				$data['access'] = array();
			}

			if (isset($permission['modify'])) {
				$data['modify'] = $permission['modify'];
			} elseif (isset($department_info['permission']['modify'])) {
				$data['modify'] = $department_info['permission']['modify'];
			} else { 
				$data['modify'] = array();
			}
		
			$ignore_path = array(
				'admin/login',
				'admin/logout',
				'admin/permission',
				'admin/dashboard',
				'admin/alerts'
			);

			$files = glob(APPPATH .'/controllers/admin/*.php');
			$extension_files = glob(APPPATH .'extensions/admin/controllers/*.php');
	
			$paths = array();
			foreach (array_merge($files, $extension_files) as $file) {
				$file_name = 'admin/'. basename($file, '.php');

				if (!in_array($file_name, $ignore_path)) {
					$paths[] = $file_name;
				}
			}
		
			$data['paths'] = $paths;

			if ($this->input->post() && $this->_updateDepartment($department_id) === TRUE) {
			
				redirect('admin/departments');
	
			}
		}
		
		//load customer_edit page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/departments_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addDepartment() {

    	if (!$this->user->hasPermissions('modify', 'admin/departments')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else { 
								
			//form validation
			$this->form_validation->set_rules('department_name', 'Department', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('permission[access][]', 'Access Permission', 'trim');
			$this->form_validation->set_rules('permission[modify][]', 'Modify Permission', 'trim');

			//if validation is true
			if ($this->form_validation->run() === TRUE) {
				$add = array();

				//Sanitizing the POST values
				$add['department_name']	= $this->input->post('department_name');
				
				if ($this->input->post('permission')) {
					$add['permission'] = $this->input->post('permission');
				} else {
					$add['permission'] = array('EMPTY');
				}

				if ($this->Departments_model->addDepartment($add)) { // calls model to save data to SQL
				
					$this->session->set_flashdata('alert', '<p class="success">Departments Added Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
				}
			
				return TRUE;
			}	
		}
	}

	public function _updateDepartment($department_id) {
    	if (!$this->user->hasPermissions('modify', 'admin/departments')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
								
			//form validation
			$this->form_validation->set_rules('department_name', 'Department', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('permission[access][]', 'Access Permission', 'trim');
			$this->form_validation->set_rules('permission[modify][]', 'Modify Permission', 'trim');

			//if validation is true
			if ($this->form_validation->run() === TRUE) {
				$update = array();

				//Sanitizing the POST values
				$update['department_id']		= $department_id;
				$update['department_name']		= $this->input->post('department_name');
			
				if ($this->input->post('permission')) {
					$update['permission'] = $this->input->post('permission');
				} else {
					$update['permission'] = array();
				}


				if ($this->Departments_model->updateDepartment($update)) { // calls model to save data to SQL
				
					$this->session->set_flashdata('alert', '<p class="success">Department Updated Sucessfully!</p>');
			
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');
			
				}
			
				return TRUE;
			}
		}
	}	

	public function _deleteDepartment() {
    	if (!$this->user->hasPermissions('modify', 'admin/departments')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[remove_deal] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$department_id = $value;
				
					$this->Departments_model->deleteDepartment($department_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Departments(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}