<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Mealtimes extends Admin_Controller {

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->user->restrict('Admin.Mealtimes');

        $this->load->model('Mealtimes_model');

        $this->lang->load('mealtimes');
	}

	public function index() {
        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
		$this->template->setButton($this->lang->line('button_save'), array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		$this->template->setStyleTag(assets_url('js/datepicker/bootstrap-timepicker.css'), 'bootstrap-timepicker-css');
		$this->template->setScriptTag(assets_url("js/datepicker/bootstrap-timepicker.js"), 'bootstrap-timepicker-js');

		if ($this->input->post() AND $this->_updateMealtimes() === TRUE){
			redirect('mealtimes');
		}

		if ($this->input->post('mealtimes')) {
			$results = $this->input->post('mealtimes');
		} else {
			$results = $this->Mealtimes_model->getMealtimes();
		}

		$data['mealtimes'] = array();
		foreach ($results as $result) {
			$data['mealtimes'][] = array(
				'mealtime_id'     => ($result['mealtime_id'] > 0) ? $result['mealtime_id'] : '0',
				'mealtime_name'   => $result['mealtime_name'],
				'start_time'      => mdate('%h:%i %A', strtotime($result['start_time'])),
				'end_time'        => mdate('%h:%i %A', strtotime($result['end_time'])),
				'mealtime_status' => $result['mealtime_status'],
			);
		}

		$this->template->render('mealtimes', $data);
	}

	private function _updateMealtimes() {
    	if ($this->input->post('mealtimes') AND $this->validateForm() === TRUE) {
			if ($this->Mealtimes_model->updateMealtimes($this->input->post('mealtimes'))) {
                $this->alert->set('success', sprintf($this->lang->line('alert_success'), $this->lang->line('text_heading') .' '. $this->lang->line('text_updated').' '));
            } else {
                $this->alert->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
			}

			return TRUE;
		}
	}

	private function validateForm() {
		if ($this->input->post('mealtimes')) {
			foreach ($this->input->post('mealtimes') as $key => $value) {
				$this->form_validation->set_rules('mealtimes['.$key.'][mealtime_id]', 'lang:label_mealtime_id', 'xss_clean|trim|required|integer');
				$this->form_validation->set_rules('mealtimes['.$key.'][mealtime_name]', 'lang:label_mealtime_name', 'xss_clean|trim|required|min_length[2]|max_length[128]');
				$this->form_validation->set_rules('mealtimes['.$key.'][start_time]', 'lang:label_start_time', 'xss_clean|trim|required|valid_time');
				$this->form_validation->set_rules('mealtimes['.$key.'][end_time]', 'lang:label_end_time', 'xss_clean|trim|required|valid_time');
				$this->form_validation->set_rules('mealtimes['.$key.'][mealtime_status]', 'lang:label_mealtime_status', 'xss_clean|trim|required|integer');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file mealtimes.php */
/* Location: ./admin/controllers/mealtimes.php */