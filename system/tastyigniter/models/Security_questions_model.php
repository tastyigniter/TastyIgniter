<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Security_questions_model extends TI_Model {

	public function getQuestions() {
		$this->db->from('security_questions');

		$this->db->order_by('priority', 'ASC');

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
		$query = FALSE;

		if ( ! empty($questions)) {
			$priority = 1;

			foreach ($questions as $question) {
				if ( ! empty($question['text'])) {
					if ( ! empty($question['question_id']) AND $question['question_id'] > 0) {
						$this->db->set('text', $question['text']);
						$this->db->set('priority', $priority);
						$this->db->where('question_id', $question['question_id']);
						$this->db->update('security_questions');
					} else if ( ! empty($question['text'])) {
						$this->db->set('text', $question['text']);
						$this->db->set('priority', $priority);
						$this->db->insert('security_questions');
					}
				}

				$priority ++;
			}

			$query = TRUE;
		}

		return $query;
	}
}

/* End of file security_questions_model.php */
/* Location: ./system/tastyigniter/models/security_questions_model.php */