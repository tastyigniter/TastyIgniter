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
 * Permalink Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Permalink_model.php
 * @link           http://docs.tastyigniter.com
 */
class Permalink_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'permalinks';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'permalink_id';

	/**
	 * Check is permalink is enabled
	 *
	 * @return bool TRUE if enabled, or FALSE if disabled
	 */
	public function isPermalinkEnabled() {
		return ($this->config->item('permalink') == '1') ? TRUE : FALSE;
	}

	/**
	 * Return all permalinks
	 *
	 * @return array
	 */
	public function getPermalinks() {
		if (!$this->isPermalinkEnabled()) {
			return array();
		}

		return $this->find_all();
	}

	/**
	 * Find a single permalink by query
	 *
	 * @param string $query
	 *
	 * @return array|bool
	 */
	public function getPermalink($query) {
		if (!$this->isPermalinkEnabled()) return array();

		return $this->find('query', $query);
	}

	/**
	 * Create a new or update an existing permalink
	 *
	 * @param string $controller
	 * @param array  $permalink
	 * @param string $query
	 *
	 * @return bool|int The $page_id of the affected row, or FALSE on failure
	 */
	public function savePermalink($controller, $permalink = array(), $query = '') {
		if (!$this->isPermalinkEnabled()) return FALSE;

		if (empty($controller)) return FALSE;

		$permalink_id = !empty($permalink['permalink_id']) ? $permalink['permalink_id'] : NULL;

		if (!empty($permalink['slug']) AND !empty($query)) {
			$slug = $this->_checkDuplicate($controller, $permalink);

			if ($permalink_id) {
				$this->update(array('permalink_id' => $permalink['permalink_id'], 'query' => $query),
					array('slug' => $slug, 'controller' => $controller));
			} else {
				$this->delete(array('query' => $query, 'controller' => $controller));

				$permalink_id = $this->insert(array('slug' => $slug, 'controller' => $controller, 'query' => $query));
			}
		}

		return $permalink_id;
	}

	/**
	 * Makes sure permalink slug does not already exist
	 *
	 * @param string $controller
	 * @param array  $permalink
	 * @param string $duplicate
	 *
	 * @return mixed|string
	 */
	protected function _checkDuplicate($controller, $permalink = array(), $duplicate = '0') {
		if (!empty($controller) AND !empty($permalink['slug'])) {

			$slug = ($duplicate > 0) ? $permalink['slug'] . '-' . $duplicate : $permalink['slug'];
			$slug = url_title($slug, '-', TRUE);

			$row = $this->find(array('slug' => $slug, 'controller' => $controller));

			if ($row) {
				if (!empty($permalink['permalink_id']) AND $permalink['permalink_id'] === $row['permalink_id']) {
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
	public function deletePermalink($controller, $query) {
		if (is_string($controller) AND is_string($query)) {
			$affected_rows = $this->delete(array('query' => $query, 'controller' => $controller));

			return ($affected_rows > 0);
		}
	}
}

/* End of file Permalink_model.php */
/* Location: ./system/tastyigniter/models/Permalink_model.php */