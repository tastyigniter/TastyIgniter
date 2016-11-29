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
 * Languages Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Languages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Languages_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'languages';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'language_id';

	/**
	 * Scope a query to only include enabled language
	 *
	 * @param $query
	 *
	 * @return $this
	 */
	public function scopeIsEnabled($query)
	{
		return $query->where('status', '1');
	}

	/**
	 * Filter database records
	 *
	 * @param $query
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		if (!empty($filter['filter_search'])) {
			$query->like('name', $filter['filter_search']);
			$query->orLike('code', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('status', $filter['filter_status']);
		}

		return $query;
	}

	/**
	 * Return all enabled languages
	 *
	 * @return array
	 */
	public function getLanguages()
	{
		return $this->isEnabled()->getAsArray();
	}

	/**
	 * Find a single language by language_id
	 *
	 * @param int $language_id
	 *
	 * @return mixed
	 */
	public function getLanguage($language_id)
	{
		return $this->findOrNew($language_id)->toArray();
	}

	/**
	 * Create a new or update existing language, skips validation
	 *
	 * @param int $language_id
	 * @param array $save
	 *
	 * @return bool|int The $language_id of the affected row, or FALSE on failure
	 */
	public function saveLanguage($language_id, $save = [])
	{
		if (empty($save)) return FALSE;

		unset($save['clone_language'], $save['language_to_clone']);

		$languageModel = $this->findOrNew($language_id);

		$saved = $languageModel->fill($save)->save();

		return $saved ? $languageModel->getKey() : $saved;
	}

	/**
	 * Delete a single or multiple language by language_id
	 *
	 * @param string|array $language_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteLanguage($language_id)
	{
		if (is_numeric($language_id)) $language_id = [$language_id];

		if (!empty($language_id) AND ctype_digit(implode('', $language_id))) {
			$languages = $this->whereIn('language_id', $language_id)
							  ->where('language_id', '!=', '11')->where('can_delete', '0')->getAsArray();

			if ($languages) {
				foreach ($languages as $row) {
					delete_language($row['idiom']);
				}
			}

			return $this->where('language_id', '!=', '11')->where('can_delete', '0')
						->whereIn('language_id', $language_id)->delete();
		}
	}
}

/* End of file Languages_model.php */
/* Location: ./system/tastyigniter/models/Languages_model.php */