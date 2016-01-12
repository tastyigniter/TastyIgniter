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
class Permalink_model extends TI_Model {

	public function isPermalinkEnabled() {
		return ($this->config->item('permalink') == '1') ? TRUE : FALSE;
	}

	public function getPermalinks() {
		if ( ! $this->isPermalinkEnabled()) return array();

		$this->db->from('permalinks');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getPermalink($query) {
		if ( ! $this->isPermalinkEnabled()) return array();

		$this->db->from('permalinks');
		$this->db->where('query', $query);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function savePermalink($controller, $permalink = array(), $query = '') {
		if ( ! $this->isPermalinkEnabled()) return FALSE;

		if (empty($controller)) return FALSE;

		if ( ! empty($permalink['slug']) AND ! empty($query)) {
			$slug = $this->_checkDuplicate($controller, $permalink);

			if ( ! empty($permalink['permalink_id'])) {
				$this->db->set('slug', $slug);
				$this->db->set('controller', $controller);

				$this->db->where('permalink_id', $permalink['permalink_id']);
				$this->db->where('query', $query);
				$query = $this->db->update('permalinks');
			} else {
				$this->db->where('query', $query);
				$this->db->where('controller', $controller);
				$this->db->delete('permalinks');

				$this->db->set('controller', $controller);
				$this->db->set('slug', $slug);
				$this->db->set('query', $query);

				$query = $this->db->insert('permalinks');
				$permalink['permalink_id'] = $this->db->insert_id();
			}
		}

		return $query;
	}

	private function _checkDuplicate($controller, $permalink = array(), $duplicate = '0') {
		if ( ! empty($controller) AND ! empty($permalink['slug'])) {

			$slug = ($duplicate > 0) ? $permalink['slug'] . '-' . $duplicate : $permalink['slug'];
			$slug = url_title($slug, '-', TRUE);

			$this->db->where('controller', $controller);
			$this->db->where('slug', $slug);

			$this->db->from('permalinks');
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				if ( ! empty($permalink['permalink_id']) AND $permalink['permalink_id'] === $row['permalink_id']) {
					return $slug;
				}

				$duplicate ++;
				$slug = $this->_checkDuplicate($controller, $permalink, $duplicate);
			}

			return $slug;
		}
	}

	public function deletePermalink($controller, $query) {
		if (is_string($controller) AND is_string($query)) {
			$this->db->where('query', $query);
			$this->db->where('controller', $controller);
			$this->db->delete('permalinks');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file permalink_model.php */
/* Location: ./system/tastyigniter/models/permalink_model.php */