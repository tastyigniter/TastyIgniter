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
 * Banners Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Banners_model.php
 * @link           http://docs.tastyigniter.com
 */
class Banners_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'banners';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'banner_id';

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
	 * List all coupons matching the filter
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

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all banners from the database
	 *
	 * @return array
	 */
	public function getBanners() {
		return $this->find_all();
	}

	/**
	 * Find a single banner by banner_id
	 *
	 * @param int $banner_id
	 *
	 * @return array
	 */
	public function getBanner($banner_id) {
		return $this->find($banner_id);
	}

	/**
	 * Create a new or update existing banner
	 *
	 * @param int   $banner_id
	 * @param array $save input post data
	 *
	 * @return bool|int The $banner_id of the affected row, or FALSE on failure
	 */
	public function saveBanner($banner_id, $save = array()) {
		if (empty($save)) return FALSE;

		$save['image_code'] = array();
		if ($save['type'] === 'image' AND isset($save['image_path'])) {
			$save['image_code']['path'] = $save['image_path'];
		} else if ($save['type'] === 'carousel' AND isset($save['carousels']) AND is_array($save['carousels'])) {
			$save['image_code']['paths'] = array_values($save['carousels']);
		}

		return $this->skip_validation(TRUE)->save(array_merge($save, array(
			'image_code' => serialize($save['image_code']),
		)), $banner_id);
	}

	/**
	 * Delete a single or multiple banner by banner_id
	 *
	 * @param string|array $banner_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteBanner($banner_id) {
		if (is_numeric($banner_id)) $banner_id = array($banner_id);

		if (isset($banner_id) AND ctype_digit(implode('', $banner_id))) {
			return $this->delete('banner_id', $banner_id);
		}
	}
}

/* End of file Banners_model.php */
/* Location: ./system/tastyigniter/models/Banners_model.php */