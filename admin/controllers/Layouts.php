<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Layouts extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->user->restrict('Site.Layouts');

		$this->load->model('Layouts_model');
		$this->load->model('Extensions_model');

		$this->lang->load('layouts');
	}

	public function index()
	{
		if ($this->input->post('delete') AND $this->_deleteLayout() === TRUE) {
			$this->redirect();
		}

		$this->template->setTitle($this->lang->line('text_title'));
		$this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_new'), ['class' => 'btn btn-primary', 'href' => page_url() . '/edit']);
		$this->template->setButton($this->lang->line('button_delete'), ['class' => 'btn btn-danger', 'onclick' => 'confirmDelete();']);;

		$data = $this->getList();

		$this->template->render('layouts', $data);
	}

	public function edit()
	{
		if ($this->input->post() AND $layout_id = $this->_saveLayout()) {
			$this->redirect($layout_id);
		}

		$layoutModel = $this->Layouts_model->findOrNew((int)$this->input->get('id'));

		$title = (isset($layoutModel->name)) ? $layoutModel->name : $this->lang->line('text_new');
		$this->template->setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
		$this->template->setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

		$this->template->setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
		$this->template->setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
		$this->template->setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => site_url('layouts')]);

		$this->assets->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

		$data = $this->getForm($layoutModel);

		$this->template->render('layouts_edit', $data);
	}

	public function getList()
	{
		$this->load->model('Layout_modules_model');
		$_layout_components = $this->Layout_modules_model->getLayoutModules();
		$components = Components::list_components();

		$data['layouts'] = [];
		$results = $this->Layouts_model->paginate();
		foreach ($results->list as $result) {
			$layout_components = [];
			if (isset($_layout_components[$result['layout_id']])) {
				foreach ($_layout_components[$result['layout_id']] as $layout_component) {
					$module_code = $layout_component['module_code'];
					if (!empty($components[$module_code]['name'])) {
						$layout_components[] = $this->lang->line($components[$module_code]['name']);
					}
				}
			}

			$data['layouts'][] = array_merge($result, [
				'components' => $layout_components,
				'edit'       => $this->pageUrl($this->edit_url, ['id' => $result['layout_id']]),
			]);
		}

		$data['pagination'] = $results->pagination;

		return $data;
	}

	public function getForm(Layouts_model $layoutModel)
	{
		$data = $layout_info = $layoutModel->toArray();

		$layout_id = 0;
		$data['_action'] = $this->pageUrl($this->create_url);
		if (!empty($layout_info['layout_id'])) {
			$layout_id = $layout_info['layout_id'];
			$data['_action'] = $this->pageUrl($this->edit_url, ['id' => $layout_id]);
		}

		$theme_partials = get_theme_partials($this->config->item('main', 'default_themes'), 'main');
		foreach ($theme_partials as $partial) {
			$partial['id'] = isset($partial['id']) ? $partial['id'] : '';
			$deprecated_id = explode('_', $partial['id']);
			$partial['deprecated_id'] = isset($deprecated_id['1']) ? $deprecated_id['1'] : ''; // support @DEPRECATED position key
			$partial['name'] = isset($partial['name']) ? $partial['name'] : '';
			$data['theme_partials'][] = $partial;
		}

		$data['components'] = [];
		$components = Components::list_components();
		foreach ($components as $code => $meta) {
			$meta['name'] = isset($meta['name']) ? $this->lang->line($meta['name']) : '';
			$meta['description'] = isset($meta['description']) ? $this->lang->line($meta['description']) : '';
			$data['components'][$code] = array_merge($meta, [
				'module_code' => $code,
				'description' => (strlen($meta['description']) > 70) ? character_limiter($meta['description'], 70) : $meta['description'],
			]);
		}

		if ($this->input->post('components')) {
			$layout_components = $this->input->post('components');
		} else {
			$layout_components = $this->Layouts_model->getLayoutModules($layout_id);
		}

		$data['layout_components'] = [];
		foreach ($layout_components as $partial => $components) {
			$components = (is_numeric($partial)) ? $components : $components;
			foreach ($components as $priority => $component) {
				if (!Components::has_component($component['module_code'])) continue;

				$data['layout_components'][$partial][] = array_merge($component, [
					'name'     => isset($data['components'][$component['module_code']]['name']) ? $data['components'][$component['module_code']]['name'] : $component['module_code'],
					'partial'  => !empty($component['partial']) ? $component['partial'] : $partial,
					'priority' => !empty($component['priority']) ? $component['priority'] : $priority,
					'fixed'    => isset($component['fixed']) ? $component['fixed'] : '0',
					'status'   => isset($component['status']) ? $component['status'] : '1',
				]);
			}
		}

		if ($this->input->post('routes')) {
			$data['layout_routes'] = $this->input->post('routes');
		} else {
			$data['layout_routes'] = $this->Layouts_model->getLayoutRoutes($layout_id);
		}

		$data['routes'] = [];
		$results = $this->Layouts_model->getRoutes(1);
		foreach ($results as $result) {
			$data['routes'][] = [
				'route_id' => $result['uri_route_id'],
				'route'    => $result['uri_route'],
			];
		}

		return $data;
	}

	protected function _saveLayout()
	{
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

	protected function _deleteLayout()
	{
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

	protected function validateForm()
	{
		$rules[] = ['name', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[128]'];

		if ($this->input->post('routes')) {
			foreach ($this->input->post('routes') as $key => $value) {
				$rules[] = ['routes[' . $key . '][uri_route]', 'lang:label_route', 'xss_clean|trim|required'];
			}
		}

		if ($this->input->post('components')) {
			foreach ($this->input->post('components') as $partial => $layout_components) {
				foreach ($layout_components as $key => $value) {
					$rules[] = ['components[' . $partial . '][' . $key . '][module_code]', '[' . $partial . '] ' . $this->lang->line('label_module_code'), 'xss_clean|trim|required|alpha_dash'];
					$rules[] = ['components[' . $partial . '][' . $key . '][partial]', '[' . $partial . '] ' . $this->lang->line('label_module_partial'), 'xss_clean|trim|required|alpha_dash'];
					$rules[] = ['components[' . $partial . '][' . $key . '][title]', '[' . $partial . '] ' . $this->lang->line('label_module_title'), 'xss_clean|trim|min_length[2]'];
					$rules[] = ['components[' . $partial . '][' . $key . '][fixed]', '[' . $partial . '] ' . $this->lang->line('label_module_fixed'), 'xss_clean|trim|required|integer'];

					if ($this->input->post('components[' . $partial . '][' . $key . '][fixed]') == '1') {
						$rules[] = ['components[' . $partial . '][' . $key . '][fixed_top_offset]', '[' . $partial . '] ' . $this->lang->line('label_fixed_offset'), 'xss_clean|trim|required|integer'];
						$rules[] = ['components[' . $partial . '][' . $key . '][fixed_bottom_offset]', '[' . $partial . '] ' . $this->lang->line('label_fixed_offset'), 'xss_clean|trim|required|integer'];
					}

					$rules[] = ['components[' . $partial . '][' . $key . '][status]', '[' . $partial . '] ' . $this->lang->line('label_module_status'), 'xss_clean|trim|required|integer'];
				}
			}
		}

		return $this->form_validation->set_rules($rules)->run();
	}
}

/* End of file Layouts.php */
/* Location: ./admin/controllers/Layouts.php */