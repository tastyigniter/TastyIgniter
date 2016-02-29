<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Currencies extends Admin_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Site.Currencies');

        $this->load->model('Currencies_model');
        $this->load->model('Countries_model');

        $this->load->library('pagination');

        $this->lang->load('currencies');
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

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() .'/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_update_rate'), array('class' => 'btn btn-success pull-right', 'href' => site_url('currencies?refresh=1')));;

		if ($this->input->get('refresh') === '1') {
			if ($this->Currencies_model->updateRates(TRUE)) {
				$this->alert->set('success', $this->lang->line('alert_rates_updated'));
			}

			redirect('currencies');
		}

		if ($this->input->post('delete') AND $this->_deleteCurrency() === TRUE) {
			redirect('currencies');
		}

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
				'currency_rate'	    => $result['currency_rate'],
				'country_name'		=> $result['country_name'],
				'currency_status'	=> ($result['currency_status'] === '1') ? $this->lang->line('text_enabled') : $this->lang->line('text_disabled'),
				'edit' 				=> site_url('currencies/edit?id=' . $result['currency_id'])
			);
		}

		if ($this->input->get('sort_by') AND $this->input->get('order_by')) {
			$url .= 'sort_by='.$filter['sort_by'].'&';
			$url .= 'order_by='.$filter['order_by'].'&';
		}

		$config['base_url'] 		= site_url('currencies'.$url);
		$config['total_rows'] 		= $this->Currencies_model->getCount($filter);
		$config['per_page'] 		= $filter['limit'];

		$this->pagination->initialize($config);

		$data['pagination'] = array(
			'info'		=> $this->pagination->create_infos(),
			'links'		=> $this->pagination->create_links()
		);

		$this->template->render('currencies', $data);
	}

	public function edit() {
		$currency_info = $this->Currencies_model->getCurrency((int) $this->input->get('id'));

		if ($currency_info) {
			$currency_id = $currency_info['currency_id'];
			$data['_action']	= site_url('currencies/edit?id='. $currency_id);
		} else {
		    $currency_id = 0;
			$data['_action']	= site_url('currencies/edit');
		}

		$title = (isset($currency_info['currency_name'])) ? $currency_info['currency_name'] : $this->lang->line('text_new');
        $this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        $this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('currencies')));

		if ($this->input->post() AND $currency_id = $this->_saveCurrency()) {
			if ($this->input->post('save_close') === '1') {
				redirect('currencies');
			}

			redirect('currencies/edit?id='. $currency_id);
		}

		$data['currency_name'] 		= $currency_info['currency_name'];
		$data['currency_code'] 		= $currency_info['currency_code'];
		$data['currency_symbol'] 	= $currency_info['currency_symbol'];
		$data['country_id'] 		= $currency_info['country_id'];
		$data['currency_rate'] 		= $currency_info['currency_rate'];
		$data['symbol_position']    = $currency_info['symbol_position'];
		$data['thousand_sign'] 		= $currency_info['thousand_sign'];
		$data['decimal_sign'] 		= $currency_info['decimal_sign'];
		$data['decimal_position']   = $currency_info['decimal_position'];
		$data['currency_status'] 	= $currency_info['currency_status'];

		$data['countries'] = array();
		$results = $this->Countries_model->getCountries(); 										// retrieve countries array from getCountries method in locations model
		foreach ($results as $result) {															// loop through crountries array
			$data['countries'][] = array( 														// create array of countries data to pass to view
				'country_id'	=>	$result['country_id'],
				'name'			=>	$result['country_name'],
			);
		}

		$this->template->render('currencies_edit', $data);
	}

	private function _saveCurrency() {
    	if ($this->validateForm() === TRUE) {
            $save_type = ( ! is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($currency_id = $this->Currencies_model->saveCurrency($this->input->get('id'), $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Currency '.$save_type));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $currency_id;
		}
	}

	private function _deleteCurrency() {
        if ($this->input->post('delete')) {
            $deleted_rows = $this->Currencies_model->deleteCurrency($this->input->post('delete'));

            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Currencies': 'Currency';
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
	}

	private function validateForm() {
		$this->form_validation->set_rules('currency_name', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$this->form_validation->set_rules('currency_code', 'lang:label_code', 'xss_clean|trim|required|exact_length[3]');
		$this->form_validation->set_rules('currency_symbol', 'lang:label_symbol', 'xss_clean|trim|required');
		$this->form_validation->set_rules('country_id', 'lang:label_country', 'xss_clean|trim|required|integer');
		$this->form_validation->set_rules('symbol_position', 'lang:label_symbol_position', 'xss_clean|trim|required|integer|exact_length[1]');
		$this->form_validation->set_rules('currency_rate', 'lang:label_rate', 'xss_clean|trim|required|decimal');
		$this->form_validation->set_rules('thousand_sign', 'lang:label_thousand_sign', 'xss_clean|trim|required|exact_length[1]');
		$this->form_validation->set_rules('decimal_sign', 'lang:label_decimal_sign', 'xss_clean|trim|required|exact_length[1]');
		$this->form_validation->set_rules('decimal_position', 'lang:label_decimal_position', 'xss_clean|trim|required|integer|exact_length[1]');
		$this->form_validation->set_rules('currency_status', 'lang:label_status', 'xss_clean|trim|required|integer');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file currencies.php */
/* Location: ./admin/controllers/currencies.php */