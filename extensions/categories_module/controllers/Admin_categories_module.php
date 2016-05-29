<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_categories_module extends Admin_Controller {

	public function index($module = array()) {
		$this->lang->load('categories_module/categories_module');

		$this->user->restrict('Module.CategoriesModule');

        if (!empty($module)) {
            $title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

            $this->template->setTitle('Module: ' . $title);
            $this->template->setHeading('Module: ' . $title);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

            if (isset($ext_data['fixed_categories'])) {
                $data['fixed_categories'] = $ext_data['fixed_categories'];
            } else if ($this->input->post('fixed_categories')) {
                $data['fixed_categories'] = $this->input->post('fixed_categories');
            } else {
                $data['fixed_categories'] = '1';
            }

            if (isset($ext_data['fixed_top_offset'])) {
                $data['fixed_top_offset'] = $ext_data['fixed_top_offset'];
            } else if ($this->input->post('fixed_top_offset')) {
                $data['fixed_top_offset'] = $this->input->post('fixed_top_offset');
            } else {
                $data['fixed_top_offset'] = '350';
            }

            if (isset($ext_data['fixed_bottom_offset'])) {
                $data['fixed_bottom_offset'] = $ext_data['fixed_bottom_offset'];
            } else if ($this->input->post('fixed_bottom_offset')) {
                $data['fixed_bottom_offset'] = $this->input->post('fixed_bottom_offset');
            } else {
                $data['fixed_bottom_offset'] = '320';
            }

            if ($this->input->post() AND $this->_updateModule() === TRUE) {
                if ($this->input->post('save_close') === '1') {
                    redirect('extensions');
                }

                redirect('extensions/edit/module/categories_module');
            }

            return $this->load->view('categories_module/admin_categories_module', $data, TRUE);
        }
	}

    private function _updateModule() {
        $this->user->restrict('Module.CategoriesModule.Manage');

        if ($this->validateForm() === TRUE) {

            if ($this->Extensions_model->updateExtension('module', 'categories_module', $this->input->post())) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title').' module '.$this->lang->line('text_updated')));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
            }

            return TRUE;
        }
    }

    private function validateForm() {
        $this->form_validation->set_rules('fixed_categories', 'lang:label_fixed_categories', 'xss_clean|trim|required|integer');

        if ($this->input->post('fixed_categories') === '1') {
            $this->form_validation->set_rules('fixed_top_offset', 'lang:label_fixed_top_offset', 'xss_clean|trim|required|integer');
            $this->form_validation->set_rules('fixed_bottom_offset', 'lang:label_fixed_bottom_offset', 'xss_clean|trim|required|integer');
        }

        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* End of file admin_categories_module.php */
/* Location: ./extensions/categories_module/controllers/admin_categories_module.php */