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
 * Pages Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Pages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Pages_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'pages';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'page_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created', 'updated');

	protected $belongs_to = array(
		'languages' => 'Languages_model',
	);

	/**
	 * Scope a query to only include enabled page
	 *
	 * @return $this
	 */
	public function isEnabled() {
		return $this->where('status', '1');
	}

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->with('languages')->count();
	}

	/**
	 * List all pages matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array|bool
	 */
	public function getList($filter = array()) {
		$this->select('*, languages.name AS language_name, pages.name AS name');

		return $this->filter($filter)->with('languages')->find_all();
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
			$this->like('pages.name', $filter['filter_search']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('pages.status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all pages
	 *
	 * @return array
	 */
	public function getPages() {
		if ($result = $this->find_all('status', '1')) {
			foreach ($result as &$row) {
				if (!empty($row['navigation'])) {
					$row['navigation'] = unserialize($row['navigation']);
				}
			}
		}

		return $result;
	}

	/**
	 * Find a single page by page_id
	 *
	 * @param int $page_id
	 *
	 * @return array
	 */
	public function getPage($page_id) {
		return $this->find($page_id);
	}

	/**
	 * Create a new or update existing page
	 *
	 * @param int   $page_id
	 * @param array $save
	 *
	 * @return bool|int The $page_id of the affected row, or FALSE on failure
	 */
	public function savePage($page_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['title'])) {
			$save['name'] = $save['title'];
		}

		if (isset($save['navigation'])) {
			$save['navigation'] = serialize($save['navigation']);
		}

		if ($page_id = $this->skip_validation(TRUE)->save($save, $page_id)) {
			if (!empty($save['permalink'])) {
				$this->permalink->savePermalink('pages', $save['permalink'], 'page_id=' . $page_id);
			}

			return $page_id;
		}
	}

	/**
	 * Delete a single or multiple page by page_id
	 *
	 * @param int $page_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deletePage($page_id) {
		if (is_numeric($page_id)) $page_id = array($page_id);

		if (!empty($page_id) AND ctype_digit(implode('', $page_id))) {
			$affected_rows = $this->delete('page_id', $page_id);

			if ($affected_rows > 0) {
				foreach ($page_id as $id) {
					$this->permalink->deletePermalink('pages', 'page_id=' . $id);
				}

				return $affected_rows;
			}
		}
	}
}

/* End of file Pages_model.php */
/* Location: ./system/tastyigniter/models/Pages_model.php */