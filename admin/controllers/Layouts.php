<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Layouts extends Admin_Controller
{

	public function __construct() {
		parent::__construct();

		$this->user->restrict('Site.Layouts');

		$this->load->model('Layouts_model');
		$this->load->model('Extensions_model');

		$this->lang->load('layouts');
	}

	public function index() {
		if ($this->input->post('delete') AND $this->_deleteLayout() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), array('class' => 'btn btn-primary', 'href' => page_url() . '/edit'));
		$this->template->setButton($this->lang->line('button_delete'), array('class' => 'btn btn-danger', 'onclick' => 'confirmDelete();'));;

		$data = $this->getList();

		$this->template->render('layouts', $data);
	}

	public function edit() {
		if ($this->input->post() AND $layout_id = $this->_saveLayout()) {
			$this->redirect($layout_id);
		}

		$layout_info = $this->Layouts_model->getLayout((int)$this->input->get('id'));

		$title = (isset($layout_info['name'])) ? $layout_info['name'] : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
		$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
		$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('layouts')));

		$this->template->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

		$data = $this->getForm($layout_info);

		$this->template->render('layouts_edit', $data);
	}

	public function getList() {
		$_modules = $this->Extensions_model->getModules();

		$this->load->model('Layout_modules_model');
		$modules = $this->Layout_modules_model->getLayoutModules();

		$data['layouts'] = array();
		$results = $this->Layouts_model->paginate();
		foreach ($results->list as $result) {
			$layout_modules = array();
			if (isset($modules[$result['layout_id']])) foreach ($modules[$result['layout_id']] as $module) {
				foreach ($_modules as $mod) {
					if ($mod['name'] === $module['module_code']) {
						$layout_modules[] = $mod['title'];
					}
				}
			}

			$data['layouts'][] = array_merge($result, array(
				'modules' => implode(', ', $layout_modules),
				'edit' => $this->pageUrl($this->edit_url, array('id' => $result['layout_id'])),
			));
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm($layout_info) {
		$data = $layout_info;

		$layout_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($layout_info['layout_id'])) {
			$layout_id = $layout_info['layout_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, array('id' => $layout_id));
		}

		$data['layout_id'] = $layout_info['layout_id'];
		$data['name'] = $layout_info['name'];

		$theme_partials = get_theme_partials($this->config->item('main', 'default_themes'), 'main');
		foreach ($theme_partials as $partial) {
			$partial['id'] = isset($partial['id']) ? $partial['id'] : '';
			$deprecated_id = explode('_', $partial['id']);
			$partial['deprecated_id'] = isset($deprecated_id['1']) ? $deprecated_id['1'] : ''; // support @DEPRECATED position key
			$partial['name'] = isset($partial['name']) ? $partial['name'] : '';
			$data['theme_partials'][] = $partial;
		}

		$data['modules'] = array();
		$results = $this->Extensions_model->getModules();
		foreach ($results as $result) {
			$config = $this->extension->loadConfig($result['name'], FALSE, TRUE);

			if (empty($config['layout_ready'])) continue;

			$meta = $this->extension->getMeta($result['name'], $config);
			$data['modules'][$result['name']] = array_merge($result, array(
				'module_code'	=> $result['name'],
				'description' => (strlen($meta['description']) > 70) ? character_limiter($meta['description'], 70) : $meta['description'],
			));
		}

		if ($this->input->post('modules')) {
			$modules = $this->input->post('modules');
		} else {
			$modules = $this->Layouts_model->getLayoutModules($layout_id);
		}

		$data['partial_modules'] = array();
		foreach ($modules as $partial => $partial_modules) {
			$partial_modules = (is_numeric($partial)) ? $partial_modules : $partial_modules;
			foreach ($partial_modules as $priority => $module) {
				$data['partial_modules'][$partial][] = array_merge($module, array(
					'name'     => isset($data['modules'][$module['module_code']]['title']) ? $data['modules'][$module['module_code']]['title'] : $module['module_code'],
					'partial'  => !empty($module['partial']) ? $module['partial'] : $partial,
					'priority' => !empty($module['priority']) ? $module['priority'] : $priority,
					'fixed'    => isset($module['fixed']) ? $module['fixed'] : '0',
					'status'   => isset($module['status']) ? $module['status'] : '1',
				));
			}
		}

		if ($this->input->post('routes')) {
			$data['layout_routes'] = $this->input->post('routes');
		} else {
			$data['layout_routes'] = $this->Layouts_model->getLayoutRoutes($layout_id);
		}

		$data['routes'] = array();
		$results = $this->Layouts_model->getRoutes(1);
		foreach ($results as $result) {
			$data['routes'][] = array(
				'route_id' => $result['uri_route_id'],
				'route'    => $result['uri_route'],
			);
		}

		return $data;
	}

	protected function _saveLayout() {
		if ($this->validateForm() === TRUE) {
			$save_type = (!is_numeric($this->input->get('id'))) ? $this->lang->line('text_added') : $this->lang->line('text_updated');

			if ($layout_id = $this->Layouts_model->saveLayout($this->input->get('id'), $this->input->post())) {
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Layout ' . $save_type));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $save_type));
			}

			return $layout_id;
		}
	}

	protected function _deleteLayout() {
		if ($this->input->post('delete')) {
			$deleted_rows = $this->Layouts_model->deleteLayout($this->input->post('delete'));

			if ($deleted_rows > 0) {
				$prefix = ($deleted_rows > 1) ? '[' . $deleted_rows . '] Layouts' : 'Layout';
				$this->alert->set('success', sprintf($this->lang->line('alert_success'), $prefix . ' ' . $this->lang->line('text_deleted')));
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		$rules[] = array('name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($this->input->post('routes')) {
			foreach ($this->input->post('routes') as $key => $value) {
				$rules[] = array('routes[' . $key . '][uri_route]', 'lang:label_route', 'xss_clean|trim|required');
			}
		}

		if ($this->input->post('modules')) {
			foreach ($this->input->post('modules') as $partial => $modules) {
				foreach ($modules as $key => $value) {
					$rules[] = array('modules[' . $partial . '][' . $key . '][module_code]', '[' . $partial . '] ' . $this->lang->line('label_module_code'), 'xss_clean|trim|required|alpha_dash');
					$rules[] = array('modules[' . $partial . '][' . $key . '][partial]', '[' . $partial . '] ' . $this->lang->line('label_module_partial'), 'xss_clean|trim|required|alpha_dash');
					$rules[] = array('modules[' . $partial . '][' . $key . '][title]', '[' . $partial . '] ' . $this->lang->line('label_module_title'), 'xss_clean|trim|min_length[2]');
					$rules[] = array('modules[' . $partial . '][' . $key . '][fixed]', '[' . $partial . '] ' . $this->lang->line('label_module_fixed'), 'xss_clean|trim|required|integer');

					if ($this->input->post('modules[' . $partial . '][' . $key . '][fixed]') === '1') {
						$rules[] = array('modules[' . $partial . '][' . $key . '][fixed_top_offset]', '[' . $partial . '] ' . $this->lang->line('label_fixed_offset'), 'xss_clean|trim|required|integer');
						$rules[] = array('modules[' . $partial . '][' . $key . '][fixed_bottom_offset]', '[' . $partial . '] ' . $this->lang->line('label_fixed_offset'), 'xss_clean|trim|required|integer');
					}

					$rules[] = array('modules[' . $partial . '][' . $key . '][status]', '[' . $partial . '] ' . $this->lang->line('label_module_status'), 'xss_clean|trim|required|integer');
				}
			}
		}

		return $this->Layouts_model->set_rules($rules)->validate();
	}
}

/* End of file Layouts.php */
/* Location: ./admin/controllers/Layouts.php */