<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Security_questions_model extends CI_Model {

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
}

/* End of file security_questions_model.php */
/* Location: ./main/models/security_questions_model.php */