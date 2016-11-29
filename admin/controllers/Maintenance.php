<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Maintenance extends Admin_Controller
{
	public $create_url = 'maintenance/backup';
	public $browse_url = 'maintenance/browse_table';

	public $edit_url = 'maintenance/backup?{action}={name}';

	public $filter = [
		'table' => '',
	];

	public function __construct()
	{
		parent::__construct(); //  calls the constructor

		$this->load->model('Maintenance_model');

		$this->lang->load('maintenance');
	}

	public function index()
	{
		$this->user->restrict('Admin.Maintenance.Access');

		if ($this->input->post('migrate') AND $this->_migrate() === TRUE) {
			$this->redirect();
		}

		if ($this->Maintenance_model->checkTables($this->input->post('tables'))) {
			$this->session->set_flashdata('tables', $this->input->post('tables'));
			$this->redirect($this->create_url);
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));

		$this->template->setButton($this->lang->line('button_backup'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#tables-form\').submit();']);
		$this->template->setButton($this->lang->line('button_migrate'), ['class' => 'btn btn-success', 'onclick' => '$(\'#migrate-form\').submit();']);

		$data = $this->getList();

		$this->template->render('maintenance', $data);
	}

	public function backup()
	{
		$this->user->restrict('Admin.Maintenance.Manage');

		if ($this->input->get('restore') AND $this->_restore() === TRUE) {
			$this->redirect();
		} else if ($this->input->get('download') AND $this->_download() === TRUE) {
			$this->redirect();
		} else if ($this->input->get('delete') AND $this->_delete() === TRUE) {
			$this->redirect();
		}

		$checked_tables = ($this->session->flashdata('tables')) ? $this->session->flashdata('tables') : $this->input->post('tables');
		if (!$this->Maintenance_model->checkTables($checked_tables)) {
			$this->redirect();
		} else if ($this->input->post('tables') AND $this->input->post('compression') AND $this->_backup() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_backup_heading'));
		$this->template->setHeading($this->lang->line('text_backup_heading'));

		$this->template->setButton($this->lang->line('button_backup'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
		$this->template->setButton($this->lang->line('button_migrate'), ['class' => 'btn btn-success', 'onclick' => '$(\'#migrate-form\').submit();']);
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('maintenance')]);

		$data = $this->getForm();

		$this->template->render('maintenance', $data);
	}

	public function browse_table()
	{
		$this->user->restrict('Admin.Maintenance.Access');
		$this->user->restrict('Admin.Maintenance.Manage');

		if ($this->uri->rsegment(3)) {
			$this->setFilter('table', $this->uri->rsegment(3));
		}

		$this->template->setTitle(sprintf($this->lang->line('text_browse_heading'), $this->getFilter('table')));
		$this->template->setHeading(sprintf($this->lang->line('text_browse_heading'), $this->getFilter('table')));
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('maintenance')]);

		$data = $this->getTableList();

		$this->template->render('maintenance_browse', $data);
	}

	public function getList()
	{
		$this->load->helper('number');

		$data['backup_tables'] = FALSE;
		$data['db_tables'] = [];
		$db_tables = $this->Maintenance_model->getdbTables();
		foreach ($db_tables as $db_table) {
			$data['db_tables'][] = [
				'name'         => $db_table['table_name'],
				'records'      => $db_table['table_rows'],
				'data_length'  => byte_format($db_table['data_length']),
				'index_length' => byte_format($db_table['index_length']),
				'data_free'    => byte_format($db_table['data_free']),
				'engine'       => $db_table['engine'],
				'browse'       => $this->pageUrl($this->browse_url . '/' . $db_table['table_name']),
			];
		}

		$data['backup_files'] = [];
		$backup_files = $this->Maintenance_model->getBackupFiles();
		foreach ($backup_files as $file) {
			$data['backup_files'][] = array_merge($file, [
				'download' => $this->pageUrl($this->edit_url, ['action' => 'download', 'name' => $file['filename']]),
				'restore'  => $this->pageUrl($this->edit_url, ['action' => 'restore', 'name' => $file['filename']]),
				'delete'   => $this->pageUrl($this->edit_url, ['action' => 'delete', 'name' => $file['filename']]),
			]);
		}

		$migrate_type = 'core';
		$this->load->library('migration');
		$data['installed_version'] = $this->migration->get_version($migrate_type);
		$data['latest_version'] = (int)$this->migration->get_latest_version($migrate_type);

		$data['migration_files'] = [];
		if ($migration_files = $this->migration->find_migrations($migrate_type)) {
			foreach ($migration_files as $version => $migration_file) {
				$migration_file = basename($migration_file);
				$version = $this->migration->get_migration_number(basename($migration_file));
				$data['migration_files'][$version] = $migration_file;
			}
		}

		return $data;
	}

	public function getForm()
	{
		$data['backup_tables'] = TRUE;

		$timestamp = mdate('%Y-%m-%d-%H-%i-%s', now());

		if ($this->input->post('file_name')) {
			$data['file_name'] = $this->input->post('file_name');
		} else {
			$data['file_name'] = 'tastyigniter-' . $timestamp;
		}

		if ($this->input->post('drop_tables')) {
			$data['drop_tables'] = $this->input->post('drop_tables');
		} else {
			$data['drop_tables'] = '0';
		}

		if ($this->input->post('add_inserts')) {
			$data['add_inserts'] = $this->input->post('add_inserts');
		} else {
			$data['add_inserts'] = '1';
		}

		if ($this->input->post('compression')) {
			$data['compression'] = $this->input->post('compression');
		} else {
			$data['compression'] = 'none';
		}

		if ($this->session->flashdata('tables')) {
			$data['tables'] = $this->session->flashdata('tables');
		} else if ($this->input->post('tables')) {
			$data['tables'] = $this->input->post('tables');
		} else {
			$data['tables'] = [];
		}

		return $data;
	}

	protected function getTableList()
	{
		$table_info = $this->Maintenance_model->browseTable($this->getFilter());

		$data['sql_query'] = 'SELECT * FROM (' . $this->filter['table'] . ')';

		if (!empty($table_info['query'])) {
			$this->load->library('table');
			$template = ['table_open' => '<table class="table table-striped table-border">'];
			$this->table->set_template($template);
			$data['query_table'] = $this->table->generate($table_info['query']);
		} else {
			$data['query_table'] = '';
		}

		$config['base_url'] = $this->pageUrl($this->browse_url . '/' . $this->filter['table']);
		$config['total_rows'] = !empty($table_info['total_rows']) ? $table_info['total_rows'] : '0';
		$config['per_page'] = $this->filter['limit'];

		$data['pagination'] = $this->Maintenance_model->buildPaginateHtml($config);

		return $data;
	}

	protected function _backup()
	{
		if ($this->input->post('tables') AND $this->validateForm() === TRUE) {

			if ($this->Maintenance_model->backupDatabase($this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Database backed up '));
			}

			return TRUE;
		}
	}

	protected function _restore()
	{
		$this->user->restrict('Admin.Maintenance.Add');

		if ($this->input->get('restore')) {
			if ($this->config->item('maintenance_mode') != '1') {
				$this->alert->set('warning', sprintf($this->lang->line('alert_warning_maintenance'), 'restore'));
			} else if ($this->Maintenance_model->restoreDatabase($this->input->get('restore'))) { // calls model to save data to SQL
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Database restored '));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'restored'));
			}

			return TRUE;
		}
	}

	protected function _download()
	{
		$this->user->restrict('Admin.Maintenance.Manage');

		if ($this->input->get('download') AND $result = $this->Maintenance_model->readBackupFile($this->input->get('download'))) {

			$this->load->helper('download');
			force_download($result['filename'], $result['content']);
		}
	}

	protected function _delete()
	{
		$this->user->restrict('Admin.Maintenance.Delete');

		if ($this->input->get('delete')) {
			if ($result = $this->Maintenance_model->deleteBackupFile($this->input->get('delete'))) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Database backup deleted '));
			}

			return TRUE;
		}
	}

	protected function _migrate()
	{
		$this->user->restrict('Admin.Maintenance.Manage');

		if ($this->input->post('migrate') AND is_numeric($this->input->post('migrate'))) {
			if (ENVIRONMENT === 'production' AND $this->config->item('maintenance_mode') != '1') {
				$this->alert->set('warning', sprintf($this->lang->line('alert_warning_maintenance'), 'migrate'));
			} else {
				$this->load->library('migration');
				$migrate = (int)$this->migration->get_migration_number($this->input->post('migrate'));

				if ($this->migration->version($migrate, 'core')) {
					$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Database migrated '));
				} else {
					$this->alert->set('warning', sprintf($this->lang->line('alert_error'), $this->migration->error_string()));
				}
			}
		}

		return TRUE;
	}

	protected function validateForm()
	{
		$rules[] = ['file_name', 'lang:label_file_name', 'xss_clean|trim|required'];
		$rules[] = ['drop_tables', 'lang:label_drop_tables', 'xss_clean|trim|required|alpha_dash'];
		$rules[] = ['add_inserts', 'lang:label_add_inserts', 'xss_clean|trim|required|alpha_dash'];
		$rules[] = ['compression', 'lang:label_compression', 'xss_clean|trim|required|alpha_dash'];
		$rules[] = ['tables[]', 'lang:label_backup_table', 'xss_clean|trim|required|alpha_dash'];

		if (!empty($_POST['file_name'])) {
			$_POST['file_name'] = html_entity_decode($_POST['file_name'], ENT_QUOTES, 'UTF-8');
			$_POST['file_name'] = str_replace(['"', "'", "/", "\\"], "", $_POST['file_name']);
			$filename = $this->security->sanitize_filename($_POST['file_name']);
			$_POST['file_name'] = basename($filename);
		}

		return $this->form_validation->set_rules($rules)->run();
	}
}

/* End of file Maintenance.php */
/* Location: ./admin/controllers/Maintenance.php */