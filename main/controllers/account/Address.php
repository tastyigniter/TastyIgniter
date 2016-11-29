<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Address extends Main_Controller
{

	public function __construct() {
		parent::__construct();                                                                    //  calls the constructor

		if (!$this->customer->isLogged()) {                                                    // if customer is not logged in redirect to account login page
			$this->redirect('account/login');
		}

		$this->load->model('Countries_model');
		$this->load->model('Addresses_model');
		$this->load->model('Pages_model');

		$this->lang->load('account/address');
	}

	public function index() {
		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/address');

		$this->template->setTitle($this->lang->line('text_heading'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->filter['customer_id'] = (int)$this->customer->getId();

		$data['continue_url'] = $this->pageUrl('account/address/edit');
		$data['back_url'] = $this->pageUrl('account/account');

		$data['address_id'] = $this->customer->getAddressId();

		$this->load->library('country');
		$data['addresses'] = array();
		$results = $this->Addresses_model->paginateWithFilter($this->filter);                                // retrieve customer address data from getAddresses method in Customers model
		if ($results->list) {
			foreach ($results->list as $result) {                                                        // loop through the customer address data
				$data['addresses'][] = array_merge($result, array(                                                    // create array of customer address data to pass to view
					'address' => $this->country->addressFormat($result),
					'edit'    => $this->pageUrl('account/address/edit/' . $result['address_id']),
					'delete'  => $this->pageUrl('account/address/delete/' . $result['address_id']),
				));
			}
		}

		$data['pagination'] = $results->pagination;

		$this->template->render('account/address', $data);
	}

	public function edit() {                                                                    // method to edit customer address
		if (is_numeric($this->uri->rsegment(3))) {                                                // retrieve if available and check if fouth uri segment is numeric
			$address_id = (int)$this->uri->rsegment(3);
			$data['_action'] = $this->pageUrl('account/address/edit/' . $address_id);
		} else {                                                                                // else if customer is logged in retrieve customer id from customer library
			$address_id = FALSE;
			$data['_action'] = $this->pageUrl('account/address/edit');
		}

		$this->template->setBreadcrumb('<i class="fa fa-home"></i>', '/');
		$this->template->setBreadcrumb($this->lang->line('text_my_account'), 'account/account');
		$this->template->setBreadcrumb($this->lang->line('text_heading'), 'account/address');
		$this->template->setBreadcrumb($this->lang->line('text_edit_heading'), 'account/address/edit');

		$this->template->setTitle($this->lang->line('text_edit_heading'));
		$this->template->setHeading($this->lang->line('text_edit_heading'));

		$data['back_url'] = $this->pageUrl('account/address');
		$data['country_id'] = $this->config->item('country_id');

		$data['address'] = array();
		// if uri segment is available and numeric, retrieve customer address based on uri segment and customer id
		if ($result = $this->Addresses_model->getAddress($this->customer->getId(), $address_id)) {
			$data['address'] = $result;
			$data['button_update'] = $this->lang->line('button_update');
		} else {
			$data['button_update'] = $this->lang->line('button_add');
		}

		$data['countries'] = $this->Countries_model->isEnabled()->dropdown('country_name');                                        // retrieve countries data from getCountries method in Locations model

		if ($this->input->post() AND $this->_updateAddress() === TRUE) {
			$this->redirect('account/address');
		}

		$this->template->render('account/address_edit', $data);
	}

	public function delete() {
		$address_id = is_numeric($this->uri->rsegment(3)) ? $this->uri->rsegment(3) : FALSE;
		if ($this->Addresses_model->deleteAddress($this->customer->getId(), $address_id)) {
			$this->alert->set('alert', $this->lang->line('alert_deleted_success'));
		}

		$this->redirect('account/address');
	}

	protected function _updateAddress() {
		if ($this->validateForm() === TRUE AND $this->input->post('address')) {
			if ($this->Addresses_model->saveAddress($this->customer->getId(), $this->uri->rsegment(3), $this->input->post('address'))) {                                // check if address updated successfully then display success message else error message
				$this->alert->set('alert', $this->lang->line('alert_updated_success'));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		// START of form validation rules
		$rules[] = array('address[address_1]', 'lang:label_address_1', 'xss_clean|trim|required|min_length[3]|max_length[128]|get_lat_lng[address]');
		$rules[] = array('address[address_2]', 'lang:label_address_2', 'xss_clean|trim|max_length[128]');
		$rules[] = array('address[city]', 'lang:label_city', 'xss_clean|trim|required|min_length[2]|max_length[128]');
		$rules[] = array('address[state]', 'lang:label_state', 'xss_clean|trim|max_length[128]');
		$rules[] = array('address[postcode]', 'lang:label_postcode', 'xss_clean|trim|min_length[2]|max_length[11]');
		$rules[] = array('address[country]', 'lang:label_country', 'xss_clean|trim|required|integer');

		// END of form validation rules

		return $this->form_validation->set_rules($rules)->run();
	}
}

/* End of file Address.php */
/* Location: ./main/controllers/Address.php */