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
 * Permalink Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Permalink_model.php
 * @link           http://docs.tastyigniter.com
 */
class Permalink_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'permalinks';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'permalink_id';

	protected $fillable = ['permalink_id', 'slug', 'controller', 'query'];

	public function scopeWhereQueryAndController($query, $httpQuery, $controller)
	{
		return $query->where('query', $httpQuery)->where('controller', $controller);
	}

	public function scopeWhereSlugAndController($q, $slug, $controller)
	{
		return $q->where('slug', $slug)->where('controller', $controller);
	}

	/**
	 * Check is permalink is enabled
	 *
	 * @return bool TRUE if enabled, or FALSE if disabled
	 */
	public function isPermalinkEnabled()
	{
		return ($this->config->item('permalink') == '1') ? TRUE : FALSE;
	}

	/**
	 * Return all permalinks
	 *
	 * @return array
	 */
	public function getPermalinks()
	{
		if (!$this->isPermalinkEnabled()) {
			return [];
		}

		return $this->getAsArray();
	}

	/**
	 * Find a single permalink by query
	 *
	 * @param string $query
	 *
	 * @return array|bool
	 */
	public function getPermalink($query)
	{
		if (!$this->isPermalinkEnabled()) return [];

		return $this->firstOrNew('query', $query)->toArray();
	}

	/**
	 * Create a new or update an existing permalink
	 *
	 * @param string $controller
	 * @param array $permalink
	 * @param string $query
	 *
	 * @return bool|int The $page_id of the affected row, or FALSE on failure
	 */
	public function savePermalink($controller, $permalink = [], $query = '')
	{
		if (!$this->isPermalinkEnabled()) return FALSE;

		if (empty($controller)) return FALSE;

		$permalink_id = !empty($permalink['permalink_id']) ? $permalink['permalink_id'] : null;

		if (!empty($permalink['slug']) AND !empty($query)) {
			$slug = $this->_checkDuplicate($controller, $permalink);

			if ($permalink_id) {
				$this->where('permalink_id', $permalink['permalink_id'])->where('query', $query)
					 ->update(['slug' => $slug, 'controller' => $controller]);
			} else {
				$this->whereQueryAndController($query, $controller)->delete();

				$permalink_id = $this->insertGetId(['slug' => $slug, 'controller' => $controller, 'query' => $query]);
			}
		}

		return $permalink_id;
	}

	/**
	 * Makes sure permalink slug does not already exist
	 *
	 * @param string $controller
	 * @param array $permalink
	 * @param string $duplicate
	 *
	 * @return mixed|string
	 */
	protected function _checkDuplicate($controller, $permalink = [], $duplicate = '0')
	{
		if (!empty($controller) AND !empty($permalink['slug'])) {

			$slug = ($duplicate > 0) ? $permalink['slug'] . '-' . $duplicate : $permalink['slug'];
			$slug = url_title($slug, '-', TRUE);

			$row = $this->whereSlugAndController($slug, $controller)->first();

			if ($row) {
				if (!empty($permalink['permalink_id']) AND $permalink['permalink_id'] == $row->permalink_id) {
					return $slug;
				}

				$duplicate++;
				$slug = $this->_checkDuplicate($controller, $permalink, $duplicate);
			}

			return $slug;
		}
	}

	/**
	 * Delete a single or multiple permalink by controller and query
	 *
	 * @param string $controller
	 * @param string $query
	 *
	 * @return int  The number of deleted rows
	 */
	public function deletePermalink($controller, $query)
	{
		if (is_string($controller) AND is_string($query)) {
			$affected_rows = $this->whereQueryAndController($query, $controller)->delete();

			return ($affected_rows > 0);
		}
	}
}

/* End of file Permalink_model.php */
/* Location: ./system/tastyigniter/models/Permalink_model.php */