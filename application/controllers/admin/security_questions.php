<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Security_questions extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Security_questions_model');
	}

	public function index() {
		if (!$this->user->islogged()) {  
  			redirect(ADMIN_URI.'/login');
		}

    	if (!$this->user->hasPermissions('access', ADMIN_URI.'/security_questions')) {
  			redirect(ADMIN_URI.'/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$this->template->setTitle('Security Questions');
		$this->template->setHeading('Security Questions');
		$this->template->setButton('Save', array('class' => 'btn btn-success', 'onclick' => '$(\'#edit-form\').submit();'));

		$data['text_empty'] 		= 'There are no security questions, please add!.';

		//load questions data into array
		$data['questions'] = array();
		
		if ($this->input->post('questions')) {
			$results = $this->input->post('questions');
		} else {
			$results = $this->Security_questions_model->getQuestions();
		}
		
		foreach ($results as $result) {
			$data['questions'][] = array(
				'question_id'	=> ($result['question_id'] > 0) ? $result['question_id'] : '-',
				'text'			=> $result['text']
			);
		}

		if ($this->input->post() AND $this->_updateSecurityQuestion() === TRUE){
			redirect(ADMIN_URI.'/security_questions');
		}

		$this->template->regions(array('header', 'footer'));
		if (file_exists(APPPATH .'views/themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme').'security_questions.php')) {
			$this->template->render('themes/'.ADMIN_URI.'/'.$this->config->item('admin_theme'), 'security_questions', $data);
		} else {
			$this->template->render('themes/'.ADMIN_URI.'/default/', 'security_questions', $data);
		}
	}

	public function _updateSecurityQuestion() {
    	if (!$this->user->hasPermissions('modify', ADMIN_URI.'/security_questions')) {
			$this->session->set_flashdata('alert', '<p class="alert-warning">Warning: You do not have permission to update!</p>');
			return TRUE;
    	} else if ($this->input->post('questions') AND $this->validateForm() === TRUE) { 
			$questions = $this->input->post('questions');

			if ($this->Security_questions_model->updateQuestions($questions)) {
				$this->session->set_flashdata('alert', '<p class="alert-success">Security Question updated sucessfully.</p>');
			} else {
				$this->session->set_flashdata('alert', '<p class="alert-warning">An error occured, nothing updated.</p>');				
			}
	
			return TRUE;
		}
	}

	public function validateForm() {
		if ($this->input->post('questions')) {
			foreach ($this->input->post('questions') as $key => $value) {
				$this->form_validation->set_rules('questions['.$key.'][question_id]', 'Question Id', 'xss_clean|trim|required|integer');
				$this->form_validation->set_rules('questions['.$key.'][text]', 'Security Question', 'xss_clean|trim|required|min_length[2]|max_length[128]');
			}
		}

		if ($this->form_validation->run() === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
}

/* End of file security_questions.php */
/* Location: ./application/controllers/admin/security_questions.php */