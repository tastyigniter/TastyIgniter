<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Currencies extends Admin_Controller {

    public $_permission_rules = array('access[index|edit]', 'modify[index|edit]');

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('pagination');
		$this->load->model('Currencies_model');
		$this->load->model('Countries_model');
	}

	public function index() {
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
			$filter['sort_by'] = $data['sort_by'] = 'currency_name';
		}

		if ($this->input->get('order_by')) {
			$filter['order_by'] = $data['order_by'] = $this->input->get('order_by');
			$data['order_by_active'] = $this->input->get('order_by') .' active';
		} else {
			$filter['order_by'] = $data['order_by'] = 'ASC';
			$data['order_by_active'] = '';
		}

		$this->template->setTitle('Currencies');
		$this->template->setHeading('Currencies');
		$this->template->setButton('+ New', array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton('Delete', array('class' => 'btn btn-danger', 'onclick' => '$(\'#list-form\').submit();'));

		$data['text_empty'] 		= 'There are no currencies available.';

		$order_by = (isset($filter['order_by']) AND $filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
		$data['sort_country'] 		= site_url('currencies'.$url.'sort_by=country_name&order_by='.$order_by);
		$data['sort_name'] 			= site_url('currencies'.$url.'sort_by=currency_name&order_by='.$order_by);
		$data['sort_code'] 			= site_url('currencies'.$url.'sort_by=currency_code&order_by='.$order_by);

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
				'currency_status'	=> ($result['currency_status'] === '1') ? 'Enabled' : 'Disabled',
				'edit' 				=> site_url('currencies/edit?id=' . $result['currency_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('currencies').$url;
		$config['total_rows'] 		= $this->Currencies_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		if ($this->input->post('delete') AND $this->_deleteCurrency() === TRUE) {
			redirect('currencies');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('currencies', $data);
	}

	public function edit() {
		$currency_info = $this->Currencies_model->getCurrency((int) $this->input->get('id'));

		if ($currency_info) {
			$currency_id = $currency_info['currency_id'];
			$data['action']	= site_url('currencies/edit?id='. $currency_id);
		} else {
		    $currency_id = 0;
			$data['action']	= site_url('currencies/edit');
		}

		$title = (isset($currency_info['currency_name'])) ? $currency_info['currency_name'] : 'New';
		$this->template->setTitle('Currency: '. $title);
		$this->template->setHeading('Currency: '. $title);
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setBackButton('btn btn-back', site_url('currencies'));

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

		if ($this->input->post() AND $currency_id = $this->_saveCurrency()) {
			if ($this->input->post('save_close') === '1') {
				redirect('currencies');
			}

			redirect('currencies/edit?id='. $currency_id);
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('currencies_edit', $data);
	}

	public function _saveCurrency() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? 'added' : 'updated';

			if ($currency_id = $this->Currencies_model->addCurrency($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', 'Currency ' . $save_type . ' successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing ' . $save_type . '.');
			}

			return $currency_id;
		}
	}

	public function _deleteCurrency() {
    	if (is_array($this->input->post('delete'))) {
			foreach ($this->input->post('delete') as $key => $value) {
				$this->Currencies_model->deleteCurrency($value);
			}

			$this->alert->set('success', 'Currency(s) deleted successfully!');
		}

		return TRUE;
	}

	public function validateForm() {
		$this->form_validation->set_rules('currency_name', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('currency_code', 'Code', 'xss_clean|trim|required|exact_length[3]');
		$this->form_validation->set_rules('currency_symbol', 'Symbol', 'xss_clean|trim|required');
		$this->form_validation->set_rules('country_id', 'Country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('iso_alpha2', 'ISO Alpha 2', 'xss_clean|trim|required|exact_length[2]');
		$this->form_validation->set_rules('iso_alpha3', 'ISO Alpha 3', 'xss_clean|trim|required|exact_length[3]');
		$this->form_validation->set_rules('iso_numeric', 'ISO Numeric', 'xss_clean|trim|required|numeric');
		$this->form_validation->set_rules('currency_status', 'Status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file currencies.php */
/* Location: ./admin/controllers/currencies.php */