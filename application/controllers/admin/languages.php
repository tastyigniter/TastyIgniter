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
			$filter['filter_search'] = $data['filter_search'] = $this->input->get('filter_search');
			$url .= 'filter_search='.$filter['filter_search'].'&';
		} else {
			$data['filter_search'] = '';
		}
		
		if (is_numeric($this->input->get('filter_status'))) {
			$filter['filter_status'] = $data['filter_status'] = $this->input->get('filter_status');
			$url .= 'filter_status='.$filter['filter_status'].'&';
		} else {
			$filter['filter_status'] = $data['filter_status'] = '';
		}
		
		if ($this->input->get('sort_by')) {
			$filter['sort_by'] = $data['sort_by'] = $this->input->get('sort_by');
		} else {
			$filter['sort_by'] = $data['sort_by'] = 'language_id';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'DESC';
			$data['order_by_active'] = 'DESC';
		}
		
		$this->template->setTitle('Languages');
		$this->template->setHeading('Languages');
		$this->template->setButton('+ New', array('class' => 'add_button', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'delete_button', 'onclick' => '$(\'form:not(#filter-form)\').submit();'));

		$data['text_empty'] 		= 'There are no languages available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
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

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
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

		if ($this->input->post('delete') AND $this->_deleteLanguage() === TRUE) {
			redirect('admin/languages');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'languages.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'languages', $data);
		} else {
			$this->template->render('themes/admin/default/', 'languages', $data);
		}
	}
	
	public function edit() {
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/languages')) {
  			redirect('admin/permission');
		}
		
		if (is_numeric($this->input->get('id'))) {
			$language_id = $this->input->get('id');
			$data['action']	= site_url('admin/languages/edit?id='. $language_id);
		} else {
		    $language_id = 0;
			$data['action']	= site_url('admin/languages/edit');
		}
		
		if ($this->input->post() AND $this->_addLanguage() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect('admin/languages/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('admin/languages');
			}
		}

		if ($this->input->post() AND $this->_updateLanguage() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/languages');
			}
			
			redirect('admin/languages/edit?id='. $language_id);
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}		

		$result = $this->Languages_model->getLanguage($language_id);
		
		$title = (isset($result['name'])) ? 'Edit - '. $result['name'] : 'New';	
		$this->template->setTitle('Languages: '. $title);
		$this->template->setHeading('Languages: '. $title);
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'save_close_button', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('back_button', site_url('admin/languages'));

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

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'languages_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'languages_edit', $data);
		} else {
			$this->template->render('themes/admin/default/', 'languages_edit', $data);
		}
	}

	public function _addLanguage() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/languages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['name'] 		= $this->input->post('name');
			$add['code'] 		= $this->input->post('code');
			$add['image'] 		= $this->input->post('image');
			$add['directory'] 	= $this->input->post('directory');
			$add['status'] 		= $this->input->post('status');
			
			if ($_POST['insert_id'] = $this->Languages_model->addLanguage($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Language added sucessfully.</p>');
				return TRUE;
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing added.</p>');
				return FALSE
				;
			}
		}	
	}
	
	public function _updateLanguage() {
    	if ( ! $this->user->hasPermissions('modify', 'admin/languages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['language_id'] 	= $this->input->get('id');
			$update['name'] 		= $this->input->post('name');
			$update['code'] 		= $this->input->post('code');
			$update['image'] 		= $this->security->sanitize_filename($this->input->post('image'));
			$update['directory'] 	= $this->input->post('directory');
			$update['status'] 		= $this->input->post('status');
			
			if ($this->Languages_model->updateLanguage($update)) {
				$this->session->set_flashdata('alert', '<p class="success">Language updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing added.</p>');				
			}
							
			return TRUE;
		}	
	}	

	public function _deleteLanguage() {
    	if (!$this->user->hasPermissions('modify', 'admin/languages')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Languages_model->deleteLanguage($value);
			}			
		
			$this->session->set_flashdata('alert', '<p class="success">Language deleted sucessfully!</p>');
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