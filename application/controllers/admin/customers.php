<?php
class Customers extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->library('pagination');
		$this->load->model('Customers_model');
		$this->load->model('Countries_model');
		$this->load->model('Security_questions_model');
		$this->load->model('Locations_model');
	}

	public function index() {
			
		if ( !file_exists(APPPATH .'/views/admin/customers.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/customers')) {
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
				
		$data['heading'] 			= 'Customers';
		$data['sub_menu_add'] 		= 'Add';
		$data['sub_menu_delete'] 	= 'Delete';
		$data['sub_menu_list'] 		= '<li><a id="menu-add">Add new customer</a></li>';
		$data['text_no_customers'] 	= 'There are no customer(s).';

		$data['customers'] = array();
		$results = $this->Customers_model->getList($filter);
		foreach ($results as $result) {
			
			$data['customers'][] = array(
				'customer_id' 		=> $result['customer_id'],
				'first_name' 		=> $result['first_name'],
				'last_name'			=> $result['last_name'],
				'email' 			=> $result['email'],
				'telephone' 		=> $result['telephone'],
				'date_added' 		=> mdate('%d-%m-%Y', strtotime($result['date_added'])),
				'status' 			=> ($result['status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 				=> $this->config->site_url('admin/customers/edit/' . $result['customer_id'])
			);
		}

		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'id'	=> $result['question_id'],
				'text'	=> $result['question_text']
			);
		}

		$data['country_id'] = $this->config->item('config_country');
		$data['countries'] = array();
		$results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
		foreach ($results as $result) {															// loop through crountries array
			$data['countries'][] = array( 														// create array of countries data to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$config['base_url'] 		= $this->config->site_url('admin/customers');
		$config['total_rows'] 		= $this->Customers_model->record_count();
		$config['per_page'] 		= $filter['limit'];
		$config['num_links'] 		= round($config['total_rows'] / $config['per_page']);
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		//if POST sumbit is Register then call the _addCustomer method
		if ($this->input->post() && $this->_addCustomer() === TRUE) {
		
			redirect('admin/customers');
		}

		//check if POST update_deal then remove deal_id
		if ($this->input->post('delete') && $this->_deleteCustomer() === TRUE) {
			
			redirect('admin/customers');  			
		}	

		//load customer page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/customers', $data);
		$this->load->view('admin/footer');
	}
	
	public function edit() {
		
		if ( !file_exists(APPPATH .'/views/admin/customers_edit.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}
		
		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/customers')) {
  			redirect('admin/permission');
		}
		
		//check if customer_id is set in uri string
		if ($this->uri->segment(4)) {
			$customer_id = (int)$this->uri->segment(4);
		} else {
		    redirect('admin/customers');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$customer_info = $this->Customers_model->getCustomer($customer_id);
		if ($customer_info) {
			$data['heading'] 			= 'Customers';
			$data['sub_menu_update'] 	= 'Update';
			$data['sub_menu_back'] 		= $this->config->site_url('admin/customers');
		
			$data['first_name'] 		= $customer_info['first_name'];
			$data['last_name'] 			= $customer_info['last_name'];
			$data['email'] 				= $customer_info['email'];
			$data['telephone'] 			= $customer_info['telephone'];
			$data['security_question'] 	= $customer_info['security_question_id'];
			$data['security_answer'] 	= $customer_info['security_answer'];
			$data['status'] 			= $customer_info['status'];
			$data['addresses'] 			= $this->Customers_model->getCustomerAddresses($customer_id);
			
			$data['questions'] = array();
			$results = $this->Security_questions_model->getQuestions();
			foreach ($results as $result) {
				$data['questions'][] = array(
					'id'	=> $result['question_id'],
					'text'	=> $result['question_text']
				);
			}

			$data['country_id'] = $this->config->item('config_country');
			$data['countries'] = array();
			$results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
			foreach ($results as $result) {															// loop through crountries array
				$data['countries'][] = array( 														// create array of countries data to pass to view
					'country_id'	=>	$result['country_id'],
					'name'			=>	$result['country_name'],
				);
			}

			if ($this->input->post() && $this->_updateCustomer($customer_id, $data['email']) === TRUE) {

				redirect('admin/customers');

			}
		}
		
		//load customer_edit page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/customers_edit', $data);
		$this->load->view('admin/footer');
	}

	public function autocomplete() {
		$json = array();
		
		if ($this->input->get('customer_name')) {
			$filter_data = array();
			$filter_data = array(
				'customer_name' => urldecode($this->input->get('customer_name'))
			);
		}
		
		$results = $this->Customers_model->getAutoComplete($filter_data);

		if ($results) {
			foreach ($results as $result) {
				$json[] = array(
					'customer_id' 		=> $result['customer_id'],
					'customer_name' 	=> $result['first_name'] .' '. $result['last_name']
				);
			}
		}
		
		$this->output->set_output(json_encode($json));
	}
	
	public function _addCustomer() {
						
    	if ( ! $this->user->hasPermissions('modify', 'admin/customers')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
  	
    	} else {
    	
			//validate form
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
			$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|max_length[96]|is_unique[customers.email]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|matches[password_confirm]');
			$this->form_validation->set_rules('password_confirm', 'Password Confirm', 'trim|required');
			$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
			$this->form_validation->set_rules('security_question', 'Security Question', 'trim|required|integer');
			$this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required|min_length[2]');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[2]');

			$this->form_validation->set_rules('address[][address_1]', 'Address 1', 'trim|min_length[3]|max_length[128]');
			$this->form_validation->set_rules('address[][city]', 'City', 'trim|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('address[][postcode]', 'Postcode', 'trim|min_length[2]|max_length[10]');
			$this->form_validation->set_rules('address[][country]', 'Country', 'trim|integer');


			//if validation is true
			if ($this->form_validation->run() === TRUE) {
				$add = array();
				
				//store post values
				$add['first_name'] 				= $this->input->post('first_name');
				$add['last_name'] 				= $this->input->post('last_name');
				$add['email'] 					= $this->input->post('email');
				$add['password'] 				= $this->input->post('password');
				$add['telephone'] 				= $this->input->post('telephone');
				$add['security_question_id'] 	= $this->input->post('security_question');
				$add['security_answer'] 		= $this->input->post('security_answer');
				$add['date_added'] 				= mdate('%Y-%m-%d', time());
				$add['status']					= $this->input->post('status');

				//add into database
				if ($this->Customers_model->addCustomer($add)) {	
					
					$this->session->set_flashdata('alert', '<p class="success">Customer Added Sucessfully!</p>');
				
				} else {
				
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Added!</p>');
				}
				
				return TRUE;		
			}
		}
	}

	public function _updateCustomer($customer_id, $customer_email) {
						
    	if ( ! $this->user->hasPermissions('modify', 'admin/customers')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
  			return TRUE;
  	
    	} else if (!$this->input->post('delete')) {

			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');
			$this->form_validation->set_rules('last_name', 'First Name', 'trim|required|min_length[2]|max_length[12]');

			if ($customer_email !== $this->input->post('email')) {
				$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[96]|is_unique[customers.email]');
			}

			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|matches[confirm_password]');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|md5');
			}
			
			$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|integer');
			$this->form_validation->set_rules('security_question', 'Security Question', 'required|integer');
			$this->form_validation->set_rules('security_answer', 'Security Answer', 'required|min_length[2]');
			$this->form_validation->set_rules('status', 'Status', 'trim|required|integer');

			$this->form_validation->set_rules('address[][address_1]', 'Address 1', 'trim|min_length[3]|max_length[128]');
			$this->form_validation->set_rules('address[][city]', 'City', 'trim|min_length[2]|max_length[128]');
			$this->form_validation->set_rules('address[][postcode]', 'Postcode', 'trim|min_length[2]|max_length[10]');
			$this->form_validation->set_rules('address[][country]', 'Country', 'trim|integer');

			if ($this->form_validation->run() === TRUE) {
				$update = array();
				
				$update['customer_id'] 			= $customer_id;
				$update['first_name'] 			= $this->input->post('first_name');
				$update['last_name'] 			= $this->input->post('last_name');
				$update['telephone'] 			= $this->input->post('telephone');
				$update['security_question_id'] = $this->input->post('security_question');
				$update['security_answer']		= $this->input->post('security_answer');
				$update['status']				= $this->input->post('status');
				$update['address']				= $this->input->post('address');
				
				if ($customer_email !== $this->input->post('email')) {
					$update['email']	= $this->input->post('email');
				}

				if ($this->input->post('password')) {
					$update['password'] = $this->input->post('password');
				}

				if ($this->Customers_model->updateCustomer($update)) {
					
					$this->session->set_flashdata('alert', '<p class="success">Customer Updated Sucessfully!</p>');
					
				} else {
					
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');	
				
				}
				
				return TRUE;
			}
		}
	}

	public function _deleteCustomer($customer_id = FALSE) {
    	if (!$this->user->hasPermissions('modify', 'admin/menus')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
    	
    	} else { 
		
			if (is_array($this->input->post('delete'))) {

				//sorting the post[remove_deal] array to rowid and qty.
				foreach ($this->input->post('delete') as $key => $value) {
					$customer_id = $value;
				
					$this->Customers_model->deleteCustomer($customer_id);
				}			
			
				$this->session->set_flashdata('alert', '<p class="success">Customer(s) Deleted Sucessfully!</p>');

			}
		}
				
		return TRUE;
	}
}
