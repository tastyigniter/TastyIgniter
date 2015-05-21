<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Security_questions extends Admin_Controller {

    public $_permission_rules = array('access', 'modify');

    public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->model('Security_questions_model');
	}

	public function index() {
		$this->template->setTitle('Security Questions');
		$this->template->setHeading('Security Questions');
		$this->template->setButton('Save', array('class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();'));

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
				'question_id'	=> ($result['question_id'] > 0) ? $result['question_id'] : '0',
				'text'			=> $result['text']
			);
		}

		if ($this->input->post() AND $this->_updateSecurityQuestion() === TRUE){
			redirect('security_questions');
		}

		$this->template->setPartials(array('header', 'footer'));
		$this->template->render('security_questions', $data);
	}

	private function _updateSecurityQuestion() {
    	if ($this->input->post('questions') AND $this->validateForm() === TRUE) {
			$questions = $this->input->post('questions');

			if ($this->Security_questions_model->updateQuestions($questions)) {
				$this->alert->set('success', 'Security Question updated successfully.');
			} else {
				$this->alert->set('warning', 'An error occurred, nothing updated.');
			}

			return TRUE;
		}
	}

	private function validateForm() {
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
/* Location: ./admin/controllers/security_questions.php */