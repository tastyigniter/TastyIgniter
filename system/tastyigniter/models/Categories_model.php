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
 * Categories Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Categories_model.php
 * @link           http://docs.tastyigniter.com
 */
class Categories_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'categories';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'category_id';

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count();
	}

	/**
	 * List all categories matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		return $this->filter($filter)->find_all();
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
		}

		if (is_numeric($filter['filter_status'])) {
			$this->where('menu_status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all categories with child and sibling
	 *
	 * @param int $parent
	 *
	 * @return array
	 */
	public function getCategories($parent = NULL) {
		$sql = "SELECT cat1.category_id, cat1.name, cat1.description, cat1.image, ";
		$sql .= "cat1.priority, cat1.status, child.category_id as child_id, sibling.category_id as sibling_id ";
		$sql .= "FROM {$this->table_prefix('categories')} AS cat1 ";
		$sql .= "LEFT JOIN {$this->table_prefix('categories')} AS child ON child.parent_id = cat1.category_id ";
		$sql .= "LEFT JOIN {$this->table_prefix('categories')} AS sibling ON sibling.parent_id = child.category_id ";

		if ($parent === NULL) {
			$sql .= "WHERE cat1.parent_id >= 0 ";
		} else if (empty($parent)) {
			$sql .= "WHERE cat1.parent_id = 0 ";
		} else {
			$sql .= "WHERE cat1.parent_id = ? ";
		}

		if (APPDIR === MAINDIR) {
			$sql .= "AND cat1.status = 1 ";
		}

		$query = $this->db->query($sql, $parent);

		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$result[$row['category_id']] = $row;
			}
		}

		return $result;
	}

	/**
	 * Find a single category by category_id
	 *
	 * @param int $category_id
	 *
	 * @return array
	 */
	public function getCategory($category_id) {
		if (is_numeric($category_id)) {
			if (APPDIR === MAINDIR) {
				$this->where('status', '1');
			}

			return $this->find($category_id);
		}
	}

	/**
	 * Create a new or update existing menu category
	 *
	 * @param int   $category_id
	 * @param array $save
	 *
	 * @return bool|int The $category_id of the affected row, or FALSE on failure
	 */
	public function saveCategory($category_id, $save = array()) {
		if (empty($save)) return FALSE;

		if ($category_id = $this->skip_validation(TRUE)->save($save, $category_id)) {
			if (!empty($save['permalink'])) {
				$this->permalink->savePermalink('menus', $save['permalink'], 'category_id=' . $category_id);
			}

			return $category_id;
		}
	}

	/**
	 * Delete a single or multiple category by category_id
	 *
	 * @param string|array $category_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteCategory($category_id) {
		if (is_numeric($category_id)) $category_id = array($category_id);

		if (!empty($category_id) AND ctype_digit(implode('', $category_id))) {
			$affected_rows = $this->delete('category_id', $category_id);

			if ($affected_rows > 0) {
				foreach ($category_id as $id) {
					$this->permalink->deletePermalink('menus', 'category_id=' . $id);
				}

				return $affected_rows;
			}
		}
	}
}

/* End of file Categories_model.php */
/* Location: ./system/tastyigniter/models/Categories_model.php */