<?php
class Countries extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Countries_model');
	}

	public function index() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/countries')) {
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
			$filter['sort_by'] = $data['sort_by'] = 'country_name';
		}
		
		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = 'ASC';
		}

		$this->template->setTitle('Countries');
		$this->template->setHeading('Countries');
		$this->template->setButton('+ New', array('class' => 'add_button', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'delete_button', 'onclick' => '$(\'form:not(#filter-form)\').submit();'));

		$data['text_empty'] 		= 'There are no countries available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_name'] 			= site_url('admin/countries').$url.'sort_by=country_name&order_by='.$order_by;

		$data['country_id'] = $this->config->item('country_id');

		$data['countries'] = array();
		$results = $this->Countries_model->getList($filter);
		foreach ($results as $result) {					
			$data['countries'][] = array(
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
				'status'		=>	($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 			=> site_url('admin/countries/edit?id=' . $result['country_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}
		
		$config['base_url'] 		= site_url('admin/countries').$url;
		$config['total_rows'] 		= $this->Countries_model->record_count($filter);
		$config['per_page'] 		= $filter['limit'];
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteCountry() === TRUE) {
			
			redirect('admin/countries');  			
		}	

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'countries.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'countries', $data);
		} else {
			$this->template->render('themes/admin/default/', 'countries', $data);
		}
	}

	public function edit() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/countries')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		if (is_numeric($this->input->get('id'))) {
			$country_id = $this->input->get('id');
			$data['action']	= site_url('admin/countries/edit?id='. $country_id);
		} else {
		    $country_id = 0;
			$data['action']	= site_url('admin/countries/edit');
		}
		
		$result = $this->Countries_model->getCountry($country_id);
		
		$title = (isset($result['country_name'])) ? 'Edit - '. $result['country_name'] : 'New';	
		$this->template->setTitle('Country: '. $title);
		$this->template->setHeading('Country: '. $title);
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'save_close_button', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('back_button', site_url('admin/countries'));

		$data['country_name'] 		= $result['country_name'];
		$data['iso_code_2'] 		= $result['iso_code_2'];
		$data['iso_code_3'] 		= $result['iso_code_3'];
		$data['format'] 			= $result['format'];
		$data['status'] 			= $result['status'];

		if ($this->input->post() AND $this->_addCountry() === TRUE) {
			if ($this->input->post('save_close') !== '1' AND is_numeric($this->input->post('insert_id'))) {	
				redirect('admin/countries/edit?id='. $this->input->post('insert_id'));
			} else {
				redirect('admin/countries');
			}
		}

		if ($this->input->post() AND $this->_updateCountry() === TRUE) {
			if ($this->input->post('save_close') === '1') {
				redirect('admin/countries');
			}
			
			redirect('admin/countries/edit?id='. $country_id);
		}
			
		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'countries_edit.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'countries_edit', $data);
		} else {
			$this->template->render('themes/admin/default/', 'countries_edit', $data);
		}
	}

	public function _addCountry() {
    	if (!$this->user->hasPermissions('modify', 'admin/countries')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to add!</p>');
  			return TRUE;
    	} else if ( ! is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
			$add = array();
		
			$add['country_name'] 	= $this->input->post('country_name');
			$add['iso_code_2'] 		= $this->input->post('iso_code_2');
			$add['iso_code_3'] 		= $this->input->post('iso_code_3');
			$add['format'] 			= $this->input->post('format');
			$add['status'] 			= $this->input->post('status');

			if ($_POST['insert_id'] = $this->Countries_model->addCountry($add)) {	
				$this->session->set_flashdata('alert', '<p class="success">Country added sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');				
			}
	
			return TRUE;
		}
	}
	
	public function _updateCountry() {
    	if (!$this->user->hasPermissions('modify', 'admin/countries')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
  			return TRUE;
    	} else if (is_numeric($this->input->get('id')) AND $this->validateForm() === TRUE) { 
		
			$update = array();
			
			$update['country_id'] 		= $this->input->get('id');
			$update['country_name'] 	= $this->input->post('country_name');
			$update['iso_code_2'] 		= $this->input->post('iso_code_2');
			$update['iso_code_3'] 		= $this->input->post('iso_code_3');
			$update['format'] 			= $this->input->post('format');
			$update['status'] 			= $this->input->post('status');


			if ($this->Countries_model->updateCountry($update)) {	
				$this->session->set_flashdata('alert', '<p class="success">Country updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}		
	}	
	
	public function _deleteCountry() {
    	if (!$this->user->hasPermissions('modify', 'admin/countries')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to delete!</p>');
    	} else if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Countries_model->deleteCountry($value);
			}			
		
			$this->session->set_flashdata('alert', '<p class="success">Country(s) deleted sucessfully!</p>');
		}
				
		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('country_name', 'Country', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('iso_code_2', 'ISO Code (2)', 'xss_clean|trim|required|exact_length[2]');
		$this->form_validation->set_rules('iso_code_3', 'ISO Code (3)', 'xss_clean|trim|required|exact_length[3]');
		$this->form_validation->set_rules('format', 'Format', 'xss_clean|trim|min_length[2]');
		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file countries.php */
/* Location: ./application/controllers/admin/countries.php */