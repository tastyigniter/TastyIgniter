<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_pages_module extends Admin_Controller {

	public function index($data = array()) {
        $this->user->restrict('Module.PagesModule');

        if (!empty($data)) {
            $data['title'] = (isset($data['title'])) ? $data['title'] : 'Pages Module';

            $this->template->setTitle('Module: ' . $data['title']);
            $this->template->setHeading('Module: ' . $data['title']);
            $this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setBackButton('btn btn-back', site_url('extensions'));

            if ($this->input->post() AND $this->_updateModule() === TRUE) {
                if ($this->input->post('save_close') === '1') {
                    redirect('extensions');
                }

                redirect('extensions/edit?action=edit&name=pages_module');
            }

            return $this->load->view('pages_module/admin_pages_module', $data, TRUE);
        }
	}

	private function _updateModule() {
    	if ($this->validateForm() === TRUE) {
			$update = array();

			$update['type'] 			= 'module';
			$update['name'] 			= $this->input->get('name');
			$update['title'] 			= $this->input->post('title');
			$update['extension_id'] 	= (int) $this->input->get('id');
			$update['data']['layouts'] 	= $this->input->post('layouts');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'Pages Module updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

 	private function validateForm() {
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		foreach ($this->input->post('layouts') as $key => $value) {
			$this->form_validation->set_rules('layouts['.$key.'][layout_id]', 'Layout', 'xss_clean|trim|required|integer');
			$this->form_validation->set_rules('layouts['.$key.'][position]', 'Position', 'xss_clean|trim|required');
			$this->form_validation->set_rules('layouts['.$key.'][priority]', 'Priority', 'xss_clean|trim|integer');
			$this->form_validation->set_rules('layouts['.$key.'][status]', 'Status', 'xss_clean|trim|required|integer');
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file pages_module.php */
/* Location: ./extensions/pages_module/controllers/pages_module.php */