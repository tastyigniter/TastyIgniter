<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Currencies extends Admin_Controller
{
	public $filter = array(
		'filter_search' => '',
		'filter_type'   => '',
		'filter_status' => '',
	);

	public $default_sort = array('currency_name', 'ASC');

	public $sort = array('country_name', 'currency_name', 'currency_code');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Site.Currencies');

		$this->load->model('Currencies_model');
		$this->load->model('Countries_model');

		$this->lang->load('currencies');
	}

	public function index() {
		if ($this->input->get('refresh') === '1') {
			if ($this->Currencies_model->updateRates(TRUE)) {
				$this->alert->set('success', $this->lang->line('alert_rates_updated'));
			}

			$this->redirect();
		}

		if ($this->input->post('delete') AND $this->_deleteCurrency() === TRUE) {
			$this->redirect();
		}


		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));
		$this->template->setButton($this->lang->line('button_update_rate'), array('class' => 'btn btn-success pull-right', 'href' => site_url('currencies?refresh=1')));;

		$data = $this->getList();

		$this->template->render('currencies', $data);
	}

	public function edit() {
		if ($this->input->post() AND $currency_id = $this->_saveCurrency()) {
			$this->redirect($currency_id);
		}

		$currency_info = $this->Currencies_model->getCurrency((int)$this->input->get('id'));

		$title = (isset($currency_info['currency_name'])) ? $currency_info['currency_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('currencies')));

		$data = $this->getForm($currency_info);

		$this->template->render('currencies_edit', $data);
	}

	public function getList() {
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['currency_id'] = $this->config->item('currency_id');

		$data['currencies'] = array();
		$results = $this->Currencies_model->paginate($this->getFilter());
		foreach ($results->list as $result) {
			$data['currencies'][] = array_merge($result, array(
				'edit' => $this->pageUrl($this->edit_url, array('id' => $result['currency_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($currency_info = array()) {
		$data = $currency_info;

		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($currency_info['country_id'])) {
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $currency_info['country_id']));
		}

		$data['currency_name'] = $currency_info['currency_name'];
		$data['currency_code'] = $currency_info['currency_code'];
		$data['currency_symbol'] = $currency_info['currency_symbol'];
		$data['country_id'] = $currency_info['country_id'];
		$data['currency_rate'] = $currency_info['currency_rate'];
		$data['symbol_position'] = $currency_info['symbol_position'];
		$data['thousand_sign'] = $currency_info['thousand_sign'];
		$data['decimal_sign'] = $currency_info['decimal_sign'];
		$data['decimal_position'] = $currency_info['decimal_position'];
		$data['currency_status'] = $currency_info['currency_status'];

		$data['countries'] = $this->Countries_model->isEnabled()->dropdown('country_name');

		return $data;
	}

	protected function _saveCurrency() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($currency_id = $this->Currencies_model->saveCurrency($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Currency ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $currency_id;
		}
	}

	protected function _deleteCurrency() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Currencies_model->deleteCurrency($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Currencies' : 'Currency';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules = [
			array('currency_name', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[32]'),
			array('currency_code', 'lang:label_code', 'xss_clean|trim|required|exact_length[3]'),
			array('currency_symbol', 'lang:label_symbol', 'xss_clean|trim|required'),
			array('country_id', 'lang:label_country', 'xss_clean|trim|required|integer'),
			array('symbol_position', 'lang:label_symbol_position', 'xss_clean|trim|required|integer|exact_length[1]'),
			array('currency_rate', 'lang:label_rate', 'xss_clean|trim|required|decimal'),
			array('thousand_sign', 'lang:label_thousand_sign', 'xss_clean|trim|required|exact_length[1]'),
			array('decimal_sign', 'lang:label_decimal_sign', 'xss_clean|trim|required|exact_length[1]'),
			array('decimal_position', 'lang:label_decimal_position', 'xss_clean|trim|required|integer|exact_length[1]'),
			array('currency_status', 'lang:label_status', 'xss_clean|trim|required|integer'),
		];

		return $this->Currencies_model->set_rules($rules)->validate();
	}
}

/* End of file Currencies.php */
/* Location: ./admin/controllers/Currencies.php */