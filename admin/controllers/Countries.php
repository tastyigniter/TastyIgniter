<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller Class Countries
 */
class Countries extends Admin_Controller
{
	public $list_filters = array(
		'filter_search' => '',
		'filter_status' => '',
		'sort_by'       => 'country_name',
		'order_by'      => 'ASC',
	);

	public $sort_columns = array('country_name', 'iso_code_2', 'iso_code_3');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Site.Countries');

		$this->load->model('Countries_model');
		$this->load->model('Image_tool_model');

		$this->lang->load('countries');
	}

	public function index() {
		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		if ($this->input->post('delete') AND $this->_deleteCountry() === TRUE) {
			$this->redirect();
		}

		$data = $this->getList();

		$this->template->render('countries', $data);
	}

	public function edit() {
		if ($this->input->post() AND $country_id = $this->_saveCountry()) {
			$this->redirect($country_id);
		}

		$country_info = $this->Countries_model->getCountry((int)$this->input->get('id'));

		$title = (isset($country_info['country_name'])) ? $country_info['country_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('countries')));

		$data = $this->getFrom($country_info);

		$this->template->render('countries_edit', $data);
	}

	protected function getList() {
		$data = array_merge($this->list_filters, $this->sort_columns);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';
		
		$data['country_id'] = $this->config->item('country_id');

		$no_country_flag = $this->Image_tool_model->resize('data/flags/no_flag.png');

		$data['countries'] = array();
		$results = $this->Countries_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $result) {
			$data['countries'][] = array_merge($result, array(
				'flag' => (!empty($result['flag'])) ? $this->Image_tool_model->resize($result['flag']) : $no_country_flag,
				'edit' => $this->pageUrl($this->edit_url, array('id' => $result['country_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	protected function getFrom($country_info = array()) {
		$data = $country_info;

		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($country_info['country_id'])) {
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $country_info['country_id']));
		}

		$data['country_name'] = $country_info['country_name'];
		$data['iso_code_2'] = $country_info['iso_code_2'];
		$data['iso_code_3'] = $country_info['iso_code_3'];
		$data['format'] = $country_info['format'];
		$data['status'] = $country_info['status'];
		$data['no_photo'] = $this->Image_tool_model->resize('data/flags/no_flag.png');

		$data['flag'] = array();
		if ($this->input->post('flag')) {
			$data['flag']['path'] = $this->Image_tool_model->resize($this->input->post('flag'));
			$data['flag']['name'] = basename($this->input->post('flag'));
			$data['flag']['input'] = $this->input->post('flag');
		} else if (!empty($country_info['flag'])) {
			$data['flag']['path'] = $this->Image_tool_model->resize($country_info['flag']);
			$data['flag']['name'] = basename($country_info['flag']);
			$data['flag']['input'] = $country_info['flag'];
		} else {
			$data['flag']['path'] = $this->Image_tool_model->resize('data/flags/no_flag.png');
			$data['flag']['name'] = 'no_flag.png';
			$data['flag']['input'] = 'data/flags/no_flag.png';
		}

		return $data;
	}

	protected function _saveCountry() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');
			if ($country_id = $this->Countries_model->saveCountry($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Country ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $country_id;
		}
	}

	protected function _deleteCountry() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Countries_model->deleteCountry($this->input->post('delete'));
			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Countries' : 'Country';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules = [
			array('country_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]'),
			array('iso_code_2', 'lang:label_iso_code2', 'xss_clean|trim|required|exact_length[2]'),
			array('iso_code_3', 'lang:label_iso_code3', 'xss_clean|trim|required|exact_length[3]'),
			array('flag', 'lang:label_flag', 'xss_clean|trim|required'),
			array('format', 'lang:label_format', 'xss_clean|trim|min_length[2]'),
			array('status', 'lang:label_status', 'xss_clean|trim|required|integer'),
		];

		return $this->Countries_model->set_rules($rules)->validate();
	}
}

/* End of file Countries.php */
/* Location: ./admin/controllers/Countries.php */