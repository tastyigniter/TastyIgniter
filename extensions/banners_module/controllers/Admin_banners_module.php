<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_banners_module extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Layouts_model');
        $this->load->model('Banners_model');
        $this->lang->load('banners_module/banners_module');
    }

	public function index($module = array()) {
        $this->user->restrict('Module.BannersModule');

        if (!empty($module)) {
            $title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

            $this->template->setTitle('Module: ' . $title);
            $this->template->setHeading('Module: ' . $title);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setButton($this->lang->line('button_banners'), array('class' => 'btn btn-default', 'href' => site_url('banners/edit')));
            $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

            $ext_data = (!empty($module['ext_data']) AND is_array($module['ext_data'])) ? $module['ext_data'] : array();

            if ($this->input->post('banners')) {
                $ext_data['banners'] = $this->input->post('banners');
            }

            $this->load->model('Image_tool_model');

            $data['module_banners'] = array();
            if (!empty($ext_data['banners'])) {
                foreach ($ext_data['banners'] as $banner) {
                    $data['module_banners'][] = array(
                        'banner_id'      => $banner['banner_id'],
                        'layout_partial' => isset($banner['layout_partial']) ? $banner['layout_partial'] : '',
                        'status'         => isset($banner['status']) ? $banner['status'] : '1',
                        'width'          => $banner['width'],
                        'height'         => $banner['height'],
                        'edit'           => admin_url('banners/edit/'.$banner['banner_id']),
                    );
                }
            }

            $data['banners'] = array();
            $results = $this->Banners_model->getBanners();
            foreach ($results as $result) {
                $data['banners'][] = array(
                    'banner_id'       => $result['banner_id'],
                    'name'			=> $result['name']
                );
            }

            $data['layouts'] = array();
            $results = $this->Layouts_model->getModuleLayouts('banners_module');
            foreach ($results as $result) {
                $data['layouts'][] = array(
                    'value'		    => "{$result['layout_id']}|{$result['partial']}",
                    'name'			=> "{$result['name']} - {$result['partial']}",
                );
            }

            $theme_partials = get_theme_partials($this->config->item('main', 'default_themes'), 'main');
            foreach ($theme_partials as $partial) {
                $partial['id'] = isset($partial['id']) ? $partial['id'] : '';
                $deprecated_id = explode('_', $partial['id']);
                $partial['deprecated_id'] = isset($deprecated_id['1']) ? $deprecated_id['1'] : ''; // support @DEPRECATED position key

                $partial['name'] = isset($partial['name']) ? $partial['name'] : '';

                $data['theme_partials'][] = $partial;
            }

            if ($this->input->post() AND $this->_updateModule() === TRUE) {
                if ($this->input->post('save_close') === '1') {
                    redirect('extensions');
                }

                redirect('extensions/edit/module/banners_module');
            }

            return $this->load->view('banners_module/admin_banners_module', $data, TRUE);
        }
	}

	private function _updateModule() {
		$this->user->restrict('Module.BannersModule.Manage');

    	if ($this->validateForm() === TRUE) {

			if ($this->Extensions_model->updateExtension('module', 'banners_module', $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title').' module '.$this->lang->line('text_updated')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
			}

			return TRUE;
		}
	}

 	private function validateForm() {
        foreach ($this->input->post('banners') as $key => $value) {
            $this->form_validation->set_rules('banners['.$key.'][banner_id]', 'lang:label_banner', 'xss_clean|trim|required|integer');
            $this->form_validation->set_rules('banners['.$key.'][layout_partial]', 'lang:label_layout_partial', 'xss_clean|trim|required');
            $this->form_validation->set_rules('banners['.$key.'][width]', 'lang:label_width', 'xss_clean|trim|alpha_numeric');
            $this->form_validation->set_rules('banners['.$key.'][height]', 'lang:label_height', 'xss_clean|trim|alpha_numeric');
            $this->form_validation->set_rules('banners['.$key.'][status]', 'lang:label_status', 'xss_clean|trim|required|integer');
        }

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file banners_module.php */
/* Location: ./extensions/banners_module/controllers/banners_module.php */