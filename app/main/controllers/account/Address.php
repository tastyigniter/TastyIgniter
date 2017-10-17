<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Address extends Main_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor

		if (!$this->customer->isLogged()) {  													// if customer is not logged in redirect to account login page
  			redirect('account/login');
		}

        $this->load->model('Countries_model');
        $this->load->model('Addresses_model');
        $this->load->model('Pages_model');

        $this->lang->load('account/address');
	}

	public function index() {
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
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/address');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$data['continue_url'] 		= site_url('account/address/edit');
		$data['back_url'] 			= site_url('account/account');

        $data['address_id'] = $this->customer->getAddressId();

        $this->load->library('country');
        $data['addresses'] = array();
		$results = $this->Addresses_model->getList($filter);								// retrieve customer address data from getAddresses method in Customers model
		if ($results) {
			foreach ($results as $result) {														// loop through the customer address data

				$data['addresses'][] = array(													// create array of customer address data to pass to view
					'address_id'	=> $result['address_id'],
					'address' 		=> $this->country->addressFormat($result),
					'edit' 			=> site_url('account/address/edit/'. $result['address_id']),
					'delete' 		=> site_url('account/address/delete/'. $result['address_id'])
				);
			}
		}

		$prefs['base_url'] 			= site_url('account/address'.$url);
		$prefs['total_rows'] 		= $this->Addresses_model->getCount($filter);
		$prefs['per_page'] 			= $filter['limit'];

		$this->load->library('pagination');
		$this->pagination->initialize($prefs);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('account/address', $data);
	}

	public function edit() {																	// method to edit customer address
		if (is_numeric($this->uri->rsegment(3))) {												// retrieve if available and check if fouth uri segment is numeric
			$address_id = (int)$this->uri->rsegment(3);
			$data['_action']	= site_url('account/address/edit/'. $address_id);
		} else {																				// else if customer is logged in retrieve customer id from customer library
			$address_id = FALSE;
			$data['_action']	= site_url('account/address/edit');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
        $this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
        $this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/address');
		$this->template->setBreadcrumb($this->lang->line('text_edit_heading'), 'account/address/edit');

		$this->template->setTitle($this->lang->line('text_edit_heading'));
		$this->template->setHeading($this->lang->line('text_edit_heading'));

		$data['back_url'] 		= site_url('account/address');
		$data['country_id'] 	= $this->config->item('country_id');

        $data['address'] = array();
        // if uri segment is available and numeric, retrieve customer address based on uri segment and customer id
		if ($result = $this->Addresses_model->getAddress($this->customer->getId(), $address_id)) {
			$data['address'] = array(														// create array of customer address data to pass to view
				'address_id'	=> $result['address_id'],
				'address_1' 	=> $result['address_1'],
				'address_2' 	=> $result['address_2'],
				'city' 			=> $result['city'],
				'state' 		=> $result['state'],
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

		if ($this->input->post() AND $this->_updateAddress() === TRUE) {
			redirect('account/address');
		}

		$this->template->render('account/address_edit', $data);
	}

	public function delete() {
		$address_id = is_numeric($this->uri->rsegment(3)) ? $this->uri->rsegment(3) : FALSE;

		if ($this->Addresses_model->deleteAddress($this->customer->getId(), $address_id)) {
			$this->alert->set('alert', $this->lang->line('alert_deleted_success'));
		}

		redirect('account/address');
	}

	private function _updateAddress() {
		if ($this->validateForm() === TRUE AND $this->input->post('address')) {
			$address = $this->input->post('address');

			if ($this->Addresses_model->saveAddress($this->customer->getId(), $this->uri->rsegment(3), $address)) {								// check if address updated successfully then display success message else error message
				$this->alert->set('alert', $this->lang->line('alert_updated_success'));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		// START of form validation rules
		$this->form_validation->set_rules('address[address_1]', 'lang:label_address_1', 'xss_clean|trim|required|min_length[3]|max_length[128]|get_lat_lng[address]');
		$this->form_validation->set_rules('address[address_2]', 'lang:label_address_2', 'xss_clean|trim|max_length[128]');
		$this->form_validation->set_rules('address[city]', 'lang:label_city', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$this->form_validation->set_rules('address[state]', 'lang:label_state', 'xss_clean|trim|max_length[128]');
		$this->form_validation->set_rules('address[postcode]', 'lang:label_postcode', 'xss_clean|trim|min_length[2]|max_length[11]');
		$this->form_validation->set_rules('address[country]', 'lang:label_country', 'xss_clean|trim|required|integer');
		// END of form validation rules

  		if ($this->form_validation->run() === TRUE) {											// checks if form validation routines ran successfully
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file address.php */
/* Location: ./main/controllers/address.php */