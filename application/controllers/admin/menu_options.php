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
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		
		if ( !file_exists(APPPATH .'/views/admin/menu_options.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

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

		$filter = array();
		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = 1;
		}
		
		if ($this->config->item('config_page_limit')) {
			$filter['limit'] = $this->config->item('config_page_limit');
		}

		$data['heading'] 			= 'Menu Options';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new menu option</a></li>';
		$data['text_empty'] 		= 'There are no menu options, please add!.';

		$data['menu_options'] = array();
		$results = $this->Menus_model->getOptionsList($filter);
		foreach ($results as $result) {
			$data['menu_options'][] = array(
				'option_id' 	=> $result['option_id'],
				'option_name' 	=> $result['option_name'],
				'option_price' 	=> $this->currency->format($result['option_price']),
				'edit' 			=> $this->config->site_url('admin/menus/options/edit/' . $result['option_id'])
			);
		}

		$config['base_url'] 		= $this->config->site_url('admin/menus/options');
		$config['total_rows'] 		= $this->Menus_model->options_record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		//check if POST add_menu_option then add option name and price to option DB table
		if ($this->input->post() && $this->_addMenuOpiton() === TRUE) {
			
			redirect('admin/menus/options');
		}

		//check if POST update_menu then remove menu_id
		if ($this->input->post('delete') && $this->_deleteMenuOption() === TRUE) {
			
			redirect('admin/menus/options');
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/menu_options', $data);
		$this->load->view('admin/footer');
	}
	
	public function edit() {
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
		
		if ( !file_exists(APPPATH .'/views/admin/menu_options_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
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
		
		//check if /menu_id is set in uri string
		if (is_numeric($this->uri->segment(5))) {
			$option_id = $this->uri->segment(5);
		} else {
		    redirect('admin/menus/options');
		}
		
		$option_info = $this->Menus_model->getMenuOption($option_id);
	
		$data['heading'] 			= 'Menus Option';
		$data['sub_menu_update'] 	= 'Update';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/menus/options');

		$data['option_id'] 		= $option_info['option_id'];
		$data['option_name'] 	= $option_info['option_name'];
		$data['option_price'] 	= $option_info['option_price'];

		//check if POST add_menu, validate fields and add Menu to model
		if ($this->input->post() && $this->_updateMenuOption($option_id) === TRUE){
					
			redirect('admin/menus/options');
		}
					
		//Remove Menu
		if ($this->input->post('delete') && $this->_deleteMenuOption($option_id) === TRUE) {
				
			redirect('admin/menus/options');
		}
				
		$this->load->view('admin/header', $data);
		$this->load->view('admin/menu_options_edit', $data);
		$this->load->view('admin/footer');
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
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			
			$this->form_validation->set_rules('option_name', 'Option Name', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('option_price', 'Option Price', 'trim|required|numeric');

			//if validation is true
			if ($this->form_validation->run() === TRUE) {
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
	}

	public function _updateMenuOption($option_id) {
						
    	if (!$this->user->hasPermissions('modify', 'admin/menu_options')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
			
			$this->form_validation->set_rules('option_name', 'Option Name', 'trim|required|min_length[2]|max_length[32]');
			$this->form_validation->set_rules('option_price', 'Option Price', 'trim|required|numeric');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
			
				//Sanitizing the POST values
				$update['option_id'] = $option_id;
				$update['option_name'] = $this->input->post('option_name');
				$update['option_price'] = $this->input->post('option_price');	

				if ($this->Menus_model->updateMenuOption($update)) {						
			
					$this->session->set_flashdata('alert', '<p class="success">Menu Option Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}

	public function _deleteMenuOption($option_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/menu_options')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$option_id = $value;
				
					$this->Menus_model->deleteMenuOption($option_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Menu Option(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}