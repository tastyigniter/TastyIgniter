<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Address extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('customer'); 														// load the customer library
		$this->load->model('Countries_model');
		$this->load->model('Addresses_model');
		$this->load->model('Pages_model');
		$this->lang->load('address');
	}

	public function index() {
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('login');
		}

		$url = '?';
		$filter = array();
		$filter['customer_id'] = (int) $this->customer->getId();

		if ($this->input->get('page')) {
			$filter['page'] = (int) $this->input->get('page');
		} else {
			$filter['page'] = '';
		}

		if ($this->config->item('page_limit')) {
			$filter['limit'] = $this->config->item('page_limit');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'address');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));
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

		$data['continue'] 				= site_url('address/edit');
		$data['back'] 					= site_url('account');

		$this->load->library('country');
		$data['addresses'] = array();
		$results = $this->Addresses_model->getList($filter);								// retrieve customer address data from getAddresses method in Customers model
		if ($results) {
			foreach ($results as $result) {														// loop through the customer address data

				$data['addresses'][] = array(													// create array of customer address data to pass to view
					'address_id'	=> $result['address_id'],
					'address' 		=> $this->country->addressFormat($result),
					'edit' 			=> site_url('address/edit/'. $result['address_id'])
				);
			}
		}

		$prefs['base_url'] 			= site_url('address').$url;
		$prefs['total_rows'] 		= $this->Addresses_model->getCount($filter);
		$prefs['per_page'] 			= $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('address', $data);
	}

	public function edit() {																	// method to edit customer address
		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('login');
		} else {																				// else if customer is logged in retrieve customer id from customer library
			$customer_id = $this->customer->getId();
		}

		if (is_numeric($this->uri->rsegment(3))) {												// retrieve if available and check if fouth uri segment is numeric
			$address_id = (int)$this->uri->rsegment(3);
			$data['action']	= site_url('address/edit/'. $address_id);
		} else {																				// else if customer is logged in retrieve customer id from customer library
			$address_id = FALSE;
			$data['action']	= site_url('address/edit');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'address');
		$this->template->setBreadcrumb($this->lang->line('text_edit_heading'), 'address/edit');

		// START of retrieving lines from language file to pass to view.
		$this->template->setTitle($this->lang->line('text_edit_heading'));
		$this->template->setHeading($this->lang->line('text_edit_heading'));
		$data['text_heading'] 			= $this->lang->line('text_edit_heading');
		$data['text_edit_address'] 		= $this->lang->line('text_edit_address');
		$data['text_new_address'] 		= $this->lang->line('text_new_address');
		$data['text_delete'] 			= $this->lang->line('text_delete');

		$data['entry_address_1'] 		= $this->lang->line('entry_address_1');
		$data['entry_address_2'] 		= $this->lang->line('entry_address_2');
		$data['entry_city'] 			= $this->lang->line('entry_city');
		$data['entry_postcode'] 		= $this->lang->line('entry_postcode');
		$data['entry_country'] 			= $this->lang->line('entry_country');

		$data['button_back'] 			= $this->lang->line('button_back');
		// END of retrieving lines from language file to pass to view.

		$data['back'] 					= site_url('address');
		$data['country_id'] 			= $this->config->item('country_id');

		$data['address'] = array();

		$result = $this->Addresses_model->getAddress($customer_id, $address_id);	// if uri segment is available and numeric, retrieve customer address based on uri segment and customer id
		if ($result) {
			$data['address'] = array(														// create array of customer address data to pass to view
				'address_id'	=> $result['address_id'],
				'address_1' 	=> $result['address_1'],
				'address_2' 	=> $result['address_2'],
				'city' 			=> $result['city'],
				'postcode' 		=> $result['postcode'],
				'country_id' 	=> $result['country_id']
			);
			$data['button_update'] 			= $this->lang->line('button_update');
		} else {
			$data['button_update'] 			= $this->lang->line('button_add');
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
			redirect('address');
		}

		// Delete Customer Address
		if ($this->input->post() AND $this->input->post('delete')) {
			$this->Addresses_model->deleteAddress($customer_id, $address_id);
			$this->alert->set('alert', $this->lang->line('text_deleted_msg'));

			redirect('address');
		}

		$this->template->setPartials(array('header', 'content_top', 'content_left', 'content_right', 'content_bottom', 'footer'));
		$this->template->render('address_edit', $data);
	}

	public function _updateAddress($address_id = FALSE) {
		$this->load->library('location'); 														// load the customer library

		if ($this->validateForm() === TRUE AND $this->uri->rsegment(3) == $address_id) {
			$update = array();

			$customer_id = FALSE;
			if ($this->customer->getId()) {
				$customer_id = $this->customer->getId();								// retrieve customer id from customer library and add to update array
			}

			$address = $this->input->post('address');

			if ($this->Addresses_model->updateAddress($customer_id, $address_id, $address)) {								// check if address updated successfully then display success message else error message
				$this->alert->set('alert', $this->lang->line('alert_added'));
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
/* Location: ./main/controllers//address.php */