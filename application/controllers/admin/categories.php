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
			$filter['filter_search'] = $this->input->get('filter_search');
			$data['filter_search'] = $filter['filter_search'];
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $this->input->get('sort_by');
			$data['sort_by'] = $filter['sort_by'];
		} else {
			$filter['sort_by'] = '';
			$data['sort_by'] = '';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = strtolower($this->input->get('order_by')) .' active';
			$data['order_by'] = strtolower($this->input->get('order_by'));
		} else {
			$filter['order_by'] = '';
			$data['order_by_active'] = '';
			$data['order_by'] = 'desc';
		}

		$data['heading'] 			= 'Categories';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no categories available.';
		
		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_name'] 			= site_url('admin/categories'.$url.'sort_by=category_name&order_by='.$order_by);
		$data['sort_id'] 			= site_url('admin/categories'.$url.'sort_by=category_id&order_by='.$order_by);

		$categories = array();				
		$results = $this->Menus_model->getCategoriesList($filter);
		$data['categories'] = array();
		foreach ($results as $result) {
			//load categories data into array
			$data['categories'][] = array(
				'category_id' 			=> $result['category_id'],
				'category_name' 		=> $result['category_name'],
				'category_description' 	=> substr(strip_tags(html_entity_decode($result['category_description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'edit' 					=> site_url('admin/categories/edit?id=' . $result['category_id'])
			);
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/categories').$url;
		$config['total_rows'] 		= $this->Menus_model->categories_record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteCategory() === TRUE) {

			redirect('admin/categories');  			
		}	
				
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'categories.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'categories', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'categories', $regions, $data);
		}
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
			$data['action']	= site_url('admin/categories/edit?id='. $category_id);
		} else {
		    $category_id = 0;
			$data['action']	= site_url('admin/categories/edit');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$category_info = $this->Menus_model->getCategory($category_id);

		$data['heading'] 				= 'Categories - '. $category_info['category_name'];
		$data['button_save'] 			= 'Save';
		$data['button_save_close'] 		= 'Save & Close';
		$data['sub_menu_back'] 			= site_url('admin/categories');
	
		$data['category_id'] 			= $category_info['category_id'];
		$data['category_name'] 			= $category_info['category_name'];
		$data['category_description'] 	= $category_info['category_description'];

		if ( ! $this->input->get('id') & $this->input->post() && $this->_addCategory() === TRUE) {
			redirect('admin/categories');
		}

		if ($this->input->get('id') && $this->input->post() && $this->_updateCategory() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/categories');
			}
			
			redirect('admin/categories/edit?id='. $category_id);
		}
	
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'categories_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'categories_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'categories_edit', $regions, $data);
		}
	}

	
	public function _addCategory() {
    	if (!$this->user->hasPermissions('modify', 'admin/categories')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
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
	
	public function _updateCategory() {
    	if (!$this->user->hasPermissions('modify', 'admin/categories')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
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

	public function _deleteCategory() {
    	if (!$this->user->hasPermissions('modify', 'admin/categories')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$category_id = $value;
					$this->Menus_model->deleteCategory($category_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Category(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('category_name', 'Category Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('category_description', 'Category Description', 'xss_clean|trim|min_length[2]|max_length[1028]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */