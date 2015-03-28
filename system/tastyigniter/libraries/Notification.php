<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Notification {
	var $permalinks = array();

	public function __construct() {
		$this->CI =& get_instance();
		$this->fetchPermalinks();
	}

	public function fetchPermalinks() {
		if (empty($this->permalinks)) {
			$this->CI->load->database();
			$this->CI->db->from('permalinks');
			$query = $this->CI->db->get();

			if ($query->num_rows() > 0) {
				$results = array();

				foreach ($query->result_array() as $row) {
					if (isset($row['slug']) AND isset($row['query'])) {
						$results[$row['slug']] = $row['query'];
					}
				}

				$this->permalinks = $results;
			}
		}

		$this->setQuery();
	}

	public function setPermalink($query = '') {
        $permalinks = array_flip($this->permalinks);

	  	if (isset($permalinks[$query])) {
			return $permalinks[$query];
	  	}
	}

	public function setQuery() {
		if ($this->CI->config->item('permalink') == '1' AND $this->CI->uri->segment(2)) {
			$permalink = $this->CI->uri->segment(2);

			if (isset($this->permalinks[$permalink])) {
				$query = $this->permalinks[$permalink];
				$query = explode('=', $query);

				if (isset($query[1])) {
					$_GET[$query[0]] = $query[1];
				}
			}
		}
	}
}

// END Notification class

/* End of file Notification.php */
/* Location: ./system/tastyigniter/libraries/Notification.php */