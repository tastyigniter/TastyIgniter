<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Currencies extends Admin_Controller
{
	public $filter = [
		'filter_search' => '',
		'filter_type'   => '',
		'filter_status' => '',
	];

	public $default_sort = ['currency_name', 'ASC'];

	public $sort = ['country_name', 'currency_name', 'currency_code'];

	public function __construct()
	{
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Site.Currencies');

		$this->load->model('Currencies_model');
		$this->load->model('Countries_model');

		$this->lang->load('currencies');
	}

	public function index()
	{
		if ($this->input->get('refresh') == '1') {
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
		$this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url() . '/edit']);
		$this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;
		$this->template->setButton($this->lang->line('button_icon_filter'), ['class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button']);
		$this->template->setButton($this->lang->line('button_update_rate'), ['class' => 'btn btn-success pull-right', 'href' => site_url('currencies?refresh=1')]);;

		$data = $this->getList();

		$this->template->render('currencies', $data);
	}

	public function edit()
	{
		if ($this->input->post() AND $currency_id = $this->_saveCurrency()) {
			$this->redirect($currency_id);
		}

		$currencyModel = $this->Currencies_model->joinCountryTable()
												->findOrNew((int)$this->input->get('id'));

		$title = (isset($currencyModel->currency_name)) ?: $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
		$this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('currencies')]);

		$data = $this->getForm($currencyModel);

		$this->template->render('currencies_edit', $data);
	}

	public function getList()
	{
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['currency_id'] = $this->config->item('currency_id');

		$data['currencies'] = [];
		$results = $this->Currencies_model->paginateWithFilter($this->getFilter());
		foreach ($results->list as $result) {
			$data['currencies'][] = array_merge($result, [
				'edit' => $this->pageUrl($this->edit_url, ['id' => $result['currency_id']]),
			]);
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm(Currencies_model $currencyModel)
	{
		$data = $currency_info = $currencyModel->toArray();

		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($currency_info['currency_id'])) {
			$data['_action'] = $this->pageUrl($this->edit_url, ['id' => $currency_info['currency_id']]);
		}

		$data['countries'] = $this->Countries_model->isEnabled()->dropdown('country_name');

		return $data;
	}

	protected function _saveCurrency()
	{
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

	protected function _deleteCurrency()
	{
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

	protected function validateForm()
	{
		$rules = [
			['currency_name', 'lang:label_title', 'xss_clean|trim|required|min_length[2]|max_length[32]'],
			['currency_code', 'lang:label_code', 'xss_clean|trim|required|exact_length[3]'],
			['currency_symbol', 'lang:label_symbol', 'xss_clean|trim|required'],
			['country_id', 'lang:label_country', 'xss_clean|trim|required|integer'],
			['symbol_position', 'lang:label_symbol_position', 'xss_clean|trim|required|integer|exact_length[1]'],
			['currency_rate', 'lang:label_rate', 'xss_clean|trim|required|decimal'],
			['thousand_sign', 'lang:label_thousand_sign', 'xss_clean|trim|required|exact_length[1]'],
			['decimal_sign', 'lang:label_decimal_sign', 'xss_clean|trim|required|exact_length[1]'],
			['decimal_position', 'lang:label_decimal_position', 'xss_clean|trim|required|integer|exact_length[1]'],
			['currency_status', 'lang:label_status', 'xss_clean|trim|required|integer'],
		];

		return $this->form_validation->set_rules($rules)->run();
	}
}

/* End of file Currencies.php */
/* Location: ./admin/controllers/Currencies.php */