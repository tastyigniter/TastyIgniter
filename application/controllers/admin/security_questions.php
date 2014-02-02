<?php
class Security_questions extends CI_Controller {

	public function __construct() {
		parent::__construct(); //  calls the constructor
		$this->load->library('user');
		$this->load->model('Security_questions_model');
		$this->output->enable_profiler(TRUE); // for debugging profiler... remove later
	}

	public function index() {
			
		if ( !file_exists(APPPATH .'/views/admin/security_questions.php')) { //check if file exists in views folder
			show_404(); // Whoops, show 404 error page!
		}

		if (!$this->user->islogged()) {  
  			redirect('admin/login');
		}

    	if (!$this->user->hasPermissions('access', 'admin/security_questions')) {
  			redirect('admin/permission');
		}
		
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		$data['heading'] 			= 'Security Questions';
		$data['sub_menu_update'] 	= 'Update';
		$data['text_empty'] 		= 'There are no security questions, please add!.';

		//load questions data into array
		$data['questions'] = array();
		$results = $this->Security_questions_model->getQuestions();
		foreach ($results as $result) {
			$data['questions'][] = array(
				'question_id'	=> $result['question_id'],
				'question_text'	=> $result['question_text']
			);
		}

		if ($this->input->post() && $this->_updateSecurityQuestion() === TRUE){
					
			redirect('admin/security_questions');
		}

		//load home page content
		$this->load->view('admin/header', $data);
		$this->load->view('admin/security_questions', $data);
		$this->load->view('admin/footer');
	}

	public function _updateSecurityQuestion() {
						
    	if (!$this->user->hasPermissions('modify', 'admin/security_questions')) {
		
			$this->session->set_flashdata('alert', '<p class="warning">Warning: You do not have permission to modify!</p>');
			return TRUE;
    	
    	} else { 
			
			if ($this->input->post('questions')) {
				foreach ($this->input->post('questions') as $key => $value) {
					$this->form_validation->set_rules('questions['.$key.'][id]', 'Question Id', 'trim|required|integer');
					$this->form_validation->set_rules('questions['.$key.'][text]', 'Security Question', 'trim|min_length[2]|max_length[128]');
				}
			}
			
			if ($this->form_validation->run() === TRUE) {

				$questions = $this->input->post('questions');

				if ($this->Security_questions_model->updateQuestions($questions)) {
		
					$this->session->set_flashdata('alert', '<p class="success">Security Question Updated Sucessfully!</p>');
				} else {
		
					$this->session->set_flashdata('alert', '<p class="warning">Nothing Updated!</p>');				
				}
		
				return TRUE;
			}
		}
	}
}