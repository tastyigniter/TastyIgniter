<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Security_questions Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Security_questions_model.php
 * @link           http://docs.tastyigniter.com
 */
class Security_questions_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'security_questions';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'question_id';

	/**
	 * Return all security questions
	 *
	 * @return array
	 */
	public function getQuestions()
	{
		return $this->orderBy('priority')->getAsArray();
	}

	/**
	 * Find a single security_question by question_id
	 *
	 * @param int $question_id
	 *
	 * @return array
	 */
	public function getQuestion($question_id)
	{
		return $this->findOrNew($question_id)->toArray();
	}

	/**
	 * Create a new or update an existing security question
	 *
	 * @param array $questions
	 *
	 * @return bool
	 */
	public function updateQuestions($questions = [])
	{
		$query = FALSE;

		if (!empty($questions)) {
			$priority = 1;

			foreach ($questions as $question) {
				if (!empty($question['text'])) {
					if (!empty($question['question_id']) AND $question['question_id'] > 0) {
						$this->where('question_id', $question['question_id'])->update([
							'text'     => $question['text'],
							'priority' => $priority,
						]);
					} else if (!empty($question['text'])) {
						$this->insert([
							'text'     => $question['text'],
							'priority' => $priority,
						]);
					}
				}

				$priority++;
			}

			$query = TRUE;
		}

		return $query;
	}
}

/* End of file Security_questions_model.php */
/* Location: ./system/tastyigniter/models/Security_questions_model.php */