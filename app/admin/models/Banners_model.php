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
class Banners_model extends TI_Model {

	public function getBanners() {
		$this->db->from('banners');

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getBanner($banner_id) {
		$this->db->from('banners');

		$this->db->where('banner_id', $banner_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function saveBanner($banner_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['name'])) {
			$this->db->set('name', $save['name']);
		}

		if (isset($save['type'])) {
			$this->db->set('type', $save['type']);
		}

		if (isset($save['click_url'])) {
			$this->db->set('click_url', $save['click_url']);
		}

		if (isset($save['language_id'])) {
			$this->db->set('language_id', $save['language_id']);
		}

		if (isset($save['alt_text'])) {
			$this->db->set('alt_text', $save['alt_text']);
		}

		if (isset($save['type']) AND $save['type'] === 'custom' AND isset($save['custom_code'])) {

			$this->db->set('custom_code', $save['custom_code']);
		} else if (isset($save['type']) AND $save['type'] === 'image' AND isset($save['image_path'])) {

			$save['image_code']['path'] = $save['image_path'];

			$this->db->set('image_code', serialize($save['image_code']));
		} else if (isset($save['type']) AND $save['type'] === 'carousel') {
			if (isset($save['carousels']) AND is_array($save['carousels'])) {
				foreach ($save['carousels'] as $key => $value) {
					$save['image_code']['paths'][] = $value;
				}

				$this->db->set('image_code', serialize($save['image_code']));
			}
		}

		if (isset($save['status'])) {
			$this->db->set('status', $save['status']);
		} else {
			$this->db->set('status', '0');
		}

		if (is_numeric($banner_id)) {
			$this->db->where('banner_id', $banner_id);
			$query = $this->db->update('banners');
		} else {
			$query = $this->db->insert('banners');
			$banner_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($banner_id)) ? $banner_id : FALSE;
	}

	public function deleteBanner($banner_id) {
		if (is_numeric($banner_id)) $banner_id = array($banner_id);

		if (isset($banner_id) AND ctype_digit(implode('', $banner_id))) {
			$this->db->where_in('banner_id', $banner_id);
			$this->db->delete('banners');

			return $this->db->affected_rows();
		}
	}
}

/* End of file banners_model.php */
/* Location: ./system/tastyigniter/models/banners_model.php */