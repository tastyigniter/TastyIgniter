<?php
class Currencies extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Currencies_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {

		if ( !file_exists(APPPATH .'/views/admin/currencies.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/currencies')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Currencies';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new currency</a></li>';
		$data['text_empty'] 		= 'There are no quantities, please add!.';

		//load ratings data into array
		$data['currencies'] = array();
		$results = $this->Currencies_model->getList();
		foreach ($results as $result) {					
			$data['currencies'][] = array(
				'currency_id'		=> $result['currency_id'],
				'currency_title'	=> $result['currency_title'],
				'currency_code'		=> $result['currency_code'],
				'currency_symbol'	=> $result['currency_symbol'],
				'currency_status'	=> $result['currency_status'],
				'edit' 				=> $this->config->site_url('admin/currencies/edit/' . $result['currency_id'])
			);
		}

		// check POST submit, validate fields and send quantity data to model
		if ($this->input->post() && $this->_addCurrency() === TRUE) {
		
			redirect('admin/currencies');  			
		}

		//check if POST submit then remove food_id
		if ($this->input->post('delete') && $this->_deleteCurrency() === TRUE) {
			
			redirect('admin/currencies');  			
		}	

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/currencies', $data);
		$this->load->view('admin/footer');
	}

	public function edit() {

		if ( !file_exists(APPPATH .'/views/admin/currencies_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/currencies')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		
		
		//check if /rating_id is set in uri string
		if (is_numeric($this->uri->segment(4))) {
			$currency_id = $this->uri->segment(4);
		} else {
		    redirect('admin/currencies');
		}
		
		$currency_info = $this->Currencies_model->getCurrency($currency_id);
		
		if ($currency_info) {
			$data['heading'] 			= 'Currencies';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/currencies');

			$data['currency_title'] 	= $currency_info['currency_title'];
			$data['currency_code'] 		= $currency_info['currency_code'];
			$data['currency_symbol'] 	= $currency_info['currency_symbol'];
			$data['currency_status'] 	= $currency_info['currency_status'];

			//check if POST add_Ratings, validate fields and add Ratings to model
			if ($this->input->post() && $this->_updateCurrency($currency_id) === TRUE) {
						
				redirect('admin/currencies');
			}
						
			//Remove Ratings
			if ($this->input->post('delete') && $this->_deleteCurrency($currency_id) === TRUE) {
					
				redirect('admin/currencies');
			}
		}
				
		$this->load->view('admin/header', $data);
		$this->load->view('admin/currencies_edit', $data);
		$this->load->view('admin/footer');
	}

	public function _addCurrency() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/currencies')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
		
			//validate category value
			$this->form_validation->set_rules('currency_title', 'Currency Title', 'trim|required|min_length[2]|max_length[45]');
			$this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required|exact_length[3]');
			$this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'trim|required');
			$this->form_validation->set_rules('currency_status', 'Currency Symbol', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				$add = array();
				
				$add['currency_title'] 	= $this->input->post('currency_title');
				$add['currency_code'] 	= $this->input->post('currency_code');
				$add['currency_symbol'] = $this->input->post('currency_symbol');
				$add['currency_status'] = $this->input->post('currency_status');
	
				if ($this->Currencies_model->addCurrency($add)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Currency Added Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}
	}
	
	public function _updateCurrency($currency_id) {
    	
    	if (!$this->user->hasPermissions('modify', 'admin/currencies')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->post('delete')) { 
		
			//validate category value
			$this->form_validation->set_rules('currency_title', 'Currency Title', 'trim|required|min_length[2]|max_length[45]');
			$this->form_validation->set_rules('currency_code', 'Currency Code', 'trim|required|exact_length[3]');
			$this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'trim|required');
			$this->form_validation->set_rules('currency_status', 'Currency Symbol', 'trim|required|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				$update['currency_id'] 		= $currency_id;
				$update['currency_title'] 	= $this->input->post('currency_title');
				$update['currency_code'] 	= $this->input->post('currency_code');
				$update['currency_symbol'] 	= $this->input->post('currency_symbol');
				$update['currency_status'] 	= $this->input->post('currency_status');
	
				if ($this->Currencies_model->updateCurrency($update)) {	
				
					$this->session->set_flashdata('alert', '<p class="success">Currency Updated Sucessfully!</p>');
				} else {
			
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
			
				return TRUE;
			}
		}		
	}	
	
	public function _deleteCurrency($currency_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/currencies')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[quantity] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$currency_id = $value;
				
					$this->Currencies_model->deleteCurrency($currency_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Currency(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}