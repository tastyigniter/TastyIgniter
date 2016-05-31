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
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permalink Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Permalink.php
 * @link           http://docs.tastyigniter.com
 */
class Permalink {
	var $permalinks = array();
	var $slugs = array();

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->model('Permalink_model');

		$this->getPermalinks();

		if ($this->CI->config->item('permalink') == '1') {
			$this->slugs = $this->getSlugs();
			$this->_setRequestQuery();
		}
	}

	public function getPermalinks() {
		if (empty($this->permalinks)) {
			$this->permalinks = $this->CI->Permalink_model->getPermalinks();
		}

		return $this->permalinks;
	}

	public function getPermalink($query) {
		$result = array('permalink_id' => 0, 'slug' => '', 'controller' => '', 'url' => '', 'query' => $query);

		if (!empty($query) AND !empty($this->permalinks)) {
			foreach ($this->permalinks as $permalink) {
				if ($query === $permalink['query']) {
					$result = $permalink;
				}
			}
		}

		return $result;
	}

	public function getSlugs() {
		$result = array();

		if (!empty($this->permalinks)) {
			foreach ($this->permalinks as $permalink) {
				if (isset($permalink['slug']) AND isset($permalink['query'])) {
					$result[$permalink['slug']] = $permalink['query'];
				}
			}
		}

		return $result;
	}


	public function getQuerySlug($query = '', $controller = 'pages') {
		$query_arr = array();

        $controller = strtolower($controller);
        if (!isset($this->slugs[$controller])) return NULL;

		$slugs = array_flip($this->slugs[$controller]);

		parse_str($query, $query_arr);

		foreach ($query_arr as $key => $val) {
			if (isset($slugs[$key.'='.$val])) {
				$slug = $slugs[$key.'='.$val];

				unset($query_arr[$key]);
				return ! empty($query_arr) ? $slug . '?' . http_build_query($query_arr) : $slug;
			}
		}
	}

	public function savePermalink($controller, $permalink = array(), $query = '') {
		return $this->CI->Permalink_model->savePermalink($controller, $permalink, $query);
	}

	public function deletePermalink($controller, $query = '') {
		return $this->CI->Permalink_model->deletePermalink($controller, $query);
	}

	private function _setRequestQuery() {
		if ($this->CI->config->item('permalink') === '1') {

            $controller = strtolower($this->CI->uri->rsegment(1) ? $this->CI->uri->rsegment(1) : 'pages');

			if ($this->CI->uri->segment(2)) {
				$slug = $this->CI->uri->segment(2);
			} else if ($this->CI->uri->segment(1)) {
				$slug = $this->CI->uri->segment(1);
			} else {
				$slug = '';
			}

            if (isset($this->slugs[$controller][$slug])) {
                $query = $this->slugs[$controller][$slug];
				$query = explode('=', $query);

				if (isset($query[1])) {
					$_GET[$query[0]] = $query[1];
				}
			}
		}
	}
}

// END Permalink class

/* End of file Permalink.php */
/* Location: ./system/tastyigniter/libraries/Permalink.php */