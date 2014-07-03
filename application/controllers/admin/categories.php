<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Categories extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Menus_model'); // load the menus model
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/categories')) {
  			redirect(ADMIN_URI.'/permission');
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
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'category_id';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC';
		}

		$this->template->setTitle('Categories');
		$this->template->setHeading('Categories');
		$this->template->setButton('+ New', array('class' => 'btn btn-success', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-default', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no categories available.';
		
		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url(ADMIN_URI.'/categories'.$url.'sort_by=name&order_by='.$order_by);
		$data['sort_id'] 			= site_url(ADMIN_URI.'/categories'.$url.'sort_by=category_id&order_by='.$order_by);

		$categories = array();				
		$results = $this->Menus_model->getCategoriesList($filter);
		$data['categories'] = array();
		foreach ($results as $result) {
			//load categories data into array
			$data['categories'][] = array(
				'category_id' 			=> $result['category_id'],
				'name' 					=> $result['name'],
				'description' 			=> substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'edit' 					=> site_url(ADMIN_URI.'/categories/edit?id=' . $result['category_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url(ADMIN_URI.'/categories').$url;
		$config['total_rows'] 		= $this->Menus_model->getAdminCategoriesListCount($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteCategory() === TRUE) {

			redirect(ADMIN_URI.'/categories');  			
		}	
				
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'categories.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'categories', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'categories', $data);
		}
	}

	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/categories')) {
  			redirect(ADMIN_URI.'/permission');
		}

		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}
		
		$category_info = $this->Menus_model->getCategory((int) $this->input->get('id'));

		if ($category_info) {
			$category_id = $category_info['category_id'];
			$data['action']	= site_url(ADMIN_URI.'/categories/edit?id='. $category_id);
		} else {
		    $category_id = 0;
			$data['action']	= site_url(ADMIN_URI.'/categories/edit');
		}

		$title = (isset($category_info['name'])) ? $category_info['name'] : 'New';	
		$this->template->setTitle('Category: '. $title);
		$this->template->setHeading('Category: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn-back', site_url(ADMIN_URI.'/categories'));
	
		$data['category_id'] 		= $category_info['category_id'];
		$data['name'] 				= $category_info['name'];
		$data['description'] 		= $category_info['description'];

		$this->load->model('Permalinks_model');
		$data['permalink'] 			= $this->Permalinks_model->getPermalink('category_id='.$category_info['category_id']);

		if ($this->input->post() AND $this->_addCategory() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect(ADMIN_URI.'/categories/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect(ADMIN_URI.'/categories');
			}
		}

		if ($this->input->post() AND $this->_updateCategory() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect(ADMIN_URI.'/categories');
			}
			
			redirect(ADMIN_URI.'/categories/edit?id='. $category_id);
		}
	
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'categories_edit.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'categories_edit', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'categories_edit', $data);
		}
	}

	
	public function _addCategory() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/categories')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['name'] 			= $this->input->post('name');
			$add['permalink'] 		= $this->input->post('permalink');
			$add['description'] 	= $this->input->post('description');
				
			if ($_POST['insert_id'] = $this->Menus_model->addCategory($add)) {	
				$this->session->set_flashdata('alert', '<p class="alert-success">Category added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing added.</p>');
			}
			
			return TRUE;
		}
	}	
	
	public function _updateCategory() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/categories')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['category_id'] 	= $this->input->get('id');
			$update['name'] 		= $this->input->post('name');
			$update['permalink'] 	= $this->input->post('permalink');
			$update['description'] 	= $this->input->post('description');
			
			if ($this->Menus_model->updateCategory($update)) {				
				$this->session->set_flashdata('alert', '<p class="alert-success">Category updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');
			}
			
			return TRUE;
		}
	}

	public function _deleteCategory() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/categories')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Menus_model->deleteCategory($value);
			}			
		
			$this->session->set_flashdata('alert', '<p class="alert-success">Category(s) deleted sucessfully!</p>');
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean|trim|min_length[2]|max_length[1028]');
		$this->form_validation->set_rules('permalink', 'Permalink', 'xss_clean|trim|alpha_dash|max_length[255]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */