<?php
class Currencies extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Currencies_model');
		$this->load->model('Countries_model');
	}

	public function index() {

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
		
		$data['heading'] 			= 'Currencies';
		$data['button_add'] 		= 'New';
		$data['button_delete'] 		= 'Delete';
		$data['text_empty'] 		= 'There are no currencies available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'DESC') ? 'ASC' : 'DESC';
		$data['sort_country'] 		= site_url('admin/currencies'.$url.'sort_by=country_name&order_by='.$order_by);
		$data['sort_name'] 			= site_url('admin/currencies'.$url.'sort_by=currency_name&order_by='.$order_by);
		$data['sort_code'] 			= site_url('admin/currencies'.$url.'sort_by=currency_code&order_by='.$order_by);

		$data['currency_id'] = $this->config->item('currency_id');

		$data['currencies'] = array();
		$results = $this->Currencies_model->getList($filter);
		foreach ($results as $result) {					
			$data['currencies'][] = array(
				'currency_id'		=> $result['currency_id'],
				'currency_name'		=> $result['currency_name'],
				'currency_code'		=> $result['currency_code'],
				'currency_symbol'	=> $result['currency_symbol'],
				'country_name'		=> $result['country_name'],
				'currency_status'	=> $result['currency_status'],
				'edit' 				=> site_url('admin/currencies/edit?id=' . $result['currency_id'])
			);
		}

		if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/currencies').$url;
		$config['total_rows'] 		= $this->Currencies_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteCurrency() === TRUE) {
			redirect('admin/currencies');  			
		}	

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'currencies.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'currencies', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'currencies', $regions, $data);
		}
	}

	public function edit() {

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
		if (is_numeric($this->input->get('id'))) {
			$currency_id = $this->input->get('id');
			$data['action']	= site_url('admin/currencies/edit?id='. $currency_id);
		} else {
		    $currency_id = 0;
			$data['action']	= site_url('admin/currencies/edit');
		}
		
		$currency_info = $this->Currencies_model->getCurrency($currency_id);
		
		$data['heading'] 			= 'Currencies - '. $currency_info['currency_name'];
		$data['button_save'] 		= 'Save';
		$data['button_save_close'] 	= 'Save & Close';
		$data['sub_menu_back'] 		= site_url('admin/currencies');

		$data['currency_name'] 		= $currency_info['currency_name'];
		$data['currency_code'] 		= $currency_info['currency_code'];
		$data['currency_symbol'] 	= $currency_info['currency_symbol'];
		$data['country_id'] 		= $currency_info['country_id'];
		$data['iso_alpha2'] 		= $currency_info['iso_alpha2'];
		$data['iso_alpha3'] 		= $currency_info['iso_alpha3'];
		$data['iso_numeric'] 		= $currency_info['iso_numeric'];
		$data['currency_status'] 	= $currency_info['currency_status'];

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
		foreach ($results as $result) {															// loop through crountries array
			$data['countries'][] = array( 														// create array of countries data to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		if ($this->input->post() && $this->_addCurrency() === TRUE) {
			redirect('admin/currencies');  			
		}

		if ($this->input->post() && $this->_updateCurrency() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/currencies');
			}
			
			redirect('admin/currencies/edit?id='. $currency_id);
		}

		$regions = array('header', 'footer');
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'currencies_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'currencies_edit', $regions, $data);
		} else {
			$this->template->render('themes/admin/default/', 'currencies_edit', $regions, $data);
		}
	}

	public function _addCurrency() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/currencies')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
			
			$add['currency_name'] 		= $this->input->post('currency_name');
			$add['currency_code'] 		= $this->input->post('currency_code');
			$add['currency_symbol'] 	= $this->input->post('currency_symbol');
			$add['country_id'] 			= $this->input->post('country_id');
			$add['iso_alpha2'] 			= $this->input->post('iso_alpha2');
			$add['iso_alpha3']			= $this->input->post('iso_alpha3');
			$add['iso_numeric'] 		= $this->input->post('iso_numeric');
			$add['currency_status'] 	= $this->input->post('currency_status');

			if ($this->Currencies_model->addCurrency($add)) {	
				$this->session->set_flashdata('alert', '<p class="success">Currency Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}
	}
	
	public function _updateCurrency() {
    	
    	if (!$this->user->hasPermissions('modify', 'admin/currencies')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['currency_id'] 		= $this->input->get('id');
			$update['currency_name'] 	= $this->input->post('currency_name');
			$update['currency_code'] 	= $this->input->post('currency_code');
			$update['currency_symbol'] 	= $this->input->post('currency_symbol');
			$update['country_id'] 		= $this->input->post('country_id');
			$update['iso_alpha2'] 		= $this->input->post('iso_alpha2');
			$update['iso_alpha3']		= $this->input->post('iso_alpha3');
			$update['iso_numeric'] 		= $this->input->post('iso_numeric');
			$update['currency_status'] 	= $this->input->post('currency_status');

			if ($this->Currencies_model->updateCurrency($update)) {	
				$this->session->set_flashdata('alert', '<p class="success">Currency Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
		
			return TRUE;
		}		
	}	
	
	public function _deleteCurrency() {
    	if (!$this->user->hasPermissions('modify', 'admin/currencies')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$currency_id = $value;
					$this->Currencies_model->deleteCurrency($currency_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Currency(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('currency_name', 'Currency Title', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('currency_code', 'Currency Code', 'xss_clean|trim|required|exact_length[3]');
		$this->form_validation->set_rules('currency_symbol', 'Currency Symbol', 'xss_clean|trim');
		$this->form_validation->set_rules('country_id', 'Country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('iso_alpha2', 'ISO Alpha 2', 'xss_clean|trim|required|exact_length[2]');
		$this->form_validation->set_rules('iso_alpha3', 'ISO Alpha 3', 'xss_clean|trim|required|exact_length[3]');
		$this->form_validation->set_rules('iso_numeric', 'ISO Numeric', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('currency_status', 'Currency Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file currencies.php */
/* Location: ./application/controllers/admin/currencies.php */