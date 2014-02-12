<?php

class Security_questions_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getQuestions() {
		$this->db->from('security_questions');

		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}

	public function getQuestion($question_id) {
		$this->db->from('security_questions');

		$this->db->where('question_id', $question_id);
		$query = $this->db->get();
		
		return $query->row_array();
	}

	public function updateQuestions($questions = array()) {

		if (!empty($questions)) {
			$this->db->truncate('security_questions'); 

			foreach ($questions as $question) {

				if (!empty($question['id']) && !empty($question['text'])) {
					$this->db->set('question_text', $question['text']);
					$this->db->set('question_id', $question['id']);
					$this->db->insert('security_questions'); 
				}
			}
					
			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function deleteQuestion($question_id) {

		$this->db->where('question_id', $question_id);
		
		$this->db->delete('security_questions');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}