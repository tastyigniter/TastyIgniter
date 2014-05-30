<?php
class Ratings extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('user');
	}

	public function index() {

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/ratings')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Ratings');
		$this->template->setHeading('Ratings');
		$this->template->setButton('Save', array('class' => 'save_button', 'onclick' => '$(\'form\').submit();'));

		$data['text_empty'] 		= 'There are no ratings, please add!.';
		
		if ($this->input->post('ratings')) {
			$results = $this->input->post('ratings');
		} else if ($this->config->item('ratings')) {
			$results = $this->config->item('ratings');
		} else {
			$results = '';
		}

		$data['ratings'] = array();
		if (is_array($results)) {
			foreach ($results['ratings'] as $key => $value) {					
				$data['ratings'][$key] = $value;
			}
		}

		if ($this->input->post() AND $this->_updateRating() === TRUE) {
			redirect('admin/ratings');  			
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/admin/'.$this->config->item('admin_theme').'ratings.php')) {
			$this->template->render('themes/admin/'.$this->config->item('admin_theme'), 'ratings', $data);
		} else {
			$this->template->render('themes/admin/default/', 'ratings', $data);
		}
	}
	
	public function _updateRating() {
    	if (!$this->user->hasPermissions('modify', 'admin/ratings')) {
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ($this->input->post('ratings') AND $this->validateForm() === TRUE) { 
			$this->load->model('Settings_model');
			$update = array();
			$update['ratings'] = $this->input->post('ratings');
			
			if ($this->Settings_model->addSetting('ratings', 'ratings', $update, '1')) {
				$this->session->set_flashdata('alert', '<p class="success">Rating updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="warning">An error occured, nothing updated.</p>');				
			}
		
			return TRUE;
		}
	}

	public function validateForm() {
		if ($this->input->post('ratings')) {
			foreach ($this->input->post('ratings') as $key => $value) {
				$this->form_validation->set_rules('ratings['.$key.']', 'Rating Name', 'xss_clean|trim|required|min_length[2]|max_length[32]');
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
/* Location: ./application/controllers/admin/ratings.php */