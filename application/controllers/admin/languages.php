<?php
class Languages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Languages_model');
	}

	public function index() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/languages')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
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
		
		$data['heading'] 			= 'Languages';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no languages available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_name'] 			= site_url('admin/languages'.$url.'sort_by=name&order_by='.$order_by);
		$data['sort_code'] 			= site_url('admin/languages'.$url.'sort_by=code&order_by='.$order_by);

		$data['language_id'] = $this->config->item('language_id');

		$data['languages'] = array();
		$results = $this->Languages_model->getList($filter);
		foreach ($results as $result) {					
			$data['languages'][] = array(
				'language_id'		=> $result['language_id'],
				'name'				=> $result['name'],
				'code'				=> $result['code'],
				'image'				=> base_url('assets/img/flags/'. $result['image']),
				'status'			=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 				=> site_url('admin/languages/edit?id=' . $result['language_id'])
			);
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/languages').$url;
		$config['total_rows'] 		= $this->Languages_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteLanguage() === TRUE) {
			redirect('admin/languages');  			
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'languages.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'languages', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'languages', $regions, $data);
		}
	}
	
	public function edit() {
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/languages')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		if (is_numeric($this->input->get('id'))) {
			$language_id = (int)$this->input->get('id');
			$data['action']	= site_url('admin/languages/edit?id='. $language_id);
		} else {
		    $language_id = 0;
			$data['action']	= site_url('admin/languages/edit');
		}
		
		$result = $this->Languages_model->getLanguage($language_id);
		
		$data['heading'] 			= 'Languages - '. $result['name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/languages');

		$data['language_id'] 		= $result['language_id'];
		$data['name'] 				= $result['name'];
		$data['code'] 				= $result['code'];
		$data['image'] 				= $result['image'];
		$data['image_url'] 			= base_url('assets/img/flags/'. $result['image']);
		$data['directory'] 			= $result['directory'];
		$data['status'] 			= $result['status'];

		$flags = glob(IMAGEPATH .'/flags/*.png');
	
		$data['flags'] = array();
		foreach ($flags as $flag) {
			$flag_name = basename($flag, '.png');

			$data['flags'][] = array(
				'name' 		=> strtoupper($flag_name),
				'file' 		=> $flag_name .'.png'
			);		
		}

		if ($this->input->post() && $this->_addLanguage() === TRUE) {
			redirect('/admin/languages');
		}

		if ($this->input->post() && $this->_updateLanguage() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/languages');
			}
			
			redirect('admin/languages/edit?id='. $language_id);
		}
		
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'languages_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'languages_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'languages_edit', $regions, $data);
		}
	}

	public function _addLanguage() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/languages')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
  	
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['name'] 		= $this->input->post('name');
			$add['code'] 		= $this->input->post('code');
			$add['image'] 		= $this->input->post('image');
			$add['directory'] 	= $this->input->post('directory');
			$add['status'] 		= $this->input->post('status');
			
			if ($this->Languages_model->addLanguage($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Language Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			}
							
			return TRUE;
		}	
	}
	
	public function _updateLanguage() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/languages')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
  	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['language_id'] 	= $this->input->get('id');
			$update['name'] 		= $this->input->post('name');
			$update['code'] 		= $this->input->post('code');
			$update['image'] 		= $this->security->sanitize_filename($this->input->post('image'));
			$update['directory'] 	= $this->input->post('directory');
			$update['status'] 		= $this->input->post('status');
			
			if ($this->Languages_model->updateLanguage($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Language Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			}
							
			return TRUE;
		}	
	}	

	public function _deleteLanguage() {
    	if (!$this->user->hasPermissions('modify', 'admin/languages')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$language_id = $value;
					$this->Languages_model->deleteLanguage($language_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Language Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}
	
	public function validateForm() {
		$this->form_validation->set_rules('name', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('code', 'Code', 'xss_clean|trim|required|min_length[2]');
		$this->form_validation->set_rules('image', 'Image', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('directory', 'Directory', 'xss_clean|trim|required|min_length[2]|max_length[32]|callback_valid_dir');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}

	public function valid_dir($str) {
		if (!file_exists(APPPATH .'language/'. $str)) {
			$this->form_validation->set_message('valid_dir', 'The specified directory name does not exist in the language folder');
			return FALSE;
		} else {																				// else validation is successful
			return TRUE;
		}
	}
}

/* End of file languages.php */
/* Location: ./application/controllers/admin/languages.php */