<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permalinks_model extends CI_Model {

	public function getPermalinks() {
		$this->db->from('permalinks');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getPermalink($slug) {
		$result = array('permalink_id' => '', 'slug' => '');

		if (!empty($slug)) {
			$this->db->from('permalinks');

			$this->db->where('query', $slug);
			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$result = $query->row_array();
			}
		}

		return $result;
	}

	public function checkDuplicate($permalink = array(), $duplicate = '0') {
		if (!empty($permalink) AND isset($permalink['permalink'])  AND isset($permalink['controller'])
			AND isset($permalink['permalink']['permalink_id']) AND isset($permalink['permalink']['slug'])) {
			$this->db->from('permalinks');

			$this->db->where('controller', $permalink['controller']);

			$slug = ($duplicate > 0) ? $permalink['permalink']['slug'].'-'.$duplicate : $permalink['permalink']['slug'];

			$this->db->where('slug', $slug);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				if ($permalink['permalink']['permalink_id'] !== $row['permalink_id']) {
					$duplicate++;
					$query = $this->checkDuplicate($permalink, $duplicate);

				}
			}

			return $duplicate;
		}

		return FALSE;
	}

	public function updatePermalink($update = array()) {
		$query = FALSE;

		if (empty($update['permalink']['permalink_id'])) {
			$query = $this->addPermalink($update);
		}


		if (!empty($update['permalink']) AND !empty($update['permalink']['permalink_id'])
			AND isset($update['permalink']['slug'])) {

			$duplicate = $this->checkDuplicate($update);

			$slug = ($duplicate > 0) ? $update['permalink']['slug'].'-'.$duplicate : $update['permalink']['slug'];
			$this->db->set('slug', $slug);

			if (!empty($update['controller'])) {
				$this->db->set('controller', $update['controller']);
			}

			if (!empty($update['query'])) {
				$this->db->where('permalink_id', $update['permalink']['permalink_id']);
				$this->db->where('query', $update['query']);
				$query = $this->db->update('permalinks');
			}
		}

		return $query;
	}

	public function addPermalink($add = array()) {
		$query = FALSE;

		if (!empty($add['permalink']['permalink_id'])) {
			$query = $this->updatePermalink($add);
		}

		if (!empty($add['permalink']) AND !empty($add['query'])
			AND empty($add['permalink']['permalink_id']) AND isset($add['permalink']['slug'])) {

			$this->db->where('query', $add['query']);
			$this->db->delete('permalinks');

			$duplicate = $this->checkDuplicate($add);

			if (!empty($add['controller'])) {
				$this->db->set('controller', $add['controller']);
			}

			$slug = ($duplicate > 0) ? $add['permalink']['slug'].'-'.$duplicate : $add['permalink']['slug'];
			$this->db->set('slug', $slug);
			$this->db->set('query', $add['query']);

			if ($this->db->insert('permalinks')) {
				$query = $this->db->insert_id();
			}
		}

		return $query;
	}
}

/* End of file permalinks_model.php */
/* Location: ./admin/models/permalinks_model.php */