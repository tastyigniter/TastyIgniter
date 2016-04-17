<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_pages_module extends Admin_Controller {

	public function index($module = array()) {
		$this->lang->load('pages_module/pages_module');

		$this->user->restrict('Module.PagesModule');

        if (!empty($module)) {
	        $title = (isset($module['title'])) ? $module['title'] : $this->lang->line('_text_title');

	        $this->template->setTitle('Module: ' . $title);
	        $this->template->setHeading('Module: ' . $title);
            $this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton($this->lang->line('button_save_close'), array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setButton($this->lang->line('button_icon_back'), array('class' => 'btn btn-default', 'href' => site_url('extensions')));

	        if ($this->input->post('heading')) {
		        $data['heading'] = $this->input->post('heading');
	        } else if (!empty($module['ext_data']['heading'])) {
		        $data['heading'] = $module['ext_data']['heading'];
	        } else {
		        $data['heading'] = $title;
	        }

	        if ($this->input->post() AND $this->_updateModule() === TRUE) {
                if ($this->input->post('save_close') === '1') {
                    redirect('extensions');
                }

                redirect('extensions/edit/module/pages_module');
            }

            return $this->load->view('pages_module/admin_pages_module', $data, TRUE);
        }
	}

	private function _updateModule() {
    	if ($this->validateForm() === TRUE) {

		    if ($this->Extensions_model->updateExtension('module', 'pages_module', $this->input->post())) {
			    $this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('_text_title').' module '.$this->lang->line('text_updated')));
		    } else {
			    $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_updated')));
		    }

			return TRUE;
		}
	}

 	private function validateForm() {
		$this->form_validation->set_rules('heading', 'lang:label_heading', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file pages_module.php */
/* Location: ./extensions/pages_module/controllers/pages_module.php */