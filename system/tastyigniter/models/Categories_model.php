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
 * Categories Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Categories_model.php
 * @link           http://docs.tastyigniter.com
 */
class Categories_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'categories';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'category_id';

	protected $fillable = ['name', 'description', 'parent_id', 'priority', 'image', 'status'];

	/**
	 * Scope a query to only include enabled category
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
		}

		if (is_numeric($filter['filter_status'])) {
			$query->where('menu_status', $filter['filter_status']);
		}

		return $query;
	}

	public function getDescriptionAttribute($value)
	{
		return strip_tags(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
	}

	/**
	 * Return all categories with child and sibling
	 *
	 * @param int $parent
	 *
	 * @return array
	 */
	public function getCategories($parent = null)
	{
		$categoriesTable = $this->tablePrefix('categories');
		$catOneTable = $this->tablePrefix('cat1');
		$childTable = $this->tablePrefix('child');
		$siblingTable = $this->tablePrefix('sibling');

		$query = $this->selectRaw("{$catOneTable}.category_id, {$catOneTable}.name, {$catOneTable}.description, {$catOneTable}.image, " .
			"{$catOneTable}.priority, {$catOneTable}.status, {$childTable}.category_id as child_id, {$siblingTable}.category_id as sibling_id");
		$query->from("categories AS cat1");
		$query->leftJoin("categories AS child", function ($join) {
			$join->on('child.parent_id', '=', 'cat1.category_id');
		})->leftJoin("categories AS sibling", function ($join) {
			$join->on('sibling.parent_id', '=', 'child.category_id');
		});

		if ($parent === null) {
			$query->where('cat1.parent_id', '>=', '0');
		} else if (empty($parent)) {
			$query->where('cat1.parent_id', '=', '0');
		} else {
			$query->where('cat1.parent_id', '=', $parent);
		}

		if (APPDIR === MAINDIR) {
			$query->where('cat1.status', '=', '1');
		}

		$result = [];

		foreach ($query->getAsArray() as $row) {
			$result[$row['category_id']] = $row;
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
	public function getCategory($category_id)
	{
		if (is_numeric($category_id)) {
			$query = $this->query();

			if (APPDIR === MAINDIR) {
				$query->where('status', '1');
			}

			return $query->findOrNew($category_id)->toArray();
		}
	}

	/**
	 * Create a new or update existing menu category
	 *
	 * @param int $category_id
	 * @param array $save
	 *
	 * @return bool|int The $category_id of the affected row, or FALSE on failure
	 */
	public function saveCategory($category_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$categoryModel = $this->findOrNew($category_id);

		if ($saved = $categoryModel->fill($save)->save()) {
			if (!empty($save['permalink'])) {
				$this->permalink->savePermalink('menus', $save['permalink'], 'category_id=' . $categoryModel->getKey());
			}

			return $saved ? $categoryModel->getKey() : $saved;
		}
	}

	/**
	 * Delete a single or multiple category by category_id
	 *
	 * @param string|array $category_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteCategory($category_id)
	{
		if (is_numeric($category_id)) $category_id = [$category_id];

		if (!empty($category_id) AND ctype_digit(implode('', $category_id))) {
			$affected_rows = $this->whereIn('category_id', $category_id)->delete();

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