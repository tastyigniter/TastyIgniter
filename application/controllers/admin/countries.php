<?php
class Countries extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Countries_model');
	}

	public function index() {

		if ( !file_exists(APPPATH .'/views/admin/countries.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/countries')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}
				
		$data['heading'] 			= 'Countries';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new country</a></li>';
		$data['text_empty'] 		= 'There are no countries, please add!.';

		$data['countries'] = array();
		$results = $this->Countries_model->getList($filter);
		foreach ($results as $result) {					
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
				'status'		=>	$result['status'],
				'edit' 			=> $this->config->site_url('admin/countries/edit/' . $result['country_id'])
			);
		}

		$config['base_url'] 		= $this->config->site_url('admin/countries');
		$config['total_rows'] 		= $this->Countries_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post() && $this->_addCountry() === TRUE) {
		
			redirect('admin/countries');  			
		}

		//check if POST submit then remove food_id
		if ($this->input->post('delete') && $this->_deleteCountry() === TRUE) {
			
			redirect('admin/countries');  			
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/countries', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {

		if ( !file_exists(APPPATH .'/views/admin/countries_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/countries')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /rating_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$country_id = $this->uri->segment(4);
		} else {
		    redirect('admin/countries');
		}
		
		$result = $this->Countries_model->getCountry($country_id);
		
		if ($result) {
			$data['heading'] 			= 'Countries';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/countries');

			$data['country_name'] 		= $result['country_name'];
			$data['iso_code_2'] 		= $result['iso_code_2'];
			$data['iso_code_3'] 		= $result['iso_code_3'];
			$data['format'] 			= '';
			$data['status'] 			= $result['status'];

			//check if POST add_Ratings, validate fields and add Ratings to model
			if ($this->input->post() && $this->_updateCountry($country_id) === TRUE) {
						
				redirect('admin/countries');
			}
		}
				
		$this->load->view('admin/header', $data);
		$this->load->view('admin/countries_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addCountry() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/countries')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
		
			$this->form_validation->set_rules('country_name', 'Country', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('iso_code_2', 'ISO Code (2)', 'trim|required|exact_length[2]');
			$this->form_validation->set_rules('iso_code_3', 'ISO Code (3)', 'trim|required|exact_length[3]');
			$this->form_validation->set_rules('format', 'Format', 'trim');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				$add = array();
				
				$add['country_name'] 	= $this->input->post('country_name');
				$add['iso_code_2'] 		= $this->input->post('iso_code_2');
				$add['iso_code_3'] 		= $this->input->post('iso_code_3');
				$add['format'] 			= $this->input->post('format');
				$add['status'] 			= $this->input->post('status');
	
				if ($this->Countries_model->addCountry($add)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Country Added Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}
	
	public function _updateCountry($country_id) {
    	
    	if (!$this->user->hasPermissions('modify', 'admin/countries')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
		
			$this->form_validation->set_rules('country_name', 'Country', 'trim|required|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('iso_code_2', 'ISO Code (2)', 'trim|required|exact_length[2]');
			$this->form_validation->set_rules('iso_code_3', 'ISO Code (3)', 'trim|required|exact_length[3]');
			$this->form_validation->set_rules('format', 'Format', 'trim');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				$update['country_id'] 		= $country_id;
				$update['country_name'] 	= $this->input->post('country_name');
				$update['iso_code_2'] 		= $this->input->post('iso_code_2');
				$update['iso_code_3'] 		= $this->input->post('iso_code_3');
				$update['format'] 			= $this->input->post('format');
				$update['status'] 			= $this->input->post('status');
	
	
				if ($this->Countries_model->updateCountry($update)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Country Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}		
	}	
	
	public function _deleteCountry($country_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/countries')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$country_id = $value;
				
					$this->Countries_model->deleteCountry($country_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Country(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}