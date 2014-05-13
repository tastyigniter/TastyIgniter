<?php
class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Pages_model');
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/pages')) {
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
		
		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $this->input->get('filter_status');
			$data['filter_status'] = $filter['filter_status'];
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = '';
			$data['filter_status'] = '';
		}
		
		$data['heading'] 			= 'Pages';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no pages available.';

		$data['pages'] = array();
		$results = $this->Pages_model->getList($filter);
		foreach ($results as $result) {					
			$data['pages'][] = array(
				'page_id'			=> $result['page_id'],
				'name'				=> $result['name'],
				'language'			=> $result['language_name'],
				'date_updated'		=> mdate('%d %M %y - %H:%i', strtotime($result['date_updated'])),
				'status'			=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'preview' 			=> site_url('main/pages/page/'. $result['page_id']),
				'edit' 				=> site_url('admin/pages/edit?id='. $result['page_id'])
			);
		}

		$config['base_url'] 		= site_url('admin/pages').$url;
		$config['total_rows'] 		= $this->Pages_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deletePage() === TRUE) {
			redirect('admin/pages');  			
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'pages.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'pages', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'pages', $regions, $data);
		}
	}

	public function edit() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/pages')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /rating_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$page_id = $this->input->get('id');
			$data['action']	= site_url('admin/pages/edit?id='. $page_id);
		} else {
		    $page_id = 0;
			$data['action']	= site_url('admin/pages/edit');
		}
		
		$result = $this->Pages_model->getPage($page_id);
		
		$data['heading'] 			= 'Pages - '. $result['name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/pages');

		$data['page_id'] 			= $result['page_id'];
		$data['language_id'] 		= $result['language_id'];
		$data['name'] 				= $result['name'];
		$data['page_title'] 		= $result['title'];
		$data['page_heading'] 		= $result['heading'];
		$data['content'] 			= html_entity_decode($result['content']);
		$data['meta_description'] 	= $result['meta_description'];
		$data['meta_keywords'] 		= $result['meta_keywords'];
		$data['layout_id'] 			= $result['layout_id'];
		$data['status'] 			= $result['status'];

		$this->load->model('Design_model');

		$data['layouts'] = array();
		$results = $this->Design_model->getLayouts();
		foreach ($results as $result) {					
			$data['layouts'][] = array(
				'layout_id'		=> $result['layout_id'],
				'name'			=> $result['name']
			);
		}
		
		$this->load->model('Languages_model');
		$data['languages'] = array();
		$results = $this->Languages_model->getLanguages();
		foreach ($results as $result) {					
			$data['languages'][] = array(
				'language_id'	=> $result['language_id'],
				'name'			=> $result['name']
			);
		}
		
		if ($this->input->post() AND $this->_addPage() === TRUE) {
			redirect('admin/pages');  			
		}

		if ($this->input->post() AND $this->_updatePage() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/pages');
			}
			
			redirect('admin/pages/edit?id='. $page_id);
		}

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'pages_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'pages_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'pages_edit', $regions, $data);
		}
	}

	public function _addPage() {
    	if (!$this->user->hasPermissions('modify', 'admin/pages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['language_id'] 		= $this->input->post('language_id');
			$add['name'] 				= $this->input->post('name');
			$add['title'] 				= $this->input->post('title');
			$add['heading'] 			= $this->input->post('heading');
			$add['content'] 			= $this->input->post('content');
			$add['meta_description'] 	= $this->input->post('meta_description');
			$add['meta_keywords'] 		= $this->input->post('meta_keywords');
			$add['layout_id'] 			= $this->input->post('layout_id');
			$add['date_added'] 			= mdate('%Y-%m-%d %H:%i:%s', time());
			$add['date_updated'] 		= mdate('%Y-%m-%d %H:%i:%s', time());
			$add['status'] 				= $this->input->post('status');

			if ($this->Pages_model->addPage($add)) {	
				$this->session->set_flashdata('alert', '<p class="success">Page Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}
	}
	
	public function _updatePage() {
    	if (!$this->user->hasPermissions('modify', 'admin/pages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['page_id'] 				= $this->input->get('id');
			$update['language_id'] 			= $this->input->post('language_id');
			$update['name'] 				= $this->input->post('name');
			$update['title'] 				= $this->input->post('title');
			$update['heading'] 				= $this->input->post('heading');
			$update['content'] 				= $this->input->post('content');
			$update['meta_description'] 	= $this->input->post('meta_description');
			$update['meta_keywords'] 		= $this->input->post('meta_keywords');
			$update['layout_id'] 			= $this->input->post('layout_id');
			$update['date_updated'] 		= mdate('%Y-%m-%d %H:%i:%s', time());
			$update['status'] 				= $this->input->post('status');

			if ($this->Pages_model->updatePage($update)) {	
				$this->session->set_flashdata('alert', '<p class="success">Page Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}		
	}	
	
	public function _deletePage() {
    	if (!$this->user->hasPermissions('modify', 'admin/pages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$page_id = $value;
					$this->Pages_model->deletePage($page_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Page(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('language_id', 'Language', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('heading', 'Heading', 'xss_clean|trim|required|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('content', 'Content', 'trim|required|min_length[2]|max_length[5028]');
		$this->form_validation->set_rules('meta_description', 'Meta Description', 'xss_clean|trim|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'xss_clean|trim|min_length[2]|max_length[255]');
		$this->form_validation->set_rules('layout_id', 'Layout', 'xss_clean|trim|integer');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/admin/pages.php */