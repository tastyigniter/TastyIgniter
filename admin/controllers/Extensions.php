<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Extensions extends Admin_Controller
{

	public $edit_url = 'extensions/{code}/settings';
	public $delete_url = 'extensions/delete/{code}';
	public $manage_url = 'extensions/{manage}/{code}';
	public $browse_url = 'updates/browse/extensions';
	public $check_url = 'updates';

	public $create_url = 'extensions/add';

	public $filter = [
		'filter_search' => '',
		'filter_type'   => 'module',
		'filter_status' => '',
	];

	public $default_sort = ['name', 'ASC'];

	public $sort = ['name', 'type'];

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Extensions_model');
		$this->load->model('Layouts_model');

		$this->lang->load('extensions');
	}

	public function _remap($method)
	{
		if ($method !== 'edit' AND method_exists($this, $method)) {
			$this->$method();
		} else if (strtolower($this->uri->segment(3)) === 'settings') {
			$this->edit();
		} else {
			show_404($this->uri->uri_string());
		}
	}

	public function index()
	{
		$this->user->restrict('Admin.Extensions');

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url() . '/add']);
		$this->template->setButton($this->lang->line('button_browse'), ['class' => 'btn btn-default', 'href' => $this->pageUrl($this->browse_url)]);
		$this->template->setButton($this->lang->line('button_icon_filter'), ['class' => 'btn btn-default btn-filter pull-right', 'data-toggle' => 'button']);
		$this->template->setButton($this->lang->line('button_check'), ['class' => 'btn btn-default', 'href' => $this->pageUrl($this->check_url)]);

		$data = $this->getList();

		$this->template->render('extensions', $data);
	}

	public function edit()
	{
		$this->user->restrict('Admin.Extensions.Access');

		$data = $this->getForm();

		$this->template->render('extensions_edit', $data);
	}

	public function add()
	{
		$this->user->restrict('Admin.Extensions.Access');

		$this->template->setTitle($this->lang->line('text_add_heading'));
		$this->template->setHeading($this->lang->line('text_add_heading'));

		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('extensions')]);
		$this->template->setButton($this->lang->line('button_browse'), ['class' => 'btn btn-default', 'href' => $this->pageUrl($this->browse_url)]);

		$data['_action'] = $this->pageUrl($this->create_url);

		if ($this->_addExtension() === TRUE) {
			$this->redirect();
		}

		$this->template->render('extensions_add', $data);
	}

	public function browse()
	{
		$this->user->restrict('Admin.Extensions.Access');

		$this->template->setTitle($this->lang->line('text_browse_heading'));
		$this->template->setHeading($this->lang->line('text_browse_heading'));

		$this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => site_url('extensions/add')]);
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('extensions')]);

		$data['_action'] = $this->pageUrl($this->browse_url);

		$this->template->render('extensions_browse', $data);
	}

	public function install()
	{
		$this->user->restrict('Admin.Extensions.Access');
		$this->user->restrict('Admin.Extensions.Manage');

		$extension_code = $this->uri->rsegment(3);

		if ($extension = Modules::find_extension($extension_code)) {

			$meta = $extension->extensionMeta();
			$extension_name = isset($meta['name']) ? $meta['name'] : '';

			if ($this->Extensions_model->install($extension_code, $extension)) {
				$success = TRUE;

				log_activity($this->user->getStaffId(), 'installed', 'extensions', get_activity_message('activity_custom_no_link',
					['{staff}', '{action}', '{context}', '{item}'],
					[$this->user->getStaffName(), 'installed', 'extension', $extension_name]
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$extension_name} installed "));
				if ((isset($config['layout_ready']) AND $config['layout_ready'] === TRUE)) {
					$this->alert->set('info', sprintf($this->lang->line('alert_info_layouts'), site_url('layouts')));
				}
			}
		}

		if (empty($success)) $this->alert->danger_now($this->lang->line('alert_error_try_again'));
		$this->redirect(referrer_url());
	}

	public function uninstall()
	{
		$this->user->restrict('Admin.Extensions.Access');
		$this->user->restrict('Admin.Extensions.Manage');

		$extension_code = $this->uri->rsegment(3);

		if ($extension = Modules::find_extension($extension_code)) {

			$meta = $extension->extensionMeta();
			$extension_name = isset($meta['name']) ? $meta['name'] : '';

			if ($this->Extensions_model->uninstall($extension_code, $extension)) {
				log_activity($this->user->getStaffId(), 'uninstalled', 'extensions', get_activity_message('activity_custom_no_link',
					['{staff}', '{action}', '{context}', '{item}'],
					[$this->user->getStaffName(), 'uninstalled', 'extension', $extension_name]
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$extension_name} uninstalled "));
			} else {
				$this->alert->danger_now($this->lang->line('alert_error_try_again'));
			}
		}

		$this->redirect(referrer_url());
	}

	public function delete()
	{
		$this->user->restrict('Admin.Extensions.Access');
		$this->user->restrict('Admin.Extensions.Delete');

		$this->template->setTitle($this->lang->line('text_delete_heading'));
		$this->template->setHeading($this->lang->line('text_delete_heading'));

		$data['extension_code'] = $this->uri->rsegment(3);

		if (!($extension = Modules::find_extension($data['extension_code']))) {
			$this->redirect(referrer_url());
		}

		$meta = $extension->extensionMeta();
		$extension = $this->Extensions_model->getExtension($data['extension_code'], FALSE);

		$data['extension_name'] = isset($meta['name']) ? $meta['name'] : '';
		$data['extension_data'] = !empty($extension['ext_data']) ? TRUE : FALSE;
		$data['delete_action'] = !empty($extension['ext_data']) ? $this->lang->line('text_files_data') : $this->lang->line('text_files');

		if ($this->input->post('confirm_delete') == $data['extension_code']) {
			$delete_data = ($this->input->post('delete_data') == '1') ? TRUE : FALSE;

			if ($this->Extensions_model->delete($data['extension_code'], $delete_data)) {
				log_activity($this->user->getStaffId(), 'deleted', 'extensions', get_activity_message('activity_custom_no_link',
					['{staff}', '{action}', '{context}', '{item}'],
					[$this->user->getStaffName(), 'deleted', $data['extension_type'] . ' extension', $data['extension_name']]
				));

				$this->alert->set('success', sprintf($this->lang->line('alert_success'), "Extension {$data['extension_name']} deleted "));
			} else {
				$this->alert->danger_now($this->lang->line('alert_error_try_again'));
			}

			$this->redirect(referrer_url());
		}

		$files = $this->Extensions_model->getExtensionFiles($data['extension_code']);
		$data['files_to_delete'] = $files;

		$this->template->render('extensions_delete', $data);
	}

	public function getList()
	{
		$data = array_merge($this->getFilter(), $this->getSort());

		$data['extensions'] = [];
		$results = $this->Extensions_model->paginateWithFilter($this->getFilter());
		foreach ($results->list as $result) {
			$result['manage'] = ($result['installed'] === TRUE AND $result['status'] == '1') ? 'uninstall' : 'install';
			$data['extensions'][] = array_merge($result, [
				'author'      => isset($result['author']) ? $result['author'] : '--',
				'version'     => !empty($result['version']) ? $result['version'] : '',
				'description' => isset($result['description']) ? character_limiter($result['description'], 128) : '',
				'edit'        => $result['settings'],
				'delete'      => $this->pageUrl($this->delete_url, $result),
				'manage'      => $this->pageUrl($this->manage_url, $result),
			]);
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($data = [])
	{
		$extension_code = $this->uri->rsegment(2);
		$loaded = $error_msg = FALSE;

		$extension = Modules::find_extension($extension_code);
		if (!Modules::is_disabled($extension_code)) {
			$meta = $extension->extensionMeta();
			$db_extension = $this->Extensions_model->getExtension($extension_code);
			$module_layouts = $this->Layouts_model->getModuleLayouts($extension_code);
			$components = $extension->registerComponents();

			if (!empty($components) AND empty($module_layouts)) {
				$this->alert->set('info', sprintf($this->lang->line('alert_warning_layouts'), site_url('layouts')));
			}

			$ext_controller = $meta['code'] . '/settings';
			$ext_class = 'Settings';

			if ($settings = $extension->registerSettings()) {
				if (empty($settings)) {
					$error_msg = $this->lang->line('error_options');
				} else if ($db_extension['installed'] === FALSE) {
					$error_msg = $this->lang->line('error_installed');
				} else {
					$this->load->module($ext_controller);
					if (class_exists($ext_class, FALSE)) {
						if ($this->input->post()) $this->user->restrict("Admin.Extensions.Manage");

						$data['extension'] = $this->{strtolower($ext_class)}->index($db_extension);
						$loaded = TRUE;
					} else {
						$error_msg = sprintf($this->lang->line('error_failed'), $ext_class);
					}
				}
			} else {
				show_404($ext_controller);
			}
		}

		if (!$loaded OR $error_msg !== FALSE) {
			$this->alert->set('warning', $error_msg);
			$this->redirect('extensions');
		}

		return $data;
	}

	protected function _addExtension()
	{
		$this->user->restrict('Admin.Extensions.Add', site_url('extensions/add'));

		if (isset($_FILES['extension_zip'])) {
			if ($this->validateUpload() === TRUE) {
				$extension_name = $_FILES['extension_zip']['name'];

				Modules::extract_extension($_FILES['extension_zip']['tmp_name']);

				$path = Modules::path($extension_name);
				if ($extension = Modules::load_extension($extension_name, $path)) {
					$meta = $extension->extensionMeta();

					$extension_name = isset($meta['name']) ? $meta['name'] : '';
					$extension_type = isset($meta['type']) ? $meta['type'] : '';
					$alert = "Extension {$extension_name} uploaded ";

					if ($this->Extensions_model->install($extension_name, $extension)) {
						log_activity($this->user->getStaffId(), 'installed', 'extensions', get_activity_message('activity_custom_no_link',
							['{staff}', '{action}', '{context}', '{item}'],
							[$this->user->getStaffName(), 'installed', $extension_type . ' extension', $extension_name]
						));

						$alert .= "and installed ";
					}

					$this->alert->set('success', sprintf($this->lang->line('alert_success'), $alert));

					return TRUE;
				}

				$this->alert->danger_now(sprintf($this->lang->line('alert_error'), $this->lang->line('error_config_no_found')));
			}
		}

		return FALSE;
	}

	protected function validateUpload()
	{
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
			$_FILES['extension_zip']['name'] = str_replace(['"', "'", "/", "\\"], "", $_FILES['extension_zip']['name']);
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