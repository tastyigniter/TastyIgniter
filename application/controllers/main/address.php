<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address extends MX_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Customers_model');													// load the customers model
		$this->load->model('Locations_model'); 													// load the locations model
		$this->load->model('Countries_model');
	}

	public function index() {
		$this->lang->load('main/address');  													// loads language file
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_heading');
		$data['text_edit_address'] 		= $this->lang->line('text_edit_address');
		$data['text_no_address'] 		= $this->lang->line('text_no_address');
		$data['text_edit'] 				= $this->lang->line('text_edit');

		$data['entry_address_1'] 		= $this->lang->line('entry_address_1');
		$data['entry_address_2'] 		= $this->lang->line('entry_address_2');
		$data['entry_city'] 			= $this->lang->line('entry_city');
		$data['entry_postcode'] 		= $this->lang->line('entry_postcode');
		$data['entry_country'] 			= $this->lang->line('entry_country');
		
		$data['button_back'] 			= $this->lang->line('button_back');
		$data['button_add'] 			= $this->lang->line('button_add');
		// END of retrieving lines from language file to pass to view.
		
		$data['continue'] 				= site_url('main/address/edit');
		$data['back'] 					= site_url('main/account');

		$this->load->library('country');
		$data['addresses'] = array();		
		$results = $this->Customers_model->getCustomerAddresses($this->customer->getId());								// retrieve customer address data from getCustomerAddresses method in Customers model
		if ($results) {
			foreach ($results as $result) {														// loop through the customer address data

				$data['addresses'][] = array(													// create array of customer address data to pass to view
					'address_id'	=> $result['address_id'],
					'address' 		=> $this->country->addressFormat($result),
					'edit' 			=> site_url('main/address/edit/'. $result['address_id'])
				);
			}
		}
		
		$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'address.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'address', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'address', $regions, $data);
		}
	}

	public function edit() {																	// method to edit customer address
		$this->lang->load('main/address');  													// loads language file
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  								// retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		} else {																				// else if customer is logged in retrieve customer id from customer library
			$customer_id = $this->customer->getId();
		}

		if (is_numeric($this->uri->segment(4))) {												// retrieve if available and check if fouth uri segment is numeric
			$address_id = (int)$this->uri->segment(4);
			$data['action']	= site_url('main/address/edit/'. $address_id);
		} else {																				// else if customer is logged in retrieve customer id from customer library
			$address_id = FALSE;
			$data['action']	= site_url('main/address/edit');
		}

		$this->load->model('Messages_model');													// load the customers model
		$inbox_total = $this->Messages_model->getMainInboxTotal();					// retrieve total number of customer messages from getMainInboxTotal method in Messages model

		// START of retrieving lines from language file to pass to view.
		$data['text_heading'] 			= $this->lang->line('text_edit_heading');
		$data['text_edit_address'] 		= $this->lang->line('text_edit_address');
		$data['text_new_address'] 		= $this->lang->line('text_new_address');
		$data['text_delete'] 			= $this->lang->line('text_delete');

		$data['entry_address_1'] 		= $this->lang->line('entry_address_1');
		$data['entry_address_2'] 		= $this->lang->line('entry_address_2');
		$data['entry_city'] 			= $this->lang->line('entry_city');
		$data['entry_postcode'] 		= $this->lang->line('entry_postcode');
		$data['entry_country'] 			= $this->lang->line('entry_country');
		
		$data['button_address'] 		= $this->lang->line('button_address');
		$data['button_update'] 			= $this->lang->line('button_update');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('main/address');
		$data['country_id'] 			= $this->config->item('country_id');
		
		$data['address'] = array();
		
		$result = $this->Customers_model->getCustomerAddress($customer_id, $address_id);	// if uri segment is available and numeric, retrieve customer address based on uri segment and customer id
		if ($result) {
			$data['address'] = array(														// create array of customer address data to pass to view
				'address_id'	=> $result['address_id'],
				'address_1' 	=> $result['address_1'],
				'address_2' 	=> $result['address_2'],
				'city' 			=> $result['city'],
				'postcode' 		=> $result['postcode'],
				'country_id' 	=> $result['country_id']	
			);
		}		
		
		$data['countries'] = array();
		$results = $this->Countries_model->getCountries();										// retrieve countries data from getCountries method in Locations model
		foreach ($results as $result) {					
			$data['countries'][] = array(														// create array of countries to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}
		
		if ($this->input->post() && $this->_updateAddress($address_id) === TRUE) {
			redirect('account/address');
		}
						
		// Delete Customer Address
		if ($this->input->post() AND $this->input->post('delete')) {
			$this->Customers_model->deleteAddress($customer_id, $address_id);
			$this->session->set_flashdata('alert', $this->lang->line('text_deleted_msg'));

			redirect('account/address');
		}

		$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
		if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'address_edit.php')) {
			$this->template->render('themes/main/'.$this->config->item('main_theme'), 'address_edit', $regions, $data);
		} else {
			$this->template->render('themes/main/default/', 'address_edit', $regions, $data);
		}
	}
	
	public function _updateAddress($address_id = FALSE) {
		$this->load->library('location'); 														// load the customer library

		if ($this->validateForm() === TRUE) {		
			$update = array();
			
			$customer_id = FALSE;
			if ($this->customer->getId()) {  
				$customer_id = $this->customer->getId();								// retrieve customer id from customer library and add to update array
			}

			$address = $this->input->post('address');
		
			if ($this->Customers_model->updateCustomerAddress($customer_id, $address_id, $address)) {								// check if address updated successfully then display success message else error message
				$this->session->set_flashdata('alert', $this->lang->line('text_added_msg'));
			} else {
				$this->session->set_flashdata('alert', $this->lang->line('text_nothing_msg'));				
			}
		
			return TRUE;
		}
	}

	public function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('address[address_1]', 'Address 1', 'xss_clean|trim|required|min_length[3]|max_length[128]');
		$this->form_validation->set_rules('address[address_2]', 'Address 2', 'xss_clean|trim|max_length[128]');
		$this->form_validation->set_rules('address[city]', 'City', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[postcode]', 'Postcode', 'xss_clean|trim|required|min_length[2]|max_length[11]|callback_get_lat_lag');
		$this->form_validation->set_rules('address[country]', 'Country', 'xss_clean|trim|required|integer');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function get_lat_lag() {
		if (isset($_POST['address']) && is_array($_POST['address']) && !empty($_POST['address']['postcode'])) {			 
			$address_string =  implode(", ", $_POST['address']);
			$address = urlencode($address_string);
			$geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='. $address .'&sensor=false&region=GB');
    		$output = json_decode($geocode);
    		$status = $output->status;
    		
    		if ($status === 'OK') {
				$_POST['address']['location_lat'] = $output->results[0]->geometry->location->lat;
				$_POST['address']['location_lng'] = $output->results[0]->geometry->location->lng;
			    return TRUE;
    		} else {
        		$this->form_validation->set_message('get_lat_lag', 'The Address you entered failed Geocoding, please enter a different address!');
        		return FALSE;
    		}
        }
	}
}

/* End of file address.php */
/* Location: ./application/controllers/main/address.php */