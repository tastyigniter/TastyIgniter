<?php if (!defined('BASEPATH')) exit('No direct access allowed');

class Settings extends Admin_Controller
{

	public function __construct() {
		parent::__construct();
		$this->load->model('Layouts_model');
		$this->load->model('Pages_model');
		$this->load->model('Page_anywhere_model');
		$this->lang->load('page_anywhere_module/page_anywhere_module');

		$this->settingsView = 'page_anywhere_module/settings';
	}

	public function index($module = array()) {
		$this->user->restrict('Module.PageAnywhereModule');

		if (!empty($module)) {
			$title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

			$this->template->setTitle('Module: ' . $title);
			$this->template->setHeading('Module: ' . $title);
			$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
			$this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
			$this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

			$data['pages'] = $this->Pages_model->getPages();
			$data['layouts'] = $this->_getLayouts();
			$data['partials'] = $this->_getPartials();
			$data['page_anywhere_refs'] = $this->Page_anywhere_model->getPageAnywhereRefs();

			if ($this->input->post() AND $this->_updateModule() === TRUE) {
				if ($this->input->post('save_close') == '1') {
					$this->redirect('extensions');
				}
				$this->redirect(admin_extension_url($this->settingsView));
			}

			return $this->load->view($this->settingsView, $data, TRUE);
		}
	}

	protected function _getPartials() {
		$allPartials = array();
		$theme_partials = get_theme_partials($this->config->item('main', 'default_themes'), 'main');
		foreach ($theme_partials as $partial) {
			$partial['id'] = isset($partial['id']) ? $partial['id'] : '';
			$deprecated_id = explode('_', $partial['id']);
			$partial['deprecated_id'] = isset($deprecated_id['1']) ? $deprecated_id['1'] : ''; // support @DEPRECATED position key

			$partial['name'] = isset($partial['name']) ? $partial['name'] : '';

			$allPartials[] = $partial;
		}

		return $allPartials;
	}

	protected function _getLayouts() {
		$layouts = array();
		$results = $this->Layouts_model->getModuleLayouts('page_anywhere_module');
		foreach ($results as $result) {
			$layouts[] = array(
				'value' => "{$result['layout_id']}|{$result['partial']}",
				'name'  => "{$result['name']} - {$result['partial']}",
			);
		}

		return $layouts;
	}

	protected function _updateModule() {
		$this->user->restrict('Module.PageAnywhereModule.Manage');

		if ($this->validateForm() === TRUE) {

			$formattedPageRefs = array();
			$deleteRequests = array();

			foreach($this->input->post('pagerefs') as $pageRef) {
				$explodeLayoutPartial = explode('|', $pageRef['layout_partial']);

				$formattedPageRefs[] = array(
					'pa_id' => $pageRef['pa_id'],
					'layout_id' => $explodeLayoutPartial[0],
					'page_id'  => $pageRef['page_id'],
					'partial' => $explodeLayoutPartial[1],
					'status' => $pageRef['status']
				);

				if (is_numeric($pageRef['delete_pa'])) {
					$deleteRequests[] = $pageRef['delete_pa'];
				}
			}



			if ($this->Page_anywhere_model->savePageAnywhereRefs($formattedPageRefs)) {
				if ($deleteRequests) {
					if ($this->Page_anywhere_model->deletePageAnywhereRefs($deleteRequests)) {
						$this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title') . ' module ' . $this->lang->line('text_updated')));
					}
					else {
						$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
					}
				} else {
					$this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title') . ' module ' . $this->lang->line('text_updated')));
				}
			} else {
				$this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
			}

			return TRUE;
		}
	}

	protected function validateForm() {
		foreach ($this->input->post('pagerefs') as $key => $value) {
			$this->form_validation->set_rules('pagerefs[' . $key . '][page_id]', 'lang:label_banner', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('pagerefs[' . $key . '][layout_partial]', 'lang:label_layout_partial', 'xss_clean|trim|required');
			$this->form_validation->set_rules('pagerefs[' . $key . '][status]', 'lang:label_status', 'xss_clean|trim|required|integer');
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file Settings.php */
/* Location: ./extensions/page_anywhere_module/controllers/Settings.php */