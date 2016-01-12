<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Security_questions Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Security_questions_model.php
 * @link           http://docs.tastyigniter.com
 */
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