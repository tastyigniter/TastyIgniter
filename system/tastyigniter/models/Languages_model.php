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
 * Languages Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Languages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Languages_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'languages';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'language_id';

	/**
	 * Scope a query to only include enabled language
	 * 
	 * @return $this
	 */
	public function isEnabled() {
		return $this->where('status', '1');
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('name', $filter['filter_search']);
			$this->or_like('code', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all enabled languages
	 *
	 * @return array
	 */
	public function getLanguages() {
		return $this->find_all('status', '1');
	}

	/**
	 * Find a single language by language_id
	 *
	 * @param int $language_id
	 *
	 * @return mixed
	 */
	public function getLanguage($language_id) {
		return $this->find($language_id);
	}

	/**
	 * Create a new or update existing language, skips validation
	 *
	 * @param int   $language_id
	 * @param array $save
	 *
	 * @return bool|int The $language_id of the affected row, or FALSE on failure
	 */
	public function saveLanguage($language_id, $save = array()) {
		if (empty($save)) return FALSE;

		return $this->skip_validation(TRUE)->save($save, $language_id);
	}

	/**
	 * Delete a single or multiple language by language_id
	 *
	 * @param string|array $language_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteLanguage($language_id) {
		if (is_numeric($language_id)) $language_id = array($language_id);

		if (!empty($language_id) AND ctype_digit(implode('', $language_id))) {
			$this->where_in('language_id', $language_id);
			$this->where('language_id !=', '11')->where('can_delete', '0');

			if ($result = $this->find_all()) {
				foreach ($result as $row) {
					delete_language($row['idiom']);
				}
			}

			$this->where('language_id !=', '11')->where('can_delete', '0');

			return $this->delete('language_id', $language_id);
		}
	}
}

/* End of file Languages_model.php */
/* Location: ./system/tastyigniter/models/Languages_model.php */