<?php
class Tables extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Tables_model');
		$this->load->model('Locations_model'); // load the locations model
	}

	public function index() {
			
		if (!file_exists(APPPATH .'views/admin/tables.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/tables')) {
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
		
		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}
				
		$data['heading'] 			= 'Tables';
		$data['sub_menu_add'] 		= 'Add new table';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['text_empty'] 		= 'There are no tables available.';

		//load ratings data into array
		$data['tables'] = array();
		$results = $this->Tables_model->getList($filter);
		foreach ($results as $result) {					
			$data['tables'][] = array(
				'table_id'			=> $result['table_id'],
				'table_name'		=> $result['table_name'],
				'min_capacity'		=> $result['min_capacity'],
				'max_capacity'		=> $result['max_capacity'],
				'table_status'		=> ($result['table_status'] == '1') ? 'Enabled' : 'Disabled',
				'edit'				=> $this->config->site_url('admin/tables/edit?id=' . $result['table_id'])
			);
		}

		$config['base_url'] 		= $this->config->site_url('admin/tables');
		$config['total_rows'] 		= $this->Tables_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') && $this->_deleteTable() === TRUE) {
			
			redirect('admin/tables');  			
		}	

		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/tables', $data);
	}

	public function edit() {
		
		if (!file_exists(APPPATH .'views/admin/tables_edit.php')) {
			show_404();
		}
			
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/tables')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else { 
			$data['alert'] = '';
		}		

		//check if /location_id is set in uri string
		if (is_numeric($this->input->get('id'))) {
			$table_id = (int)$this->input->get('id');
			$data['action']	= $this->config->site_url('admin/tables/edit?id='. $table_id);
		} else {
		    $table_id = 0;
			$data['action']	= $this->config->site_url('admin/tables/edit');
		}
		
		$table_info = $this->Tables_model->getTable($table_id);

		$data['heading'] 			= 'Table - '. $table_info['table_name'];
		$data['sub_menu_save'] 		= 'Save';
		$data['sub_menu_back'] 		= $this->config->site_url('admin/tables');


		$data['table_id'] 			= $table_info['table_id'];
		$data['table_name'] 		= $table_info['table_name'];
		$data['min_capacity'] 		= $table_info['min_capacity'];
		$data['max_capacity'] 		= $table_info['max_capacity'];
		$data['table_status'] 		= $table_info['table_status'];

		if ($this->input->post() && $this->_addTable() === TRUE) {
		
			redirect('admin/tables');
		}

		if ($this->input->post() && $this->_updateTable() === TRUE) {
					
			redirect('admin/tables');
		}
		
		$regions = array(
			'admin/header',
			'admin/footer'
		);
		
		$this->template->regions($regions);
		$this->template->load('admin/tables_edit', $data);
	}

	public function autocomplete() {
		$json = array();
		
		if ($this->input->get('table_name')) {
			$filter_data = array();
			$filter_data = array(
				'table_name' => $this->input->get('table_name')
			);
		}
		
		$results = $this->Tables_model->getAutoComplete($filter_data);

		if ($results) {
			foreach ($results as $result) {
				$json[] = array(
					'table_id' 			=> $result['table_id'],
					'table_name' 		=> $result['table_name'],
					'min_capacity' 		=> $result['min_capacity'],
					'max_capacity' 		=> $result['max_capacity']
				);
			}
		}
		
		$this->output->set_output(json_encode($json));
	}
	
	public function _addTable() {
									
    	if (!$this->user->hasPermissions('modify', 'admin/tables')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
			return TRUE;
    	
    	} else if ( ! $this->input->get('id') AND $this->validateForm() === TRUE) { 
			$add = array();
			
			//Sanitizing the POST values
			$add['table_name'] 	= $this->input->post('table_name');
			$add['min_capacity'] 	= $this->input->post('min_capacity');
			$add['max_capacity'] = $this->input->post('max_capacity');
			$add['table_status'] 	= $this->input->post('table_status');
			
			if ($this->Tables_model->addTable($add)) {
				$this->session->set_flashdata('alert', '<p class="success">Table Added Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');				
			}
			
			return TRUE;
		}	
	}

	public function _updateTable() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/tables')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
			return TRUE;
    	
    	} else if ($this->input->get('id') AND $this->validateForm() === TRUE) { 
			$update = array();
			
			$update['table_id'] 		= $this->input->get('id');
			$update['table_name'] 		= $this->input->post('table_name');
			$update['min_capacity'] 	= $this->input->post('min_capacity');
			$update['max_capacity'] 	= $this->input->post('max_capacity');
			$update['table_status'] 	= $this->input->post('table_status');
			
			if ($this->Tables_model->updateTable($update)) {						
				$this->session->set_flashdata('alert', '<p class="success">Table Updated Sucessfully!</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
			}
			
			return TRUE;
		}
	}

	public function _deleteTable() {
    	if (!$this->user->hasPermissions('modify', 'admin/tables')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have the right permission to edit!</p>');
    	
    	} else { 
			if (is_array($this->input->post('delete'))) {
				foreach ($this->input->post('delete') as $key => $value) {
					$table_id = $value;
					$this->Tables_model->deleteTable($table_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Table(s) Deleted Sucessfully!</p>');
			}
		}
				
		return TRUE;
	}
	
	public function validateForm() {
		$this->form_validation->set_rules('table_name', 'Table Name', 'trim|required');
		$this->form_validation->set_rules('min_capacity', 'Table Minimum', 'trim|required|integer|greater_than[1]');
		$this->form_validation->set_rules('max_capacity', 'Table Capacity', 'trim|required|integer');
		$this->form_validation->set_rules('table_status', 'Table Status', 'trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}