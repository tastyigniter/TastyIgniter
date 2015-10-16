<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_categories_module extends Admin_Controller {

	public function index($data = array()) {
		$this->lang->load('categories_module/categories_module');

		$this->user->restrict('Module.CategoriesModule');

        if (!empty($data)) {
            $title = (isset($data['title'])) ? $data['title'] : $this->lang->line('_text_title');

            $this->template->setTitle('Module: ' . $title);
            $this->template->setHeading('Module: ' . $title);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

            if ($this->input->post('status')) {
                $data['status'] = $this->input->post('status');
            } else if (!empty($data['ext_data']['status'])) {
                $data['status'] = $data['ext_data']['status'];
            } else {
                $data['status'] = '0';
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
        $this->form_validation->set_rules('status', 'lang:label_status', 'xss_clean|trim|required|integer');

        if ($this->form_validation->run() === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

/* End of file admin_categories_module.php */
/* Location: ./extensions/categories_module/controllers/admin_categories_module.php */