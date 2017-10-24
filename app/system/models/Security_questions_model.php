<?php namespace System\Models;

use Model;
use Igniter\Flame\Database\Traits\Sortable;

/**
 * SecurityQuestions Model Class
 *
 * @package System
 */
class Security_questions_model extends Model
{
    use Sortable;

    const SORT_ORDER = 'priority';

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
        return $this->orderBy('priority')->get();
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
        if (!$question = $this->find($question_id))
            return null;

        return $question->toArray();
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
                    $this->updateOrCreate([
                        'question_id' => isset($question['question_id']) ? $question['question_id'] : null
                    ], [
                        'text'     => $question['text'],
                        'priority' => $priority,
                    ]);
                }

                $priority++;
            }

            $query = TRUE;
        }

        return $query;
    }
}