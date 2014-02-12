<?php
class Categories extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Menus_model'); // load the menus model
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/categories')) {
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
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		$data['heading'] 			= 'Categories';
		$data['sub_menu_add'] 		= 'Add new category';
		$data['sub_menu_delete'] 	= 'Delete';

		$categories = array();				
		$results = $this->Menus_model->getCategoriesList($filter);
		foreach ($results as $result) {
			//load categories data into array
			$data['categories'][] = array(
				'category_id' 			=> $result['category_id'],
				'category_name' 		=> $result['category_name'],
				'category_description' 	=> substr(strip_tags(html_entity_decode($result['category_description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'edit' 					=> $this->config->site_url('admin/categories/edit?id=' . $result['category_id'])
			);
		}

		$config['base_url'] 		= $this->config->site_url('admin/categories');
		$config['total_rows'] 		= $this->Menus_model->categories_record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteCategory() === TRUE) {

			redirect('admin/categories');  			
		}	
				
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/categories', $data);
	}

	public function edit() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/categories')) {
  			redirect('admin/permission');
		}
		
		//check if /category_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$category_id = $this->input->get('id');
			$data['action']	= $this->config->site_url('admin/categories/edit?id='. $category_id);
		} else {
		    $category_id = 0;
			$data['action']	= $this->config->site_url('admin/categories/edit');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$category_info = $this->Menus_model->getCategory($category_id);

		$data['heading'] 				= 'Categories - '. $category_info['category_name'];
		$data['sub_menu_save'] 			= 'Save';
		$data['sub_menu_back'] 			= $this->config->site_url('admin/categories');
	
		$data['category_id'] 			= $category_info['category_id'];
		$data['category_name'] 			= $category_info['category_name'];
		$data['category_description'] 	= $category_info['category_description'];

		if ( ! $this->input->get('id') & $this->input->post() && $this->_addCategory() === TRUE) {
			
			redirect('admin/categories');
		}

		if ($this->input->get('id') && $this->input->post() && $this->_updateCategory() === TRUE) {
					
			redirect('admin/categories');
		}
	
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/categories_edit', $data);
	}

	
	public function _addCategory() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/categories')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->get('id')) { 

			//validate category value
			$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('category_description', 'Category Description', 'trim|min_length[2]|max_length[1028]');

			if ($this->form_validation->run() === TRUE) {
			
				$category_name = $this->input->post('category_name');
				$category_description = $this->input->post('category_description');
					
				if ($this->Menus_model->addCategory($category_name, $category_description)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Category Added Sucessfully!</p>');
				
				} else {

					$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');

				}
				
				return TRUE;
			}
		}
	}	
	
	public function _updateCategory() {

    	if (!$this->user->hasPermissions('modify', 'admin/categories')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ($this->input->get('id')) { 
		
			$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('category_description', 'Category Description', 'trim|min_length[2]|max_length[1028]');

	  		if ($this->form_validation->run() === TRUE) {

				$category_id			= $this->input->get('id');
				$category_name 			= $this->input->post('category_name');
				$category_description 	= $this->input->post('category_description');
				
				if ($this->Menus_model->updateCategory($category_id, $category_name, $category_description)) {				

					$this->session->set_flashdata('alert', '<p class="success">Category Updated Sucessfully!</p>');
				} else {

					$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');

				}
				
				return TRUE;
			}
		}
	}

	public function _deleteCategory() {
    	if (!$this->user->hasPermissions('modify', 'admin/categories')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$category_id = $value;
				
					$this->Menus_model->deleteCategory($category_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Category(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}
