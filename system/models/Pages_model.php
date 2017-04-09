<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use Igniter\Database\Model;

/**
 * Pages Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Pages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Pages_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'pages';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'page_id';

	protected $fillable = ['language_id', 'name', 'title', 'heading', 'content', 'meta_description',
		'meta_keywords', 'layout_id', 'navigation', 'date_added', 'date_updated', 'status'];

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';
	const UPDATED_AT = 'date_updated';

	public $belongsTo = [
		'languages' => 'Languages_model',
	];

	protected $casts = [
		'navigation' => 'serialize',
	];

	public function getContentAttribute($value)
	{
		return html_entity_decode($value);
	}

	/**
	 * Scope a query to only include enabled page
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
		$languagesTable = $this->tablePrefix('languages');
		$pagesTable = $this->tablePrefix('pages');

		$query->selectRaw("*, {$languagesTable}.name AS language_name, {$pagesTable}.name AS name, {$pagesTable}.status AS status");
		$query->join('languages', 'languages.language_id', '=', 'pages.language_id', 'left');

		if (!empty($filter['filter_search'])) {
			$query->search($filter['filter_search'], [$pagesTable.'.name']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('pages.status', $filter['filter_status']);
		}

		return $query;
	}

	/**
	 * Return all pages
	 *
	 * @return array
	 */
	public function getPages()
	{
		return $this->isEnabled()->getAsArray();
	}

	/**
	 * Find a single page by page_id
	 *
	 * @param int $page_id
	 *
	 * @return array
	 */
	public function getPage($page_id)
	{
		return $this->findOrNew($page_id)->toArray();
	}

	/**
	 * Create a new or update existing page
	 *
	 * @param int $page_id
	 * @param array $save
	 *
	 * @return bool|int The $page_id of the affected row, or FALSE on failure
	 */
	public function savePage($page_id, $save = [])
	{
		if (empty($save)) return FALSE;

		if (isset($save['title'])) {
			$save['name'] = $save['title'];
		}

		$pageModel = $this->findOrNew($page_id);

		if ($saved = $pageModel->fill($save)->save()) {
			if (!empty($save['permalink'])) {
				$this->permalink->savePermalink('pages', $save['permalink'], 'page_id=' . $pageModel->getKey());
			}

			return $pageModel->getKey();
		}
	}

	/**
	 * Delete a single or multiple page by page_id
	 *
	 * @param int $page_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deletePage($page_id)
	{
		if (is_numeric($page_id)) $page_id = [$page_id];

		if (!empty($page_id) AND ctype_digit(implode('', $page_id))) {
			$affected_rows = $this->whereIn('page_id', $page_id)->delete();

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