<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Admin_reservation_module extends Ext_Controller {

	public function index($data = array()) {
        if (!empty($data)) {
            $data['title'] = (isset($data['title'])) ? $data['title'] : 'Reservation Module';

            $this->template->setTitle('Module: ' . $data['title']);
            $this->template->setHeading('Module: ' . $data['title']);
            $this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));
            $this->template->setButton('Save & Close', array('class' => 'btn btn-default', 'onclick' => 'saveClose();'));
            $this->template->setBackButton('btn btn-back', site_url('extensions'));

            if ($this->input->post() AND $this->_updateModule() === TRUE) {
                if ($this->input->post('save_close') === '1') {
                    redirect('extensions');
                }

                redirect('extensions/edit?action=edit&name=reservation_module');
            }

            return $this->load->view('reservation_module/admin_reservation_module', $data, TRUE);
        }
	}

	private function _updateModule() {
    	if ($this->validateForm() === TRUE) {
			$update = array();

			$update['type'] 			= 'module';
			$update['name'] 			= $this->input->get('name');
			$update['title'] 			= $this->input->post('title');
			$update['extension_id'] 	= (int) $this->input->get('extension_id');

			if ($this->Extensions_model->updateExtension($update, '1')) {
				$this->alert->set('success', 'Reservation Module updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

 	private function validateForm() {
		$this->form_validation->set_rules('title', 'Title', 'xss_clean|trim|required|min_length[2]|max_length[128]');

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file reservation_module.php */
/* Location: ./extensions/reservation_module/controllers/reservation_module.php */