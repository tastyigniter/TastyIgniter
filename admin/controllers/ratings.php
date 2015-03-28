<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Ratings extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
	}

	public function index() {

		if (!$this->user->islogged()) {
  			redirect('login');
		}

    	if (!$this->user->hasPermissions('access', 'ratings')) {
  			redirect('permission');
		}

		$this->template->setTitle('Ratings');
		$this->template->setHeading('Ratings');
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

		$data['text_empty'] 		= 'There are no ratings, please add!.';

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

		if ($this->input->post() AND $this->_updateRating() === TRUE) {
			redirect('ratings');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('ratings', $data);
	}

	public function _updateRating() {
    	if (!$this->user->hasPermissions('modify', 'ratings')) {
			$this->alert->set('warning', 'Warning: You do not have permission to update!');
			return TRUE;
    	} else if ($this->input->post('ratings') AND $this->validateForm() === TRUE) {
			$this->load->model('Settings_model');
			$update = array();
			$update['ratings'] = $this->input->post('ratings');

			if ($this->Settings_model->addSetting('ratings', 'ratings', $update, '1')) {
				$this->alert->set('success', 'Rating updated sucessfully.');
			} else {
				$this->alert->set('warning', 'An error occured, nothing updated.');
			}

			return TRUE;
		}
	}

	public function validateForm() {
		if ($this->input->post('ratings')) {
			foreach ($this->input->post('ratings') as $key => $value) {
				$this->form_validation->set_rules('ratings['.$key.']', 'Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
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