<?php
class Menu_options extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('currency'); // load the currency library
		$this->load->library('pagination');
		$this->load->model('Menus_model'); // load the menus model
	}

	public function index() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/menu_options')) {
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
		
		$data['heading'] 			= 'Menu Options';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no menu options, please add!.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_name'] 			= site_url('admin/menu_options'.$url.'sort_by=option_name&order_by='.$order_by);
		$data['sort_price'] 		= site_url('admin/menu_options'.$url.'sort_by=option_price&order_by='.$order_by);
		$data['sort_id'] 			= site_url('admin/menu_options'.$url.'sort_by=option_id&order_by='.$order_by);

		$data['menu_options'] = array();
		$results = $this->Menus_model->getOptionsList($filter);
		foreach ($results as $result) {
			$data['menu_options'][] = array(
				'option_id' 	=> $result['option_id'],
				'option_name' 	=> $result['option_name'],
				'option_price' 	=> $this->currency->format($result['option_price']),
				'edit' 			=> site_url('admin/menu_options/edit?id=' . $result['option_id'])
			);
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/menu_options').$url;
		$config['total_rows'] 		= $this->Menus_model->options_record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteMenuOption() === TRUE) {
			
			redirect('admin/menu_options');
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'menu_options.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'menu_options', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'menu_options', $regions, $data);
		}
	}
	
	public function edit() {
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/menu_options')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		if (is_numeric($this->input->get('id'))) {
			$option_id = $this->input->get('id');
			$data['action']	= site_url('admin/menu_options/edit?id='. $option_id);
		} else {
			$option_id = 0;
			$data['action']	= site_url('admin/menu_options/edit');
		}
		
		$option_info = $this->Menus_model->getMenuOption($option_id);
	
		$data['heading'] 			= 'Menus Option - ' . $option_info['option_name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/menu_options');

		$data['option_id'] 			= $option_info['option_id'];
		$data['option_name'] 		= $option_info['option_name'];
		$data['option_price'] 		= $option_info['option_price'];

		if ( ! $this->input->get('id') && $this->input->post() && $this->_addMenuOpiton() === TRUE) {
			
			redirect('admin/menu_options');
		}

		if ($this->input->get('id') && $this->input->post() && $this->_updateMenuOption() === TRUE){
			if ($this->input->post('save_close') === '1') {
				redirect('admin/menu_options');
			}
			
			redirect('admin/menu_options/edit?id='. $option_id);
		}
					
		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'menu_options_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'menu_options_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'menu_options_edit', $regions, $data);
		}
	}

	public function autocomplete() {
		$json = array();
		
		if ($this->input->get('option_name')) {
			$filter_data = array();
			$filter_data = array(
				'option_name' => $this->input->get('option_name')
			);
		}
		
		$results = $this->Menus_model->getOptionsAutoComplete($filter_data);

		if ($results) {
			foreach ($results as $result) {
				$json[] = array(
					'option_id' 	=> $result['option_id'],
					'option_name' 	=> $result['option_name'],
					'option_price' 	=> $result['option_price']
				);
			}
		}
		
		$this->output->set_output(json_encode($json));
	}
	
	public function _addMenuOpiton() {

    	if (!$this->user->hasPermissions('modify', 'admin/menu_options')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
	
			//Sanitizing the POST values
			$add['option_name'] = $this->input->post('option_name');
			$add['option_price'] = $this->input->post('option_price');	
										
			if ($this->Menus_model->addMenuOption($add)) {
			
				$this->session->set_flashdata('alert', '<p class="success">Menu Option Added Sucessfully!</p>');
			} else {
			
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
			
			return TRUE;
		}
	}

	public function _updateMenuOption() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/menu_options')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
		
			//Sanitizing the POST values
			$update['option_id'] 		= $this->input->get('id');
			$update['option_name'] 		= $this->input->post('option_name');
			$update['option_price'] 	= $this->input->post('option_price');	

			if ($this->Menus_model->updateMenuOption($update)) {						
		
				$this->session->set_flashdata('alert', '<p class="success">Menu Option Updated Sucessfully!</p>');
			} else {
		
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}
	}

	public function _deleteMenuOption($option_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/menu_options')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$option_id = $value;
					$this->Menus_model->deleteMenuOption($option_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Menu Option(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}
	
	public function validateForm() {
		$this->form_validation->set_rules('option_name', 'Option Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('option_price', 'Option Price', 'xss_clean|trim|required|numeric');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file menu_options.php */
/* Location: ./application/controllers/admin/menu_options.php */