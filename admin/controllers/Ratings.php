<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Ratings extends Admin_Controller {

	public function index() {
        $this->user->restrict('Admin.Ratings');

        $this->lang->load('ratings');

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		$this->template->setScriptTag(assets_url('js/jquery-sortable.js'), 'jquery-sortable-js');

		if ($this->input->post() AND $this->_updateRating() === TRUE) {
			redirect('ratings');
		}

		if ($this->input->post('ratings')) {
			$results = $this->input->post('ratings');
		} else if ($this->config->item('ratings')) {
			$ratings = $this->config->item('ratings');
			$results = $ratings['ratings'];
		} else {
			$results = '';
		}

		$data['ratings'] = array();
		if (is_array($results)) {
			foreach ($results as $key => $value) {
				$data['ratings'][$key] = $value;
			}
		}

		$this->template->render('ratings', $data);
	}

	private function _updateRating() {
    	if ($this->input->post('ratings') AND $this->validateForm() === TRUE) {
			$this->load->model('Settings_model');
			$update = array();
			$update['ratings'] = $this->input->post('ratings');

			if ($this->Settings_model->addSetting('ratings', 'ratings', $update, '1')) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), 'Rating updated '));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		if ($this->input->post('ratings')) {
			foreach ($this->input->post('ratings') as $key => $value) {
				$this->form_validation->set_rules('ratings['.$key.']', 'lang:label_name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file ratings.php */
/* Location: ./admin/controllers/ratings.php */