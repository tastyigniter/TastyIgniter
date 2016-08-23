<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Statuses extends Admin_Controller
{

	public $filter = array(
		'filter_search' => '',
		'filter_type'   => '',
	);

	public $default_sort = array('status_for', 'ASC');
	
	public $sort = array('status_id', 'status_name', 'status_for', 'notify_customer');

	public function __construct() {
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Statuses');

		$this->load->model('Statuses_model');

		$this->lang->load('statuses');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteStatus() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('statuses', $data);
	}

	public function edit() {
		if ($this->input->post() AND $status_id = $this->_saveStatus()) {
			$this->redirect($status_id);
		}

		$status_info = $this->Statuses_model->getStatus((int)$this->input->get('id'));

		$title = (isset($status_info['status_name'])) ? $status_info['status_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('statuses')));

		$this->assets->setStyleTag(assets_url('js/colorpicker/css/bootstrap-colorpicker.min.css'), 'bootstrap-colorpicker-css');
		$this->assets->setScriptTag(assets_url('js/colorpicker/js/bootstrap-colorpicker.min.js'), 'bootstrap-colorpicker-js');

		$data = $this->getForm($status_info);

		$this->template->render('statuses_edit', $data);
	}

	public function comment_notify() {
		if ($this->input->get('status_id')) {
			$status = $this->Statuses_model->getStatus($this->input->get('status_id'));

			$json = array('comment' => $status['status_comment'], 'notify' => $status['notify_customer']);

			$this->output->set_output(json_encode($json));
		}
	}

	public function getList() {
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['statuses'] = array();
		$results = $this->Statuses_model->paginate($this->getFilter());
		foreach ($results->list as $result) {
			$data['statuses'][] = array_merge($result, array(
				'edit' => $this->pageUrl($this->edit_url, array('id' => $result['status_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($status_info) {
		$data = $status_info;

		$status_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($status_info['status_id'])) {
			$status_id = $status_info['status_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $status_id));
		}

		$data['status_id'] = $status_info['status_id'];
		$data['status_name'] = $status_info['status_name'];
		$data['status_color'] = $status_info['status_color'];
		$data['status_comment'] = $status_info['status_comment'];
		$data['status_for'] = $status_info['status_for'];
		$data['notify_customer'] = $status_info['notify_customer'];

		return $data;
	}

	protected function _saveStatus() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($status_id = $this->Statuses_model->saveStatus($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Status ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $status_id;
		}
	}

	protected function _deleteStatus() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Statuses_model->deleteStatus($this->input->post('delete'));

			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Order Statuses' : 'Order Status';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('status_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
		$rules[] = array('status_for', 'lang:label_for', 'xss_clean|trim|required|alpha');
		$rules[] = array('status_color', 'lang:label_color', 'xss_clean|trim|required|max_length[7]');
		$rules[] = array('status_comment', 'lang:label_comment', 'xss_clean|trim|max_length[1028]');
		$rules[] = array('notify_customer', 'lang:label_notify', 'xss_clean|trim|integer');

		return $this->Statuses_model->set_rules($rules)->validate();
	}
}

/* End of file Statuses.php */
/* Location: ./admin/controllers/Statuses.php */