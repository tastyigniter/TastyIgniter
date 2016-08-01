<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Extensions extends Admin_Controller
{

	public $edit_url = 'extensions/edit/{type}/{name}';
	public $delete_url = 'extensions/delete/{type}/{name}';
	public $manage_url = 'extensions/{manage}/{type}/{name}';
	public $browse_url = 'extensions/browse';

	public $create_url = 'extensions/add';

	public $list_filters = array(
		'filter_search' => '',
		'filter_type'   => 'module',
		'filter_status' => '',
		'sort_by'       => 'name',
		'order_by'      => 'ASC',
	);

	public $sort_columns = array('name', 'type');

	public function __construct() {
		parent::__construct();

		$this->load->model('Extensions_model');
		$this->load->model('Layouts_model');

		$this->lang->load('extensions');
	}

	public function index() {
		$this->user->restrict('Admin.Extensions');

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/add'));
		$this->template->setButton($this->lang->line('button_browse'), array('class' => 'btn btn-default disabled', 'href' => page_url() . '/browse'));
		$this->template->setButton($this->lang->line('button_icon_filter'), array('class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button'));

		$data = $this->getList();

		$this->template->render('extensions', $data);
	}

	public function edit() {
		$this->user->restrict('Admin.Extensions.Access');

		$data = $this->getForm();

		$this->template->render('extensions_edit', $data);
	}

	public function add() {
		$this->user->restrict('Admin.Extensions.Access');

		$this->template->setTitle($this->lang->line('text_add_heading'));
		$this->template->setHeading($this->lang->line('text_add_heading'));

		$this->template->setButton($this->lang->line('button_browse'), array('class' => 'btn btn-default disabled', 'href' => site_url('extensions/browse')));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

		$data['_action'] = $this->pageUrl($this->create_url);

		if ($this->_addExtension() === TRUE) {
			$this->redirect();
		}

		$this->template->render('extensions_add', $data);
	}

	public function browse() {
		$this->user->restrict('Admin.Extensions.Access');

		$this->template->setTitle($this->lang->line('text_browse_heading'));
		$this->template->setHeading($this->lang->line('text_browse_heading'));

		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => site_url('extensions/add')));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

		$data['_action'] = $this->pageUrl($this->browse_url);

		$this->template->render('extensions_browse', $data);
	}

	public function install() {
		$this->user->restrict('Admin.Extensions.Access');
		$this->user->restrict('Admin.Extensions.Manage');

		$extension_name = ($this->input->get('name')) ? $this->input->get('name') : $this->uri->rsegment(4);

		if ($this->Extensions_model->extensionExists($extension_name)) {

			$config = $this->extension->loadConfig($extension_name, FALSE, TRUE);
			$extension_title = isset($config['extension_meta']['title']) ? $config['extension_meta']['title'] : '';
			$extension_type = isset($config['extension_meta']['type']) ? $config['extension_meta']['type'] : '';

			if ($this->Extensions_model->install($this->uri->rsegment(3), $extension_name, $config)) {
				$success = TRUE;

				log_activity($this->user->getStaffId(), 'installed', 'extensions', get_activity_message('activity_custom_no_link',
					array('{staff}', '{action}', '{context}', '{item}'),
					array($this->user->getStaffName(), 'installed', $extension_type . ' extension', $extension_title)
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$extension_title} installed "));
				if ((isset($config['layout_ready']) AND $config['layout_ready'] === TRUE)) {
					$this->alert->set('info', sprintf($this->lang->line('alert_info_layouts'), site_url('layouts')));
				}
			}
		}

		if (empty($success)) $this->alert->danger_now($this->lang->line('alert_error_try_again'));
		$this->redirect(referrer_url());
	}

	public function uninstall() {
		$this->user->restrict('Admin.Extensions.Access');
		$this->user->restrict('Admin.Extensions.Manage');

		$extension_name = ($this->input->get('name')) ? $this->input->get('name') : $this->uri->rsegment(4);

		if ($this->Extensions_model->extensionExists($extension_name)) {
			$config = $this->extension->loadConfig($extension_name, FALSE, TRUE);
			$extension_title = isset($config['extension_meta']['title']) ? $config['extension_meta']['title'] : '';
			$extension_type = isset($config['extension_meta']['type']) ? $config['extension_meta']['type'] : '';

			if ($this->Extensions_model->uninstall($this->uri->rsegment(3), $extension_name)) {
				log_activity($this->user->getStaffId(), 'uninstalled', 'extensions', get_activity_message('activity_custom_no_link',
					array('{staff}', '{action}', '{context}', '{item}'),
					array($this->user->getStaffName(), 'uninstalled', $extension_type . ' extension', $extension_title)
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$extension_title} uninstalled "));
			} else {
				$this->alert->danger_now($this->lang->line('alert_error_try_again'));
			}
		}

		$this->redirect(referrer_url());
	}

	public function delete() {
		$this->user->restrict('Admin.Extensions.Access');
		$this->user->restrict('Admin.Extensions.Delete');

		$this->template->setTitle($this->lang->line('text_delete_heading'));
		$this->template->setHeading($this->lang->line('text_delete_heading'));

		$data['extension_name'] = ($this->input->get('name')) ? $this->input->get('name') : $this->uri->rsegment(4);

		if (!$this->uri->rsegment(3) OR !$this->Extensions_model->extensionExists($data['extension_name'])) {
			$this->redirect(referrer_url());
		}

		$extension = $this->Extensions_model->getExtension($data['extension_name'], FALSE);

		$config = $this->extension->loadConfig($data['extension_name'], FALSE, TRUE);
		$data['extension_title'] = isset($config['extension_meta']['title']) ? $config['extension_meta']['title'] : '';
		$data['extension_type'] = isset($config['extension_meta']['type']) ? $config['extension_meta']['type'] : '';
		$data['extension_data'] = !empty($extension['ext_data']) ? TRUE : FALSE;
		$data['delete_action'] = !empty($extension['ext_data']) ? $this->lang->line('text_files_data') : $this->lang->line('text_files');

		if ($this->input->post('confirm_delete') === $data['extension_name']) {

			$delete_data = ($this->input->post('delete_data') === '1') ? TRUE : FALSE;

			if ($this->Extensions_model->delete($this->uri->rsegment(3), $data['extension_name'], $delete_data)) {
				log_activity($this->user->getStaffId(), 'deleted', 'extensions', get_activity_message('activity_custom_no_link',
					array('{staff}', '{action}', '{context}', '{item}'),
					array($this->user->getStaffName(), 'deleted', $data['extension_type'] . ' extension', $data['extension_title'])
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$data['extension_name']} deleted "));
			} else {
				$this->alert->danger_now($this->lang->line('alert_error_try_again'));
			}

			$this->redirect('extensions?filter_type=' . $data['extension_type']);
		}

		$files = $this->Extensions_model->getExtensionFiles($data['extension_name']);
		$data['files_to_delete'] = $files;

		$this->template->render('extensions_delete', $data);
	}

	protected function getList() {
		$data = array_merge($this->list_filters, $this->sort_columns);
		$data['order_by_active'] = $this->list_filters['order_by'] . ' active';

		$data['extensions'] = array();
		$results = $this->Extensions_model->paginate($this->list_filters, $this->index_url);
		foreach ($results->list as $result) {
			if (!is_array($result['config'])) {
				$this->alert->warning_now($result['config']);
				continue;
			}

			$result['manage'] = ($result['installed'] === TRUE AND $result['status'] === '1') ? 'uninstall' : 'install';
			$data['extensions'][] = array_merge($result, array(
				'author'      => isset($result['author']) ? $result['author'] : '--',
				'version'     => !empty($result['meta']['version']) ? $result['meta']['version'] : '',
				'type'        => ucfirst($result['type']),
				'description' => isset($result['description']) ? character_limiter($result['description'], 128) : '',
				'edit'        => $this->pageUrl($this->edit_url, $result),
				'delete'      => $this->pageUrl($this->delete_url, $result),
				'manage'      => $this->pageUrl($this->manage_url, $result),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	protected function getForm($data = array()) {
		$extension_name = ($this->input->get('name')) ? $this->input->get('name') : $this->uri->rsegment(4);
		$extension_type = $this->uri->rsegment(3);
		$loaded = $error_msg = FALSE;

		if ($extension = $this->Extensions_model->getExtension($extension_name)) {

			$data['extension_name'] = $extension_name;
			$ext_controller = $extension['name'] . '/admin_' . $extension['name'];
			$ext_class = ucfirst('admin_' . $extension['name']);

			$module_layouts = $this->Layouts_model->getModuleLayouts($extension_name);
			if (empty($module_layouts) AND isset($extension['config']['layout_ready']) AND $extension['config']['layout_ready'] === TRUE) {
				$this->alert->set('info', sprintf($this->lang->line('alert_warning_layouts'), site_url('layouts')));
			}

			if (isset($extension['config'], $extension['installed'], $extension['settings'])) {
				if (!is_array($extension['config'])) {
					$error_msg = $this->lang->line('error_config');
				} else if ($extension['settings'] === FALSE) {
					$error_msg = $this->lang->line('error_options');
				} else if ($extension['installed'] === FALSE) {
					$error_msg = $this->lang->line('error_installed');
				} else {
					$this->load->module($ext_controller);
					if (class_exists($ext_class, FALSE)) {
						if ($this->input->post()) $this->user->restrict("Admin.Extensions.Manage");

						$data['extension'] = $this->{strtolower($ext_class)}->index($extension);
						$loaded = TRUE;
					} else {
						$error_msg = sprintf($this->lang->line('error_failed'), $ext_class);
					}
				}
			}
		}

		if (!$loaded OR $error_msg !== FALSE) {
			$this->alert->set('warning', $error_msg);
			$this->redirect(referrer_url());
		}

		return $data;
	}

	protected function _addExtension() {
		$this->user->restrict('Admin.Extensions.Add', site_url('extensions/add'));

		if (isset($_FILES['extension_zip'])) {
			if ($this->validateUpload() === TRUE) {
				$message = $this->Extensions_model->extractExtension($_FILES['extension_zip']);

				if ($message === TRUE) {
					$extension_name = $_FILES['extension_zip']['name'];

					$config = $this->extension->loadConfig($extension_name, FALSE, TRUE);
					$extension_title = isset($config['extension_meta']['title']) ? $config['extension_meta']['title'] : '';
					$extension_type = isset($config['extension_meta']['type']) ? $config['extension_meta']['type'] : '';

					$alert = "Extension {$extension_title} uploaded ";

					if ($this->Extensions_model->install($extension_type, $extension_name, $config)) {
						log_activity($this->user->getStaffId(), 'installed', 'extensions', get_activity_message('activity_custom_no_link',
							array('{staff}', '{action}', '{context}', '{item}'),
							array($this->user->getStaffName(), 'installed', $extension_type . ' extension', $extension_title)
						));

						$alert .= "and installed ";
					}

					$this->alert->set('success', sprintf($this->lang->line('alert_success'), $alert));

					return TRUE;
				}

				$this->alert->danger_now(sprintf($this->lang->line('alert_error'), $message));
			}
		}

		return FALSE;
	}

	protected function validateUpload() {
		if (!empty($_FILES['extension_zip']['name']) AND !empty($_FILES['extension_zip']['tmp_name'])) {

			if (preg_match('/\s/', $_FILES['extension_zip']['name'])) {
				$this->alert->danger_now($this->lang->line('error_upload_name'));

				return FALSE;
			}

			if ($_FILES['extension_zip']['type'] !== 'application/zip') {
				$this->alert->danger_now($this->lang->line('error_upload_type'));

				return FALSE;
			}

			$_FILES['extension_zip']['name'] = html_entity_decode($_FILES['extension_zip']['name'], ENT_QUOTES, 'UTF-8');
			$_FILES['extension_zip']['name'] = str_replace(array('"', "'", "/", "\\"), "", $_FILES['extension_zip']['name']);
			$filename = $this->security->sanitize_filename($_FILES['extension_zip']['name']);
			$_FILES['extension_zip']['name'] = basename($filename, '.zip');

			if (!empty($_FILES['extension_zip']['error'])) {
				$this->alert->danger_now($this->lang->line('error_php_upload') . $_FILES['extension_zip']['error']);

				return FALSE;
			}

			if (file_exists(ROOTPATH . EXTPATH . $_FILES['extension_zip']['name'])) {
				$this->alert->danger_now(sprintf($this->lang->line('alert_error'), $this->lang->line('error_extension_exists')));

				return FALSE;
			}

			if (is_uploaded_file($_FILES['extension_zip']['tmp_name'])) return TRUE;

			return FALSE;
		}
	}
}

/* End of file Extensions.php */
/* Location: ./admin/controllers/Extensions.php */