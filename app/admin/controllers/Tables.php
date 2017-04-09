<?php if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * Admin Controller Class Tables
 */
class Tables extends Admin_Controller
{

	public $filter = [
		'filter_search' => '',
		'filter_status' => '',
	];

	public $default_sort = ['table_id', 'ASC'];

	public $sort = ['table_name', 'min_capacity', 'max_capacity', 'table_id'];

	public function __construct()
	{
		parent::__construct(); //  calls the constructor

		$this->user->restrict('Admin.Tables');

		$this->load->model('Tables_model');

		$this->lang->load('tables');
	}

	public function index()
	{
		if ($this->input->post('delete') AND $this->_deleteTable() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url() . '/edit']);
		$this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;
		$this->template->setButton($this->lang->line('button_icon_filter'), ['class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button']);

		$data = $this->getList();

		$this->template->render('tables', $data);
	}

	public function edit()
	{
		if ($this->input->post() AND $table_id = $this->_saveTable()) {
			$this->redirect($table_id);
		}

		$table_info = $this->Tables_model->getTableById((int)$this->input->get('id'));

		$title = (isset($table_info['table_name'])) ? $table_info['table_name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
		$this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('tables')]);

		$data = $this->getForm($table_info);

		$this->template->render('tables_edit', $data);
	}

	public function autocomplete()
	{
		$json = [];

		if ($this->input->get('term')) {
			$results = $this->Tables_model->getAutoComplete(['table_name' => $this->input->get('term')]);
			if ($results) {
				foreach ($results as $result) {
					$json['results'][] = [
						'id'   => $result['table_id'],
						'text' => utf8_encode($result['table_name']),
						'min'  => $result['min_capacity'],
						'max'  => $result['max_capacity'],
					];
				}
			} else {
				$json['results'] = ['id' => '0', 'text' => $this->lang->line('text_no_match')];
			}
		}

		$this->output->set_output(json_encode($json));
	}

	public function getList()
	{
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['tables'] = [];
		$results = $this->Tables_model->paginateWithFilter($this->getFilter());
		foreach ($results->list as $result) {
			$data['tables'][] = array_merge($result, [
				'edit' => $this->pageUrl($this->edit_url, ['id' => $result['table_id']]),
			]);
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($table_info = [])
	{
		$data = $table_info;

		$table_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($table_info['table_id'])) {
			$table_id = $table_info['table_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, ['id' => $table_id]);
		}

		return $data;
	}

	protected function _saveTable()
	{
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($table_id = $this->Tables_model->saveTable($this->input->get('id'), $this->input->post())) {
				log_activity($this->user->getStaffId(), $save_type, 'tables', get_activity_message('activity_custom',
					['{staff}', '{action}', '{context}', '{link}', '{item}'],
					[$this->user->getStaffName(), $save_type, 'table', current_url(), $this->input->post('table_name')]
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Table ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $table_id;
		}
	}

	protected function _deleteTable()
	{
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Tables_model->deleteTable($this->input->post('delete'));

			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Tables' : 'Table';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm()
	{
		$rules[] = ['table_name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[255]'];
		$rules[] = ['min_capacity', 'lang:label_min_capacity', 'xss_clean|trim|required|integer|greater_than[1]'];
		$rules[] = ['max_capacity', 'lang:label_capacity', 'xss_clean|trim|required|integer|greater_than[1]|callback__check_capacity'];
		$rules[] = ['table_status', 'lang:label_status', 'xss_clean|trim|required|integer'];

		return $this->form_validation->set_rules($rules)->run();
	}

	public function _check_capacity($str)
	{
		if ($str < $_POST['min_capacity']) {
			$this->form_validation->set_message('_check_capacity', $this->lang->line('error_capacity'));

			return FALSE;
		}

		return TRUE;
	}
}

/* End of file Tables.php */
/* Location: ./admin/controllers/Tables.php */